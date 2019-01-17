<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $guarded = ['id','deleted_at','updated_at','created_at'];

    protected $dates = ['deleted_at'];

    // 追加到模型数组表单的访问器
    protected $appends = ['is_overdue'];

	/**
     * 获得此申请的附件；1：n关系
     */
    public function attachments()
	{
	    return $this->hasMany(\App\Attachment::class);
	}

	/**
     * 获得此申请的还款信息；1：n关系
     */
	public function repayments()
	{
	    return $this->hasMany(\App\Repayment::class);
	}

    /**
     * 获得此申请的有意向的资金方；1：n关系
     */
    public function intention()
    {
        return $this->hasMany(\App\Intention::class);
    }

	 /**
     * 获得此申请表所属的客户信息。n:1
     */
    public function client()
    {
        return $this->belongsTo(\App\Client::class);
    }

     /**
     * 获得此申请表所属的业务员信息。n:1
     */
    public function agent()
    {
        return $this->belongsTo(\App\Agent::class);
    }

     /**
     * 获得此申请表所属的资金方信息。n:1
     */
    public function capital()
    {
        return $this->belongsTo(\App\Capital::class);
    }
}
