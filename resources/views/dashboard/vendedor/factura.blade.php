@extends('layouts.app',['title' => 'Facturacion'])

@section('content')
    <script src="{{asset('js/tokenQuery.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery-ui.min.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
    

    <style type="text/css">
        footer{ display: none !important; }
    </style>
    <div class="row m-0 p-0 mt-1">
        <div class="col-md-3 px-1"> 
            <h4 class="bg-dark text-center p-1 text-white"> Factura Nro: {{$codigo_factura}} </h4>
            <div class="card">
                <div class="card-body p-2">
                    <h5 class="card-title"> 
                        <span>
                            Cliente: {{$factura->cliente->name}}
                        </span>
                    </h5>
                    <h5 class="card-title"> 
                        <span>
                            Fecha: {{$factura->created_at}}
                        </span>
                    </h5>
                    <h5 class="card-title"> 
                        <span>
                            Cedula: {{$factura->cliente->ci}}
                        </span>
                    </h5>
                </div>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item"> 

                        <form method="get" action="{{route('dashboard.addItem')}}">
                            
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="serial">Nombre del Producto</label>
                                <input class="form-control" id="name" 
                                placeholder="Nombre del producto" value="{{old('name')}}">
                            </div>
                            <div class="form-group">
                                <input class="form-control" id="serial" name="serial" readonly>
                            </div>

                            <script type="text/javascript">
                                var names = new Array();
                                var code = new Array();
                        
                                $.get("{{route('getAjax.productos')}}",function(response){
                        
                                   for (let index = 0; index < response.length; index++) 
                                   {
                                       names[index] = response[index]['name']; 
                                       code[response[index]['name']] = response[index]['id']; 
                                   }  

                                });

                                $( "#name" ).autocomplete({
                                    source: names,
                                    select: function( event, ui ) 
                                    {
                                        $( "#name" ).val( ui.item.label );
                                        console.log(code[ui.item.label]);
                                        $('#serial').val(code[ui.item.label]);
                                        return false;
                                    } 
                                });
                        
                            </script>

                            <div class="form-group">
                                <label for="cantidad">Cantidad </label>
                                <input type="number" min="1" value="1" class="form-control" 
                                        id ="cantidad" name="cantidad">
                            </div>

                            <div class="form-group">
                                <button id="send" class="btn btn-danger btn-block btn-sm" type="submit"> 
                                    Añadir al carrito
                                </button>
                            </div>

                            <input type="text" name="factura_id" value="{{$factura->id}}" hidden>

                        </form>
                        @if($errors->has('error'))
                            <div class="col-md-12 bg-warning p-2 mx-auto text-center mt-1">
                                <span class="font-weight-bold"> Nombre de producto incorrecto </span>
                            </div>
                        @endif

                      </li>
                    </ul>

                <div class="card-body p-3 text-center">
                    <a href="{{route('dashboard.abortar',['id'=>$factura->id, 'mode'=>'normal'])}}" class="card-link">
                        <i class="material-icons align-middle"> arrow_back </i>
                        <span class="align-middle  py-2"> Cancelar </span>
                    </a>
                    <a href="{{route('dashboard.consolidar',['id'=>$factura->id, 'mode'=>'normal'])}}" class="card-link">
                        <i class="material-icons align-middle"> check_circle </i>
                        <span class="align-middle  py-2"> Confirmar </span>
                    </a>
                </div>

            </div>
        </div>

        <div class="col-md-9 p-0">
            <h4 class="bg-dark text-center p-1 text-white"> Listado de productos </h4>
            <div class="card">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <table class="table m-1" style="overflow-x:scroll; max-height: 10rem;">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col"> Nombre </th>
                                        <th scope="col"> Precio BsS. </th>
                                        <th scope="col"> Cantidad </th>
                                        <th scope="col"> Costo BsS.</th>
                                        <th scope="col"> Opciones </th>
                                    </tr>
                                </thead>
                                <tbody> 
                                @if(session()->get('detalles'))
                                    @foreach(session()->get('detalles'); as $detalle)
                                        <tr class="text-center">
                                            <td> {{$detalle->producto->name.' '.$detalle->producto->peso}}</td>
                                            <td> {{number_format(($detalle->producto->precio_venta), 2, '.', ',')}}</td>
                                            <td> {{$detalle->cantidad}}</td>
                                            <td> {{number_format(($detalle->producto->precio_venta * $detalle->cantidad), 2, '.', ',')}}</td>
                                            <td class="p-0 py-1"> 
                                                <div class="btn-group dropleft" id="opciones">
                                                    <button class=" btn btn-sm btn-outline-danger btn-block"
                                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="material-icons align-middle"> settings </i>
                                                    </button>
                                                    <div class="dropdown-menu p-0 m-0 rounded">
                                                        <a class="font-weight-bold text-left dropdown-item btn btn-sm btn-ouline-danger p-2"
                                                            href="{{route('dashboard.delItem',['producto_id'=>$detalle->producto_id])}}">
                                                            <i class="material-icons align-middle"> delete </i>
                                                            <span class="align-middle"> Borrar </span>
                                                        </a>
                                                        <a class="font-weight-bold text-left dropdown-item btn btn-sm btn-ouline-secondary p-2"
                                                            href="{{route('dashboard.detpdts',['id' => $detalle->producto->id])}}">
                                                            <i class="material-icons align-middle"> assignment </i>
                                                            <span class="align-middle"> Detalles </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach   
                                @endif    
                                </tbody>
                            </table>
                            @if (session()->get('detalles'))
                                <h4 class="mt-2"> Subtotal: {{number_format(session()->get('subtotal'), 2 ,',','.')}} </h4>
                                <h4 class="mt-2"> Base imponible: {{number_format(session()->get('base'), 2 ,',','.')}} </h4>
                                <h4 class="mt-2"> Iva 16%: {{number_format(session()->get('iva16'), 2 ,',','.')}} </h4>
                                <h4 class="mt-2"> Excento: {{number_format(session()->get('iva'), 2 ,',','.')}} </h4>
                                <h4 class="mt-2"> Total: {{number_format(session()->get('total'), 2 ,',','.')}} </h4>
                                <a class="btn btn-secondary" href="{{route('pdf.imprimir')}}" role="button" target="_blank">Imprimir Factura <i class="material-icons right">local_printshop</i></a>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>       
    </div>
@endsection