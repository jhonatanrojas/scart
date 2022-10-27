<?php

namespace App\Http\Controllers;

use App\Models\Municipio as ModelsMunicipio;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class Municipio extends Controller
{
    public function get_municipio($id ){
        $ID = intval($id);
        $municipio = ModelsMunicipio::where('codigoestado', $ID)->get();
        
        return response()->json(['respuesta' => $municipio]);

    }
}
