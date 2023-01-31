<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('ID');
            $table->integer('user_id')->unsigned()->comment('ユーザID');
            $table->integer('property_id')->unsigned()->comment('物件ID');
            $table->integer('request_id')->unsigned()->comment('依頼ID');
            $table->integer('painter_id')->unsigned()->comment('業者ID');
            $table->string('category', 48)->nullable()->default(null)->comment('カテゴリー');
            $table->string('document', 256)->nullable()->default(null)->comment('契約書');
            $table->integer('contract_amount')->unsigned()->nullable()->default(null)->comment('契約金額');
            $table->date('contract_date')->nullable()->default(null)->comment('契約日');
            $table->string('contract_details', 256)->nullable()->default(null)->comment('契約内容詳細');
            $table->string('charge_name', 256)->nullable()->default(null)->comment('担当者');
            $table->string('plan', 256)->nullable()->default(null)->comment('工事プラン');
            $table->smallInteger('period')->unsigned()->nullable()->default(null)->comment('工事期間');
            $table->string('paint', 256)->nullable()->default(null)->comment('使用塗料');
            $table->string('warranty_title', 256)->nullable()->default(null)->comment('保証項目名');
            $table->string('warranty', 256)->nullable()->default(null)->comment('保証内容');
            $table->text('memo')->nullable()->default(null)->comment('メモ');
            $table->date('complete_date')->nullable()->default(null)->comment('完工日');
            $table->integer('amount')->unsigned()->nullable()->default(null)->comment('金額');
            $table->dateTime('deleted_at')->nullable()->default(null)->comment('削除日時');
            $table->dateTime('created_at')->nullable()->default(null)->comment('作成日時');
            $table->dateTime('updated_at')->nullable()->default(null)->comment('更新日時');
        });

        DB::statement("ALTER TABLE contracts COMMENT '契約'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
