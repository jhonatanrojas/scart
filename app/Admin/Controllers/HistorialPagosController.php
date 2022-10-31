<?php
namespace App\Admin\Controllers;

use SCart\Core\Admin\Admin;
use SCart\Core\Admin\Controllers\RootAdminController;
use SCart\Core\Front\Models\ShopAttributeGroup;
use SCart\Core\Front\Models\ShopCountry;
use SCart\Core\Front\Models\ShopCurrency;

use SCart\Core\Admin\Models\AdminOrder;
use SCart\Core\Admin\Models\AdminProduct;
use SCart\Core\Front\Models\ShopOrderTotal;
use Validator;
use App\Models\HistorialPago;
use App\Models\Catalogo\PaymentStatus;

class HistorialPagosController extends RootAdminController
{
    public $statusPayment;
    public $statusOrder;
    public $statusShipping;
    public $statusOrderMap;
    public $statusShippingMap;
    public $statusPaymentMap;
    public $currency;
    public $country;
    public $countryMap;

    public function __construct()
    {
        parent::__construct();

    }
    /**
     * Index interface.
     *
     * @return Content
     */

     public function index(){
   
     }

    public function detalle(){
        $data = [
            'title'         => 'Detalle de pago', 
            'subTitle'      => '',
            'icon'          => 'fa fa-indent',
            'urlDeleteItem' => sc_route_admin('admin_customer.delete'),
            'removeList'    => 0, // 1 - Enable function delete list item
            'buttonRefresh' => 0, // 1 - Enable button refresh
            'buttonSort'    => 1, // 1 - Enable button sort
            'css'           => '',
            'js'            => '',
        ];
        //Process add content
        $data['menuRight'] = sc_config_group('menuRight', \Request::route()->getName());
        $data['menuLeft'] = sc_config_group('menuLeft', \Request::route()->getName());
        $data['topMenuRight'] = sc_config_group('topMenuRight', \Request::route()->getName());
        $data['topMenuLeft'] = sc_config_group('topMenuLeft', \Request::route()->getName());
        $data['blockBottom'] = sc_config_group('blockBottom', \Request::route()->getName());

        $listTh = [
            'Nro orden'      => 'Nro de orden',
            'Importe pagado'       => 'Importe pagado',
            'Metodo de pago'      => 'Metodo de pago',
            'Estatus' => 'Estatus',
            'Creado'   =>  'Creado',
            'action'     => sc_language_render('action.title'),
        ];
        $sort_order = sc_clean(request('sort_order') ?? 'id_desc');
        $id_orden=request('id');
  
   
        $keyword    = sc_clean(request('keyword') ?? '');
      $statusPayment = PaymentStatus::select(['name','id'])->get();

      $arrSort=['0'=>'Todos'];

      foreach ($statusPayment as $key => $value) {
        $arrSort[$value->id] = $value->name;
        # code...
      }
      



        $dataSearch = [
            'keyword'    => $keyword,
            'sort_order' => $sort_order,
            'arrSort'    => $arrSort,
        ];

  
        $dataTmp  =   HistorialPago::where('order_id',$id_orden)
        ->orderByDesc('id')
        ->paginate(20);
        




        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[$row->id ] = [
                'Nro orden' =>  $row->order_id,
                'Importe pagado' =>  $row->importe_pagado,
                'Metodo de pago' =>  $row->metodo_pago->name,
                'Estatus' => $row->estatus->name,
                'Creado' =>  $row->created_at->format('d/m/Y'),
         
            
                'action' => '
                    <a href="' . sc_route_admin('admin_customer.edit', ['id' => $row->id ? $row->id  : 'not-found-id']) . '"><span title="Ver orden" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                    <a href="' . sc_route_admin('admin_customer.document', ['id' => $row->id  ? $row->id : 'not-found-id']) . '"><span title="' . sc_language_render('action.documetos') . '" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-file"></i></span></a>&nbsp;


                    
                    '
                ,
            ];
        }

        $data['listTh'] = $listTh;

        
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links($this->templatePathAdmin.'component.pagination');
        $data['resultItems'] = sc_language_render('admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'total' =>  $dataTmp->total()]);

        //menuRight
        $data['menuRight'][] = '<a href="' . sc_route_admin('admin_customer.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
                           <i class="fa fa-plus" title="'.sc_language_render('admin.add_new').'"></i>
                           </a>';
        //=menuRight

        //menuSort
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }
        $data['urlSort'] = sc_route_admin('historial_pagos.detalle', request()->except(['_token', '_pjax', 'sort_order']));
        $data['optionSort'] = $optionSort;
        //=menuSort

        //menuSearch
        $data['topMenuRight'][] = '
                <form action="' . sc_route_admin('historial_pagos.detalle') . '" id="button_search">
                <div class="input-group input-group" style="width: 350px;">
                    <input type="text" name="keyword" class="form-control rounded-0 float-right" placeholder="' . sc_language_render('search.placeholder') . '" value="' . $keyword . '">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                </form>';
        //=menuSearch

        return view($this->templatePathAdmin.'pagos.detalle')
            ->with($data);
    }

    public static function getOrderListAdmin(array $dataSearch)
    {
        $keyword      = $dataSearch['keyword'] ?? '';
        $email        = $dataSearch['email'] ?? '';
        $from_to      = $dataSearch['from_to'] ?? '';
        $end_to       = $dataSearch['end_to'] ?? '';
        $sort_order   = $dataSearch['sort_order'] ?? '';
        $arrSort      = $dataSearch['arrSort'] ?? '';
        $order_status = $dataSearch['order_status'] ?? '';
        $storeId      = $dataSearch['storeId'] ?? '';

        $orderList = (new HistorialPago);
        
        if ($storeId) {
            $orderList = $orderList->where('store_id', $storeId);
        }

        if ($order_status) {
            $orderList = $orderList->where('status', $order_status);
        }
        if ($keyword) {
            $orderList = $orderList->where(function ($sql) use ($keyword) {
                $sql->Where('id', $keyword);
            });
        }

        if ($email) {
            $orderList = $orderList->where(function ($sql) use ($email) {
                $sql->Where('email', 'like', '%'.$email.'%');
            });
        }

        if ($from_to) {
            $orderList = $orderList->where(function ($sql) use ($from_to) {
                $sql->Where('created_at', '>=', $from_to);
            });
        }

        if ($end_to) {
            $orderList = $orderList->where(function ($sql) use ($end_to) {
                $sql->Where('created_at', '<=', $end_to);
            });
        }

        if ($sort_order && array_key_exists($sort_order, $arrSort)) {



            $orderList = $orderList->Where('payment_status',  $sort_order);
        } else {
            $orderList = $orderList->orderBy('created_at', 'desc');
        }
        $orderList = $orderList->paginate(20);

        return $orderList;
    }
}
