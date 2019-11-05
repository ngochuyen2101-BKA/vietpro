<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $table='info';

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user', 'id');
    }
}
