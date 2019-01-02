<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('tel')->nullable();
            $table->integer('apply_identity')->unsigned();   //申请身份（1：业务员，2：资金方）
            $table->integer('apply_status')->unsigned()->default(0);//该申请的处理状态（0:默认值，1:已处理， 2:不处理）
            $table->string('openId')->nullable();
            $table->string('nickName')->nullable();
            $table->string('gender')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();
            $table->string('avatarUrl')->nullable();
            $table->string('unionId')->nullable();
            $table->string('appid')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('clients');
    }
}
