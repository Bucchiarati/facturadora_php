<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public $timestamps = false;
    protected $table = 'tb_productos';
    protected $fillable = ['name', 'precio', 'cantidad', 'created_at', 'nro'];

    public function facturas()
    {
        return $this->belongsTo('App\Factura');
    }

    public function categoria()
    {
        return $this->belongsTo('App\Categoria');    
    }

    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor');
    }

    public function almacen()
    {
        return $this->belongsTo('App\Almacen');
    }
}
