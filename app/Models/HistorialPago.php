<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogo\MetodoPago;
use App\Models\Catalogo\PaymentStatus;

use App\Models\ShopProduct;
use App\Models\SC_shop_customer;

class HistorialPago extends Model
{
    use HasFactory;
    protected $table = 'sc_historial_pagos';
    protected $guarded = [];

 
    public function metodo_pago(){

        return $this->hasOne(MetodoPago::class, 'id', 'metodo_pago_id');

    }
    public function producto(){

        return $this->hasOne(ShopProduct::class, 'id', 'producto_id');

    }

    public function estatus(){

        return $this->hasOne(PaymentStatus::class, 'id', 'payment_status');

    }

    public function cliente(){

        return $this->hasOne(SC_shop_customer::class, 'id', 'customer_id');

    }
  
  
}
