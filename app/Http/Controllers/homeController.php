<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Model\card;
use App\Model\wechat_user;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use EasyWeChat\Foundation\Application;
use Cache;
use Log;

class homeController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->open_id = session('wechat_user.id');
        $this->user = null;
        $this->register_url = action('homeController@getRegister');

        $user_builder = wechat_user::where('open_id', $this->open_id);
        if ($user_builder->count() > 0) {
            $this->user = $user_builder->first();
        }else{
            return redirect($this->register_url);
        }
    }

    public function getGame($player_id = null)
    {

        if ($player_id == null) {
            return redirect($this->register_url);
        }

        $data['player'] = wechat_user::with('card')->find($player_id);
        $data['is_self'] = $data['player']->open_id == $this->open_id ? 1 : 0;
        $data['activated_card'] = 0;

        // 计算已激活卡片
        $actvie_card_need_hits = 0; // 激活第i张卡所需点击数
        for ($i = 1; $i <= env('card_num'); $i++) {
            $actvie_card_need_hits += env('card_' . $i . '_hits');
            if ($data['player']->card->hits >= $actvie_card_need_hits) {
                $data['activated_card'] = $i;
            }
        }

        $data['winners'] = card::with('user')->where('is_winner', 1)->orderBy('updated_at', 'ASC')->take(env('winner_num'))->get();
        $data['real_players_num'] = card::count();

        $app   = new Application(session('wechat_app_config'));
        $data['wechat_js'] = $app['js'];

        return view('game', $data);
    }

    public function postHits()
    {
        $validator = Validator::make($this->request->all(), [
            'player_id' => 'required|exists:cards,wc_user_id',
        ]);

        $data['msg'] = '';
        if ($validator->fails()) {
            $data['msg'] = '数据不完整';
            return response()->json($data);
        } else {

            if (card::where('is_winner', 1)->count() >= env('winner_num')) {
                $data['msg'] = '活动结束';
            } else {
                $player_id = $this->request->input('player_id');
                $cache_key = $player_id.'_'.$this->open_id;

                //检查缓存,当前open_id是否已经点击过
                if (Cache::has($cache_key)) {
                    // Log::notice("cache ".$cache_key." has:", [Cache::has($cache_key), Cache::get($cache_key)]);
                    $data['msg'] = "你今天已经帮忙过了~请明天再来~";
                }else{
                    // Log::notice("cache ".$cache_key." not has:", [Cache::has($cache_key), Cache::get($cache_key)]);
                    $player = wechat_user::with('card')->find($player_id);
                    $player->card->hits += 1;
                    $player->card->save();

                    $actvie_card_need_hits = 0;
                    for ($i = 1; $i <= env('card_num'); $i++) {
                        $actvie_card_need_hits += env('card_' . $i . '_hits');
                        if ($player->card->hits >= $actvie_card_need_hits) {
                            $data['activated_card'] = $i;
                        }
                    }

                    //用户当前点击数大于激活所有卡的点击数,记录为中奖者
                    if ($player->card->hits >= $actvie_card_need_hits) {
                        $player->card->is_winner = 1;
                        $player->card->save();
                        $data['msg'] = '恭喜你集齐所有色卡';
                    }

                    $now = Carbon::now();
                    $tomorrow = Carbon::tomorrow();
                    $minutes = $now->diffInMinutes($tomorrow);
                    // $minutes = 1;
                    //缓存时间为第二天零点
                    Cache::put($cache_key, 1, $minutes);
                }
            }

            return response()->json($data);
        }

    }

    public function getRegister()
    {
        $data['player'] = $this->user;
        return view('register', $data);
    }

    public function postRegister()
    {
        $post_data = $this->request->all();
        $msgs = [
            'name.required' => '请填写姓名',
            'phone.required' => '请填写电话',
        ];

        $validator = Validator::make($post_data, [
            'name'  => 'required|max:32',
            'phone' => 'required',
        ], $msgs);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        } else {

            $post_data['open_id'] = $this->open_id;

            $model = new wechat_user;
            $model->fill($post_data);
            $model->save();

            $card            = new card;
            $card->hits      = 0;
            $card->is_winner = 0;
            $model->card()->save($card);

            $url = action('homeController@getGame', ['player' => $model->getKey()]);
            return redirect($url);
        }
    }
}
