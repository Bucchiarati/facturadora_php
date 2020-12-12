<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'tb_proveedores';
    public $timestamps = false;

    protected $fillable = [];
}
