<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use SoftDeletes;

    protected $guarded = ['id','deleted_at','updated_at','created_at'];

    protected $dates = ['deleted_at']; 

     /**
     * 获得此附件所属的申请表信息。n:1
     */
    public function order()
    {
        return $this->belongsTo(\App\Order::class);
    }
}
