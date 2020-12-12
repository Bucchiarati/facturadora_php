@extends('dashboard.dash',['title' => 'Proveedores'])

@section('canvas')
    <div class="row m-0">
        <div class="col-md-4 p-2">
            <h4 class="text-center bg-dark text-white p-1"> Registro de proveedores </h4>
            <form method="post" action="{{route('dashboard.addprov')}}">
                {{csrf_field()}}

                <div class="form-group">
                    <div class="row m-0 p-0">
                        <div class="col-md-6 p-0 m-0">
                            <label for="id">Id del proveedor</label>
                            <input type="number" class="form-control" id="id" name="id"
                             placeholder="solamente números">
                        </div>
                        <div class="col-md-6 p-0 m-0">
                            <label for="id">Tipo de proveedor</label>
                            <select class="custom-select" id="tipo" name="tipo">
                                <option selected value="" > Escoja una opcion </option>
                                <option value="J" > JURIDICO (J)</option>
                                <option value="G" > GUBERNAMENTAL (G) </option>
                                <option value="E" > EXTRANJERO (E) </option>
                                <option value="V" > VENEZOLANO (V) </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Nombre del Proveedor</label>
                    <input class="form-control" id="name" name="name" placeholder="Nombre del proveedor">
                </div>

                <div class="form-group">
                    <label for="phone">Telefono del proveedor</label>
                    <input class="form-control" id="phone" name="phone" placeholder="Telefono del proveedor">
                </div>

                <div class="form-group">
                    <label for="email">Email del Proveedor</label>
                    <input class="form-control" id="email" name="email" placeholder="Email del proveedor">
                </div>

                <div class="form-group">
                    <button class="btn btn-danger btn-block btn-sm" type="submit"> Guardar nuevo Proveedor </button>
                    <a class="btn btn-dark btn-block btn-sm" href="#" hidden> Modificar Proveedor </a>
                    <a class="btn btn-secondary btn-block btn-sm" href="{{route('dashboard')}}"> Volver al inicio </a>
                </div>

            </form>
        </div>

        <div class="col-md-8 p-2">
            <h4 class="text-center bg-dark text-white p-1"> Proveedores registrados </h4>
            <div class="row m-0">
                <div class="col-12 my-2">
                    <form method="post" class="form-inline" action="{{route('dashboard.proveedores')}}">
                        {{csrf_field()}}

                        <div class="form-group ">
                            <label for="id">Nombre del Proveedor</label>
                            <input class="form-control ml-1" id="id" name="id">
                        </div>

                        <div class="form-group ml-1">
                            <button class="btn btn-danger btn-block" type="submit"> Buscar </button>
                        </div>

                        <div class="form-group ml-1">
                            <a class="btn btn-secondary btn-block" href="{{route('dashboard.proveedores')}}"> Limpiar Busqueda </a>
                        </div>
                    </form>
                </div>

                <table class="table">
                    <thead>
                    <tr class="text-center">
                        <th scope="col"> # </th>
                        <th scope="col"> Nombre </th>
                        <th scope="col"> Telefono </th>
                        <th scope="col"> Correo </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($proveedores as $proveedor)
                        <tr>
                            <td class="text-center"> {{$proveedor->ci}} </td>
                            <td class="text-center"> {{$proveedor->name}}</td>
                            <td class="text-center"> {{$proveedor->phone}}</td>
                            <td class="text-center"> {{$proveedor->email}}</td>
                            <td>
                                <a class="font-weight-bold text-center dropdown-item border-bottom border-white"
                                   href="{{route('dashboard.delprov',['id' => $proveedor->id])}}">
                                    <i class="material-icons align-middle"> delete </i>
                                    <span class="align-middle">Borrar</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="pagination-sm">
                    {{$proveedores->links()}}
                </div>
            </div>
        </div>
        @if($errors->has('older'))
            <div class="col-12 bg-warning p-2 mx-auto text-center">
                <span class="font-weight-bold"> Proveedor ya existe en el sistema </span>
            </div>
        @endif
        @if($errors->has('delete'))
            <div class="col-12 bg-warning p-2 mx-auto text-center">
                <span class="font-weight-bold"> Proveedor borrado con exito </span>
            </div>
        @endif
        @if($errors->has('save'))
            <div class="col-12 bg-success p-2 mx-auto text-center">
                <span class="font-weight-bold"> Proveedor guardado con exito </span>
            </div>
        @endif
        @if($errors->has('fail'))
            <div class="col-12 bg-warning p-2 mx-auto text-center">
                <span class="font-weight-bold"> Problemas al guardar el proveedor, verifique datos </span>
            </div>
        @endif
    </div>
@endsection
