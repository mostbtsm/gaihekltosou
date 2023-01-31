<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('ID');
            $table->integer('painter_id')->unsigned()->default(0)->comment('業者ID');
            $table->integer('user_id')->unsigned()->default(0)->comment('ユーザID');
            $table->integer('property_id')->unsigned()->default(0)->comment('物件ID');
            $table->integer('example_id')->unsigned()->default(0)->comment('施工事例ID');
            $table->integer('column_id')->unsigned()->default(0)->comment('コラムID');
            $table->string('image_file', 256)->nullable()->default(null)->comment('画像ファイル');
            $table->tinyInteger('flg')->unsigned()->nullable()->default(0)->comment('プロフィールフラグ');
            $table->dateTime('deleted_at')->nullable()->default(null)->comment('削除日時');
            $table->dateTime('created_at')->nullable()->default(null)->comment('作成日時');
            $table->dateTime('updated_at')->nullable()->default(null)->comment('更新日時');
        });

        DB::statement("ALTER TABLE images COMMENT '画像ファイル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
