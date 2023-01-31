<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('ID');
            $table->integer('user_id')->unsigned()->comment('ユーザID');
            $table->string('title', 256)->nullable()->default(null)->comment('タイトル');
            $table->smallInteger('budget')->unsigned()->nullable()->default(null)->comment('予算');
            $table->integer('property_id')->unsigned()->comment('物件ID');
            $table->string('category', 48)->nullable()->default(null)->comment('カテゴリー');
            $table->string('priority', 48)->nullable()->default(null)->comment('工事要望事項');
            $table->tinyInteger('period')->unsigned()->nullable()->default(null)->comment('工期予定希望');
            $table->string('memo', 256)->nullable()->default(null)->comment('依頼メモ');
            $table->string('image_file', 256)->nullable()->default(null)->comment('画像');
            $table->dateTime('deleted_at')->nullable()->default(null)->comment('削除日時');
            $table->dateTime('created_at')->nullable()->default(null)->comment('作成日時');
            $table->dateTime('updated_at')->nullable()->default(null)->comment('更新日時');
        });

        DB::statement("ALTER TABLE requests COMMENT '依頼'");
        DB::statement("ALTER TABLE requests ADD KEY `request_status` (`user_id`,`property_id`)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
