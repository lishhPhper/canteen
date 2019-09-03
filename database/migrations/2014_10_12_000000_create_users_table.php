<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone')->unique()->comment('手机号码');
            $table->string('password')->comment('密码');
            $table->string('name')->comment('姓名');
            $table->string('avatar')->nullable()->comment('头像');
            $table->string('department')->nullable()->comment('部门');
            $table->tinyInteger('type')->comment('属性1=普通用户2=白名单3=管理员');
            $table->string('face_id')->nullable()->comment('人脸ID');
            $table->string('employ_id')->nullable()->comment('工号ID');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
