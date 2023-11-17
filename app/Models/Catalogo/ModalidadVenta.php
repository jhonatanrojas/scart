<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModalidadVenta extends Model
{
    use HasFactory;
    protected $table = 'sc_modalidad_venta';
    protected $guarded = [];
}
