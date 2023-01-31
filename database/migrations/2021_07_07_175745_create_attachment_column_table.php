<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentColumnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachment_column', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('ID');
            $table->integer('attachment_id')->unsigned()->default(0)->comment('AttachmentID');
            $table->integer('column_id')->unsigned()->default(0)->comment('コラムID');

            $table->foreign('attachment_id')->references('id')->on('attachments')->onDelete('cascade');
            $table->foreign('column_id')->references('id')->on('columns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachment_column');
    }
}
