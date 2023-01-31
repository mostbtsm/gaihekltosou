<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaintersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('painters', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('ID');
            $table->string('email', 256)->comment('会社メールアドレス');
            $table->string('password', 256)->comment('パスワード');
            $table->string('name', 256)->nullable()->default(null)->comment('事業者名');
            $table->string('kana', 256)->nullable()->default(null)->comment('フリガナ');
            $table->string('ceo_name', 256)->nullable()->default(null)->comment('代表者名');
            $table->string('type', 256)->nullable()->default(null)->comment('事業内容');
            $table->string('postal', 8)->nullable()->default(null)->comment('郵便番号');
            $table->tinyInteger('prefectures')->unsigned()->nullable()->default(null)->comment('都道府県');
            $table->string('city', 20)->nullable()->default(null)->comment('市区町村');
            $table->string('address1', 256)->nullable()->default(null)->comment('住所１');
            $table->string('address2', 256)->nullable()->default(null)->comment('住所２');
            $table->string('tel', 20)->nullable()->default(null)->comment('代表電話番号');
            $table->string('fax', 20)->nullable()->default(null)->comment('FAX番号');
            $table->string('charge_name1', 48)->nullable()->default(null)->comment('担当者姓');
            $table->string('charge_name2', 48)->nullable()->default(null)->comment('担当者名');
            $table->string('charge_kana1', 48)->nullable()->default(null)->comment('担当者カナ姓');
            $table->string('charge_kana2', 48)->nullable()->default(null)->comment('担当者カナ名');
            $table->string('charge_tel', 20)->nullable()->default(null)->comment('担当者電話番号');
            $table->string('charge_email', 256)->nullable()->default(null)->comment('担当者メールアドレス');
            $table->string('url', 256)->nullable()->default(null)->comment('ホームページ');
            $table->smallInteger('established')->unsigned()->nullable()->default(null)->comment('設立年');
            $table->integer('capital')->unsigned()->nullable()->comment('資本金');
            $table->string('permission', 256)->nullable()->default(null)->comment('建設業許可証');
            $table->string('organization', 256)->nullable()->default(null)->comment('加盟団体');
            $table->tinyInteger('sales')->unsigned()->nullable()->default(null)->comment('年間売上');
            $table->integer('employees')->unsigned()->nullable()->default(null)->comment('従業員数');
            $table->tinyInteger('social_insurance')->unsigned()->nullable()->default(null)->comment('社会保険');
            $table->tinyInteger('accident_insurance')->unsigned()->nullable()->default(null)->comment('労災保険');
            $table->string('other_insurance', 128)->nullable()->default(null)->comment('その他民間保険');
            $table->string('category', 48)->nullable()->default(null)->comment('業務内容カテゴリー');
            $table->string('image_file', 256)->nullable()->default(null)->comment('プロフィール写真');
            $table->string('catch_copy', 256)->nullable()->default(null)->comment('キャッチコピー');
            $table->integer('constructions')->unsigned()->nullable()->default(null)->comment('施工件数');
            $table->integer('annual_constructions')->unsigned()->nullable()->default(null)->comment('年間施工件数');
            $table->tinyInteger('rank')->unsigned()->nullable()->default(null)->comment('ランク');
            $table->string('pr_copy', 256)->nullable()->default(null)->comment('PRコピー');
            $table->string('message_key', 256)->nullable()->default(null)->comment('メッセージ識別キー');
            $table->dateTime('deleted_at')->nullable()->default(null)->comment('削除日時');
            $table->dateTime('created_at')->nullable()->default(null)->comment('作成日時');
            $table->dateTime('updated_at')->nullable()->default(null)->comment('更新日時');
        });

        DB::statement("ALTER TABLE painters COMMENT '業者'");
        DB::statement("ALTER TABLE painters ADD KEY `painters_name` (`name`(255),`kana`(255))");
        DB::statement("ALTER TABLE painters ADD KEY `painters_address` (`prefectures`,`city`,`address1`(255),`address2`(255))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('painters');
    }
}
