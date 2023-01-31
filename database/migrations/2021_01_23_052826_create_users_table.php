<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('ID');
            $table->string('email', 256)->comment('メールアドレス');
            $table->string('password', 256)->comment('パスワード');
            $table->string('name1', 48)->nullable()->default(null)->comment('姓');
            $table->string('name2', 48)->nullable()->default(null)->comment('名');
            $table->string('kana1', 48)->nullable()->default(null)->comment('カナ姓');
            $table->string('kana2', 48)->nullable()->default(null)->comment('カナ名');
            $table->string('nickname', 48)->nullable()->default(null)->comment('ニックネーム');
            $table->string('postal', 8)->nullable()->default(null)->comment('郵便番号');
            $table->tinyInteger('prefectures')->unsigned()->nullable()->default(null)->comment('都道府県');
            $table->string('city', 20)->nullable()->default(null)->comment('市区町村');
            $table->string('address1', 256)->nullable()->default(null)->comment('住所１');
            $table->string('address2', 256)->nullable()->default(null)->comment('住所２');
            $table->string('tel', 20)->nullable()->default(null)->comment('電話番号');
            $table->string('mobile', 20)->nullable()->default(null)->comment('携帯電話番号');
            $table->date('birth_date')->nullable()->default(null)->comment('生年月日');
            $table->tinyInteger('gender')->unsigned()->nullable()->default(null)->comment('性別');
            $table->string('image_file', 256)->nullable()->default(null)->comment('プロフィール写真');
            $table->tinyInteger('type')->unsigned()->nullable()->default(0)->comment('会員種別');
            $table->dateTime('expiration_date')->nullable()->default(null)->comment('有料会員期限');
            $table->string('card_info', 256)->nullable()->default(null)->comment('カード識別情報');
            $table->string('message_key', 256)->nullable()->default(null)->comment('メッセージ識別キー');
            $table->dateTime('deleted_at')->nullable()->default(null)->comment('削除日時');
            $table->dateTime('created_at')->nullable()->default(null)->comment('作成日時');
            $table->dateTime('updated_at')->nullable()->default(null)->comment('更新日時');
        });

        DB::statement("ALTER TABLE users COMMENT 'ユーザ'");
        DB::statement("ALTER TABLE users ADD KEY `users_name` (`name1`,`name2`,`kana1`,`kana2`)");
        DB::statement("ALTER TABLE users ADD KEY `users_address` (`prefectures`,`city`,`address1`(255),`address2`(255))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
