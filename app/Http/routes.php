<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Carbon\Carbon;

Route::any('test', function() {
    $now = Carbon::now();
    $tomorrow = Carbon::tomorrow();
    $diff_mins = $now->diffInMinutes($tomorrow);
    var_dump($now);
    var_dump($tomorrow);
    var_dump($diff_mins);
    return $diff_mins / 60;
});

Route::any('/info', function() {
    return phpinfo();
});

Route::match(['GET', 'POST'], '/wechat/server', 'wechatController@server');
Route::match(['GET', 'POST'], '/wechat/callback', 'wechatController@callback');

Route::group([
        'middleware' => 'wechat.oauth'
    ], 
    function(){
        Route::controller('/', 'homeController');
    }
);