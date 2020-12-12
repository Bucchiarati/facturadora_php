<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'tb_categorias';
    public $timestamps = false;

    protected $fillable = [

        'id', 'name', 'created_at'
    ];
}
