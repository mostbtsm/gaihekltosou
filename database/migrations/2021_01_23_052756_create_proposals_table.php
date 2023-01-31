<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('ID');
            $table->integer('painter_id')->unsigned()->comment('業者ID');
            $table->integer('request_id')->unsigned()->comment('依頼ID');
            $table->date('visit_schedule')->nullable()->default(null)->comment('初回訪問予定');
            $table->date('visit_record')->nullable()->default(null)->comment('初回訪問実績');
            $table->tinyInteger('bulk_flg')->unsigned()->nullable()->comment('一括・個別区分');
            $table->string('quotation1', 256)->nullable()->default(null)->comment('見積書１');
            $table->string('quotation2', 256)->nullable()->default(null)->comment('見積書２');
            $table->string('quotation3', 256)->nullable()->default(null)->comment('見積書３');
            $table->string('quotation4', 256)->nullable()->default(null)->comment('見積書４');
            $table->string('quotation5', 256)->nullable()->default(null)->comment('見積書５');
            $table->string('document1', 256)->nullable()->default(null)->comment('添付書類１');
            $table->string('document2', 256)->nullable()->default(null)->comment('添付書類２');
            $table->string('document3', 256)->nullable()->default(null)->comment('添付書類３');
            $table->string('document4', 256)->nullable()->default(null)->comment('添付書類４');
            $table->string('document5', 256)->nullable()->default(null)->comment('添付書類５');
            $table->text('user_memo')->nullable()->default(null)->comment('相談メモ個人');
            $table->text('painter_memo')->nullable()->default(null)->comment('相談メモ業者');
            $table->text('visit_memo')->nullable()->default(null)->comment('訪問メモ');
            $table->text('quotation_memo')->nullable()->default(null)->comment('見積メモ');
            $table->tinyInteger('status')->unsigned()->nullable()->default(0)->comment('ステータス');
            $table->dateTime('deleted_at')->nullable()->default(null)->comment('削除日時');
            $table->dateTime('created_at')->nullable()->default(null)->comment('作成日時');
            $table->dateTime('updated_at')->nullable()->default(null)->comment('更新日時');
        });

        DB::statement("ALTER TABLE proposals COMMENT '提案'");
        DB::statement("ALTER TABLE proposals ADD KEY `proposal_status` (`status`)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposals');
    }
}
