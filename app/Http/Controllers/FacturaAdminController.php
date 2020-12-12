<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Factura_Admin;
use App\Producto;
use App\Detalle_Admin;
use Illuminate\Http\Request;

class FacturaAdminController extends Controller
{
    
    //PARTE DE AÑADIR Y ELEIMINAR UN CLIENTE///////////////////////////////////////////////////////

    public function index(Request $request)
    {
        session()->forget('factura');
        session()->forget('detalles');
        session()->forget('subtotal');
        session()->forget('total');
        session()->forget('base');
        session()->forget('iva16');
        session()->forget('iva_esp');
        session()->forget('iva');
        
        if (isset($request->id))
        {
            $clientes = Cliente::where('name', 'like', '%'.$request->id.'%')->paginate(10);

        }else
        {
            $clientes = Cliente::paginate(10);
        }
        return view('dashboard.administrador.factura.cliente')
            ->with([
                'clientes' => $clientes
            ]);
    }

    public function codFactura(Request $request)
    {
        $value = $request->codigo;
        session()->put('code_factura',$value);

        return back()->withErrors(['cod_normal' => true]);
    }

    public function codFactura_Admin(Request $request)
    {
        $value = $request->codigo;    
        session()->put('code_factura_admin',$value);

        return back()->withErrors(['cod_especial'  => true]);
    }

    private function lastCode_Admin()
    {
        if (Factura_Admin::get('id')->last() == null) {
            return session()->get('code_factura_admin') +1;
        } else {
            return Factura_Admin::get('id')->last()->toArray()['id'] +1;
        }
    }

    public function historial(Request $request)
    {
        $facturas = Factura_Admin::paginate(10);

        if ($request->trigger) 
        {
            if ($request->factura) 
            {
                $facturas = Factura_Admin::where('id', $request->factura)->paginate(10);
            }

            if ($request->date) 
            {
                $request->date = date("d-m-Y", strtotime($request->date));
                $facturas = Factura_Admin::where('created_at', $request->date)->paginate(10);
            }

            if ($request->name) 
            {
                $facturas = Factura_Admin::select('*')->join('tb_clientes', 'tb_clientes.id', '=', 'tb_facturasAdmin.cliente_id')
                          ->where('name','like','%'.$request->name.'%')
                          ->paginate(10);
            }
            
        }

        return view('dashboard.administrador.factura.listado')->with(['facturas'=> $facturas]);
    }

    public function delHistorial(Request $request)
    {
        $factura = Factura_Admin::where('cliente_id', $request->cliente_id)
                  ->where('id', $request->codigo);
        
        $detalles = Detalle_Admin::where('factura_id', $request->codigo);

        $detalles->delete();
        $factura->delete();
        
        return back()->withErrors(['delete' => true]);

    }

    public function detHistorial(Request $request)
    {
        $detalles = Detalle_Admin::where('factura_id', $request->factura_id)->paginate(10);

        return view('dashboard.administrador.factura.detalle')->with(['detalles' => $detalles]);
    }

    //FUNCION QUE ME RETORNA EL ULTIMO CODIGO DE FACTURA 
    private function generate_numbers($start, $digits) 
    {
        return str_pad($start, $digits, "0", STR_PAD_LEFT);
    }

    public function factura(Request $request)
    {   
        //aqui sencillamente creo una nueva factura en base base al ultimo codigo guardado en la base de datos
        $new_factura = new Factura_Admin();
        $new_factura->cliente_id = $request->id;
        $new_factura->created_at = date('d-m-Y');

        if (!session()->has('factura')) 
        {
            $new_factura->id = $this->lastCode_Admin();
            $new_factura->save();
            session()->put('factura', $new_factura);
            session()->forget('code_factura_admin');

        }else 
        {
            $new_factura->id = session()->get('factura')->id;
        }
        
        return view('dashboard.administrador.factura.factura')->with([
            'factura' => $new_factura,
            'codigo_factura' => $this->generate_numbers($new_factura->id, 10)
        ]);
    }


}
