<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntentionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intentions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();    //订单信息表ID
            $table->integer('capital_id')->unsigned();  //资金方ID
            $table->string('email')->nullable();
            $table->string('other_info')->nullable();//附件描述信息            
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('capital_id')->references('id')->on('capitals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intentions');
    }
}
