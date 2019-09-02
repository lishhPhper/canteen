<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaceUpdateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('face_update_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('last_record_id')->comment('最后拉取的数据ID');
            $table->dateTime('last_record_time')->comment('最后拉取的数据时间');
            $table->date('update_date')->comment('拉取日期');
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
        Schema::dropIfExists('face_update_log');
    }
}
