<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appoint_id')->comment('预约记录ID');
            $table->integer('user_id')->comment('用户ID');
            $table->tinyInteger('point')->comment('评分');
            $table->text('evaluation')->nullable()->comment('评价');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_log');
    }
}
