@extends('dashboard.dash',['title'=>'Detalles del producto'])

@php
    $almacen =''; $categoria =''; $proveedor =''; $iva ='';
    try {
        $proveedor = $producto->proveedor->name;
    } catch (\Throwable $th) {
        $proveedor = 'No existe, o fue eliminado del sistema';
    }

    try {
        $categoria = $producto->categoria->name;
    } catch (\Throwable $th) {
        $categoria = 'No existe, o fue eliminado del sistema';
    }

    try {
        $almacen = $producto->almacen->name;
    } catch (\Throwable $th) {
        $almacen = 'No existe, o fue eliminado del sistema';
    }

    try {
        $iva = $producto->categoria->iva;
    } catch (\Throwable $th) {
        $iva = 0;
    }
@endphp

@section('canvas')
<style>
	.card{font-size: 1.1rem !important;}	
</style>

<div class="row m-0 p-0">
    <div class="col-md-6 offset-md-3 p-1">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{$producto->name.' '.$producto->peso}}</h5>
            </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item"> *Serial: {{$producto->id}} </li>

                  @if(auth()->user()->role == 'ROLE_ADM')
                  <li class="list-group-item"> *Fecha de ingreso a stock: {{$producto->created_at}}</li>
                  <li class="list-group-item"> *Modificado el dia: {{$producto->updated_at}}</li>
                  <li class="list-group-item"> *Categoria: {{$categoria}}</li>
                  <li class="list-group-item"> *Proveedor: {{$proveedor}}</li>
                  @endif 

                  <li class="list-group-item"> *Precio compra: {{number_format($producto->precio_compra, 2, ',', '.')}} BsS.
                    *Precio venta: {{number_format($producto->precio_venta, 2, ',', '.')}} BsS.</li>
                  <li class="list-group-item"> 
                    *Iva ({{$iva}}%) : 
                    {{number_format(($producto->precio_venta * $iva/100),2,',','.')}} BsS.
                  </li>
                  <li class="list-group-item"> *Precio total: 
                      {{number_format((($producto->precio_venta * $iva/100) + $producto->precio_venta),2,',','.')}} BsS.
                  </li>

                  @if(auth()->user()->role == 'ROLE_ADM')
                    <li class="list-group-item"> *Almacenado en: {{$almacen}},
                        @if ($producto->cantidad < 1)
                            <span class="text-danger font-italic font-weight-bold"> UNIDADES AGOTADAS </span>
                        @else
                            <span class="text-success font-italic font-weight-bold"> 
                                con {{$producto->cantidad}} Unidades en stock 
                            </span>
                        @endif
                    </li>
                  @endif

                </ul>
            <div class="card-body">
                <a href="{{URL::previous()}}" class="card-link">
                    <i class="material-icons align-middle"> arrow_back </i>
                    <span class="align-middle"> Volver </span>
                </a>
            </div>
        </div>
    </div>
</div>   
@endsection