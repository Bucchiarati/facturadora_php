<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_Admin extends Model
{
    protected $table = 'tb_detallesAdmin';
    public $timestamps = false;

    public function producto()
    {
        return $this->belongsTo('App\Producto');
    }

    public function factura()
    {
        return $this->belongsTo('App\Factura_Admin');
    }
}
