@extends('dashboard.dash',['title' => 'Categorias'])
@section('canvas')
    <style>
        #save{ display: none;}
    </style>
    <div class="row m-0">

        <div class="col-md-4 p-2">
            <h4 class="text-center bg-dark text-white p-1"> Registro de categoria </h4>
            <form method="post" action="{{route('dashboard.addcatg')}}">
                {{csrf_field()}}

                <div class="form-group">
                    <label for="id">ID de la categoria</label>
                    <input type="number" class="form-control" id="id" name="id"
                           placeholder="Id de la categoria">
                </div>

                <div class="form-group">
                    <label for="name">Nombre de la categoria</label>
                    <input class="form-control" id="name" name="name" placeholder="Nombre del proveedor">
                </div>

                <div class="form-group">
                    <label for="name">IVA %</label>
                    <input class="form-control" id="iva" name="iva" 
                    placeholder="Impuesto para los productos de esta categoria">
                </div>

                <div class="form-group">
                    <button class="btn btn-danger btn-block btn-sm" id="save" type="submit"> Guardar nueva categoria </button>
                    <button class="btn btn-dark btn-block btn-sm" type="button" id="generate"> Generar codigo de categoria </button>
                    <a class="btn btn-secondary btn-block btn-sm" href="{{route('dashboard')}}"> Volver al inicio </a>
                </div>

            </form>
        </div>

        <div class="col-md-8 p-2">
            <h4 class="text-center bg-dark text-white p-1"> Categorias registrados </h4>
            <div class="row m-0">
                <div class="col-12 my-2">
                    <form method="post" class="form-inline" action="{{route('dashboard.categorias')}}">
                        {{csrf_field()}}

                        <div class="form-group ">
                            <label for="id">Nombre de la categoria</label>
                            <input class="form-control ml-1" id="id" name="id">
                        </div>

                        <div class="form-group ml-1">
                            <button class="btn btn-danger btn-block" type="submit"> Buscar </button>
                        </div>

                        <div class="form-group ml-1">
                            <a class="btn btn-secondary btn-block" href="{{route('dashboard.categorias')}}"> Limpiar Busqueda </a>
                        </div>
                    </form>
                </div>

                <table class="table">
                    <thead>
                    <tr class="text-center">
                        <th scope="col"> # </th>
                        <th scope="col"> Nombre </th>
                        <th scope="col"> IVA %</th>
                        <th scope="col"> Creado el dia </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categorias as $categoria)
                        <tr>
                            <td class="text-center"> {{$categoria->id}} </td>
                            <td class="text-center"> {{$categoria->name}}</td>
                            <td class="text-center"> {{$categoria->iva}}</td>
                            <td class="text-center"> {{$categoria->created_at}}</td>
                            <td>
                                <a class="font-weight-bold text-center dropdown-item border-bottom border-white"
                                   href="{{route('dashboard.delcatg',['id' => $categoria->id])}}">
                                    <i class="material-icons align-middle"> delete </i>
                                    <span class="align-middle">Borrar</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="pagination-sm">
                    {{$categorias->links()}}
                </div>
            </div>
        </div>
        
        @if( $errors->has('delete'))
            <div class="col-12 bg-warning p-2 mx-auto text-center" id="response">
                <span class="font-weight-bold"> Categoria borrado con exito </span>
            </div>
        @endif
        @if( $errors->has('save'))
            <div class="col-12 bg-success p-2 mx-auto text-center" id="response">
                <span class="font-weight-bold"> Categoria guardado con exito </span>
            </div>
        @endif
        @if( $errors->has('fail'))
            <div class="col-12 bg-warning p-2 mx-auto text-center" id="response">
                <span class="font-weight-bold"> Problemas al guardar la categoria, verifique datos </span>
            </div>
        @endif
    </div>

    <script type="text/javascript">
        $('#generate').click(function (e) {
            e.preventDefault();
            var aleatorio = Math.round(Math.random() * (999999 - 100000) + 100000);
            document.getElementById("id").value = aleatorio;
            $('#save').css('display','block');
        });
    </script>

@endsection