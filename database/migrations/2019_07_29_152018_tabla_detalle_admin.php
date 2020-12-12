<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaDetalleAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_detallesAdmin', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedInteger('factura_id');
            $table->bigInteger('producto_id');
            $table->unsignedInteger('cantidad');
            $table->float('precio',20,2);
            $table->float('iva', 20,2);

            $table->foreign('factura_id')->references('id')->on('tb_facturasAdmin');
            $table->foreign('producto_id')->references('id')->on('tb_productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_detallesAdmin');
    }
}
