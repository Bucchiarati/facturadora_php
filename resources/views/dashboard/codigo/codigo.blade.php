@extends('dashboard.dash', ['title' => 'Inicio de factura'])

@section('canvas')
<div class="row m-0 p-1">
    <div class="col-md-4 offset-md-2">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nota de Entrega</h5>
            </div>
            <ul class="list-group list-group-flush">
                <form method="post" action="{{route('dashboard.codespecial')}}">
                        {{csrf_field()}}
                    <li class="list-group-item">    
                        <div class="form-group">
                            <label for="codigo">Número inicial de Nota de Entrega </label>
                            <input type="number" min="1" class="form-control" 
                                    id ="codigo" name="codigo">
                        </div>
                    </li>   
                    <li class="list-group-item">
                        <div class="form-group">
                            <button id="send" class="btn btn-danger btn-block btn-sm" type="submit"> 
                                Aceptar
                            </button>
                        </div>
                    </li>
                </form> 
                @if($errors->has('cod_especial'))
                    <div class="col-md-12 bg-success p-2 mx-auto text-center mt-1">
                        <span class="font-weight-bold"> Codigo de Nota de entrega establecido </span>
                    </div>
                @endif

            </ul>
        </div>
    </div>

    <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Factura</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <form method="post" action="{{route('dashboard.codnormal')}}">
                            {{csrf_field()}}
                        <li class="list-group-item">    
                            <div class="form-group">
                                <label for="codigo">Número inicial de factura</label>
                                <input type="number" min="1" class="form-control" 
                                        id ="codigo" name="codigo">
                            </div>
                        </li>   
                        <li class="list-group-item">
                            <div class="form-group">
                                <button id="send" class="btn btn-danger btn-block btn-sm" type="submit"> 
                                    Aceptar
                                </button>
                            </div>
                        </li>
                    </form> 
                    @if($errors->has('cod_normal'))
                        <div class="col-md-12 bg-success p-2 mx-auto text-center mt-1">
                            <span class="font-weight-bold"> Codigo de factura establecido </span>
                        </div>
                    @endif              
                    
                </ul>
            </div>
        </div>
    <div class="col-md-8 offset-md-2">
        <div class="card-body">
            <a href="{{URL::previous()}}" class="card-link text-center">
                <i class="material-icons align-middle"> arrow_back </i>
                <span class="align-middle"> Volver al inicio</span>
            </a>
        </div>
    </div>
</div>
    
@endsection