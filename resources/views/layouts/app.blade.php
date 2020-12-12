<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1 
	height=device-height">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title> Sistema de facturación </title>
	<link rel="stylesheet" href="{{asset('css/app.css')}}">
	<link rel="stylesheet" href="{{asset('css/iconos.css')}}">
	<script type="text/javascript" src="{{asset('js/app.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
</head>

<script type="text/javascript">
	
</script>

<style type="text/css">

	@media (min-height: 500px) and (max-height: 768px){
		html,body{font-size: .85rem !important;}
	}	
	html,body
	{
		width: 100% !important;
		height: 100vh !important;
		position: relative;
	}

	*{margin: 0px; padding: 0px;}

	.absolute{ position: absolute;}

	.fixed{ position: fixed;}

	footer{
		bottom: 0;
		left: 0;
		right: 0;
		width: 100vw;
	}

	footer.row{ margin: 0px; }

	footer span{ background-color: #6c757d}

</style>

<body>
	<div id="app"></div>
	<div class="container-fluid m-0 p-0" id="app">
			@yield('content')

			<div class="container-fluid">
				<footer class="row fixed-bottom">
				<span class="col-12 text-center text-white">
					Creado por Teddy Pottella & Jesús Salazar
				</span>
				</footer>
			</div>
	</div>
</body>
</html>