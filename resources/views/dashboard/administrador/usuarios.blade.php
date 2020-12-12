@extends('dashboard.dash',['title'=> 'Manejo de usuarios'])

@section('canvas')
    <div class="row m-0">
        <div class="col-md-4 p-2">
            <h4 class="text-center bg-dark text-white p-1"> Registro de usuarios </h4>
            <form method="post" action="{{route('dashboard.adduser')}}">
                {{csrf_field()}}

                <div class="form-group">
                    <label for="id">Cédula del usuario</label>
                    <input class="form-control" id="id" name="id"
                           placeholder="Id del proveedor (solamente los numeros)">
                </div>

                <div class="form-group">
                    <label for="name">Nombre del usuario</label>
                    <input class="form-control" id="name" name="name" placeholder="Nombre del usuario">
                </div>

                <div class="form-group">
                    <label for="lstname">Apellido del usuario</label>
                    <input class="form-control" id="lstname" name="lstname" placeholder="Apellido del usuario">
                </div>

                <div class="form-group">
                    <label for="password">Contraseña del usuario</label>
                    <input class="form-control" id="password" name="password" placeholder="Contraseña del usuario">
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="rol">Rol de sistema</label>
                    </div>
                    <select class="custom-select" id="rol" name="rol">
                        <option selected value="" > Escoja una opcion </option>
                        <option value="ROLE_ADM"> Rol de Administrador </option>
                        <option value="ROLE_USR"> Rol de vendedor </option>
                    </select>
                </div>

                <div class="form-group">
                    <button class="btn btn-danger btn-block btn-sm" type="submit"> Guardar nuevo Usuario </button>
                    <a class="btn btn-secondary btn-block btn-sm" href="{{route('dashboard')}}"> Volver al inicio </a>
                </div>

            </form>
        </div>

            <div class="col-md-8 p-2">
                <h4 class="text-center bg-dark text-white p-1"> Usuarios registrados </h4>
                <div class="row m-0">
                    <div class="col-md-12 my-2">
                        <form method="post" class="form-inline" action="{{route('dashboard.usuarios')}}">
                            {{csrf_field()}}

                            <div class="form-group ">
                                <label for="id">Dato del Usuario (cédula)</label>
                                <input class="form-control" id="id" name="id">
                            </div>

                            <div class="form-group ml-1">
                                <button class="btn btn-danger btn-block" type="submit"> Buscar </button>
                            </div>

                            <div class="form-group ml-1">
                                <a class="btn btn-secondary btn-block" href="{{route('dashboard.usuarios')}}"> Limpiar Busqueda </a>
                            </div>
                        </form>
                    </div>

                    <table class="table">
                        <thead>
                        <tr class="text-center">
                            <th scope="col"> # </th>
                            <th scope="col"> Nombre </th>
                            <th scope="col"> Contraseña </th>
                            <th scope="col"> Rol </th>
                            <th scope="col"> Fecha </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="text-center"> {{$user->id}} </td>
                                <td class="text-center"> {{$user->name}} {{$user->lstname}}</td>
                                <td class="text-center"> {{\Illuminate\Support\Facades\Crypt::decryptString($user->password)}}</td>
                                @if($user->role == 'ROLE_ADM')
                                    <td class="text-center"> Admin </td>
                                @else
                                    <td class="text-center"> Vendedor </td>
                                @endif
                                <td class="text-center"> {{$user->created_at}} </td>
                                <td class="p-0">
                                    <a class="font-weight-bold text-center dropdown-item border-bottom border-white"
                                       href="{{route('dashboard.deluser',['id' => $user->id])}}">
                                        <i class="material-icons align-middle"> delete </i>
                                        <span class="align-middle">Borrar</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="pagination-sm">
                        {{$users->links()}}
                    </div>
                </div>
            </div>
            @if($errors->has('delete'))
                <div class="col-12 bg-warning px-2 mx-auto my-0 text-center">
                    <span class="font-weight-bold"> Usuario borrado con exito </span>
                </div>
            @endif
            @if($errors->has('save'))
                <div class="col-12 bg-success px-2 mx-auto my-0 text-center">
                    <span class="font-weight-bold"> Usuario guardado con exito </span>
                </div>
            @endif
            @if($errors->has('fail'))
                <div class="col-12 bg-warning px-2 mx-auto my-0 text-center">
                    <span class="font-weight-bold"> Problemas al guardar el usuario, verifique datos </span>
                </div>
            @endif
    </div>
@endsection