@extends('dashboard.dash', ['title' => 'A cerca de los autores'])

@section('canvas')
<div class="row m-0 p-1">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Jesús Salazar</h5>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">*Correo: jmsm27@hotmail.com</li>
              <li class="list-group-item">*Telefono:0416-5903974 / 0414-8619924 </li>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Teddy Pottella</h5>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">*Correo: teddypottella@gmail.com</li>
              <li class="list-group-item">*Telefono: 0412-8783188</li>
            </ul>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card-body">
            <a href="{{URL::previous()}}" class="card-link">
                <i class="material-icons align-middle"> arrow_back </i>
                <span class="align-middle"> Volver </span>
            </a>
        </div>
    </div>
</div>
    
@endsection