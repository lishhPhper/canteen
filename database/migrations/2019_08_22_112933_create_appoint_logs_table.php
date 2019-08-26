<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appoint_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户ID');
            $table->date('appoint_date')->comment('预约日期');
            $table->tinyInteger('eat_type')->comment('就餐类型1=午餐2晚餐');
            $table->time('start_time')->nullable()->comment('开始用餐时间');
            $table->time('end_time')->nullable()->comment('结束用餐时间');
            $table->tinyInteger('appoint_type')->default(1)->comment('预约类型1=普通2特殊');
            $table->text('desc')->nullable()->comment('特殊预约备注');
            $table->tinyInteger('verify_status')->nullable()->default(0)->comment('审核状态 0=未处理 1=通过 2=未通过');
            $table->tinyInteger('status')->nullable()->default(1)->comment('预约状态 0=取消 1=正常');
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
        Schema::dropIfExists('appoint_logs');
    }
}
