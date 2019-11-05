<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='category';
    public $timestamps=false;

    public function product()
    {
        return $this->hasMany('App\Models\Product', 'category_id', 'id');
    }
}
