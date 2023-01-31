<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('ID');
            $table->integer('user_id')->unsigned()->comment('ユーザID');
            $table->integer('painter_id')->unsigned()->comment('業者ID');
            $table->integer('request_id')->unsigned()->comment('依頼ID');
            $table->string('type', 3)->nullable()->default(null)->comment('コンテンツタイプ');
            $table->longText('contents')->nullable()->default(null)->comment('内容');
            $table->string('message_key', 256)->nullable()->default(null)->comment('メッセージ識別キー');
            $table->dateTime('deleted_at')->nullable()->default(null)->comment('削除日時');
            $table->dateTime('created_at')->nullable()->default(null)->comment('作成日時');
            $table->dateTime('updated_at')->nullable()->default(null)->comment('更新日時');
        });

        DB::statement("ALTER TABLE messages COMMENT 'メッセージ'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
