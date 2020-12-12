@extends('dashboard.dash',['title' => 'Almacenes'])
@section('canvas')
    <div class="row m-0">
        <div class="col-md-4 p-2">
            <h4 class="text-center bg-dark text-white p-1"> Registro de almacenes </h4>
            <form method="post" action="{{route('dashboard.addstrg')}}">
                {{csrf_field()}}

                <div class="form-group">
                    <label for="id">ID del almacen</label>
                    <input class="form-control" id="id" name="id"
                           placeholder="Id del almacen">
                </div>

                <div class="form-group">
                    <label for="name">Nombre del almacen</label>
                    <input class="form-control" id="name" name="name" placeholder="Nombre del almacen">
                </div>

                <div class="form-group">
                    <button class="btn btn-danger btn-block btn-sm" id="save" type="submit"> Guardar   </button>
                    <button class="btn btn-dark btn-block btn-sm" type="button" id="generate"> Generar codigo de almacen </button>
                    <a class="btn btn-secondary btn-block btn-sm" href="{{route('dashboard')}}"> Volver al inicio </a>
                </div>

            </form>
        </div>

        <div class="col-md-8 p-2">
            <h4 class="text-center bg-dark text-white p-1"> Almacenes registrados </h4>
            <div class="row m-0">
                <table class="table">
                    <thead>
                    <tr class="text-center">
                        <th scope="col"> # </th>
                        <th scope="col"> Nombre </th>
                        <th scope="col"> Creado el dia </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($almacenes as $almacen)
                        <tr>
                            <td class="text-center"> {{$almacen->id}} </td>
                            <td class="text-center"> {{$almacen->name}}</td>
                            <td class="text-center"> {{$almacen->created_at}}</td>
                            <td>
                                <a class="font-weight-bold text-center dropdown-item border-bottom border-white"
                                   href="{{route('dashboard.delstrg',['id' => $almacen->id])}}">
                                    <i class="material-icons align-middle"> delete </i>
                                    <span class="align-middle">Borrar</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="pagination-sm">
                    {{$almacenes->links()}}
                </div>
            </div>
        </div>
        
        @if( $errors->has('older'))
            <div class="col-12 bg-warning p-2 mx-auto text-center" id="response">
                <span class="font-weight-bold"> Codigo de almacen ya existe en el sistema </span>
            </div>
        @endif
        @if( $errors->has('delete'))
            <div class="col-12 bg-warning p-2 mx-auto text-center" id="response">
                <span class="font-weight-bold"> Almacen borrado con exito </span>
            </div>
        @endif
        @if( $errors->has('save'))
            <div class="col-12 bg-success p-2 mx-auto text-center" id="response">
                <span class="font-weight-bold"> Almacen guardado con exito </span>
            </div>
        @endif
        @if( $errors->has('fail'))
            <div class="col-12 bg-warning p-2 mx-auto text-center" id="response">
                <span class="font-weight-bold"> Problemas al guardar el almacen, verifique datos </span>
            </div>
        @endif
    </div>

    <script type="text/javascript">
        $('#generate').click(function (e) {
            e.preventDefault();
            var aleatorio = Math.round(Math.random() * (999999 - 100000) + 100000);
            document.getElementById("id").value = aleatorio;
        });
    </script>

@endsection