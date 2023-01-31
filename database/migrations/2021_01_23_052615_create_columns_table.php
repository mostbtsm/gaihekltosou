<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('columns', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('ID');
            $table->integer('painter_id')->unsigned()->comment('業者ID');
            $table->string('title', 256)->nullable()->default(null)->comment('タイトル');
            $table->tinyInteger('category')->unsigned()->nullable()->default(null)->comment('カテゴリー');
            $table->text('contents')->nullable()->default(null)->comment('内容');
            $table->tinyInteger('public')->unsigned()->nullable()->default(null)->comment('公開フラグ');
            $table->dateTime('deleted_at')->nullable()->default(null)->comment('削除日時');
            $table->dateTime('created_at')->nullable()->default(null)->comment('作成日時');
            $table->dateTime('updated_at')->nullable()->default(null)->comment('更新日時');
        });

        DB::statement("ALTER TABLE columns COMMENT 'コラム'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('columns');
    }
}
