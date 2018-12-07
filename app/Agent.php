<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    use SoftDeletes;

    protected $guarded = ['id','deleted_at','updated_at','created_at'];

    protected $dates = ['deleted_at']; 

    /**
     * 获得此业务员的申请表信息；1：n关系
     */
	public function orders()
	{
	    return $this->hasMany(\App\Order::class);
	}
}
