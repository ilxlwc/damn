<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();   //订单信息表ID
            $table->string('url');//附件存储地址
            //附件类型
            //0:身份证图片,1:户口本图片,2:婚姻证明图片,3:征信记录图片,
            //4:房产证图片,5:营业执照或工作证明,6:流水私发,7:评估截图,
            $table->integer('file_type')->unsigned();
            $table->string('file_desc')->nullable();//附件存储地址
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
        Schema::dropIfExists('attachments');
    }
}
