<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogo\TipoTarjeta;



class MontoTarjetaModalidad extends Model
{
    use HasFactory;
    protected $table = 'sc_monto_tarjetas_modalidad';
    protected $guarded = [];

 
    public function tipoTarjeta()
    {
        return $this->belongsTo(TipoTarjeta::class, 'tipo_tarjeta_id', 'id');
    }
  
}
