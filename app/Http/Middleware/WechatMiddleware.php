<?php

namespace App\Http\Middleware;

use App\Model\WCOAMember;
use Closure;
use EasyWeChat\Foundation\Application;
use Log;
use Illuminate\Contracts\Routing\TerminableMiddleware;

// class WechatMiddleware implements TerminableMiddleware
class WechatMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $config = [
            'debug'     => env('APP_DEBUG', false),
            'app_id'    => env('WECHAT_APP_ID'),
            'secret'    => env('WECHAT_APP_Secret'),
            'token'     => env('WECHAT_TOKEN'),
            'log' => [
                'level' => 'debug',
                'file'  => public_path('easywechat.log'),
            ],
            'oauth' => [
                  'scopes'   => ['snsapi_userinfo'],
                  'callback' => url('/wechat/callback'),
            ],
        ];
        session()->put('wechat_app_config', $config);
        $app   = new Application(session('wechat_app_config'));

        $oauth = $app['oauth'];

        if ($request->session()->has('wechat_user')) {
            return $next($request);
        } else {
            session()->put( 'oauth_prev_url' ,session()->get('_previous.url') );
            return $oauth->redirect();
        }

    }
}
