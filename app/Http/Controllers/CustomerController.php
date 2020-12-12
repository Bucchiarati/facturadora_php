<?php

namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use PDF;
use App\Cliente;
use App\Factura;
  
class CustomerController extends Controller
{
    public function printPDF()
    {
       // This  $data array will be passed to our PDF blade
       $aux = session()->get('factura');
       $cliente = Cliente::find($aux->cliente_id);
       //var_dump($cliente->toArray()); die();
       $data = [ 
          'title' => 'Factura #'.$aux->id,
          'content' => 'Nombre:'.$cliente->name.' '.$cliente->lstname,
          'content2' => 'RIF/C.I.:'.$cliente->id,
          'content3' => 'Dirección:'.$cliente->dir,
          'content4' => 'Telefono:'.$cliente->phone,
          'content5' => 'Factura:'.$aux->id,
          'content6' => 'Fecha:'.$aux->created_at,
          'content7' => 'L.A.E.:0',

            ];
        
        
        $pdf = PDF::loadView('pdf_view', ['cliente' => $cliente]);
        $pdf->setPaper('210x148'); 
        return $pdf->stream('factura #'.$aux->id.' fecha '.$aux->created_at.' Cliente '.$cliente->name.'.pdf');
        
    }
    
    public function printPDFnota()
    {
       // This  $data array will be passed to our PDF blade
       $aux = session()->get('factura');
       $cliente = Cliente::find($aux->cliente_id);
       //var_dump($cliente->toArray()); die();
       $data = [ 
          'title' => 'Factura #'.$aux->id,
          'content' => 'Nombre:'.$cliente->name.' '.$cliente->lstname,
          'content2' => 'RIF/C.I.:'.$cliente->id,
          'content3' => 'Dirección:'.$cliente->dir,
          'content4' => 'Telefono:'.$cliente->phone,
          'content5' => 'Factura:'.$aux->id,
          'content6' => 'Fecha:'.$aux->created_at,
          'content7' => 'L.A.E.:0',

            ];
        
        
        $pdf = PDF::loadView('pdf_viewnota', ['cliente' => $cliente]);
        $pdf->setPaper('210x148'); 
        return $pdf->stream('Nota Entrega #'.$aux->id.' fecha '.$aux->created_at.' Cliente '.$cliente->name.'.pdf');
        
    }
}