<?php

namespace App\Http\Controllers;

use App\Proveedor;
use Illuminate\Http\Request;

class ProvController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->id))
        {
            $proveedores = Proveedor::where('name','like','%'.$request->id.'%')->paginate(10);

        }else
        {
            $proveedores = Proveedor::paginate(10);
        }
        return view('dashboard.administrador.proveedores')
            ->with([
                'proveedores' => $proveedores
            ]);
    }

    public function add(Request $request)
    {
        $nuevo = new Proveedor();

        $nuevo->id = $request->id;
        $nuevo->ci = $request->tipo.'-'.$request->id;
        $nuevo->name = strtoupper($request->name);
        $nuevo->phone = $request->phone;
        $nuevo->email = $request->email;

        if(
            $nuevo->name == null || $nuevo->ci == null
            || $nuevo->phone == null || $nuevo->email == null
            || $nuevo->id == null
            )
        {
            return back()->withErrors(['fail' => true]);

        }if (Proveedor::find($nuevo->id)) {

            return back()->withErrors(['older' => true]);
        }
        else
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
        $proveedor = Proveedor::find($request->id);
        $proveedor->delete();
        return back()->withErrors(['delete' => true]);
    }
}
