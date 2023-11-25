<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogo\TipoTarjeta;
use App\Models\MontoTarjetaModalidad;
use App\Models\TransaccionesTarjetas;


class Tarjeta extends Model
{
    use HasFactory;
    protected $table = 'sc_tarjetas';
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo('SCart\Core\Front\Models\ShopCustomer', 'customer_id', 'id');
    }

    public function tipoTarjeta()
    {
        return $this->belongsTo(TipoTarjeta::class, 'tipo_tarjeta_id', 'id');
    }
    public function transacciones()
    {

        return $this->hasMany(TransaccionesTarjetas::class,  'tarjeta_id', 'id');
    }
    public function limites()
    {

        return $this->hasMany(MontoTarjetaModalidad::class,  'tarjeta_id', 'id');
    }

    public function totalLimite($id)
    {

        $classMonto =   MontoTarjetaModalidad::where('tarjeta_id', $id)->get();
        $total = 0;
        foreach ($classMonto as $key => $value) {
            $total += $value->monto;
        }

        return    $total;
    }

    public function totalTransaccion($id)
    {

        $classMonto =   TransaccionesTarjetas::where('tarjeta_id', $id)->get();
        $total = 0;
        foreach ($classMonto as $key => $value) {
            $total += $value->monto;
        }

        return    $total;
    }

    public function totalLimiteModalidad($id,$id_modalidad)
    {

        $classMonto =   MontoTarjetaModalidad::where('tarjeta_id', $id)
        ->where('modalida_venta_id',$id_modalidad)                
        ->get();
        $total = 0;
        foreach ($classMonto as $key => $value) {
            $total += $value->monto;
        }

        return    $total;
    }

    public function totalTransaccionModalidad($id,$id_modalidad)
    {

        $classMonto =   TransaccionesTarjetas::where('tarjeta_id', $id)
        ->where('modalida_venta_id',$id_modalidad)                
        ->get();
      
        $total = 0;
        foreach ($classMonto as $key => $value) {
            $total += $value->monto;
        }

        return    $total;
    }



    public static function getTarjetaAdmin($id)
    {
        $data  = self::with(['transacciones', 'limites'])->leftjoin('sc_tipo_tarjetas', 'sc_tipo_tarjetas.id', '=', 'sc_tarjetas.tipo_tarjeta_id')
            ->leftjoin('sc_shop_customer', 'sc_tarjetas.customer_id', '=', 'sc_shop_customer.id')
            ->select('sc_tarjetas.*', 'sc_shop_customer.*', 'sc_tipo_tarjetas.tipo')
            ->where('sc_tarjetas.id', $id);

        return $data->first();
    }
    public static function getTarjetasCliente($id)
    {
        $data  = self::with(['transacciones', 'limites'])->leftjoin('sc_tipo_tarjetas', 'sc_tipo_tarjetas.id', '=', 'sc_tarjetas.tipo_tarjeta_id')
            ->leftjoin('sc_shop_customer', 'sc_tarjetas.customer_id', '=', 'sc_shop_customer.id')
            ->select('sc_tarjetas.*', 'sc_tarjetas.id as id_tarjeta', 'sc_shop_customer.*', 'sc_tipo_tarjetas.tipo')

            ->where('sc_tarjetas.customer_id', $id);

        return $data->get();
    }

    public static function listTarjetasAdmin()
    {
        $data  = self::with(['transacciones', 'limites'])->leftjoin('sc_tipo_tarjetas', 'sc_tipo_tarjetas.id', '=', 'sc_tarjetas.tipo_tarjeta_id')
            ->leftjoin('sc_shop_customer', 'sc_tarjetas.customer_id', '=', 'sc_shop_customer.id')
            ->select('sc_shop_customer.*', 'sc_tipo_tarjetas.tipo', 'sc_tarjetas.*');


        return $data->paginate(20);
    }
}
