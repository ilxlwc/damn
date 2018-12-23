<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntroductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('introductions', function (Blueprint $table) {
            //该数据库的第一条为基本信息，其余的都为轮播图片
            $table->increments('id');
            $table->integer('item_type')->unsigned(); //0:基本信息，1:轮播图片 
            $table->text('desc')->nullable();//公司介绍
            $table->string('tel')->nullable();//电话
            $table->string('addr')->nullable();//地址
            $table->string('linkman')->nullable();//联系人
            $table->string('email')->nullable();//邮箱
            $table->string('others')->nullable();//其它
            
            $table->string('pic')->nullable();//轮播图片url
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
        Schema::dropIfExists('introductions');
    }
}
