<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentExampleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachment_example', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('ID');
            $table->integer('attachment_id')->unsigned()->default(0)->comment('AttachmentID');
            $table->integer('example_id')->unsigned()->default(0)->comment('施工事例ID');

            $table->foreign('attachment_id')->references('id')->on('attachments')->onDelete('cascade');
            $table->foreign('example_id')->references('id')->on('examples')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachment_example');
    }
}
