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
            $table->increments('id');
            //字段类型
            //0:公司介绍,1:轮播图片url,2:电话,3:地址,4:联系人,5:邮箱,6:其它
            $table->integer('item_type')->unsigned();   
            $table->text('desc')->nullable();//公司介绍
            $table->string('pic')->nullable();//轮播图片url
            $table->string('tel')->nullable();//电话
            $table->string('addr')->nullable();//地址
            $table->string('linkman')->nullable();//联系人
            $table->string('email')->nullable();//邮箱
            $table->string('others')->nullable();//其它
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
