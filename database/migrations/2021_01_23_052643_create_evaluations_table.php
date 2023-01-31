<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('ID');
            $table->integer('painter_id')->unsigned()->comment('業者ID');
            $table->integer('contract_id')->unsigned()->comment('契約ID');
            $table->string('user_name', 48)->nullable()->default(null)->comment('ユーザ名');
            $table->tinyInteger('quality')->unsigned()->nullable()->default(null)->comment('品質');
            $table->tinyInteger('price')->unsigned()->nullable()->default(null)->comment('金額');
            $table->tinyInteger('speed')->unsigned()->nullable()->default(null)->comment('スピード');
            $table->tinyInteger('correspondence')->unsigned()->nullable()->default(null)->comment('対応');
            $table->text('evaluation')->nullable()->default(null)->comment('口コミ');
            $table->tinyInteger('flg')->unsigned()->nullable()->default(0)->comment('評価済フラグ');
            $table->dateTime('deleted_at')->nullable()->default(null)->comment('削除日時');
            $table->dateTime('created_at')->nullable()->default(null)->comment('作成日時');
            $table->dateTime('updated_at')->nullable()->default(null)->comment('更新日時');
        });

        DB::statement("ALTER TABLE evaluations COMMENT '評価'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
}
