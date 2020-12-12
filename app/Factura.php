<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'tb_facturas';
    public $timestamps = false;

    protected $fillable = ['created_at'];

    public function cliente()
    {
        return $this->belongsTo('App\Cliente');
    }
}

