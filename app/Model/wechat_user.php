<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class wechat_user extends Model
{
    protected $table = 'wechat_users';
    protected $guarded = ['id'];
    protected $hidden = [];

    public function card()
    {
        return $this->hasOne('App\Model\card', 'wc_user_id');
    }
}
