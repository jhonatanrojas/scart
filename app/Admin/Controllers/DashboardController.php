<?php

namespace App\Admin\Controllers;

use SCart\Core\Admin\Controllers\RootAdminController;
use SCart\Core\Admin\Models\AdminNews;
use SCart\Core\Admin\Models\AdminProduct;
use SCart\Core\Admin\Models\AdminCustomer;
use SCart\Core\Admin\Models\AdminOrder;
use App\Models\HistorialPago;
use App\Models\ShopOrder;
use App\Models\SC_admin_role;
use SCart\Core\Admin\Admin;
use SCart\Core\Admin\Models\AdminUser;

use Illuminate\Http\Request;

class DashboardController extends RootAdminController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index(Request $request)
    {
        //Check user allow view dasdboard
        if (!\Admin::user()->checkUrlAllowAccess(route('admin.home'))) {
            $data['title'] = sc_language_render('admin.dashboard');
            return view($this->templatePathAdmin.'default', $data);
        }

        $data                   = [];
        $data['title']          = sc_language_render('admin.dashboard');
        $data['totalOrder']     = AdminOrder::getTotalOrder();
        $data['totalProduct']   = AdminProduct::getTotalProduct();
        $data['totalNews']      = AdminNews::getTotalNews();
        $data['totalCustomer']  = AdminCustomer::getTotalCustomer();
        $data['topCustomer']    = AdminCustomer::getTopCustomer();
        $data['topOrder']       = AdminOrder::getTopOrder();

        $dminUser = new AdminUser;
        $list_usuarios=  $dminUser->pluck('name', 'id')->all();
        $ademin = SC_admin_role::pluck('id' , 'name')->all();
        $id_usuario_rol = Admin::user()->id;

        $user_roles = $dminUser::where('sc_admin_user.id' ,$id_usuario_rol)->orderBy('id')
        ->join('sc_admin_role_user', 'sc_admin_user.id', '=', 'sc_admin_role_user.user_id')
        ->join('sc_admin_role', 'sc_admin_role.id', '=', 'sc_admin_role_user.role_id')
        ->select('sc_admin_user.*', 'sc_admin_user.id','sc_admin_role.name as rol' )->first();

        $data['pago_pendiente'] =  HistorialPago::Join('sc_shop_order', 'order_id' , '=', 'sc_shop_order.id')->join('sc_shop_payment_status', 'sc_shop_payment_status.id', '=', 'sc_historial_pagos.payment_status')->select('sc_shop_order.*', 'sc_shop_order.phone' , 'sc_shop_order.payment_status as estatus' ,'sc_historial_pagos.payment_status as pago_revicion' ,'sc_historial_pagos.order_id as numero_order' , 'sc_shop_payment_status.name as payment_Estatus', 'sc_historial_pagos.created_at as creado' , 'sc_historial_pagos.fecha_pago as fecha_de_pago')
        ->get();

       
       
        
       

        $data['mapStyleStatus'] = AdminOrder::$mapStyleStatus;

       

        if (config('admin.admin_dashboard.pie_chart_type') == 'country') {
            //Country statistics
            $dataCountries = AdminOrder::getCountryInYear();
            $arrCountryMap   = [];
            $ctTotal = 0;
            $ctTop = 0;
            foreach ($dataCountries as $key => $country) {
                $ctTotal +=$country->count;
                if($key <= 3) {
                    $ctTop +=$country->count;
                    $countryName = $country->country ?? $key ;
                    if($key == 0) {
                        $arrCountryMap[] =  [
                            'name' => $countryName,
                            'y' => $country->count,
                            'sliced' => true,
                            'selected' => true,
                        ];
                    } else {
                        $arrCountryMap[] =  [$countryName, $country->count];
                    }
                }
            }
            $arrCountryMap[] = ['Other', ($ctTotal - $ctTop)];
            $arrDataPie = $arrCountryMap;
            $pieChartTitle = sc_language_render('admin.chart.static_country');
            //End countries
        }

        if (config('admin.admin_dashboard.pie_chart_type') == 'device') {
            //Device statistics
            $dataDevices = AdminOrder::getDeviceInYear();
            $arrDevice   = [];
            foreach ($dataDevices as $key => $row) {
                $arrDevice[] =  [
                    'name' => ucfirst($row->device_type),
                    'y' => $row->count,
                    'sliced' => true,
                    'selected' => ($key == 0) ? true : false,
                ];

                
            }
            $arrDataPie = $arrDevice;
            $pieChartTitle = sc_language_render('admin.chart.static_device');
            //End Device statistics
        }

        

        if (config('admin.admin_dashboard.pie_chart_type') == 'order') {
            //Count order in 12 months
            $totalCountMonth = AdminOrder::getCountOrderTotalInYear()
                ->pluck('count', 'ym')->toArray();
            $arrCountOrder = [];
            for ($i = 12; $i >= 0; $i--) {
                $date = date("Y-m", strtotime(date('Y-m-01') . " -$i months"));
                $arrCountOrder[] =  [
                    'name' => '('.$date.')',
                    'y' => $totalCountMonth[$date] ?? 0,
                    'sliced' => true,
                    'selected' => ($i == 0) ? true : false,
                ];
            }
            $arrDataPie = $arrCountOrder;
            $pieChartTitle = sc_language_render('admin.chart.static_count_order');
            //End count order in 12 months
        }

        $data['pieChartTitle'] = $pieChartTitle;
        $data['dataPie'] = json_encode($arrDataPie);

        



        //Order in 30 days
        $totalsInMonth = AdminOrder::getSumOrderTotalInMonth()->keyBy('md')->toArray();
        $rangDays = new \DatePeriod(
            new \DateTime('-1 month'),
            new \DateInterval('P1D'),
            new \DateTime('+1 day')
        );

        
        $orderInMonth  = [];
        $amountInMonth  = [];
        foreach ($rangDays as $i => $day) {
            $date = $day->format('m-d');
            $orderInMonth[$date] = $totalsInMonth[$date]['total_order'] ?? '';
            $amountInMonth[$date] = ($totalsInMonth[$date]['total_amount'] ?? 0);


        }


        $data['orderInMonth'] = $orderInMonth;
        $data['amountInMonth'] = $amountInMonth;

        //End order in 30 days
        
        //Order in 12 months
        $totalMonth = AdminOrder::getSumOrderTotalInYear()
            ->pluck('total_amount', 'ym')->toArray();
        $dataInYear = [];


        if($user_roles->rol == 'Vendedor'){
           foreach($data['topOrder'] as $order){

                $data['topOrder'] =AdminOrder::where('status' , 1)->get();

           }
            ;

       }else if($user_roles->rol == 'Riesgo'){
            $data['topOrder'] =AdminOrder::where('status' , 4)->get();

       }
        for ($i = 12; $i >= 0; $i--) {
            $date = date("Y-m", strtotime(date('Y-m-01') . " -$i months"));
            $dataInYear[$date] = $totalMonth[$date] ?? 0;
        }
        $data['dataInYear'] = $dataInYear;
        //End order in 12 months

        return view($this->templatePathAdmin.'dashboard', $data);
    }

 

    /**
     * Page not found
     *
     * @return  [type]  [return description]
     */
    public function dataNotFound()
    {
        $data = [
            'title' => sc_language_render('admin.data_not_found'),
            'icon' => '',
            'url' => session('url'),
        ];
        return view($this->templatePathAdmin.'data_not_found', $data);
    }


    /**
     * Page deny
     *
     * @return  [type]  [return description]
     */
    public function deny()
    {
        $data = [
            'title' => sc_language_render('admin.deny'),
            'icon' => '',
            'method' => session('method'),
            'url' => session('url'),
        ];
        return view($this->templatePathAdmin.'deny', $data);
    }

    /**
     * [denySingle description]
     *
     * @return  [type]  [return description]
     */
    public function denySingle()
    {
        $data = [
            'method' => session('method'),
            'url' => session('url'),
        ];
        return view($this->templatePathAdmin.'deny_single', $data);
    }
}
