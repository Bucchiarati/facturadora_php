<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Almacen;

class AlmacenController extends Controller
{
    public function index(Request $request)
    {
        $almacenes = Almacen::paginate(4);
        return view('dashboard.administrador.almacen')
            ->with([
                'almacenes' => $almacenes
            ]);
    }

    public function add(Request $request)
    {
        $nuevo = new Almacen();

        $request->name = strtoupper($request->name);

        $nuevo->id = $request->id;
        $nuevo->name = $request->name;
        $nuevo->created_at = date('Y-m-d');

        if($nuevo->name == null || $nuevo->id == null)
        {
            return back()->withErrors(['fail' => true]);

        }if (Almacen::find($nuevo->id)) {
            
            return back()->withErrors(['older' => true]);
        }else
        {
            $nuevo->save();
            return back()->withErrors(['save' => true]);
        }
    }

    public function delete(Request $request)
    {
        $almacen = Almacen::find($request->id);
        $almacen->delete();
        return back()->withErrors(['delete' => true]);
    }
}
