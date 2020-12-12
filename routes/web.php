<?php

use App\Producto;
set_time_limit(0);
ini_set("memory_limit",-1);
ini_set("max_excution_time",0);

Route::get('/', 'Auth\LoginController@showLogin');

Route::get('/dashboard','DashboardController@index')->name('dashboard');

Route::group(['prefix'=>'/dashboard', 'middleware' => 'auth' ], function (){

    //OPCIONES DEL MENU DE ADMINISTRACION PRINCIPAL
    Route::get('/proveedores','ProvController@index')->name('dashboard.proveedores');
    Route::get('/categorias','CatgController@index')->name('dashboard.categorias');
    Route::get('/usuarios', 'UserController@index')->name('dashboard.usuarios');
    Route::get('/productos', 'ProductosController@index')->name('dashboard.productos');
    Route::get('/facturas','FacturaController@index')->name('dashboard.factura');
    Route::get('/almacen', 'AlmacenController@index')->name('dashboard.almacen');

    //OPCIONES DE LA SECCION DE PROVEEDORES
    Route::post('/proveedores','ProvController@index')->name('dashboard.provbuscar');
    Route::post('/proveedores/añadir','ProvController@add')->name('dashboard.addprov');
    Route::post('/proveedores/modificar','ProvController@modify')->name('dashboard.modprov');
    Route::get('/proveedores/borrar', 'ProvController@delete')->name('dashboard.delprov');

    //OPCIONES DE LA SECCION DE CATEGORIAS
    Route::post('/categorias','CatgController@index')->name('dashboard.catgbuscar');
    Route::post('/categorias/añadir','CatgController@add')->name('dashboard.addcatg');
    Route::post('/categorias/modificar','CatgController@modify')->name('dashboard.modcatg');
    Route::get('/categorias/borrar', 'CatgController@delete')->name('dashboard.delcatg');

    //OPCIONES DE LA SECCION DE USUARIOS
    Route::post('/usuarios','UserController@index')->name('dashboard.userbuscar');
    Route::post('/usuarios/añadir','UserController@add')->name('dashboard.adduser');
    Route::post('/usuarios/modificar','UserController@modify')->name('dashboard.moduser');
    Route::get('/usuarios/borrar', 'UserController@delete')->name('dashboard.deluser');

    //OPCIONES DE LA SECCION DE PRODUCTOS
    Route::post('/productos/añadir','ProductosController@add')->name('dashboard.addpdts');
    Route::post('/productos/modificar','ProductosController@modify')->name('dashboard.savepdt');
    Route::post('/productos/buscar','ProductosController@listado')->name('dashboard.getbuscar');
    Route::get('/productos/formulario','ProductosController@modify')->name('dashboard.modpdts');
    Route::get('/productos/detalles','ProductosController@details')->name('dashboard.detpdts');
    Route::get('/productos/borrar', 'ProductosController@delete')->name('dashboard.delpdts');
    Route::get('/productos/buscar','ProductosController@listado')->name('dashboard.pdtsbuscar');

    //OPCIONES DE LA SECCION DE FACTURACION
    Route::post('/factura/cliente/buscar','FacturaController@index')->name('dashboard.bscCliente');
    Route::post('/factura/cliente/añadir','FacturaController@addCliente')->name('dashboard.addCliente');

    Route::post('/factura/historial','FacturaController@historial')->name('dashboard.gethistorial');
    Route::get('/factura/cliente','FacturaController@index')->name('dashboard.cliente');
    Route::get('/factura/historial/detalles','FacturaController@detHistorial')->name('dashboard.dethistorial');
    Route::get('/factura/historial/borrar','FacturaController@delHistorial')->name('dashboard.delhistorial');

    Route::get('/factura/facturar/agregar','FacturaController@addItem')->name('dashboard.addItem');
    Route::get('/factura/facturar/pagar','FacturaController@consolidar')->name('dashboard.consolidar');
    Route::get('/factura/facturar/abortar','FacturaController@cancelar')->name('dashboard.abortar');
    Route::get('/factura/facturar/borrar','FacturaController@delItem')->name('dashboard.delItem');
    Route::get('/factura/cliente/borrar','FacturaController@delCliente')->name('dashboard.delCliente');
    Route::get('/factura/facturar','FacturaController@factura')->name('dashboard.facturar');
    Route::get('/factura/historial','FacturaController@historial')->name('dashboard.historial');

    //OPCIONES DE FACTURACION ESPECIAL
    Route::post('/factura/especial/historial','FacturaAdminController@historial')->name('dashboard.gethistorial_Admin');

    Route::get('/factura/especial/historial/detalles','FacturaAdminController@detHistorial')->name('dashboard.dethistorial_Admin');
    Route::get('/factura/especial/historial/borrar','FacturaAdminController@delHistorial')->name('dashboard.delhistorial_Admin');
    Route::get('/factura/especial/historial','FacturaAdminController@historial')->name('dashboard.historial_Admin');
    Route::get('/facturas/especial/cliente','FacturaAdminController@index')->name('dashboard.factura_Admin');
    Route::get('/facturas/especial/facturar','FacturaAdminController@factura')->name('dashboard.facturar_Admin');

    //OPCIONS DE LA SECCION DE ALMACEN
    Route::post('/almacen/añadir','AlmacenController@add')->name('dashboard.addstrg');
    Route::get('/almacen/borrar', 'AlmacenController@delete')->name('dashboard.delstrg');

    //OPCIONES DE CODIGO DE FACTURA
    Route::get('/codigo/factura',function(){
        return view('dashboard.codigo.codigo');
    })->name('dashboard.codFactura');
    Route::post('/codigo/factura/especial','FacturaAdminController@codFactura')->name('dashboard.codnormal');
    Route::post('/codigo/factura/normal','FacturaAdminController@codFactura_Admin')->name('dashboard.codespecial');

    //OPCION A CERCA DE
    Route::get('/autores',function (){
        return view('dashboard.autores');
    })->name('dashboard.autores');
    

});

Route::post('login', 'Auth\LoginController@login')->name('login');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::post('/dashboard','DashboardController@index')->name('dashboard');

Route::get('/customer/pdf/factura', 'CustomerController@printPDF')->name('pdf.imprimir');
Route::get('/customer/pdf/nota_entrega', 'CustomerController@printPDFnota')->name('pdf.imprimirnota');


Route::get('ajax/get/productos', function () {
    $productos = Producto::all();
    return $productos->toArray();
})->name('getAjax.productos');