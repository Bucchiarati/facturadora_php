<form method="post" action="{{route('logout')}}">
    {{csrf_field()}}
    <button type="submit" style="cursor: pointer" class="btn btn-block btn-outline-danger btn-xs p-1">
        Cerrar Sesión
    </button>
</form>

