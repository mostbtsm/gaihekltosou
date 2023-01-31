<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('ID');
            $table->tinyInteger('type')->unsigned()->comment('タイプ');
            $table->string('subject', 256)->nullable()->default(null)->comment('メール件名');
            $table->text('contents')->nullable()->default(null)->comment('内容');
            $table->tinyInteger('send_flg')->unsigned()->nullable()->default(0)->comment('送信済みフラグ');
            $table->dateTime('deleted_at')->nullable()->default(null)->comment('削除日時');
            $table->dateTime('created_at')->nullable()->default(null)->comment('作成日時');
            $table->dateTime('updated_at')->nullable()->default(null)->comment('更新日時');

        });

        DB::statement("ALTER TABLE notices COMMENT 'お知らせ'");
        DB::statement("ALTER TABLE notices ADD KEY `notice_type` (`type`)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notices');
    }
}
