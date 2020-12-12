<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    protected $table = 'tb_almacenes';
    public $timestamps = false;

    protected $fillable = [
        'id', 'name', 'created_at'
    ];
}
