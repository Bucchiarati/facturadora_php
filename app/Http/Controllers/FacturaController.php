<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Factura;
use App\Producto;
use App\Detalle;
use App\Factura_Admin;
use App\Detalle_Admin;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class FacturaController extends Controller
{
    //VARIABLES DE USO PARA FACTURADORA
    
    //PARTE DE AÑADIR Y ELEIMINAR UN CLIENTE///////////////////////////////////////////////////////

    public function index(Request $request)
    {   
        session()->forget('factura');
        session()->forget('detalles');
        session()->forget('subtotal');
        session()->forget('total');
        session()->forget('base');
        session()->forget('iva16');
        session()->forget('iva');

        if (isset($request->id))
        {
            $clientes = Cliente::where('name', 'like', '%'.$request->id.'%')->paginate(10);

        }else
        {
            $clientes = Cliente::paginate(10);
        }
        return view('dashboard.vendedor.cliente')
            ->with([
                'clientes' => $clientes
            ]);
    }

    public function addCliente(Request $request)
    {
        $nuevo = new Cliente();

        $request->name = strtoupper($request->name);  

        $nuevo->id = $request->id;
        $nuevo->ci = $request->tipo.'-'.$request->id;
        $nuevo->name = $request->name;
        $nuevo->dir = $request->dir;
        $nuevo->phone = $request->phone;

        
        //var_dump($nuevo->toArray()); die();
        if( $nuevo->ci == null || $nuevo->name == null
            || $nuevo->dir == null || $request->tipo == null
            || $nuevo->id == null)
        {
            return back()->withErrors(['fail' => true]);

        }
        if (Cliente::find($request->id))
        {
            return back()->withErrors(['older' => true]);

        }else
        {
            $nuevo->save();
            return back()->withErrors(['save' => true]);
        }
    }

    public function delCliente(Request $request)
    {
        $cliente = Cliente::find($request->id);
        $cliente->delete();
        return back()->withErrors(['delete' => true]);
    }

    public function historial_Admin(Request $request)
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
                $facturas = Factura_Admin::select('*')->join('tb_clientes', 'tb_clientes.id', '=', 'tb_facturas.cliente_id')
                                            ->where('name','like','%'.$request->name.'%')
                                            ->paginate(10);
            }
            
        }

        return view('dashboard.administrador.factura.listado')->with(['facturas'=> $facturas]);
    }

    public function historial(Request $request)
    {
        $facturas = Factura::paginate(10);
        if ($request->trigger) 
        {
            if ($request->factura) 
            {
                $facturas = Factura::where('id', $request->factura)->paginate(10);
            }

            if ($request->date) 
            {
                $request->date = date("d-m-Y", strtotime($request->date));
                $facturas = Factura::where('created_at', $request->date)->paginate(10);
            }

            if ($request->name) 
            {
                $facturas = Factura::select('*')->join('tb_clientes', 'tb_clientes.id', '=', 'tb_facturas.cliente_id')
                          ->where('name','like','%'.$request->name.'%')
                          ->paginate(10);
            }
            
        }

        return view('dashboard.vendedor.listado')->with(['facturas'=> $facturas]);
    }

    public function delHistorial(Request $request)
    {
        $factura = Factura::where('cliente_id', $request->cliente_id)
                  ->where('id', $request->codigo);
        
        $detalles = Detalle::where('factura_id', $request->codigo);

        $detalles->delete();
        $factura->delete();

        return back()->withErrors(['delete' => true]);
        
    }

    public function detHistorial(Request $request)
    {
        $detalles = Detalle::where('factura_id', $request->factura_id)->paginate(6);

        return view('dashboard.vendedor.detalle')->with(['detalles' => $detalles]);
    }


    //FUNCION QUE ME RETORNA EL ULTIMO CODIGO DE FACTURA 
    private function generate_numbers($start, $digits) 
    {
        return str_pad($start, $digits, "0", STR_PAD_LEFT);
    }

    private function lastCode()
    {
        if (Factura::get('id')->last() == null) {
            return session()->get('code_factura') +1;
        } else {
            return Factura::get('id')->last()->id +1;
        }
    }

    //PARTE DE AÑADIR Y ELEIMINAR UN PRODUCTO COMPRADO POR EL CLIENTE////////////////////////////////////

    public function factura(Request $request)
    {   

        //aqui sencillamente creo una nueva factura en base base al ultimo codigo guardado en la base de datos
        $new_factura = new Factura();
        $new_factura->cliente_id = $request->id;
        $new_factura->created_at = date('d-m-Y');

        if (!session()->has('factura')) 
        {
            $new_factura->id = $this->lastCode();
            $new_factura->save();
            session()->put('factura', $new_factura);
            session()->forget('code_factura');

        }else 
        {
            $new_factura->id = session()->get('factura')->id;
        }
        
        return view('dashboard.vendedor.factura')->with([
            'factura' => $new_factura,
            'codigo_factura' => $this->generate_numbers($new_factura->id, 10)
        ]);
    }

    public function addItem(Request $request)
    {
        //llamo una variable de stock dependiendo del codigo recibido junto a una variable de tipo detalle del producto
        $stock_item = Producto::find($request->serial);
        //var_dump($stock_item); die();
        $item = new Detalle();

        //si el codigo es erroneo retorna error; sino hace un largo proceso para añadir el producto
        if (!$request->serial || $stock_item == null) 
        {
            return back()->withErrors(['error' => true])
                         ->withInput($request->all()); 
        }
        else
        {
            //creo variables auxiliares para el movimiento del producto y las operaciones del iva
            $aux = 0;
            $aux_iva = 0;

            $aux_iva = $stock_item->categoria->iva/100;
            
            //uso la variable de tipo "detalle" y cargo las caracteristicas mandadas desde el front y las sacadas por la variable "stock"
            $item->factura_id = $request->factura_id;
            $item->producto_id = $request->serial;
            $item->cantidad = $request->cantidad;

            //precio con iva será la mult. del iva% * el precio de venta del objeto
            $item->iva = $aux_iva * $stock_item->precio_venta;

            //aqui se concluye el precio total del producto en base a la cantidad que se compre * el precio con iva(si lo tiene...)
            $item->precio_total = ($stock_item->precio_venta + $item->iva) * $item->cantidad;

            //sino existe la sesision de "subtotal y total" sencillamente crea una nueva
            if(!$request->session()->get('subtotal'))
            {$request->session()->put('subtotal', ($item->cantidad * $stock_item->precio_venta));}
            if (!$request->session()->get('total')) {$request->session()->put('total', $item->precio_total);}

            //si tiene o no valor, en base al % de iva se hace la operacion del monto con su respectivo iva
            switch ($aux_iva) 
            {
                case 0.16:
                    $aux = $request->session()->pull('iva16');
                    $base = $request->session()->pull('base');

                    $base = $base + ($stock_item->precio_venta * $item->cantidad);
                    $aux = $aux + ($item->iva * $item->cantidad);
                    $request->session()->put('iva16', $aux);
                    $request->session()->put('base', $base);
                break;

                case 0:
                    $aux = $request->session()->pull('iva');
                    $aux = $aux + $item->precio_total;
                    $request->session()->put('iva', $aux);
                break;
            }
            
            //si la sesion de detalles no tiene nada, sencillamente crea una nueva, sino hace el proceso de agrupacion
            if (!$request->session()->get('detalles')) 
            {
                $request->session()->put('detalles', array($item));
            } 
            else 
            {
                //se jala la variable de session de detalles y se borra del server, a su vez creo una bandera predeterminada como falsa
                $aux_array = $request->session()->pull('detalles');
                $repeat = false;

                //cuento la cantidad de elemento que hay en la variable detalles que se jalo al auxiliar y busco que producto es similar
                //con el nuevo ingreso en la factura
                for($i=0; $i < count($aux_array); $i++) 
                { 
                    if($aux_array[$i]->producto_id == $item->producto_id)
		            {
                        //si encuentra similitud lo que hará es sencillamente sumar la 
                        //nueva cantidad con la anterior, lo mismo con el precio y modifica la bandera a verdadero
                        $aux_array[$i]->cantidad = $aux_array[$i]->cantidad + $item->cantidad;
                        $aux_array[$i]->precio_total = $aux_array[$i]->precio_total + $item->precio_total;
                        $repeat = true;
                        break;
		            }
                }

                //en tal caso de que no encuentre similitudes, sencillamente concatena el nuevo item de la factura
                //se establecen los totales y subtotales y al terminar, se retorna la conclusión
                if (!$repeat) {$aux_array[] = $item;}
                $request->session()->put('detalles', $aux_array);

                $subtotal = $request->session()->pull('subtotal');
                $subtotal = $subtotal + ($stock_item->precio_venta * $item->cantidad);
                $request->session()->put('subtotal', $subtotal);

                $total = $request->session()->pull('total');
                $total = $total  + $item->precio_total;
                $request->session()->put('total', $total);
                

            }

            return back();
        }
    }

    public function delItem(Request $request)
    {
        //jalo los detalles que tengo
        $aux = session()->pull('detalles');
        //llamo una variable de stock en base al codigo q paso por peticion
        $stock_item = Producto::find($request->producto_id);
        //hago una busqueda en base al id del producto que quieor borrar
        $key = array_search($request->producto_id, array_column($aux, 'producto_id') );

        //si la cantidad es menor o igual a 1 entonces resetea todo el carro de compras
        if(count($aux) <=1)
        {
            session()->forget('detalles');
            session()->forget('subtotal');
            session()->forget('total');
            session()->forget('base');
            session()->forget('iva16');
            session()->forget('iva');

            return back();
        }
        //en base a la categoria del producto y su iva, hago las respectivas restas de los valores que tenia jalandome c/u
        switch($stock_item->categoria->iva)
        {
            case 16:
                $iva_aux = session()->pull('iva16');
                $iva_aux = $iva_aux - ($aux[$key]->iva * $aux[$key]->cantidad);
                session()->put('iva16', $iva_aux);

                $base = session()->pull('base');
                $base = $base - ($stock_item->precio_venta * $aux[$key]->cantidad);
                session()->put('base', $base);

            break;

            case 0:
                $iva_aux2 = session()->pull('iva');
                $iva_aux2 = $iva_aux2 - ($aux[$key]->producto->precio_venta * $aux[$key]->cantidad);
                session()->put('iva', $iva_aux2);
            break;
        }

        //lo mismo que en el switch pero esta vez a los montos totales
        $subtotal = session()->pull('subtotal');
        $subtotal = $subtotal - ($stock_item->precio_venta * $aux[$key]->cantidad);
        session()->put('subtotal', $subtotal);

        $total = session()->pull('total');
        $total = $total  - $aux[$key]->precio_total;
        session()->put('total', $total);

        //borro el elemento que estaba buscando con la variables "key"
        unset($aux[$key]);

        //reseteo los indices del array y sobreescribo la antigua variable de sesion y retorno la conclusion
        $aux = array_values($aux);
        session()->put('detalles', $aux);
        return back();

    }

    public function consolidar(Request $request)
    {
        
        
        if($request->modo == 'ADMIN')
        { 
            $nvo_factura = new Factura_Admin();
            $nvo_factura = session()->get('factura');
            $nvo_factura->save();
        
        }
        else 
        {  
            $nvo_factura = new Factura();
            $nvo_factura = session()->get('factura');
            $nvo_factura->save();
        }

        
       foreach (session()->get('detalles') as $detalle) 
       {
          if($request->modo == 'ADMIN')
          { 
             $nvo_detalle = new Detalle_Admin(); 
          }
          else 
          {
             $nvo_detalle = new Detalle();
          }

          $stock_detalle = Producto::find($detalle->producto_id);

          $nvo_detalle->producto_id = $detalle->producto_id;
          $nvo_detalle->factura_id = $nvo_factura->id;
          $nvo_detalle->cantidad = $detalle->cantidad;
          $nvo_detalle->precio = $detalle->precio_total - ($detalle->iva * $detalle->cantidad);
          $nvo_detalle->iva = $detalle->precio_total;
          $stock_detalle->cantidad = $stock_detalle->cantidad - $detalle->cantidad;

          if($stock_detalle->cantidad <= 0){$stock_detalle->cantidad = 0;}
          
          $stock_detalle->save(); 
          $nvo_detalle->save(); 
       }
       ///////////aqui pones el codigo para el pdf////////////////////
       
       ///////////aqui pones el codigo para el pdf////////////////////

       if($request->modo == 'ADMIN')
       {
           return redirect()->route('dashboard.factura_Admin');
       }
       else
       {
           return redirect()->route('dashboard.factura');
       }
    }

    public function cancelar(Request $request)
    {
        $request->session()->forget('detalles');
        $request->session()->forget('subtotal');
        $request->session()->forget('total');
        $request->session()->forget('base');
        $request->session()->forget('iva16');
        $request->session()->forget('iva_esp');
        $request->session()->forget('iva');

        if($request->modo == 'ADMIN')
        {   
            $nro = session()->get('factura');
            $factura = Factura_Admin::where('id',$nro->id);
            $factura->delete();
            session()->forget('factura');
            return redirect()->route('dashboard.factura_Admin');
        }
        else
        {
            $nro = session()->get('factura');
            $factura = Factura::where('id',$nro->id);
            $factura->delete();
            session()->forget('factura');
            return redirect()->route('dashboard.factura');
        }
    }
}
