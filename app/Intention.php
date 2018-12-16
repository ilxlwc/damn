<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Intention extends Model
{
    use SoftDeletes;

    protected $guarded = ['id','deleted_at','updated_at','created_at'];

    protected $dates = ['deleted_at']; 


     /**
     * 获得此申请表所属的业务员信息。n:1
     */
    public function order()
    {
        return $this->belongsTo(\App\Order::class);
    }

     /**
     * 获得此申请表所属的资金方信息。n:1
     */
    public function capital()
    {
        return $this->belongsTo(\App\Capital::class);
    }
}
