<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_productos', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique()->primary();
            $table->string('name');
            $table->unsignedBigInteger('cantidad');
            $table->string('peso');
            $table->float('precio_venta',20,2);
            $table->float('precio_compra',20,2);
            $table->string('created_at');
            $table->string('updated_at');
            $table->unsignedBigInteger('proveedor_id');
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('almacen_id');
            
            $table->foreign('categoria_id')->references('id')->on('tb_categorias');
            $table->foreign('proveedor_id')->references('id')->on('tb_proveedores');
            $table->foreign('almacen_id')->references('id')->on('tb_almacenes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_productos');
    }
}
