<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEatLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eat_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户ID');
            $table->integer('appoint_id')->comment('预约ID');
            $table->date('appoint_date')->comment('就餐日期');
            $table->tinyInteger('eat_type')->comment('就餐类型1=午餐2晚餐');
            $table->time('start_time')->nullable()->comment('开始用餐时间');
            $table->time('end_time')->nullable()->comment('结束用餐时间');
            $table->integer('appoint_num')->nullable()->comment('就餐序号');
            $table->tinyInteger('appoint_type')->default(1)->comment('预约类型1=普通2特殊');
            $table->tinyInteger('is_face')->nullable()->default(0)->comment('刷脸状态 0=未刷脸 1=已刷脸');
            $table->tinyInteger('is_click')->nullable()->default(0)->comment('就餐状态 0=未点击就餐 1=已点击就餐');
            $table->tinyInteger('default')->nullable()->default(1)->comment('违约状态 1=默认违约（还需要搭配刷脸+就餐状态） 2=已移除');
            $table->tinyInteger('status')->nullable()->default(1)->comment('状态 0=取消 1=正常');
            $table->integer('evaluation_id')->nullable()->default(0)->comment('评价记录ID');
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
        Schema::dropIfExists('eat_logs');
    }
}
