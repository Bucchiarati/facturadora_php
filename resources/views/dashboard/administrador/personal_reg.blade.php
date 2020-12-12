<div class="row m-0">
    <div class="col-sm-12 text-center"> <h4 class="p-2"> Tabla de usuarios registrados en el sistema </h4> </div>
    <div class="col-sm-12 my-2">
        <form method="post" action="{{route('dashboard')}}">
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-5 ml-md-auto">
                    <input type="text" name="id" class="form-control" placeholder="Cedula del personal a buscar">
                </div>
                <div class="col-md-3">
                    <button  type="submit"
                             class="btn btn-block btn-danger">
                             Buscar personal
                    </button>
                </div>
                <div class="col-md-3">
                    <a class="btn btn-block btn-secondary" href="{{route('dashboard')}}">
                        Limpiar Busqueda
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row m-0">
    <table class="table">
        <thead>
        <tr>
            <th scope="col"> Cédula </th>
            <th scope="col"> Nombre </th>
            <th scope="col"> Apellido </th>
            <th scope="col"> Contraseña </th>
            <th scope="col"> Rol en el sistema </th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td> {{$user->id}} </td>
                <td> {{$user->name}}</td>
                <td> {{$user->lstname}}</td>
                <td> {{\Illuminate\Support\Facades\Crypt::decryptString($user->password)}}</td>
                @if($user->role == 'ROLE_ADM')
                    <td> Administrador </td>
                @else
                    <td> Vendedor </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pagination-sm">
        {{ $users->links() }}
    </div>
</div>