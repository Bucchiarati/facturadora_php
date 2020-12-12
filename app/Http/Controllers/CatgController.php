<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\VarDumper;

class CatgController extends Controller
{
    public function index(Request $request)
    {

        if (isset($request->id)) {
            $request->id = strtoupper($request->id);
            $categorias = Categoria::where('name', $request->id)->paginate(0);

        } else {
            $categorias = Categoria::paginate(4);
        }

        return view('dashboard.administrador.categorias')
            ->with([
                'categorias' => $categorias
            ]);
    }

    public function add(Request $request)
    {
        $nuevo = new Categoria();

        $request->name = strtoupper($request->name);

        $nuevo->id = $request->id;
        $nuevo->name = $request->name;
        $nuevo->iva = str_replace(',','.',$request->iva);
        $nuevo->created_at = date('Y-m-d');

        if(!is_numeric($nuevo->id) && !is_numeric($nuevo->iva))
        {
            return back()->withErrors(['fail' => true]);
        }
        if(Categoria::find($nuevo->id) ||  $nuevo->name == null || $nuevo->iva == null)
        {
            return back()->withErrors(['fail' => true]);
        }else
        {
            $nuevo->save();
            return back()->withErrors(['save' => true]);
        }
    }

    public function modify(Request $request)
    {
        var_dump($request->toArray()); die();
    }

    public function delete(Request $request)
    {
        $categoria = Categoria::find($request->id);
        $categoria->delete();
        return back()->withErrors(['delete' => true]);
    }
}
