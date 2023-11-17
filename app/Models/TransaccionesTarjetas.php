<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tarjeta;



class TransaccionesTarjetas extends Model
{
    use HasFactory;
    protected $table = 'sc_transacciones_tarjetas';
    protected $guarded = [];

 
   
    public function tipoTarjeta()
    {
        return $this->belongsTo(TipoTarjeta::class, 'tipo_tarjeta_id', 'id');
    }

    public function tarjeta()
    {
        return $this->belongsTo(Tarjeta::class, 'tarjeta_id', 'id');
    }
}
