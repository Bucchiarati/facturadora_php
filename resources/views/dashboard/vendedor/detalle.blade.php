@extends('dashboard.dash',['title' => 'Detalles de factura'])
@php $total =0; @endphp
@section('canvas')
<div class="row m-0 p-1">
    <table class="table m-1">
        <thead>
            <tr class="text-center">
                <th scope="col"> Nombre </th>
                <th scope="col"> Precio BsS. </th>
                <th scope="col"> Cantidad </th>
                <th scope="col"> IVA BsS.(16%)</th>
                <th scope="col"> Costo de venta BsS.</th>
                <th scope="col"> Costo total BsS.</th>
            </tr>
        </thead>
        <tbody> 
        @foreach($detalles as $detalle)
            <tr class="text-center">
                 @php
                    $categoria ='';
                    try {
                        $name = $detalle->producto->name;
                    } catch (\Throwable $th) {
                        $name = '<span class="text-danger">No existe</span>';
                    }finally{ echo '<td class="text-center p-0 py-1 align-middle">'.$name.'</td>'; }
                    $total = $total + $detalle->iva;
                @endphp
                <td> {{number_format(($detalle->producto->precio_venta), 2, ',', '.')}}</td>
                <td> {{$detalle->cantidad}}</td>
                <td> {{number_format(($detalle->iva - ($detalle->producto->precio_venta * $detalle->cantidad)), 2, ',', '.')}}</td>
                <td> {{number_format(($detalle->producto->precio_venta * $detalle->cantidad), 2, ',', '.')}}</td>
                <td> {{number_format(($detalle->iva), 2, ',', '.')}}</td>
            </tr>
        @endforeach 
        </tbody>
    </table>
    <div class="pagination-sm">
        {{$detalles->links()}}
    </div>
    <div class="col-md-12 bg-dark"> <h4 class="text-right pt-2 text-white"> Total: {{number_format(($total), 2, ',', '.')}} BsS. </h4></div>
</div>
@endsection