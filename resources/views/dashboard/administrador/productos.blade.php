
@extends('dashboard.dash', ['title' => 'Manejo de productos'])

@section('canvas')

    <style> #opciones{ border-radius: 20% !important; }</style>
    <div class="row m-0">
        <div class="col-md-4 p-2">
            <h4 class="text-center bg-dark text-white p-1"> Registro de productos </h4>
            <form class="row m-0 p-0" method="post" action="{{route('dashboard.addpdts')}}">
                {{csrf_field()}}

                <div class="col-md-6 m-0 p-1">
                    <div class="form-group">
                        <label for="id">Serial del Producto</label>
                        <input class="form-control" id="id" name="id"
                               placeholder="(solamente numeros)" value="{{old('id')}}">
                    </div>
                </div>

                <div class="col-md-6 m-0 p-1">
                    <div class="form-group">
                        <div class="row m-0 p-0">
                            <div class="col-md-6 p-0 m-0">
                                <label for="id">Presentacion</label>
                                <input class="form-control" id="peso" name="peso">
                            </div>
                            <div class="col-md-6 p-0 m-0">
                                <label for="id">Unidad</label>
                                <select class="custom-select" id="unidad" name="unidad">
                                    <option selected value="" > Escoja una opcion </option>
                                    <option value="Und" > UNIDADES </option>
                                    <option value="Kg" > KILOGRAMOS </option>
                                    <option value="Gr" > GRAMOS </option>
                                    <option value="Ltrs" > LITROS </option>
                                    <option value="Ml" > MILILITROS </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 m-0 p-1">
                    <div class="form-group">
                        <label for="name">Descripcion del producto</label>
                        <input class="form-control" id="name" name="name" 
                        placeholder="Nombre del producto" value="{{old('name')}}">
                    </div>
                </div>

                <div class="col-md-6 m-0 p-1">
                    <div class="form-group">
                        <label for="price"> Proveedor del producto </label>
                        <select class="custom-select" id="proveedor" name="proveedor">
                            <option selected value="" > Escoja una opcion </option>
                            @foreach($proveedores as $proveedor)
                                <option value="{{$proveedor->id}}" > {{$proveedor->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6 m-0 p-1">
                    <div class="form-group">
                        <label for="price"> Almacen </label>
                        <select class="custom-select" id="almacen" name="almacen">
                            <option selected value="" > Escoja una opcion </option>
                            @foreach ($almacenes as $almacen)
                                <option value="{{$almacen->id}}" > {{$almacen->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6 m-0 p-1">
                    <div class="form-group">
                        <label for="price"> Categoria del producto </label>
                        <select class="custom-select" id="categoria" name="categoria">
                            <option selected value="" > Escoja una opcion </option>
                            @foreach($categorias as $categoria)
                                <option value="{{$categoria->id}}" > {{$categoria->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6 m-0 p-1">
                    <div class="form-group">
                        <label for="count">Cantidad (Unidades)</label>
                        <input type="number" min="1" class="form-control" id ="count" name="count" 
                        placeholder="Unidades del producto" value="{{old('cantidad')}}">
                    </div>
                </div>

                <div class="col-md-6 m-0 p-1">
                    <div class="form-group">
                        <label for="descp">Precio de venta</label>
                        <input type="text" class="form-control" id="precio_venta" name="precio_venta" 
                        placeholder="peso neto del producto" value="{{old('precio_venta')}}">
                    </div>
                </div>

                <div class="col-md-6 m-0 p-1">
                    <div class="form-group">
                        <label for="price">Precio de compra</label>
                        <input type="text" class="form-control" id ="precio_compra" name="precio_compra" 
                        placeholder="Precio del producto" value="{{old('precio_compra')}}">
                    </div>
                </div>

                <div class="col-md-6 m-0 p-1">
                    <div class="form-group">
                        <button class="btn btn-danger btn-block btn-sm" type="submit"> Guardar Producto </button>
                    </div>
                </div>

                <div class="col-md-6 m-0 p-1">
                    <div class="form-group">
                        <a class="btn btn-secondary btn-block btn-sm" href="{{route('dashboard')}}"> Volver al inicio </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-8 p-2">
            <h4 class="text-center bg-dark text-white p-1"> Productos registrados </h4>
            <div class="row m-0">

                <table class="table">
                    <thead>
                    <tr class="text-center">
                        <th scope="col"> # </th>
                        <th scope="col"> Nombre </th>
                        <th scope="col"> Cantidad </th>
                        <th scope="col"> Categoria </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($productos as $producto)
                        <tr class="text-center">
                            <td class=" p-0 py-1 align-middle"> {{$producto->id}} </td>
                            <td class=" p-0 py-1 align-middle"> {{$producto->name}}</td>
                            @if ($producto->cantidad < 1)
                                <td class=" p-0 py-1 align-middle text-danger"> AGOTADO </td>
                            @else
                                <td class=" p-0 py-1 align-middle"> {{$producto->cantidad}} </td>
                            @endif

                            @php
                                $categoria ='';
                                try {
                                    $categoria = $producto->categoria->name;
                                } catch (\Throwable $th) {
                                    $categoria = '<span class="text-danger">No existe</span>';
                                }finally{ echo '<td class="text-center p-0 py-1 align-middle">'.$categoria.'</td>'; }
                            @endphp
                                

                            <td class="p-0 py-1"> 
                                <div class="btn-group dropleft" id="opciones">
                                    <button class=" btn btn-sm btn-outline-danger btn-block"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons align-middle"> settings </i>
                                    </button>
                                    <div class="dropdown-menu p-0 m-0 rounded">
                                        @if (auth()->user()->role == 'ROLE_ADM')
                                            <a class="font-weight-bold text-left dropdown-item btn btn-sm btn-ouline-danger p-2"
                                               href="{{route('dashboard.delpdts',['id'=>$producto->id])}}">
                                                <i class="material-icons align-middle"> delete </i>
                                                <span class="align-middle"> Borrar </span>
                                            </a>
                                            <a class="font-weight-bold text-left dropdown-item btn btn-sm btn-ouline-secondary p-2"
                                               href="{{route('dashboard.modpdts',['id' => $producto->id, 'mode' => 'get' ])}}">
                                                <i class="material-icons align-middle"> border_color </i>
                                                <span class="align-middle"> Modificar </span>
                                            </a>
                                        @endif
                                        <a class="font-weight-bold text-left dropdown-item btn btn-sm btn-ouline-secondary p-2"
                                            href="{{route('dashboard.detpdts',['id' => $producto->id])}}">
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
                        {{$productos->links()}}
                    </div>
            </div>
            </div>
            @if($errors->has('numeric'))
                <div class="col-md-12 bg-warning p-2 mx-auto text-center">
                    <span class="font-weight-bold"> Valor numérico erroneo, verifique </span>
                </div>
            @endif
            @if($errors->has('delete'))
                <div class="col-md-12 bg-warning p-2 mx-auto text-center">
                    <span class="font-weight-bold"> Producto borrado con exito </span>
                </div>
            @endif
            @if($errors->has('save'))
                <div class="col-md-12 bg-success p-2 mx-auto text-center">
                    <span class="font-weight-bold"> Producto guardado con exito </span>
                </div>
            @endif
            @if($errors->has('fail'))
                <div class="col-md-12 bg-warning p-2 mx-auto text-center">
                    <span class="font-weight-bold"> Problemas al guardar el producto, verifique datos </span>
                </div>
            @endif        
            @if($errors->has('older'))
                <div class="col-md-12 bg-warning p-2 mx-auto text-center">
                    <span class="font-weight-bold"> Este producto ya existe en almacen </span>
                </div>
            @endif
        </div>
    </div>
@endsection