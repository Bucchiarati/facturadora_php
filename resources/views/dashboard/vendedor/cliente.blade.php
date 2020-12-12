@extends('dashboard.dash', ['title'=>'Facturación/Clientes'])
@section('canvas')
    <div class="row m-0">
        <div class="col-md-4 p-2">
            <h4 class="text-center bg-dark text-white p-1"> Registro de clientes </h4>
            <form method="post" action="{{route('dashboard.addCliente')}}">
                {{csrf_field()}}

                <div class="form-group">
                    <div class="row m-0 p-0">
                        <div class="col-md-6 p-0 m-0">
                            <label for="id">Id del cliente</label>
                            <input type="number" class="form-control" id="id" name="id"
                             placeholder="solamente números">
                        </div>
                        <div class="col-md-6 p-0 m-0">
                            <label for="id">Tipo de cliente</label>
                            <select class="custom-select" id="tipo" name="tipo">
                                <option selected value="" > Escoja una opcion </option>
                                <option value="J" > JURIDICO (J)</option>
                                <option value="G" > GUBERNAMENTAL (G)</option>
                                <option value="E" > EXTRANJERO (E)</option>
                                <option value="V" > VENEZOLANO (V)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Nombre del cliente</label>
                    <input class="form-control" id="name" name="name" placeholder="Nombre del cliente">
                </div>

                <div class="form-group">
                    <label for="dir">Direccion del cliente</label>
                    <input class="form-control" id="dir" name="dir" placeholder="Direccion del cliente">
                </div>

                <div class="form-group">
                    <label for="dir">Telefono del cliente</label>
                    <input class="form-control" id="phone" name="phone">
                </div>

                <div class="form-group">
                    <button class="btn btn-danger btn-block btn-sm" type="submit"> Guardar nuevo Cliente </button>
                    <a class="btn btn-secondary btn-block btn-sm" href="{{route('dashboard')}}"> Volver al inicio </a>
                </div>
            </form>
            @if($errors->has('delete'))
                <div class="col-12 bg-warning p-2 mx-auto text-center">
                    <span class="font-weight-bold"> Cliente borrado con exito </span>
                </div>
            @endif
            @if($errors->has('save'))
                <div class="col-12 bg-success p-2 mx-auto text-center">
                    <span class="font-weight-bold"> Cliente guardado con exito </span>
                </div>
            @endif
            @if($errors->has('fail'))
                <div class="col-12 bg-warning p-2 mx-auto text-center">
                    <span class="font-weight-bold"> Problemas al guardar el cliente, verifique datos </span>
                </div>
            @endif
            @if($errors->has('older'))
                <div class="col-12 bg-warning p-2 mx-auto text-center">
                    <span class="font-weight-bold"> El cliente ya existe en el sistema, use el buscador para aligerar la facturación </span>
                </div>
            @endif
        </div>

        <div class="col-md-8 p-2">
            <h4 class="text-center bg-dark text-white p-1"> Clientes registrados </h4>
            <div class="row m-0">
                <div class="col-12 my-2">
                    <form method="post" class="form-inline" action="{{route('dashboard.bscCliente')}}">
                        {{csrf_field()}}

                        <div class="form-group ">
                            <label for="id">Nombre del cliente</label>
                            <input class="form-control ml-1" id="id" name="id">
                        </div>

                        <div class="form-group ml-1">
                            <button class="btn btn-danger btn-block" type="submit"> Buscar </button>
                        </div>

                        <div class="form-group ml-1">
                            <a class="btn btn-secondary btn-block" href="{{route('dashboard.cliente')}}"> 
                                Limpiar Busqueda 
                            </a>
                        </div>
                    </form>
                </div>

                <table class="table">
                    <thead>
                    <tr class="text-center">
                        <th scope="col"> Cedula/RIF </th>
                        <th scope="col"> Nombre </th>
                        <th scope="col"> Telefono </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($clientes as $cliente)
                        <tr>
                            <td> {{$cliente->ci}} </td>
                            <td> {{$cliente->name}}</td>
                            <td> {{$cliente->phone}}</td>
                            <td>
                                @if(Auth()->user()->role == 'ROLE_ADM')
                                    <a class="font-weight-bold text-center dropdown-item border-bottom border-white"
                                       href="{{route('dashboard.delCliente',['id' => $cliente->id])}}">
                                        <i class="material-icons align-middle"> delete </i>
                                        <span class="align-middle">Borrar</span>
                                    </a>
                                @endif
                            </td>
                            <td>
                                <a class="font-weight-bold text-center dropdown-item border-bottom border-white"
                                   href="{{route('dashboard.facturar',['id' => $cliente->id])}}">
                                    <i class="material-icons align-middle"> attach_money </i>
                                    <span class="align-middle">Facturar</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="pagination-sm">
                    {{$clientes->links()}}
                </div>
            </div>
        </div>
    </div>


    </div>
@endsection