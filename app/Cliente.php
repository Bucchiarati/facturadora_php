<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public $timestamps = false;
    protected $table = 'tb_clientes';
    protected $fillable = ['name', 'dir'];

    public function factura()
    {
    	return $this->hasMany('App\Factura');
    }
}
