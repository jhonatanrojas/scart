<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogo\MetodoPago;
use App\Models\AdminRole;
use SCart\Core\Admin\Models\AdminUser;
use SCart\Core\Admin\Admin;

class RifaCliente extends Model
{
    use HasFactory;
    protected $table = 'sc_rifas_clientes';
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo('SCart\Core\Front\Models\ShopCustomer', 'customer_id', 'id');
    }


    public function metodo_pago()
    {

        return $this->hasOne(MetodoPago::class, 'id', 'forma_pago_id');
    }
    //forma_pago_id

    public static function obtenerRifas(array $dataSearch, int $id_rifa)
    {
        $keyword      = $dataSearch['keyword'] ?? '';

        $sort_order   = $dataSearch['sort_order'] ?? '';
        $arrSort      = $dataSearch['arrSort'] ?? '';
        $orderList = (new self());


        $id_usuario_rol = Admin::user()->id;
        $dminUser = new AdminUser;
        $user_roles = $dminUser::where('sc_admin_user.id', $id_usuario_rol)->orderBy('id')
            ->join('sc_admin_role_user', 'sc_admin_user.id', '=', 'sc_admin_role_user.user_id')
            ->join('sc_admin_role', 'sc_admin_role.id', '=', 'sc_admin_role_user.role_id')
            ->select('sc_admin_user.id', 'sc_admin_user.id', 'sc_admin_role.name as rol', 'role_id')->first();
        $role = AdminRole::find($user_roles->role_id);

     
     
        if (!in_array($role->slug ,['administrator','rol_Master','PRESIDENTE','manager','rol_admin_finanzas'])) {
            $orderList =    $orderList->Where('vendor_id', Admin::user()->id);
        }




 
        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];

            $orderList = $orderList->orderBy($field, $sort_field);
        } else {
            $orderList = $orderList->orderBy('numero_rifa', 'asc');
        }
        if (!empty($estatus)) {

            $orderList = $orderList->whereIn('status', $estatus)->whereIn('modalidad_de_compra', [1, 2, 4, 5, 7]);
        }

        $orderList = $orderList->Where('rifa_id', $id_rifa);

        if ($keyword) {

            $orderList = $orderList->where(function ($sql) use ($keyword) {

                $sql->Where('numero_rifa', $keyword)
                    ->orWhere('nombre_cliente', 'like', '%' . $keyword . '%');
            });
        }

 

    //    dd($orderList->toSql());

        $orderList = $orderList->paginate(20);

        return $orderList;
    }
}
