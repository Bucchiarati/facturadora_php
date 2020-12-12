@extends('layouts.app')

@section('content')

    <style> #menu{height: 93vh;} footer span{ background-color: #343a40 !important;}</style>

    <div class="row-full shadow">
        <div class="text-center p-1 bg-dark col-12 b-inline-block">
            <div class="row w-100 p-0 m-0">
                <h4 class="text-white col-10"> {{$title}} </h4>
                <div class="col-2"> @include('auth.logout')</div>
            </div>
        </div>
    </div>

    <div class="row m-0 p-0 border-top border-right border-white">

        <div class="col-md-2 bg-secondary p-0" id="menu">

            @if(auth()->user()->role == 'ROLE_ADM')

                <!--  Aqui va la parte de proovedores y categroias -->
                <div class="btn-group dropright w-100 text-left">
                    <button class=" btn-block font-weight-bold text-left dropdown-item border-bottom border-white p-2"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons align-middle"> store_mall_directory </i>
                        <span class="align-middle">Proveedores & Categorias</span>
                    </button>
                    <div class="dropdown-menu p-0 m-0">
                        <a class="font-weight-bold text-left dropdown-item border-bottom border-white p-2"
                           href="{{route('dashboard.proveedores')}}">
                            <i class="material-icons align-middle"> store_mall_directory </i>
                            <span class="align-middle">Proveedor</span>
                        </a>
                        <a class="font-weight-bold text-left dropdown-item border-bottom border-white p-2"
                           href="{{route('dashboard.categorias')}}">
                            <i class="material-icons align-middle"> list_alt </i>
                            <span class="align-middle">Categorias</span>
                        </a>
                    </div>
                </div>
                <!--  Aqui va la parte de proovedores y categroias-->

                <a class="font-weight-bold text-left dropdown-item border-bottom border-white p-2"
                   href="{{route('dashboard.usuarios')}}">
                    <i class="material-icons align-middle"> supervised_user_circle </i>
                    <span class="align-middle">Usuarios</span>
                </a>
            @endif

                
            <div class="btn-group dropright w-100 text-left">
                <button class=" btn-block font-weight-bold text-left dropdown-item border-bottom border-white p-2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons align-middle"> shopping_basket </i>
                    <span class="align-middle">Inventario</span>
                </button>
                <div class="dropdown-menu p-0 m-0">
                    @if(auth()->user()->role == 'ROLE_ADM')
                        <a class="font-weight-bold text-left dropdown-item border-bottom border-white p-2"
                           href="{{route('dashboard.productos')}}">
                            <i class="material-icons align-middle"> add </i>
                            <span class="align-middle">Agregar productos</span>
                        </a>
                        <a class="font-weight-bold text-left dropdown-item border-bottom border-white p-2"
                           href="{{route('dashboard.almacen')}}">
                            <i class="material-icons align-middle"> home </i>
                            <span class="align-middle">Almacen</span>
                        </a>
                    @endif
                    <a class="font-weight-bold text-left dropdown-item border-bottom border-white p-2"
                       href="{{route('dashboard.pdtsbuscar')}}">
                        <i class="material-icons align-middle"> shopping_basket </i>
                        <span class="align-middle">Listado de productos</span>
                    </a>
                </div>
            </div>

            <!--  Aqui va la parte de proovedores y categroias-->
            <div class="btn-group dropright w-100 text-left">
                <button class=" btn-block font-weight-bold text-left dropdown-item border-bottom border-white p-2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons align-middle"> attach_money </i>
                    <span class="align-middle">Facturación</span>
                </button>
                @if(auth()->user()->role == 'ROLE_USR')
                    <div class="dropdown-menu p-0 m-0">
                        <a class="font-weight-bold text-left dropdown-item border-bottom border-white p-2"
                           href="{{route('dashboard.factura')}}">
                            <i class="material-icons align-middle"> add </i>
                            <span class="align-middle"> Crear nueva factura</span>
                        </a>
                        <a class="font-weight-bold text-left dropdown-item border-bottom border-white p-2"
                           href="{{route('dashboard.historial')}}">
                            <i class="material-icons align-middle"> attach_money </i>
                            <span class="align-middle"> Historial de facturacion</span>
                        </a>
                    </div>
                @else
                    <div class="dropdown-menu p-0 m-0">
                        <a class="font-weight-bold text-left dropdown-item border-bottom border-white p-2"
                           href="{{route('dashboard.factura')}}">
                            <i class="material-icons align-middle"> add </i>
                            <span class="align-middle"> Crear nueva factura normal</span>
                        </a>
                        <a class="font-weight-bold text-left dropdown-item border-bottom border-white p-2"
                           href="{{route('dashboard.factura_Admin')}}">
                            <i class="material-icons align-middle"> add </i>
                            <span class="align-middle"> Crear nota de entrega </span>
                        </a>
                        <a class="font-weight-bold text-left dropdown-item border-bottom border-white p-2"
                           href="{{route('dashboard.historial')}}">
                            <i class="material-icons align-middle"> attach_money </i>
                            <span class="align-middle"> Historial de facturacion normal</span>
                        </a>
                        <a class="font-weight-bold text-left dropdown-item border-bottom border-white p-2"
                           href="{{route('dashboard.historial_Admin')}}">
                            <i class="material-icons align-middle"> attach_money </i>
                            <span class="align-middle"> Historial de notas de entrega</span>
                        </a>
                        <a class="font-weight-bold text-left dropdown-item border-bottom border-white p-2"
                           href="{{route('dashboard.codFactura')}}">
                            <i class="material-icons align-middle"> settings </i>
                            <span class="align-middle"> Establecer codigo inicial</span>
                        </a>
                    </div>
                @endif
            </div>
                <!--  Aqui va la parte de facturacion-->


            <a class="text-left dropdown-item border-bottom border-white p-2"
                href="{{route('dashboard.autores')}}">
                <i class="material-icons align-middle"> info </i>
                <span class="align-middle">Acerca de los autores</span>
            </a>

            <div class="row m-0 p-0 pt-5 mt-5 px-2">
                <img src="{{asset('img/moncada2.png')}}" class="img-fluid m-auto p-0" alt="Responsive image">
            </div>
        </div>
        <div class="col-md-10 p-2" id="canvas">
            @section('canvas')
                @if(auth()->user()->role == 'ROLE_ADM')
                    @isset($users)
                        @include('dashboard.administrador.personal_reg', ['users' => $users])
                    @endisset
                @else

                <img src="{{asset('img/moncada.png')}}" class="img-fluid m-auto p-0" alt="Responsive image">

                @endif
            @show
        </div>
    </div>



@endsection