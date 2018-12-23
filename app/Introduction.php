<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Introduction extends Model
{
    use SoftDeletes;

    protected $guarded = ['id','deleted_at','updated_at','created_at'];

    protected $dates = ['deleted_at']; 
}
