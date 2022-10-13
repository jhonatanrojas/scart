<?php

namespace App\Http\Controllers;

use App\Models\Parroquia as ModelsParroquia;
use Illuminate\Http\Request;

class Parroquia extends Controller
{
   public function get_parroquia($cod_muni , $cod_estado){
    $Cod_muni = intval($cod_muni);
    $Cod_estado = intval($cod_estado);
   
    $municipio = ModelsParroquia::where('codigoestado',$Cod_estado)->where('codigomunicipio', $Cod_muni)->get();
   

    return response()->json(['respuesta' => $municipio]);
   }
}
