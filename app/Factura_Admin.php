<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura_Admin extends Model
{
    protected $table = 'tb_facturasAdmin';
    public $timestamps = false;

    protected $fillable = ['created_at'];

    public function cliente()
    {
        return $this->belongsTo('App\Cliente');
    }
}
