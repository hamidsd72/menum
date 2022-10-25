<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['id', 'service_id','user_id', 'title', 'slug', 'food_type', 'created_at', 'updated_at'];

    // protected $guarded = ['id', 'created_at', 'updated_at'];

    // public function pictures()
    // {
    //     return $this->morphTo();
    // }
}
