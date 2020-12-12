@extends('dashboard.dash',['title' => 'Productos registrados'])

@section('canvas')
<div class="row m-0 p-0">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
            <form method="post" class="form-inline" action="{{route('dashboard.getbuscar')}}">
                    {{csrf_field()}}
                    <style>
                        nav div a{ font-size: 1rem; font-weight: bold;}
                    </style>

                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-name-tab" data-toggle="tab" href="#nav-name" role="tab" aria-controls="nav-name" aria-selected="true">Nombre</a>
                            <a class="nav-item nav-link" id="nav-date-tab" data-toggle="tab" href="#nav-date" role="tab" aria-controls="nav-date" aria-selected="false">Fecha</a>
                            <a class="nav-item nav-link" id="nav-categoria-tab" data-toggle="tab" href="#nav-categoria" role="tab" aria-controls="nav-categoria" aria-selected="false">Categoria</a>
                            <a class="nav-item nav-link" id="nav-codigo-tab" data-toggle="tab" href="#nav-codigo" role="tab" aria-controls="nav-codigo" aria-selected="false">Codigo</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-name" role="tabpanel" >
                            
                            <div class="form-group px-1">
                                <input type="text" name="name" id="name" class="form-control" min="0">
                            </div>
                            
                        </div>

                        <div class="tab-pane fade" id="nav-date" role="tabpanel" >
                            
                            <div class="form-group px-1">
                                <input type="date" name="date" id="date" class="form-control">
                            </div>
                            
                        </div>

                        <div class="tab-pane fade" id="nav-categoria" role="tabpanel" >
                            
                            <div class="form-group px-1">
                                <select class="custom-select" id="categoria" name="categoria">
                                    <option selected value="" > Selecione una categoria </option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{$categoria->id}}" > {{$categoria->name}} </option>
                                    @endforeach
                                </select>
                            </div> 
                        
                        </div>
                        <div class="tab-pane fade" id="nav-codigo" role="tabpanel" >
                            <div class="form-group px-1">
                                <input type="number" name="serial" id="serial" class="form-control" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="form-group px-1">
                        <button type="submit" class="btn btn-block btn-danger" name="trigger" value="true"> buscar </button>
                    </div>
                    <div class="form-group ml-2 px-1">
                        <a class="btn btn-block btn-secondary" href="{{route('dashboard.pdtsbuscar')}}">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <table class="table">
            <thead>
            <tr class="text-center">
                <th scope="col"> # </th>
                <th scope="col"> Nombre </th>
                <th scope="col"> Cantidad </th>
                <th scope="col"> Categoria </th>
                <th scope="col"> Proveedor </th>
                <th scope="col"> Almacen </th>
            </tr>
            </thead>
            <tbody>
            @foreach($productos as $producto)
                <tr>
                    <td class="text-center"> {{$producto->id}} </td>
                    <td class="text-center"> {{$producto->name}}</td>
                    @if ($producto->cantidad < 1)
                        <td class=" p-0 py-1 align-middle text-danger text-center"> AGOTADO </td>
                    @else
                        <td class=" p-0 py-1 align-middle text-center"> {{$producto->cantidad}} </td>
                    @endif
                    @php
                        $categoria ='';
                        try {
                            $categoria = $producto->categoria->name;
                        } catch (\Throwable $th) {
                            $categoria = '<span class="text-danger">No existe</span>';
                        }finally{ echo '<td class="text-center p-0 py-1 align-middle">'.$categoria.'</td>'; }
                    @endphp
                    @php
                        $categoria ='';
                        try {
                            $categoria = $producto->Proveedor->name;
                        } catch (\Throwable $th) {
                            $categoria = '<span class="text-danger">No existe</span>';
                        }finally{ echo '<td class="text-center p-0 py-1 align-middle">'.$categoria.'</td>'; }
                    @endphp
                    @php
                        $categoria ='';
                        try {
                            $categoria = $producto->Almacen->name;
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
@endsection