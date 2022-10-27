<?php

namespace App\Http\Controllers;

use App\Models\Productos_cuotas;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class Productos_cuota extends Controller
{
    public function get_proct_cuotas(Request $request ){
       $saveFile = new Productos_cuotas;
       $saveFile->id_producto =$request->id;
       $saveFile->numero_cuotas =$request->numero_cuotas;
       $saveFile->id_modalidad_pago =$request->id_modalidad_pago;
       $saveFile->save();
       redirect()->route('admin_product.index')->with('success', 'Atributo agregado correta mente ');
        return response()->json(['respuesta' => $saveFile]);
   
    }
    public function product_delete($id,$id2){
    $ID = intval($id);
    $note = Productos_cuotas::where('id_producto',$id)->where('id',$id2)->get();
    $note->each->delete();
    redirect()->route('admin_product.index')->with('success', 'eliminado con exito');
    return response()->json(['respuesta' => $note]);
   

   
       

    }
}
