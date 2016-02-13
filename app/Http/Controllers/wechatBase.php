<?php

namespace App\Http\Controllers;

trait wechatBase
{
    public function callback()
    {
        $oauth = $this->app['oauth'];

        // 获取 OAuth 授权结果用户信息
        $user = $oauth->user();

        session()->put('wechat_user', $user->toArray());

        $targetUrl = session()->get('_previous.url');

        return redirect($targetUrl);
    }

    public function server()
    {
        // 从项目实例中得到服务端应用实例。
        $server = $this->app['server'];

        //消息处理
        $server->setMessageHandler(function ($message) {
            $this->_msgHandler($message);
        });

        $response = $server->serve();

        return $response;
    }
}
