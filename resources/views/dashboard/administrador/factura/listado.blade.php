@extends('dashboard.dash',['title' => 'Historial de Notas de Entrega'])

@section('canvas')
<div class="row m-0 p-0">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form method="post" class="form-inline" action="{{route('dashboard.gethistorial_Admin')}}">
                        {{csrf_field()}}
                        <style>
                            nav div a{ font-size: 1rem; font-weight: bold;}
                        </style>
    
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link" id="nav-factura-tab" data-toggle="tab" href="#nav-factura" 
                            role="tab" aria-controls="nav-factura" aria-selected="false">Codigo de la factura</a>
                            <a class="nav-item nav-link" id="nav-date-tab" data-toggle="tab" href="#nav-cedula" 
                            role="tab" aria-controls="nav-date" aria-selected="false">Nombre del cliente</a>
                            <a class="nav-item nav-link active" id="nav-name-tab" data-toggle="tab" href="#nav-date" 
                            role="tab" aria-controls="nav-name" aria-selected="true">Fecha de la factura</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-date" role="tabpanel" >
                            <div class="form-group px-1">
                                <input type="date" name="date" id="date" class="form-control">
                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-cedula" role="tabpanel" >
                            <div class="form-group px-1">
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-factura" role="tabpanel" >
                            <div class="form-group px-1">
                                <input type="number" name="factura" id="factura" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group px-1">
                        <button type="submit" class="btn btn-block btn-danger" name="trigger" value="true"> buscar </button>
                    </div>
                    <div class="form-group ml-2 px-1">
                        <a class="btn btn-block btn-secondary" href="{{route('dashboard.historial')}}">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <table class="table m-1">
        <thead>
            <tr class="text-center">
                <th scope="col"> Serial de nota </th>
                <th scope="col"> Nombre del cliente </th>
                <th scope="col"> Fecha </th>
            </tr>
        </thead>
        <tbody> 
        @foreach($facturas as $factura)
            <tr class="text-center">
                <td> {{$factura->id}}</td>
                <td> {{$factura->cliente->name}}</td>
                <td> {{$factura->created_at}}</td>
                <td class="p-0 py-1"> 
                     <div class="btn-group dropleft" id="opciones">
                            <button class=" btn btn-sm btn-outline-danger btn-block"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons align-middle"> settings </i>
                        </button>
                        <div class="dropdown-menu p-0 m-0 rounded">
                            @if (auth()->user()->role == 'ROLE_ADM')
                                <a class="font-weight-bold text-left dropdown-item btn btn-sm btn-ouline-danger p-2"
                                href="{{route('dashboard.delhistorial_Admin',[
                                        'cliente_id' => $factura->cliente_id,
                                        'date' => $factura->created_at,
                                        'codigo' => $factura->id,
                                    ])}}">
                                    <i class="material-icons align-middle"> delete </i>
                                    <span class="align-middle"> Borrar </span>
                                </a>
                            @endif
                            <a class="font-weight-bold text-left dropdown-item btn btn-sm btn-ouline-secondary p-2"
                            href="{{route('dashboard.dethistorial_Admin',['factura_id' => $factura->id])}}">
                                <i class="material-icons align-middle"> assignment </i>
                                <span class="align-middle"> Detalles </span>
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach  
        </tbody>
    </table>
    <div class="pagination-sm">
        {{$facturas->links()}}
    </div>
    @if($errors->has('delete'))
    <div class="col-md-12 bg-warning p-2 mx-auto text-center mt-1">
        <span class="font-weight-bold"> Factura borrada correctamente </span>
    </div>
    @endif
</div>
@endsection