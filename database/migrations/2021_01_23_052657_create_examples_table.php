<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examples', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('ID');
            $table->integer('painter_id')->unsigned()->comment('業者ID');
            $table->integer('contract_id')->unsigned()->comment('契約ID');
            $table->string('title', 256)->nullable()->default(null)->comment('案件名');
            $table->string('address', 256)->nullable()->default(null)->comment('住所');
            $table->string('category', 256)->nullable()->default(null)->comment('カテゴリー');
            $table->tinyInteger('property_type')->unsigned()->nullable()->default(null)->comment('建物タイプ');
            $table->string('warranty_json', 512)->nullable()->default(null)->comment('保証内容JSON');
            $table->tinyInteger('amount')->unsigned()->nullable()->default(null)->comment('契約金額');
            $table->string('complete_date_json', 256)->nullable()->default(null)->comment('完工日JSON');
            $table->tinyInteger('period')->unsigned()->nullable()->default(null)->comment('工事期間');
            $table->text('comment')->nullable()->default(null)->comment('コメント');
            $table->tinyInteger('public_consent')->unsigned()->nullable()->default(null)->comment('公開承諾フラグ');
            $table->dateTime('deleted_at')->nullable()->default(null)->comment('削除日時');
            $table->dateTime('created_at')->nullable()->default(null)->comment('作成日時');
            $table->dateTime('updated_at')->nullable()->default(null)->comment('更新日時');
        });

        DB::statement("ALTER TABLE examples COMMENT '施工事例'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('examples');
    }
}
