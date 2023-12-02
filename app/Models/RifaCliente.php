<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class RifaCliente extends Model
{
    use HasFactory;
    protected $table = 'sc_rifas_clientes';
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo('SCart\Core\Front\Models\ShopCustomer', 'customer_id', 'id');
    }

   
}
