<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class card extends Model
{
    protected $table = 'cards';
    protected $guard = ['id'];
    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo('App\Model\wechat_user', 'wc_user_id');
    }
}
