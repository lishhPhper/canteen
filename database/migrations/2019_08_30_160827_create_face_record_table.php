<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaceRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('face_record', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('record_id')->comment('拉取记录ID');
            $table->string('EmployName',50)->nullable()->comment('用户姓名');
            $table->string('DepartmentID',50)->nullable()->comment('部门ID');
            $table->string('DepartName',50)->nullable()->comment('部门名称');
            $table->string('AreaID',50)->nullable()->comment('区域ID');
            $table->string('AreaName',200)->nullable()->comment('区域名称');
            $table->string('EmployNO',50)->nullable()->comment('用户工号');
            $table->bigInteger('CardID')->nullable()->comment('用户卡号');
            $table->string('RoleID',50)->nullable();
            $table->dateTime('DateTimeRecord')->nullable()->comment('刷脸时间');
            $table->string('RecordDes',200)->nullable()->comment('描述');
            $table->string('FaceIP',50)->nullable()->comment('设备IP');
            $table->string('InOrOut',20)->nullable()->comment('进出描述');
            $table->string('Des1',200)->nullable();
            $table->string('Des2',200)->nullable();
            $table->string('Des3',200)->nullable();
            $table->string('Des4',200)->nullable();
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
        Schema::dropIfExists('face_record');
    }
}
