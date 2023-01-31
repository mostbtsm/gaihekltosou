<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('ID');
            $table->integer('chat_thread_id')->unsigned()->default(0)->comment('スレッドID');
            $table->longText('contents')->nullable()->default(null)->comment('内容');
            $table->integer('attachment_id')->unsigned()->default(0)->comment('AttachmentID');
            $table->string('message_key', 256)->nullable()->default(null)->comment('メッセージ識別キー');
            $table->dateTime('deleted_at')->nullable()->default(null)->comment('削除日時');
            $table->dateTime('created_at')->nullable()->default(null)->comment('作成日時');
            $table->dateTime('updated_at')->nullable()->default(null)->comment('更新日時');
        });

        DB::statement("ALTER TABLE chat_messages COMMENT 'チャットメッセージ'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_messages');
    }
}
