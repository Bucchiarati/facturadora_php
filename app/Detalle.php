<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    protected $table = 'tb_detalles';
    public $timestamps = false;

    public function producto()
    {
        return $this->belongsTo('App\Producto');
    }

    public function factura()
    {
        return $this->belongsTo('App\Factura');
    }
}
