@extends('layouts.app')

@section('content')
	<style>
		body{
			background-image: url("{{asset('img/bckg.png')}}");
			background-size: cover;
		}

		#login{ padding-top: 10%; }
	</style>

	<div class="row-full" id="login">


		<div class="col-md-4 offset-md-4">

			<div class="card p-2 bg-secondary text-white">
				<div class="card-body">
					<h3 class="card-title">Acceso de Usuarios</h3>
					<hr class="bg-white">

					<form method="post" action="{{route('login')}}">

						{{csrf_field()}}

						<div class="form-group {{ $errors->has('id') ? 'has-error' : ' ' }}">
							<label for="id"> Cedula del usuario </label>
							<input type="text" name="id" class="form-control"
								   placeholder="Ingresa el nro de tu cedula">
							{!! $errors->first('id','<span class="help-block p-1 ">:message </span>') !!}
						</div>

						<div class="form-group {{ $errors->has('pass') ? 'has-error' : ' ' }}">
							<label for="password"> Contraseña del usuario </label>
							<input type="password" name="password" class="form-control"
								   placeholder="Ingresa la contraseña">
							{!! $errors->first('password','<span class="help-block p-1 ">:message </span>') !!}
						</div>

						<hr class="bg-white">
						<button type="submit" class="btn btn-block btn-danger">
							Entrar al sistema
						</button>
					</form>

					@if($errors->has('fail'))
						<div class="row mt-2">
							<span class="col-12 bg-warning text-center text-dark">
								Error, los datos no coinciden; verifique
							</span>
						</div>
					@endif
				</div>
			</div>

		</div>

	</div>

@endsection