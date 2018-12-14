<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repayments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();   //订单信息表ID
            $table->string('repay_date')->nullable();//还款时间
            $table->string('repay_num')->nullable();//还款金额
            $table->integer('repay_status')->unsigned()->nullable();//还款状态（0:还款中,1:已还）
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repayments');
    }
}
