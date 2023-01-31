<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaintersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'email'=>'ohashi@smile-again.co.jp',
            'password'=>bcrypt('tosou2021'),
            'name'=>'テスト業者',
            'rank'=>1,
            'message_key'=>md5(uniqid(rand(), true))
        ];

        DB::table('painters')->insert($data);

        factory(App\Painter::class, 50)->create()->each(function ($painter) {
            $painter->save();
        });
    }
}
