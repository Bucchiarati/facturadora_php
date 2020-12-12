@extends('dashboard.dash',['title' => 'Modificar producto'])

@section('canvas')
    <div class="row m-0 p-0">
        @if($errors->has('save'))
            <div class="col-md-12 bg-success p-2 mx-auto text-center">
                <span class="font-weight-bold"> Producto modificado con exito </span>
            </div>
        @endif
        @if($errors->has('numeric'))
            <div class="col-md-12 bg-success p-2 mx-auto text-center">
                <span class="font-weight-bold"> Valor numerico erróneo, verifique el formulario </span>
            </div>
        @endif
        @if($errors->has('fail'))
            <div class="col-md-12 bg-warning p-2 mx-auto text-center">
                <span class="font-weight-bold"> Problemas al modificar el producto, verifique datos </span>
            </div>
        @endif  
        <div class="col-md-6 offset-md-3 p-2">
            <h4 class="text-center bg-dark text-white p-1"> Formulario de producto a modificar </h4>
            <form class="row m-0 p-0" method="post" action="{{route('dashboard.savepdt',['mode' => 'post'])}}">
                {{csrf_field()}}

                <div class="col-md-6 m-0 p-1">
                    <div class="form-group">
                        <label for="id">Serial del Producto</label>
                        <input class="form-control" id="id" name="id"
                               placeholder="(solamente los numeros)" 
                               value=" {{$producto->id}}" readonly>
                    </div>
                </div>

                <div class="col-md-6 m-0 p-1">
                    <div class="form-group">
                        <label for="name">Nombre del Producto</label>
                        <input class="form-control" id="name" name="name" 
                        placeholder="Nombre del producto" value=" {{$producto->name}}">
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
                        <label for="almacen"> Almacen </label>
                        <select class="custom-select" id="almacen" name="almacen">
                            <option selected value="{{$producto->almacen->id}}" > Valor anterior: {{$producto->almacen->name}} </option>
                            @foreach($almacenes as $almacen)
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
                        list="cantidad">
                    </div>
                </div>

                <datalist id="cantidad"> <option value="{{$producto->cantidad}}"> </datalist>
                
                <div class="col-md-6 m-0 p-1">
                    <div class="form-group">
                        <label for="descp">Precio de venta</label>
                        <input type="text" class="form-control" id="precio_venta" name="precio_venta" 
                        placeholder="peso neto del producto" value="{{$producto->precio_venta}}">
                    </div>
                </div>

                <div class="col-md-6 m-0 p-1">
                    <div class="form-group">
                        <label for="price">Precio de compra</label>
                        <input type="text" class="form-control" id ="precio_compra" name="precio_compra" 
                        placeholder="Precio del producto" value="{{$producto->precio_compra}}">
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
                                    <option value="Kg" > KILOGRAMOS </option>
                                    <option value="Gr" > GRAMOS </option>
                                    <option value="Ltrs" > LITROS </option>
                                    <option value="Ml" > MILILITROS </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 m-0 p-1">
                    <div class="form-group">
                        <label for="price">Modifacdo el dia: </label>
                        <input type="text" class="form-control" value="{{date('d-m-Y')}}" readonly>
                    </div>
                </div>

                <div class="col-md-6 m-0 p-1">
                    <div class="form-group">
                        <button class="btn btn-danger btn-block btn-sm" type="submit"> Guardar Producto </button>
                    </div>
                </div>

                <div class="col-md-6 m-0 p-1">
                    <div class="form-group"> 
                        <a class="btn btn-secondary btn-block btn-sm" href="{{route('dashboard.pdtsbuscar')}}"> Volver a productos </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection