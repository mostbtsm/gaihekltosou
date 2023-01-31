<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('ID');
            $table->integer('user_id')->unsigned()->comment('ユーザID');
            $table->string('name', 48)->nullable()->default(null)->comment('物件名');
            $table->string('address', 256)->nullable()->default(null)->comment('住所');
            $table->smallInteger('area')->unsigned()->nullable()->default(null)->comment('敷地面積');
            $table->smallInteger('area_b')->unsigned()->nullable()->default(null)->comment('建坪');
            $table->tinyInteger('floors')->unsigned()->nullable()->default(null)->comment('階数');
            $table->tinyInteger('age')->unsigned()->nullable()->default(null)->comment('築年数');
            $table->tinyInteger('type')->unsigned()->nullable()->default(null)->comment('タイプ');
            $table->smallInteger('num')->unsigned()->nullable()->default(null)->comment('戸数');
            $table->tinyInteger('type_wall')->unsigned()->nullable()->default(null)->comment('外壁の種類');
            $table->tinyInteger('type_roof')->unsigned()->nullable()->default(null)->comment('屋根の種類');
            $table->tinyInteger('repainting_wall')->unsigned()->nullable()->default(null)->comment('前回塗替_外壁');
            $table->tinyInteger('repainting_roof')->unsigned()->nullable()->default(null)->comment('前回塗替_屋根');
            $table->smallInteger('budget')->unsigned()->nullable()->default(null)->comment('予算');
            $table->string('image_file1', 256)->nullable()->default(null)->comment('画像１');
            $table->string('image_file2', 256)->nullable()->default(null)->comment('画像２');
            $table->string('image_file3', 256)->nullable()->default(null)->comment('画像３');
            $table->string('image_file4', 256)->nullable()->default(null)->comment('画像４');
            $table->string('image_file5', 256)->nullable()->default(null)->comment('画像５');
            $table->string('image_file6', 256)->nullable()->default(null)->comment('画像６');
            $table->dateTime('deleted_at')->nullable()->default(null)->comment('削除日時');
            $table->dateTime('created_at')->nullable()->default(null)->comment('作成日時');
            $table->dateTime('updated_at')->nullable()->default(null)->comment('更新日時');
        });

        DB::statement("ALTER TABLE properties COMMENT '物件'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
