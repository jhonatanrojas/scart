<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoTarjeta extends Model
{
    use HasFactory;
    protected $table = 'sc_tipo_tarjetas';
    protected $guarded = [];
}
