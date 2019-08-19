<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerFoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_foods', function (Blueprint $table) {
            $table->increments('id');
            $table->date('server_time')->comment('供餐日期');
            $table->integer('food_id')->comment('菜品ID');
            $table->integer('food_num')->comment('菜品数量');
            $table->tinyInteger('server_type')->comment('餐品类型1=午餐2=晚餐');
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
        Schema::dropIfExists('server_foods');
    }
}
