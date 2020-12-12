<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Producto;
use App\Proveedor;
use App\Almacen;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function index(Request $request)
    {
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        $productos = Producto::paginate(10);
        $almacenes = Almacen::all();
        return view('dashboard.administrador.productos')
            ->with([
                'productos' => $productos,
                'proveedores' => $proveedores,
                'categorias' => $categorias,
                'almacenes' => $almacenes]);
    }

    public function add(Request $request)
    {
        //var_dump($request->toArray()); die();

        $nuevo = new Producto();

        $request->name = strtoupper($request->name);
        $request->precio_venta = str_replace(',','.',$request->precio_venta);
        $request->precio_compra = str_replace(',','.',$request->precio_compra);

        $nuevo->id = $request->id;
        $nuevo->name = $request->name;
        $nuevo->cantidad = $request->count;
        $nuevo->precio_compra = $request->precio_compra;
        $nuevo->precio_venta = $request->precio_venta;
        $nuevo->peso = str_replace(',','.',$request->peso);
        $nuevo->created_at = date('d-m-Y');
        $nuevo->updated_at = date('d-m-Y');
        $nuevo->categoria_id = $request->categoria;
        $nuevo->almacen_id = $request->almacen;
        $nuevo->proveedor_id = $request->proveedor;

        //var_dump($nuevo->toArray()); die();
    
        if (!is_numeric($nuevo->peso) || !is_numeric($nuevo->precio_compra) 
            || !is_numeric($nuevo->precio_venta) || !is_numeric($nuevo->id)) 
        {
            return back()->withErrors(['numeric' => true])
                         ->withInput($request->all());
        }
        
        $nuevo->peso = $nuevo->peso.' '.$request->unidad;

        if(
            $nuevo->id == null ||  $nuevo->name == null ||  $nuevo->precio_compra == null
            ||  $nuevo->cantidad == null ||  $nuevo->precio_venta == null ||  $nuevo->peso == null
            ||  $nuevo->categoria_id == null ||  $nuevo->proveedor_id == null ||  $nuevo->almacen_id == null
            ||  $request->unidad == null
        )
        {
            return back()->withErrors(['fail' => true])
                         ->withInput($request->all());

        }if (Producto::find($nuevo->id)) 
        {
            return back()->withErrors(['older' => true])
                         ->withInput($request->all());  
        }
        else
        {   
            try 
            {
                $nuevo->save();
            } 
            catch (\Throwable $th) 
            {
                return back()->withErrors(['fail' => true]);
            }
            finally
            {    return back()->withErrors(['save' => true]);}
        }

    }

    public function modify(Request $request)
    {
        $producto = Producto::find($request->id);
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        $almacenes = Almacen::all();

        if ($request->mode == 'get') 
        {
            //var_dump($almacenes->toArray()); die();
            return view('dashboard.producto.modificar')
            ->with([
                'producto' => $producto,
                'proveedores' => $proveedores,
                'categorias' => $categorias,
                'almacenes' => $almacenes]);
        }else {
            //var_dump($request->toArray()); die();
        
            $request->name = strtoupper($request->name);
            $request->precio_venta = str_replace(',','.',$request->precio_venta);
            $request->precio_compra = str_replace(',','.',$request->precio_compra);
    
            $producto->name = $request->name;
            $producto->cantidad = $request->count;
            $producto->precio_compra = $request->precio_compra;
            $producto->precio_venta = $request->precio_venta;
            $producto->peso = str_replace(',','.',$request->peso);
            $producto->updated_at = date('d-m-Y');
            $producto->categoria_id = $request->categoria;
            $producto->almacen_id = $request->almacen;
            $producto->proveedor_id = $request->proveedor;

            /*
            $producto->name = strtoupper($request->name);
            $producto->proveedor_id = $request->proveedor;
            $producto->categoria_id = $request->categoria;
            $producto->almacen_id = $request->almacen;
            $producto->cantidad = $request->count;
            $producto->peso = str_replace(',','.',$request->peso);
            $producto->peso = $producto->peso.' '.$request->unidad;
            $producto->precio = $request->precio;
            $producto->updated_at = date('d-m-Y');
            */

            if (!is_numeric($producto->peso) || !is_numeric($producto->precio_compra) 
            || !is_numeric($producto->precio_venta)) 
            {
                return back()->withErrors(['numeric' => true]);
            }   

            $producto->peso = $producto->peso.' '.$request->unidad; 
            //var_dump($producto->toArray()); die();

            if(
                $producto->name == null ||  $producto->cantidad == null || $producto->almacen_id == null ||
                $producto->categoria_id == null ||  $producto->proveedor_id == null 
            )
            {
                return view('dashboard.producto.modificar')
                ->with([
                    'producto' => $producto,
                    'proveedores' => $proveedores,
                    'categorias' => $categorias,
                    'almacenes' => $almacenes,])
                ->withErrors(['fail' => true]);
            }else
            {
                try 
                {
                    $producto->save();

                } catch (\Throwable $th) 
                {
                    var_dump( $th );die();
                    //return back()->withErrors(['fail' => true]);
                }
                finally
                {    return back()->withErrors(['save' => true]);}
            }
        }
    }

    public function details(Request $request)
    {
        $producto = Producto::find($request->id);
        return view('dashboard.producto.detalles')
                ->with(['producto' => $producto]);
    }

    public function delete(Request $request)
    {
        $producto = Producto::find($request->id);
        $producto->delete();
        return back()->withErrors(['delete' => true]);
    }

    public function listado(Request $request)
    {
       
        $categorias = Categoria::all();
        $productos = Producto::paginate(10);

        if ($request->trigger) 
        {
            if ($request->name) 
            {
                $productos = Producto::where('name', 'like', '%'.$request->name.'%')->paginate(10);
            }

            if ($request->date) 
            {
                $request->date = date("d-m-Y", strtotime($request->date));
                $productos = Producto::where('created_at', $request->date)->paginate(10);
            }

            if ($request->categoria) 
            {
                $productos = Producto::where('categoria_id', $request->categoria)->paginate(10);
            }

            if ($request->serial) 
            {
                $productos = Producto::where('id', $request->serial)->paginate(10);
            }
            
        }
        return view('dashboard.producto.busqueda')
                ->with(['productos' => $productos, 
                    'categorias' => $categorias]);
    }


}