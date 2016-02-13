<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class WechatUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wechat_users')->truncate();

        $faker = Faker::create();

        for ($i=0; $i < 5; $i++) { 
            DB::table('wechat_users')->insert([
                'open_id' => $faker->md5,
                'name' => $faker->name,
                'phone' => $faker->phoneNumber,
            ]);
        }
    }
}
