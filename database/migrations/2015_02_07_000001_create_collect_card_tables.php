<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectCardTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wc_user_id')->unsigned();
            $table->text('hits')->deafult(0);//帮助填色次数
            $table->text('is_winner')->deafult(0);//是否中奖 0否 1是
            $table->timestamps();
            $table->foreign('wc_user_id')->references('id')->on('wechat_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cards');
    }
}
