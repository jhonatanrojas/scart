<?php


namespace App\Models;

use SCart\Core\Front\Models\ShopCustomer;
use SCart\Core\Front\Models\ShopCustomerAddress;

class AdminCustomer extends ShopCustomer
{
    protected static $getListTitleAdmin = null;
    protected static $getListCustomerGroupByParentAdmin = null;
    private static $getList = null;
    /**
     * Get customer detail in admin
     *
     * @param   [type]  $id  [$id description]
     *
     * @return  [type]       [return description]
     */
    public static function getCustomerAdmin($id)
    {
        return self::with('addresses')
            ->where('id', $id)
            ->where('store_id', session('adminStoreId'))
            ->first();
    }

    /**
     * Get customer detail in admin json
     *
     * @param   [type]  $id  [$id description]
     *
     * @return  [type]       [return description]
     */
    public static function getCustomerAdminJson($id)
    {
        return self::getCustomerAdmin($id)
        ->toJson();
    }

    /**
     * Get list customer in admin
     *
     * @param   [array]  $dataSearch  [$dataSearch description]
     *
     * @return  [type]               [return description]
     */
    public static function getCustomerListAdmin(array $dataSearch)
    {
        // Get input data from $dataSearch array
        $keyword          = $dataSearch['keyword'] ?? '';
        $sort_order       = $dataSearch['sort_order'] ?? '';
        $arrSort          = $dataSearch['arrSort'] ?? '';

        // Get customer list from database
        $customerList = self::select('sc_shop_customer.*', 'estado.nombre as estado', 'municipio.nombre as municipio')
            ->where('store_id', session('adminStoreId'))
            ->leftJoin('estado', 'estado.codigoestado', '=', 'sc_shop_customer.cod_estado')
            ->leftJoin('municipio', 'municipio.codigomunicipio', '=', 'sc_shop_customer.cod_municipio')
            ->leftJoin('parroquia', 'parroquia.codigoparroquia', '=', 'sc_shop_customer.cod_parroquia');

        // Filter by keyword
        if ($keyword) {
            $customerList->where(function ($query) use ($keyword) {
                $query->where('email', 'like', '%' . $keyword . '%')
                    ->orWhere('last_name', 'like', '%' . $keyword . '%')
                    ->orWhere('cedula', 'like', '%' . $keyword . '%')
                    ->orWhere('first_name', 'like', '%' . $keyword . '%');
            });
        }

        // Sort order
        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            [$field, $sort_field] = explode('__', $sort_order);
            $customerList->orderBy($field, $sort_field);
        } else {
            $customerList->orderBy('sc_shop_customer.id', 'desc');
        }

        // Distinct
        $customerList->distinct('sc_shop_customer.id');

        // Paginate
        $customerList = $customerList->paginate(20);

        return $customerList;
    }

    /**
     * Find address id
     *
     * @param   [type]  $id  [$id description]
     *
     * @return  [type]       [return description]
     */
    public static function getAddress($id)
    {
        return ShopCustomerAddress::find($id);
    }

    /**
     * Delete address id
     *
     * @return  [type]  [return description]
     */
    public static function deleteAddress($id)
    {
        return ShopCustomerAddress::where('id', $id)->delete();
    }

    /**
     * Get total customer of system
     *
     * @return  [type]  [return description]
     */
    public static function getTotalCustomer()
    {
        return self::count();
    }


    /**
     * Get total customer of system
     *
     * @return  [type]  [return description]
     */
    public static function getTopCustomer()
    {
        return self::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }


    /**
     * [getListAll description]
     * Performance can be affected if the data is too large
     * @return  [type]  [return description]
     */
    public static function getListAll()
    {
        if (self::$getList === null) {
            self::$getList = self::where('store_id', session('adminStoreId'))
                ->get()->keyBy('id');
        }
        return self::$getList;
    }
}
