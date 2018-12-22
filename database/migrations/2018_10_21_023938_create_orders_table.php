<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();   //借贷人ID
            $table->integer('agent_id')->unsigned()->nullable();   //业务员ID
            $table->integer('capital_id')->unsigned()->nullable();   //资金方ID
            $table->string('agent_name')->nullable(); //业务员名字
            $table->string('agent_tel')->nullable(); //业务员电话
            $table->string('capital_name')->nullable(); //资金方名字
            $table->string('capital_tel')->nullable(); //资金方电话
            $table->string('apply_amount')->nullable(); //申请金额（借贷者）
            $table->string('prepare_amount')->nullable();//准备贷款金额（业务员）
            $table->string('approve_amount')->nullable();//实批金额（管理员）
            $table->integer('repay_status')->unsigned()->default(0);//还款状态（0:还款中,1:已还）
            $table->integer('status')->unsigned()->default(0);//该申请的处理状态（0:新订单，1:审核中， 2:寻款中，3:已批款,4:不置理）
            $table->string('service_type')->nullable();//业务类型
            $table->string('charge')->nullable();//收费
            $table->string('returnfee')->nullable();//返费
            $table->string('assess_source')->nullable();//评估来源
            $table->string('assess_unit_price')->nullable();//评估单价
            $table->string('assess_gross_amount')->nullable();//评估总额
            $table->string('name')->nullable();//姓名
            $table->integer('age')->unsigned()->nullable();//年龄
            $table->char('gender',10)->nullable();//姓别（0：未知、1：男、2：女）
            $table->string('idcard')->nullable();//身份证号
            $table->string('tel')->nullable();//联系电话
            $table->string('client_remark')->nullable();//客户备注信息
            $table->char('marital_status',10->nullable();//婚姻状况（未婚0、已婚1、离异2）
            $table->string('coborrower_relation')->nullable();//共借人关系
            $table->string('coborrower_name')->nullable();//共借人姓名
            $table->char('coborrower_gender',10)->nullable();//共借人姓别（0：未知、1：男、2：女）
            $table->string('coborrower_idcard')->nullable();//共借人身份证号
            $table->string('coborrower_tel')->nullable();//共借人联系电话
            $table->char('credit_record',10)->nullable();//信用记录是否空白（0：空白，1：非空白）
            $table->char('credit_record_status',10)->nullable();//信用记录是否包含止付，冻结，杂帐（0：不包含，1包含）
            $table->string('overdue')->nullable();//当前是否逾期（0：没逾期，1：逾期）
            $table->string('house_type')->nullable();//房产类型
            $table->string('house_owner')->nullable();//产权人
            $table->char('owner_type',20)->nullable();//单独或共同拥有（0：未知，1单独拥有，2共同拥有）
            $table->string('house_address')->nullable();//房产地址
            $table->string('house_owner_certificate')->nullable();//权属证明
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('agent_id')->references('id')->on('agents');
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
        Schema::dropIfExists('orders');
    }
}
