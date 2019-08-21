<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appoint_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户ID');
            $table->date('appoint_date')->comment('预约日期');
            $table->time('start_time')->comment('预约开始用餐时间');
            $table->time('end_time')->comment('预约结束用餐时间');
            $table->tinyInteger('eat_type')->comment('就餐类型1=午餐2晚餐');
            $table->tinyInteger('appoint_type')->comment('预约类型1=普通2特殊');
            $table->integer('appoint_num')->nullable()->comment('预约序号');
            $table->text('desc')->nullable()->comment('特殊预约备注');
            $table->tinyInteger('verify_status')->nullable()->default(0)->comment('审核状态 0=未处理 1=通过 2=未通过');
            $table->tinyInteger('is_face')->nullable()->default(0)->comment('刷脸状态 0=未刷脸 1=已刷脸');
            $table->tinyInteger('is_click')->nullable()->default(0)->comment('就餐状态 0=未点击就餐 1=已点击就餐');
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
        Schema::dropIfExists('appoint_log');
    }
}
