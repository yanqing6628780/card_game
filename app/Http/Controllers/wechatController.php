<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use EasyWeChat\Foundation\Application;

class wechatController extends Controller
{
    use wechatBase;

    protected $app;

    public function __construct()
    {
        $this->config = [
            'debug'     => true,
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
        $this->app = new Application($this->config);
    }

    protected function _msgHandler()
    {
        # code...
    }
}
