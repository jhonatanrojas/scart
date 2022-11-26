<?php
namespace App\Admin\Controllers;

use SCart\Core\Admin\Admin;
use SCart\Core\Admin\Controllers\RootAdminController;
use SCart\Core\Front\Models\ShopAttributeGroup;
use SCart\Core\Front\Models\ShopCountry;
use SCart\Core\Front\Models\ShopCurrency;
use SCart\Core\Front\Models\ShopOrderDetail;
use SCart\Core\Front\Models\ShopOrderStatus;
use SCart\Core\Front\Models\ShopPaymentStatus;
use SCart\Core\Front\Models\ShopShippingStatus;
use SCart\Core\Admin\Models\AdminCustomer;
use App\Models\AdminOrder;
use App\Models\Convenio;
use App\Models\Estado;
use SCart\Core\Admin\Models\AdminProduct;
use SCart\Core\Front\Models\ShopOrderTotal;
use App\Models\ModalidadPago;
use App\Models\HistorialPago;
use App\Models\Municipio;
use App\Models\Parroquia;
use Validator;
use App\Models\SC__documento;
use App\Models\Sc_plantilla_convenio;
use App\Models\SC_shop_customer;
use App\Models\shop_order_detail;
use App\Models\ShopOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use FFI;
use SCart\Core\Front\Models\ShopCustomFieldDetail;

class  AdminOrderController extends RootAdminController
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
        $this->statusOrder    = ShopOrderStatus::getIdAll();
        $this->currency       = ShopCurrency::getListActive();
        $this->country        = ShopCountry::getCodeAll();
        $this->statusPayment  = ShopPaymentStatus::getIdAll();
        $this->statusShipping = ShopShippingStatus::getIdAll();
    }

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        $data = [
            'title'         => sc_language_render('order.admin.list'),
            'subTitle'      => '',
            'icon'          => 'fa fa-indent',
            'urlDeleteItem' => sc_route_admin('admin_order.delete'),
            'removeList'    => 1, // 1 - Enable function delete list item
            'buttonRefresh' => 1, // 1 - Enable button refresh
            'buttonSort'    => 1, // 1 - Enable button sort
            'css'           => '',
            'js'            => '',
        ];
        //Process add content
        $data['menuRight']    = sc_config_group('menuRight', \Request::route()->getName());
        $data['menuLeft']     = sc_config_group('menuLeft', \Request::route()->getName());
        $data['topMenuRight'] = sc_config_group('topMenuRight', \Request::route()->getName());
        $data['topMenuLeft']  = sc_config_group('topMenuLeft', \Request::route()->getName());
        $data['blockBottom']  = sc_config_group('blockBottom', \Request::route()->getName());

        $listTh = [
            'Nombre&Apellido'          => 'Nombre&Apellido',
            'Cedula'          => 'Cedula',
            'Telefono'          => 'Telefono',
            'Estado'          => 'Estado',
            'Municipio'          => 'Municipio',
            'Parroquia'          => 'Parroquia',
            'total'          => '<i class="fas fa-coins" aria-hidden="true" title="'.sc_language_render('order.total').'"></i>',
            'status'         =>"Estatus",
            'Modalidad'         =>"Modalidad",
            'pagos'         => '<i class="fa fa-credit-card" aria-hidden="true" title="Pagos realizados"></i>',
        ];
        if (sc_check_multi_shop_installed() && session('adminStoreId') == SC_ID_ROOT) {
            // Only show store info if store is root
            $listTh['shop_store'] = '<i class="fab fa-shopify" aria-hidden="true" title="'.sc_language_render('front.store_list').'"></i>';
        }
        $listTh['created_at'] = sc_language_render('admin.created_at');
        $listTh['action'] = sc_language_render('action.title');

        $sort_order   = sc_clean(request('sort_order') ?? 'id_desc');
        $keyword      = sc_clean(request('keyword') ?? '');
        $email        = sc_clean(request('email') ?? '');
        $from_to      = sc_clean(request('from_to') ?? '');
        $end_to       = sc_clean(request('end_to') ?? '');
        $order_status = sc_clean(request('order_status') ?? '');
        $arrSort = [
            'id__desc'         => sc_language_render('filter_sort.id_desc'),
            'id__asc'          => sc_language_render('filter_sort.id_asc'),
            'email__desc'      => sc_language_render('filter_sort.alpha_desc', ['alpha' => 'Email']),
            'email__asc'       => sc_language_render('filter_sort.alpha_asc', ['alpha' => 'Email']),
            'created_at__desc' => sc_language_render('filter_sort.value_desc', ['value' => 'Date']),
            'created_at__asc'  => sc_language_render('filter_sort.value_asc', ['value' => 'Date']),
        ];
        $dataSearch = [
            'keyword'      => $keyword,
            'email'        => $email,
            'Cedula'        => $email,
            'Telefono'        => $email,
            'Estado'        => $email,
            'from_to'      => $from_to,
            'end_to'       => $end_to,
            'sort_order'   => $sort_order,
            'arrSort'      => $arrSort,
            'order_status' => $order_status,
        ];
        $dataTmp = (new AdminOrder)->getOrderListAdmin($dataSearch);
        if (sc_check_multi_shop_installed() && session('adminStoreId') == SC_ID_ROOT) {
            $arrId = $dataTmp->pluck('id')->toArray();
            // Only show store info if store is root
            if (function_exists('sc_get_list_store_of_order')) {
                $dataStores = sc_get_list_store_of_order($arrId);
            } else {
                $dataStores = [];
            }
        }

        $estado = Estado::all();
        $municipio = Municipio::all();
        $parroquia = Parroquia::all();
     
        $styleStatus = $this->statusOrder;
        array_walk($styleStatus, function (&$v, $k) {
            $v = '<span class="badge badge-' . (AdminOrder::$mapStyleStatus[$k] ?? 'light') . '">' . $v . '</span>';
        });
        $dataTr = [];
        $AlContado = [];
        foreach ($dataTmp as $key => $row) {

            
           
            if($row->modalidad_de_compra == 0)$AlContado = "Al contado";
                else $AlContado = "Financiamiento" ;
            
            $usuario =  SC_shop_customer::where('id', $row->customer_id)->get();
            $colection = $usuario->all();

            $cedula =[];
            $phone =[];
            $nombremunicipos =[];
            $nombreparroquias =[];
            $nombreEstado =[];
            foreach($colection as $key => $usu){
                $cedula = $usu['cedula'];
                $phone = $usu['phone'];
                foreach($estado as $estados){
                    if($estados->codigoestado ==  $usu['cod_estado']){$nombreEstado = $estados->nombre;}
                         foreach($municipio as $municipos){
                             if($municipos->codigomunicipio ==  $usu['cod_municipio']){
                                 $nombremunicipos = $municipos->nombre;
                             }
                         }
                         foreach($parroquia as $parroquias){
                             if($parroquias->codigomunicipio == $usu['cod_municipio']){
                                 $nombreparroquias = $parroquias->nombre;
                                 
                             }
                            
                         }
                       
                     }


            }

            $dataMap = [
                'Nombre&Apellido'          => $row['first_name'] . " ".$row['last_name'] ?? 'N/A',
                'Cedula'          => $cedula ?? 'N/A',
                'Telefono'          => $phone ?? 'N/A',
                'Estado'          =>$nombreEstado ?? 'N/A',
                'Municipio'          =>$nombremunicipos ?? 'N/A',
                'Parroquia'          =>$nombreparroquias ?? 'N/A',
                'total'          => sc_currency_render_symbol($row['total'] ?? 0, 'USD'),
                'status'         => $styleStatus[$row['status']] ?? $row['status'],
                'Modalidad'         => $AlContado,
            ];
            if (sc_check_multi_shop_installed() && session('adminStoreId') == SC_ID_ROOT) {
                // Only show store info if store is root
                if (!empty($dataStores[$row['id']])) {
                    $storeTmp = $dataStores[$row['id']]->pluck('code', 'id')->toArray();
                    $storeTmp = array_map(function ($code) {
                        return '<a target=_new href="'.sc_get_domain_from_code($code).'">'.$code.'</a>';
                    }, $storeTmp);
                    $dataMap['shop_store'] = '<i class="nav-icon fab fa-shopify"></i> '.implode('<br><i class="nav-icon fab fa-shopify"></i> ', $storeTmp);
                } else {
                    $dataMap['shop_store'] = '';
                }
            }

            $dataMap['pagos'] =    HistorialPago::where('order_id',$row['id'])
                                        ->where('payment_status',' <>',1)
                                        ->count();
            $dataMap['created_at'] = $row['created_at'];
            $btn_pagos='';
            if($dataMap['pagos']>0)
            $btn_pagos=' <a href="' . sc_route_admin('historial_pagos.detalle', ['id' => $row['id'] ? $row['id'] : 'not-found-id']) . '"><span title="Historial de pagos" type="button" class="btn btn-flat btn-sm btn-info"><i class=" fa fa-university "></i></span></a>&nbsp;';
            $dataMap['action'] = '
            
            
            <a href="' . sc_route_admin('admin_order.detail', ['id' => $row['id'] ? $row['id'] : 'not-found-id']) . '"><span title="' . sc_language_render('action.edit') . '" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;
            '.$btn_pagos.'
            <a href="' . sc_route_admin('historial_pagos.reportar', ['id' => $row['id'] ? $row['id'] : 'not-found-id']) . '"><span title="Reportar pago" type="button" class="btn btn-flat btn-sm btn-info"><i class=" fa fa-credit-card "></i></span></a>&nbsp;
            <span onclick="deleteItem(\'' . $row['id'] . '\');"  title="' . sc_language_render('action.delete') . '" class="btn btn-flat btn-sm btn-danger"><i class="fas fa-trash-alt"></i></span>
            ';
            $dataTr[$row['id']] = $dataMap;
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links($this->templatePathAdmin.'component.pagination');
        $data['resultItems'] = sc_language_render('admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'total' =>  $dataTmp->total()]);


        //menuRight
        $data['menuRight'][] = '<a href="' . sc_route_admin('admin_order.create') . '" class="btn  btn-success  btn-flat" title="Crear pedido" id="button_create_new">
                           <i class="fa fa-plus" title="'.sc_language_render('action.add').'"></i>
                           </a>';
        //=menuRight

        //menuSort
        $optionSort = '';
        foreach ($arrSort as $key => $sort) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $sort . '</option>';
        }
        $data['optionSort'] = $optionSort;
        $data['urlSort'] = sc_route_admin('admin_order.index', request()->except(['_token', '_pjax', 'sort_order']));
        //=menuSort

        //menuSearch
        $optionStatus = '';
        foreach ($this->statusOrder as $key => $status) {
            $optionStatus .= '<option  ' . (($order_status == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }
        $data['topMenuRight'][] = '
                <form action="' . sc_route_admin('admin_order.index') . '" id="button_search">
                    <div class="input-group float-left">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>'.sc_language_render('action.from').':</label>
                                <div class="input-group">
                                <input type="text" name="from_to" id="from_to" class="form-control input-sm date_time rounded-0" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" /> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>'.sc_language_render('action.to').':</label>
                                <div class="input-group">
                                <input type="text" name="end_to" id="end_to" class="form-control input-sm date_time rounded-0" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" /> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>'.sc_language_render('order.admin.status').':</label>
                                <div class="input-group">
                                <select class="form-control rounded-0" name="order_status">
                                <option value="">'.sc_language_render('order.admin.search_order_status').'</option>
                                ' . $optionStatus . '
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Buscar por Nombre/Cedula:</label>
                                <div class="input-group">
                                    <input type="text" name="email" class="form-control rounded-0 float-right" placeholder="' . sc_language_render('order.admin.search_email') . '" value="' . $email . '">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary  btn-flat"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>';
        //=menuSearch


        return view($this->templatePathAdmin.'screen.list')
            ->with($data);
    }

    /**
     * Form create new item in admin
     * @return [type] [description]
     */
    public function create()
    {

        $users = AdminCustomer::getListAll();
        // dd($users);

       
       
        $data = [
            'title'             => sc_language_render('order.admin.add_new_title'),
            'subTitle'          => '',
            'title_description' => sc_language_render('order.admin.add_new_des'),
            'icon'              => 'fa fa-plus',
        ];
        $paymentMethod = [];
        $shippingMethod = [];
        $paymentMethodTmp = sc_get_plugin_installed('payment', $onlyActive = false);
        foreach ($paymentMethodTmp as $key => $value) {
            $paymentMethod[$key] = sc_language_render($value->detail);
        }
        $shippingMethodTmp = sc_get_plugin_installed('shipping', $onlyActive = false);
        foreach ($shippingMethodTmp as $key => $value) {
            $shippingMethod[$key] = sc_language_render($value->detail);
        }
        $orderStatus            = $this->statusOrder;
        $currencies             = $this->currency;
        $countries              = $this->country;
        $currenciesRate         = json_encode(ShopCurrency::getListRate());
        $users                  = $users;
        $data['users']          = $users;
        $data['currencies']     = $currencies;
        $data['countries']      = $countries;
        $data['orderStatus']    = $orderStatus;
        $data['currenciesRate'] = $currenciesRate;
        $data['paymentMethod']  = $paymentMethod;
        $data['shippingMethod'] = $shippingMethod;
       

        return view($this->templatePathAdmin.'screen.order_add')
            ->with($data);
    }

    /**
     * Post create new item in admin
     * @return [type] [description]
     */
    public function postCreate()
    {
        $data = request()->all();

       
    
        $validate = [
            'first_name'      => 'required|max:100',
            'email'   => 'required',
            'status'          => 'required',
            'customer_id' => 'required'
    
        ];
        if (sc_config_admin('customer_lastname')) {
            $validate['last_name'] = 'required|max:100';
        }
        if (sc_config_admin('customer_address2')) {
            $validate['address2'] = 'required|max:100';
        }
        if (sc_config_admin('customer_address3')) {
            $validate['address3'] = 'required|max:100';
        }
        if (sc_config_admin('customer_phone')) {
            $validate['phone'] = config('validation.customer.phone_required', 'required|regex:/^0[^0][0-9\-]{6,12}$/');
        }
        if (sc_config_admin('customer_country')) {
            $validate['country'] = 'required|min:2';
        }
        if (sc_config_admin('customer_postcode')) {
            $validate['postcode'] = 'required|min:5';
        }
        if (sc_config_admin('customer_company')) {
            $validate['company'] = 'required|min:3';
        }
        $messages = [
            'last_name.required'       => sc_language_render('validation.required', ['attribute'=> sc_language_render('cart.last_name')]),
            'first_name.required'      => sc_language_render('validation.required', ['attribute'=> sc_language_render('cart.first_name')]),
            'email.required'           => sc_language_render('validation.required', ['attribute'=> sc_language_render('cart.email')]),
            'address1.required'        => sc_language_render('validation.required', ['attribute'=> sc_language_render('cart.address1')]),
            'address2.required'        => sc_language_render('validation.required', ['attribute'=> sc_language_render('cart.address2')]),
            'address3.required'        => sc_language_render('validation.required', ['attribute'=> sc_language_render('cart.address3')]),
            'phone.required'           => sc_language_render('validation.required', ['attribute'=> sc_language_render('cart.phone')]),
            'country.required'         => sc_language_render('validation.required', ['attribute'=> sc_language_render('cart.country')]),
            'postcode.required'        => sc_language_render('validation.required', ['attribute'=> sc_language_render('cart.postcode')]),
            'company.required'         => sc_language_render('validation.required', ['attribute'=> sc_language_render('cart.company')]),
            'sex.required'             => sc_language_render('validation.required', ['attribute'=> sc_language_render('cart.sex')]),
            'birthday.required'        => sc_language_render('validation.required', ['attribute'=> sc_language_render('cart.birthday')]),
            'email.email'              => sc_language_render('validation.email', ['attribute'=> sc_language_render('cart.email')]),
            'phone.regex'              => sc_language_render('customer.phone_regex'),
            'postcode.min'             => sc_language_render('validation.min', ['attribute'=> sc_language_render('cart.postcode')]),
            'country.min'              => sc_language_render('validation.min', ['attribute'=> sc_language_render('cart.country')]),
            'first_name.max'           => sc_language_render('validation.max', ['attribute'=> sc_language_render('cart.first_name')]),
            'email.max'                => sc_language_render('validation.max', ['attribute'=> sc_language_render('cart.email')]),
            'address1.max'             => sc_language_render('validation.max', ['attribute'=> sc_language_render('cart.address1')]),
            'address2.max'             => sc_language_render('validation.max', ['attribute'=> sc_language_render('cart.address2')]),
            'address3.max'             => sc_language_render('validation.max', ['attribute'=> sc_language_render('cart.address3')]),
            'last_name.max'            => sc_language_render('validation.max', ['attribute'=> sc_language_render('cart.last_name')]),
            'birthday.date'            => sc_language_render('validation.date', ['attribute'=> sc_language_render('cart.birthday')]),
            'birthday.date_format'     => sc_language_render('validation.date_format', ['attribute'=> sc_language_render('cart.birthday')]),
            'shipping_method.required' => sc_language_render('cart.validation.shippingMethod_required'),
            'payment_method.required'  => sc_language_render('cart.validation.paymentMethod_required'),
        ];

      $cliente=   AdminCustomer::getCustomerAdmin($data['customer_id']);
        $validator = Validator::make($data, $validate, $messages);

        if ($validator->fails()) {


            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        //Create new order
        $dataCreate = [
            'cedula' =>  $cliente->cedula,
            'customer_id'     => $data['customer_id'] ?? "",
            'first_name'      => $data['first_name'],
            'last_name'       => $data['last_name'] ?? '',
            'status'          => $data['status'],
            'currency'        => $data['currency'] ?? '',
            'address1'        => $data['address1']?? '',
            'address2'        => $data['address2'] ?? '',
            'address3'        => $data['address3'] ?? '',
            'country'         => $data['country'] ?? '',
            'company'         => $data['company'] ?? '',
            'postcode'        => $data['postcode'] ?? '',
            'phone'           => $data['phone'] ?? '',
            'payment_method'  => $data['payment_method']?? 0,
            'shipping_method' => $data['shipping_method']?? 0,
            'exchange_rate'   => $data['exchange_rate'] ?? 0,
            'email'           => $data['email'],
            'modalidad_de_compra'           => $data['modalidad_compra'],
            'comment'         => $data['comment'],
            'usuario_id'         =>  Admin::user()->id
        ];
        $dataCreate = sc_clean($dataCreate, [], true);
        $order = AdminOrder::create($dataCreate);


        
    
       
        AdminOrder::insertOrderTotal([
            ['id' => sc_uuid(),'code' => 'subtotal', 'value' => 0, 'title' => sc_language_render('order.totals.sub_total'), 'sort' => ShopOrderTotal::POSITION_SUBTOTAL, 'order_id' => $order->id],
            ['id' => sc_uuid(),'code' => 'tax', 'value' => 0, 'title' => sc_language_render('order.totals.tax'), 'sort' => ShopOrderTotal::POSITION_TAX, 'order_id' => $order->id],
            ['id' => sc_uuid(),'code' => 'shipping', 'value' => 0, 'title' => sc_language_render('order.totals.shipping'), 'sort' => ShopOrderTotal::POSITION_SHIPPING_METHOD, 'order_id' => $order->id],
            ['id' => sc_uuid(),'code' => 'discount', 'value' => 0, 'title' => sc_language_render('order.totals.discount'), 'sort' => ShopOrderTotal::POSITION_TOTAL_METHOD, 'order_id' => $order->id],
            ['id' => sc_uuid(),'code' => 'other_fee', 'value' => 0, 'title' => config('cart.process.other_fee.title'), 'sort' => ShopOrderTotal::POSITION_OTHER_FEE, 'order_id' => $order->id],
            ['id' => sc_uuid(),'code' => 'total', 'value' => 0, 'title' => sc_language_render(' vhopkk,,h bty, yo,k r.totals.total'), 'sort' => ShopOrderTotal::POSITION_TOTAL, 'order_id' => $order->id],
            ['id' => sc_uuid(),'code' => 'received', 'value' => 0, 'title' => sc_language_render('order.totals.received'), 'sort' => ShopOrderTotal::POSITION_RECEIVED, 'order_id' => $order->id],
        ]);
        //
        return redirect()->route('admin_order.detail', ['id' => $order->id ? $order->id : 'not-found-id'])->with('success', sc_language_render('action.create_success'));
    }

    /**
     * Order detail
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {

        
        $order = AdminOrder::getOrderAdmin($id);
  
      
       
        if (!$order) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }

        $convenio = Convenio::where('order_id',$id)->first();

        $nro_convenio = str_pad(Convenio::count()+1, 6, "0", STR_PAD_LEFT);
        $historialPagos =  HistorialPago::Where('order_id',$id)
        ->orderBy('fecha_venciento')->get();
        $modalidad_pago =  ModalidadPago::pluck('name', 'id')->all();
        $documento = SC__documento::where('id_usuario', $id)->get();
 
        if(!$documento->isNotEmpty()){
             $documento= [];
 
        }
        $products = (new AdminProduct)->getProductSelectAdmin(['kind' => [SC_PRODUCT_SINGLE, SC_PRODUCT_BUILD]]);
        $paymentMethod = [];
        $shippingMethod = [];
        $fecha_primer_pago = [];
        $paymentMethodTmp = sc_get_plugin_installed('payment', $onlyActive = false);
        foreach ($paymentMethodTmp as $key => $value) {
            $paymentMethod[$key] = sc_language_render($value->detail);
        }
        $shippingMethodTmp = sc_get_plugin_installed('shipping', $onlyActive = false);
        foreach ($shippingMethodTmp as $key => $value) {
            $shippingMethod[$key] = sc_language_render($value->detail);
        }
        $fecha_primer_pago = sc_get_plugin_installed('fecha_primer_pago', $onlyActive = false);
        foreach ($shippingMethodTmp as $key => $value) {
            $fecha_primer_pago[$key] = sc_language_render($value->detail);
        }

    

      

        return view($this->templatePathAdmin.'screen.order_edit')->with(
            [
                "title" => sc_language_render('order.order_detail'),
                "subTitle" => '',
                'icon' => 'fa fa-file-text-o',
                'nro_convenio' =>$nro_convenio,
                'convenio'=>$convenio,
                "order" => $order,
                'historial_pagos'=>$historialPagos,
                "modalidad_pago" =>  $modalidad_pago,
                "products" => $products,
                "statusOrder" => $this->statusOrder,
                "statusPayment" => $this->statusPayment,
                "statusShipping" => $this->statusShipping,
                'dataTotal' => AdminOrder::getOrderTotal($id),
                'attributesGroup' => ShopAttributeGroup::pluck('name', 'id')->all(),
                'paymentMethod' => $paymentMethod,
                'shippingMethod' => $shippingMethod,
                'fecha_primer_pago' => $fecha_primer_pago,
                'country' => $this->country,
            ]
        );
    }
    public function geDetailorder()
    {
        $id = request('id');
        $order = AdminOrder::getOrderAdmin($id);
      
    
     return  response()->json($order );
     

     
    }
    /**
     * [getInfoUser description]
     * @param   [description]
     * @return [type]           [description]
     */
    public function getInfoUser()
    {
        $id = request('id');
        return AdminCustomer::getCustomerAdminJson($id);
    }

    /**
     * [getInfoProduct description]
     * @param   [description]
     * @return [type]           [description]
     */
    public function getInfoProduct()
    {
        $id = request('id');
        $orderId = request('order_id');
        $oder = AdminOrder::getOrderAdmin($orderId);
        $product = AdminProduct::getProductAdmin($id);
        if (!$product) {
            return response()->json(['error' => 1, 'msg' => sc_language_render('admin.data_not_found_detail', ['msg' => '#product:'.$id]), 'detail' => '']);
        }
        $arrayReturn = $product->toArray();
        $arrayReturn['renderAttDetails'] = $product->renderAttributeDetailsAdmin($oder->currency, $oder->exchange_rate);
        $arrayReturn['price_final'] = $product->getFinalPrice();
        return response()->json($arrayReturn);
    }

    /**
     * process update order
     * @return [json]           [description]
     */
    public function postOrderUpdate()
    {
      
        $id = request('pk');
        $code = request('name');
        $value = request('value');
        $fecha_primer_pago = request('fecha_primer_pago');
        $ordert = AdminOrder::getOrderAdmin($id);
    


        if($code == "status" && $value == 3 && $ordert->modalidad_de_compra == 1){
            $numeros = array($ordert->evaluacion_comercial, $ordert->evaluacion_financiera, $ordert->evaluacion_legal, $ordert->decision_final);
            $valorFinal = 0;
            foreach ($numeros as $numero) {
                $valorFinal += $numero;
            }
            if($valorFinal < 400){
                 return response()->json(['error' => 1, 'msg' => "las evaluaciones no estan al 100%", 'detail' => '']);
            }
            
        }
        $datavalor = [];
        $Evaluacion = request()->all();
        foreach($Evaluacion as $key => $valor){
            $datavalor = $valor;
        }
        if(isset($Evaluacion['nombre'])){
            
            $user = AdminOrder::find($Evaluacion['id']);
            $user->$datavalor = $Evaluacion['value'];
            $user->save();

            $dataHistory = [
                'order_id' => $Evaluacion['id'],
                'content' => 'Cambios <b>' . $Evaluacion['nombre'] . '</b> de <span style="color:blue">\'' . $user->$datavalor . '\'</span> ',
                'admin_id' => Admin::user()->id,
                'order_status_id' => $user->status,
            ];
            (new AdminOrder)->addOrderHistory($dataHistory);

            

        }

        
      




    

    
       

        
        if ($code == 'shipping' || $code == 'discount' || $code == 'received' || $code == 'other_fee') {
            $orderTotalOrigin = AdminOrder::getRowOrderTotal($id);
            $orderId = $orderTotalOrigin->order_id;
            $oldValue = $orderTotalOrigin->value;
            $order = AdminOrder::getOrderAdmin($orderId);
            if (!$order) {
                return response()->json(['error' => 1, 'msg' => sc_language_render('admin.data_not_found_detail', ['msg' => 'order#'.$orderId]), 'detail' => '']);
            }
           

           
            $dataRowTotal = [
                'id' => $id,
                'nota_evaluacion_comercial' => $code,
                'nota_evaluacion_financiera' => $code,
                'fecha_primer_pago' => $fecha_primer_pago,
                'code' => $code,
                'value' => $value,
                'text' => sc_currency_render_symbol($value, $order->currency),
            ];
            AdminOrder::updateRowOrderTotal($dataRowTotal);
            
        } else {

            
            $orderId = $id;
            $order = AdminOrder::getOrderAdmin($orderId);
            if (!$order) {
                return response()->json(['error' => 1, 'msg' => sc_language_render('admin.data_not_found_detail', ['msg' => 'order#'.$orderId]), 'detail' => '']);
            }
            $oldValue = $order->{$code};
            $order->update([$code => $value]);


            if ($code == 'status') {
                //Process finish order
                if ($oldValue !=  5 && $value == 5) {
                    if (function_exists('sc_order_success_finish')) {
                        sc_order_success_finish($orderId);
                    }
                }
                if ($oldValue ==  5 && $value != 5) {
                    if (function_exists('sc_order_success_unfinish')) {
                        sc_order_success_unfinish($orderId);
                    }
                }
                //Process finish order
            }
        }

        

        //Add history
        $dataHistory = [
            'order_id' => $orderId,
            'content' => 'Cambios <b>' . $code . '</b> de <span style="color:blue">\'' . $oldValue . '\'</span> a <span style="color:red">\'' . $value . '\'</span>',
            'admin_id' => Admin::user()->id,
            'order_status_id' => $order->status,
        ];
        (new AdminOrder)->addOrderHistory($dataHistory);

        $orderUpdated = AdminOrder::getOrderAdmin($orderId);
        if ($orderUpdated->balance == 0 && $orderUpdated->total != 0) {
            $style = 'style="color:#0e9e33;font-weight:bold;"';
        } elseif ($orderUpdated->balance < 0) {
            $style = 'style="color:#ff2f00;font-weight:bold;"';
        } else {
            $style = 'style="font-weight:bold;"';
        }
        $blance = '<tr ' . $style . ' class="data-balance"><td>' . sc_language_render('order.totals.balance') . ':</td><td align="right">' . sc_currency_format($orderUpdated->balance) . '</td></tr>';
        return response()->json(['error' => 0, 'detail' =>
            [
                'total' => sc_currency_format($orderUpdated->total),
                'subtotal' => sc_currency_format($orderUpdated->subtotal),
                'tax' => sc_currency_format($orderUpdated->tax),
                'shipping' => sc_currency_format($orderUpdated->shipping),
                'discount' => sc_currency_format($orderUpdated->discount),
                'other_fee' => sc_currency_format($orderUpdated->other_fee),
                'received' => sc_currency_format($orderUpdated->received),
                'balance' => $blance,
            ],
            'msg' => sc_language_render('action.update_success')
        ]);
    }

    /**
     * [postAddItem description]
     * @param   [description]
     * @return [type]           [description]
     */
    public function postAddItem()
    {

        
        $addIds = request('add_id');
        $add_price = request('add_price');
        $add_qty = request('add_qty');
        $add_nro_cuota = request('add_nro_cuota');
        $add_modalidad = request('add_modalidad');
        $add_att = request('add_att');
        $add_tax = request('add_tax');
        $orderId = request('order_id');

        $add_inicial = request('add_inicial');

 
        $items = [];

        $order = AdminOrder::getOrderAdmin($orderId);

        foreach ($addIds as $key => $id) {
            //where exits id and qty > 0
            if ($id && $add_qty[$key]) {
                $product = AdminProduct::getProductAdmin($id);
                if (!$product) {
                    return response()->json(['error' => 1, 'msg' => sc_language_render('admin.data_not_found_detail', ['msg' => '#'.$id]), 'detail' => '']);
                }
                $pAttr = json_encode($add_att[$id] ?? []);
                $items[] = array(
                    'id' => sc_uuid(),
                    'order_id' => $orderId,
                    'product_id' => $id,
                    'name' => $product->name,
                    'qty' => $add_qty[$key],
                    'price' => $add_price[$key],
                    'total_price' => $add_price[$key] * $add_qty[$key],
                    'nro_coutas' =>  $add_nro_cuota[$key],
                    'id_modalidad_pago' => $add_modalidad[$key],
                    'abono_inicial' => $add_inicial[$key],
                    'sku' => $product->sku,
                    'tax' => $add_tax[$key],
                    'attribute' => $pAttr,
                    'currency' => $order->currency,
                    'exchange_rate' => $order->exchange_rate,
                    'created_at' => sc_time_now(),
                );
            }
        }
        if ($items) {
            try {
                (new ShopOrderDetail)->addNewDetail($items);
                //Add history
                $dataHistory = [
                    'order_id' => $orderId,
                    'content' => "Producto agregado: <br>" . implode("<br>", array_column($items, 'name')),
                    'admin_id' => Admin::user()->id,
                    'order_status_id' => $order->status,
                ];
                (new AdminOrder)->addOrderHistory($dataHistory);

                AdminOrder::updateSubTotal($orderId);
                
                //end update total price
                return response()->json(['error' => 0, 'msg' => sc_language_render('action.update_success')]);
            } catch (\Throwable $e) {
                return response()->json(['error' => 1, 'msg' => 'Error: ' . $e->getMessage()]);
            }
        }
        return response()->json(['error' => 0, 'msg' => sc_language_render('action.update_success')]);
    }

    /**
     * [postEditItem description]
     * @param   [description]
     * @return [type]           [description]
     */
    public function postEditItem()
    {
        try {
          
            $id = request('pk');
         
            $field = request('name');
            $value = request('value');
            $item = ShopOrderDetail::find($id);
            $fieldOrg = $item->{$field};
            $orderId = $item->order_id;
            $item->{$field} = $value;
            if ($field == 'qty' || $field == 'price') {
                $item->total_price = $value * (($field == 'qty') ? $item->price : $item->qty);
            }
            $item->save();
            $item = $item->fresh();
            $order = AdminOrder::getOrderAdmin($orderId);
            if (!$order) {
                return response()->json(['error' => 1, 'msg' => sc_language_render('admin.data_not_found_detail', ['msg' => '#order:'.$orderId]), 'detail' => '']);
            }
            //Add history
            $dataHistory = [
                'order_id' => $orderId,
                'content' => sc_language_render('product.edit_product') . ' #' . $id . ': ' . $field . ' de ' . $fieldOrg . ' -> ' . $value,
                'admin_id' => Admin::user()->id,
                'order_status_id' => $order->status,
            ];
            (new AdminOrder)->addOrderHistory($dataHistory);

            //Update stock
            if ($field == 'qty') {
                $checkQty = $value - $fieldOrg;
                //Update stock, sold
                AdminProduct::updateStock($item->product_id, $checkQty);
            }

            //Update total price
            AdminOrder::updateSubTotal($orderId);
            //end update total price

            //fresh order info after update
            $orderUpdated = $order->fresh();

            if ($orderUpdated->balance == 0 && $orderUpdated->total != 0) {
                $style = 'style="color:#0e9e33;font-weight:bold;"';
            } elseif ($orderUpdated->balance < 0) {
                $style = 'style="color:#ff2f00;font-weight:bold;"';
            } else {
                $style = 'style="font-weight:bold;"';
            }
            $blance = '<tr ' . $style . ' class="data-balance"><td>' . sc_language_render('order.totals.balance') . ':</td><td align="right">' . sc_currency_format($orderUpdated->balance) . '</td></tr>';
            $arrayReturn = ['error' => 0, 'detail' => [
                'total'            => sc_currency_format($orderUpdated->total),
                'subtotal'         => sc_currency_format($orderUpdated->subtotal),
                'tax'              => sc_currency_format($orderUpdated->tax),
                'shipping'         => sc_currency_format($orderUpdated->shipping),
                'discount'         => sc_currency_format($orderUpdated->discount),
                'received'         => sc_currency_format($orderUpdated->received),
                'item_total_price' => sc_currency_render_symbol($item->total_price, $item->currency),
                'item_id'          => $id,
                'balance'          => $blance,
            ],'msg' => sc_language_render('action.update_success')
            ];
        } catch (\Throwable $e) {
            $arrayReturn = ['error' => 1, 'msg' => $e->getMessage()];
        }
        return response()->json($arrayReturn);
    }

    /**
     * [postDeleteItem description]
     * @param   [description]
     * @return [type]           [description]
     */
    public function postDeleteItem()
    {
        try {
            $data = request()->all();
            $pId = $data['pId'] ?? "";
            $itemDetail = (new ShopOrderDetail)->where('id', $pId)->first();
            if (!$itemDetail) {
                return response()->json(['error' => 1, 'msg' => sc_language_render('admin.data_not_found_detail', ['msg' => 'detail#'.$pId]), 'detail' => '']);
            }
            $orderId = $itemDetail->order_id;
            $order = AdminOrder::getOrderAdmin($orderId);
            if (!$order) {
                return response()->json(['error' => 1, 'msg' => sc_language_render('admin.data_not_found_detail', ['msg' => 'order#'.$orderId]), 'detail' => '']);
            }

            $pId = $itemDetail->product_id;
            $qty = $itemDetail->qty;
            $itemDetail->delete(); //Remove item from shop order detail
            //Update total price
            AdminOrder::updateSubTotal($orderId);
            //Update stock, sold
            AdminProduct::updateStock($pId, -$qty);

            //Add history
            $dataHistory = [
                'order_id' => $orderId,
                'content' => ' item eliminado pID#' . $pId,
                'admin_id' => Admin::user()->id,
                'order_status_id' => $order->status,
            ];
            (new AdminOrder)->addOrderHistory($dataHistory);
            return response()->json(['error' => 0, 'msg' => sc_language_render('action.update_success')]);
        } catch (\Throwable $e) {
            return response()->json(['error' => 1, 'msg' => 'Error: ' . $e->getMessage()]);
        }
    }

    /*
    Delete list order ID
    Need mothod destroy to boot deleting in model
    */
    public function deleteList()
    {
        if (!request()->ajax()) {
            return response()->json(['error' => 1, 'msg' => sc_language_render('admin.method_not_allow')]);
        } else {
            $ids = request('ids');
            $arrID = explode(',', $ids);
            $arrDontPermission = [];
            foreach ($arrID as $key => $id) {
                if (!$this->checkPermisisonItem($id)) {
                    $arrDontPermission[] = $id;
                }
            }
            if (count($arrDontPermission)) {
                return response()->json(['error' => 1, 'msg' => sc_language_render('admin.remove_dont_permisison') . ': ' . json_encode($arrDontPermission)]);
            } else {
                AdminOrder::destroy($arrID);
                return response()->json(['error' => 0, 'msg' => sc_language_render('action.update_success')]);
            }
        }
    }

    /**
     * Process invoice
     */
    public function invoice()
    {
        $orderId = request('order_id') ?? null;
        $action = request('action') ?? '';
        $order = AdminOrder::getOrderAdmin($orderId);
        if ($order) {
            $data                    = array();
            $data['name']            = $order['first_name'] . ' ' . $order['last_name'];
            $data['address']         = $order['address1'] . ', ' . $order['address2'] . ', ' . $order['address3'].', '.$order['country'];
            $data['phone']           = $order['phone'];
            $data['email']           = $order['email'];
            $data['comment']         = $order['comment'];
            $data['payment_method']  = $order['payment_method'];
            $data['shipping_method'] = $order['shipping_method'];
            $data['created_at']      = $order['created_at'];
            $data['currency']        = $order['currency'];
            $data['exchange_rate']   = $order['exchange_rate'];
            $data['subtotal']        = $order['subtotal'];
            $data['tax']             = $order['tax'];
            $data['shipping']        = $order['shipping'];
            $data['discount']        = $order['discount'];
            $data['total']           = $order['total'];
            $data['received']        = $order['received'];
            $data['balance']         = $order['balance'];
            $data['other_fee']       = $order['other_fee'] ?? 0;
            $data['comment']         = $order['comment'];
            $data['country']         = $order['country'];
            $data['id']              = $order->id;
            $data['details'] = [];

            $attributesGroup =  ShopAttributeGroup::pluck('name', 'id')->all();

            if ($order->details) {
                foreach ($order->details as $key => $detail) {
                    $arrAtt = json_decode($detail->attribute, true);
                    if ($arrAtt) {
                        $htmlAtt = '';
                        foreach ($arrAtt as $groupAtt => $att) {
                            $htmlAtt .= $attributesGroup[$groupAtt] .':'.sc_render_option_price($att, $order['currency'], $order['exchange_rate']);
                        }
                        $name = $detail->name.'('.strip_tags($htmlAtt).')';
                    } else {
                        $name = $detail->name;
                    }
                    $data['details'][] = [
                        'no' => $key + 1, 
                        'sku' => $detail->sku, 
                        'name' => $name, 
                        'qty' => $detail->qty, 
                        'price' => $detail->price, 
                        'total_price' => $detail->total_price,
                    ];
                }
            }

            if ($action =='invoice_excel') {
                $options = ['filename' => 'Order ' . $orderId];
                return \Export::export($action, $data, $options);
            }
            
            return view($this->templatePathAdmin.'format.invoice')
            ->with($data);
        } else {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }
    }

    /**
     * Check permisison item
     */
    public function checkPermisisonItem($id)
    {
        return AdminOrder::getOrderAdmin($id);
    }


    public function downloadPdf($id)
    {

        $estado = Estado::all();
        $municipio = Municipio::all();
        $parroquia = Parroquia::all();
        $order = ShopOrder::where('id',$id)->get();

        if (!$order) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }

        $convenio = Convenio::where('order_id',$id)->first();
        
        $usuario =  SC_shop_customer::where('email', $order[0]['email'])->get();
        $result = $usuario->all();
        $productoDetail = shop_order_detail::where('order_id' , $id)->get();
        $cantidaProduc = shop_order_detail::where('order_id',$id)->count();
        $nombreProduct = [];
        $fecha_maxima_entrega = [];
        $cuotas = [];
        $abono_inicial = [];
        $id_modalidad_pago = [];
        foreach($productoDetail as $key => $p){
            $nombreProduct = $p->name;
            $cuotas = $p->nro_coutas;
            $abono_inicial = $p->abono_inicial;
            $id_modalidad_pago = $p->id_modalidad_pago;
            $fecha_maxima_entrega = $p->fecha_maxima_entrega;
        }
        

        $nombreEstado=[];
        $nombreparroquias =[];
        $nombremunicipos =[];
        foreach($result as $c){
            foreach($estado as $estados){
           if($estados->codigoestado ==  $c['cod_estado']){$nombreEstado = $estados->nombre;}

                foreach($municipio as $municipos){
                    if($municipos->codigomunicipio ==$c['cod_municipio'])$nombremunicipos =$municipos->nombre;
                }
                foreach($parroquia as $parroquias){
                    if($parroquias->codigomunicipio == $c['cod_municipio']){
                        $nombreparroquias = $parroquias->nombre;}
                }
              
            }

            $dato_usuario = [
                'subtotal' => $c['subtotal'],
                'natural_jurídica' => $c['natural_jurídica'],
                'razon_social' => $c['razon_social'],
                'rif' => $c['rif'],
                'first_name' => $c['first_name'],
                'last_name' => $c['last_name'],
                'phone' => $c['phone'],
                'email' => $c['email'],
                'address1' => $c['address1'],
                'cedula' => $c['cedula'],
                'cod_estado' => $nombreEstado ,
                'cod_municipio' => $nombremunicipos,
                'cod_parroquia' => $nombreparroquias,
                'estado_civil' => $c['estado_civil'],
                
                [
        
                    'subtotal'=> $order[0]['subtotal'],
                    'cantidaProduc'=> $cantidaProduc,
                    'nombreProduct'=> $nombreProduct,
                    'cuotas' => $cuotas,
                    'abono_inicial' => $abono_inicial,
                    'id_modalidad_pago' => $id_modalidad_pago

                ]

            ];


        }

            
                function unidad($numuero){
                    switch ($numuero)
                    {
                        case 9:
                        {
                            $numu = "NUEVE";
                            break;
                        }
                        case 8:
                        {
                            $numu = "OCHO";
                            break;
                        }
                        case 7:
                        {
                            $numu = "SIETE";
                            break;
                        }
                        case 6:
                        {
                            $numu = "SEIS";
                            break;
                        }
                        case 5:
                        {
                            $numu = "CINCO";
                            break;
                        }
                        case 4:
                        {
                            $numu = "CUATRO";
                            break;
                        }
                        case 3:
                        {
                            $numu = "TRES";
                            break;
                        }
                        case 2:
                        {
                            $numu = "DOS";
                            break;
                        }
                        case 1:
                        {
                            $numu = "UNO";
                            break;
                        }
                        case 0:
                        {
                            $numu = "";
                            break;
                        }
                    }
                    return $numu;
                }
                
                function decenas($numdero){
                
                        if ($numdero >= 90 && $numdero <= 99)
                        {
                            $numd = "NOVENTA ";
                            if ($numdero > 90)
                                $numd = $numd."Y ".(unidad($numdero - 90));
                        }
                        else if ($numdero >= 80 && $numdero <= 89)
                        {
                            $numd = "OCHENTA ";
                            if ($numdero > 80)
                                $numd = $numd."Y ".(unidad($numdero - 80));
                        }
                        else if ($numdero >= 70 && $numdero <= 79)
                        {
                            $numd = "SETENTA ";
                            if ($numdero > 70)
                                $numd = $numd."Y ".(unidad($numdero - 70));
                        }
                        else if ($numdero >= 60 && $numdero <= 69)
                        {
                            $numd = "SESENTA ";
                            if ($numdero > 60)
                                $numd = $numd."Y ".(unidad($numdero - 60));
                        }
                        else if ($numdero >= 50 && $numdero <= 59)
                        {
                            $numd = "CINCUENTA ";
                            if ($numdero > 50)
                                $numd = $numd."Y ".(unidad($numdero - 50));
                        }
                        else if ($numdero >= 40 && $numdero <= 49)
                        {
                            $numd = "CUARENTA ";
                            if ($numdero > 40)
                                $numd = $numd."Y ".(unidad($numdero - 40));
                        }
                        else if ($numdero >= 30 && $numdero <= 39)
                        {
                            $numd = "TREINTA ";
                            if ($numdero > 30)
                                $numd = $numd."Y ".(unidad($numdero - 30));
                        }
                        else if ($numdero >= 20 && $numdero <= 29)
                        {
                            if ($numdero == 20)
                                $numd = "VEINTE ";
                            else
                                $numd = "VEINTI".(unidad($numdero - 20));
                        }
                        else if ($numdero >= 10 && $numdero <= 19)
                        {
                            switch ($numdero){
                            case 10:
                            {
                                $numd = "DIEZ ";
                                break;
                            }
                            case 11:
                            {
                                $numd = "ONCE ";
                                break;
                            }
                            case 12:
                            {
                                $numd = "DOCE ";
                                break;
                            }
                            case 13:
                            {
                                $numd = "TRECE ";
                                break;
                            }
                            case 14:
                            {
                                $numd = "CATORCE ";
                                break;
                            }
                            case 15:
                            {
                                $numd = "QUINCE ";
                                break;
                            }
                            case 16:
                            {
                                $numd = "DIECISEIS ";
                                break;
                            }
                            case 17:
                            {
                                $numd = "DIECISIETE ";
                                break;
                            }
                            case 18:
                            {
                                $numd = "DIECIOCHO ";
                                break;
                            }
                            case 19:
                            {
                                $numd = "DIECINUEVE ";
                                break;
                            }
                            }
                        }
                        else
                            $numd = unidad($numdero);
                    return $numd;
                }
                
                    function centena($numc){
                        if ($numc >= 100)
                        {
                            if ($numc >= 900 && $numc <= 999)
                            {
                                $numce = "NOVECIENTOS ";
                                if ($numc > 900)
                                    $numce = $numce.(decenas($numc - 900));
                            }
                            else if ($numc >= 800 && $numc <= 899)
                            {
                                $numce = "OCHOCIENTOS ";
                                if ($numc > 800)
                                    $numce = $numce.(decenas($numc - 800));
                            }
                            else if ($numc >= 700 && $numc <= 799)
                            {
                                $numce = "SETECIENTOS ";
                                if ($numc > 700)
                                    $numce = $numce.(decenas($numc - 700));
                            }
                            else if ($numc >= 600 && $numc <= 699)
                            {
                                $numce = "SEISCIENTOS ";
                                if ($numc > 600)
                                    $numce = $numce.(decenas($numc - 600));
                            }
                            else if ($numc >= 500 && $numc <= 599)
                            {
                                $numce = "QUINIENTOS ";
                                if ($numc > 500)
                                    $numce = $numce.(decenas($numc - 500));
                            }
                            else if ($numc >= 400 && $numc <= 499)
                            {
                                $numce = "CUATROCIENTOS ";
                                if ($numc > 400)
                                    $numce = $numce.(decenas($numc - 400));
                            }
                            else if ($numc >= 300 && $numc <= 399)
                            {
                                $numce = "TRESCIENTOS ";
                                if ($numc > 300)
                                    $numce = $numce.(decenas($numc - 300));
                            }
                            else if ($numc >= 200 && $numc <= 299)
                            {
                                $numce = "DOSCIENTOS ";
                                if ($numc > 200)
                                    $numce = $numce.(decenas($numc - 200));
                            }
                            else if ($numc >= 100 && $numc <= 199)
                            {
                                if ($numc == 100)
                                    $numce = "CIEN ";
                                else
                                    $numce = "CIENTO ".(decenas($numc - 100));
                            }
                        }
                        else
                            $numce = decenas($numc);
                
                        return $numce;
                }
                
                    function miles($nummero){
                        if ($nummero >= 1000 && $nummero < 2000){
                            $numm = "MIL ".(centena($nummero%1000));
                        }
                        if ($nummero >= 2000 && $nummero <10000){
                            $numm = unidad(Floor($nummero/1000))." MIL ".(centena($nummero%1000));
                        }
                        if ($nummero < 1000)
                            $numm = centena($nummero);
                
                        return $numm;
                    }
                
                    function decmiles($numdmero){
                        if ($numdmero == 10000)
                            $numde = "DIEZ MIL";
                        if ($numdmero > 10000 && $numdmero <20000){
                            $numde = decenas(Floor($numdmero/1000))."MIL ".(centena($numdmero%1000));
                        }
                        if ($numdmero >= 20000 && $numdmero <100000){
                            $numde = decenas(Floor($numdmero/1000))." MIL ".(miles($numdmero%1000));
                        }
                        if ($numdmero < 10000)
                            $numde = miles($numdmero);
                
                        return $numde;
                    }
                
                    function cienmiles($numcmero){
                        if ($numcmero == 100000)
                            $num_letracm = "CIEN MIL";
                        if ($numcmero >= 100000 && $numcmero <1000000){
                            $num_letracm = centena(Floor($numcmero/1000))." MIL ".(centena($numcmero%1000));
                        }
                        if ($numcmero < 100000)
                            $num_letracm = decmiles($numcmero);
                        return $num_letracm;
                    }
                
                    function millon($nummiero){
                        if ($nummiero >= 1000000 && $nummiero <2000000){
                            $num_letramm = "UN MILLON ".(cienmiles($nummiero%1000000));
                        }
                        if ($nummiero >= 2000000 && $nummiero <10000000){
                            $num_letramm = unidad(Floor($nummiero/1000000))." MILLONES ".(cienmiles($nummiero%1000000));
                        }
                        if ($nummiero < 1000000)
                            $num_letramm = cienmiles($nummiero);
                
                        return $num_letramm;
                    }
                
                    function decmillon2($numerodm){
                        if ($numerodm == 10000000)
                            $num_letradmm = "DIEZ MILLONES";
                        if ($numerodm > 10000000 && $numerodm <20000000){
                            $num_letradmm = decenas(Floor($numerodm/1000000))."MILLONES ".(cienmiles($numerodm%1000000));
                        }
                        if ($numerodm >= 20000000 && $numerodm <100000000){
                            $num_letradmm = decenas(Floor($numerodm/1000000))." MILLONES ".(millon($numerodm%1000000));
                        }
                        if ($numerodm < 10000000)
                            $num_letradmm = millon($numerodm);
                
                        return $num_letradmm;
                    }
                
                    function cienmillon2($numcmeros){
                        if ($numcmeros == 100000000)
                            $num_letracms = "CIEN MILLONES";
                        if ($numcmeros >= 100000000 && $numcmeros <1000000000){
                            $num_letracms = centena(Floor($numcmeros/1000000))." MILLONES ".(millon($numcmeros%1000000));
                        }
                        if ($numcmeros < 100000000)
                            $num_letracms = decmillon2($numcmeros);
                        return $num_letracms;
                    }
                
                    function milmillon2($nummierod){
                        if ($nummierod >= 1000000000 && $nummierod <2000000000){
                            $num_letrammd = "MIL ".(cienmillon2($nummierod%1000000000));
                        }
                        if ($nummierod >= 2000000000 && $nummierod <10000000000){
                            $num_letrammd = unidad(Floor($nummierod/1000000000))." MIL ".(cienmillon2($nummierod%1000000000));
                        }
                        if ($nummierod < 1000000000)
                            $num_letrammd = cienmillon2($nummierod);
                
                        return $num_letrammd;
                    }
                
                
                    function convertir1($numero){
                                $num = str_replace(",","",$numero);
                                $num = number_format($num,2,'.','');
                                $cents = substr($num,strlen($num)-2,strlen($num)-1);
                                $num = (int)$num;
                    
                                $numf = milmillon2($num);
                    
                            return $numf;
                    }
                    function convertir2($numero){
                        $num = str_replace(",","",$numero);
                        $num = number_format($num,2,'.','');
                        $cents = substr($num,strlen($num)-2,strlen($num)-1);
                        $num = (int)$num;
            
                        $numf = milmillon2($num);
            
                    return $numf ." CON " .$cents;
            }

                function basico($numero) {
                    $valor = array ('uno','dos','tres','cuatro','cinco','seis','siete','ocho',
                    'nueve','diez','once','doce','trece','catorce','quince','dieciseis','diecisiete','dieciocho','diecinueve','veinte','veintiuno ','vientidos ','veintitrés ', 'veinticuatro','veinticinco',
                    'veintiséis','veintisiete','veintiocho','veintinueve');
                    return $valor[$numero - 1];
                    }

                function decenass($n) {
                    $decenas = array (30=>'treinta',40=>'cuarenta',50=>'cincuenta',60=>'sesenta',
                    70=>'setenta',80=>'ochenta',90=>'noventa');
                    if( $n <= 29) return basico($n);
                    $x = $n % 10;
                    if ( $x == 0 ) {
                    return $decenas[$n];
                    } else return $decenas[$n - $x].' y '. basico($x);
                    
                    }

                    $Moneda_CAMBIOBS = sc_currency_all();
                    foreach($Moneda_CAMBIOBS as $cambio){
                        if($cambio->name == "Bolivares"){
                           $nombreBS =  decenass($cambio->exchange_rate);
                           $cod_bolibares =  $cambio->exchange_rate;
                        }
                    }

                $borrado_html = [];
                if($abono_inicial <= "0.00"){
                    $borrado_html = Sc_plantilla_convenio::where('id' , 1)->first()->where('name','sin_inicial')->get();
                    }else{
                        $borrado_html = Sc_plantilla_convenio::where('id' , 2)->first()->where('name','con_inicial')->get();
                    }


                $pieces = explode(" ", $dato_usuario['cedula']);
                if ($dato_usuario[0]['id_modalidad_pago']== 3) {
                    $mesualQuinsena = "MENSUAL";
                    $cod_diaMes = "LOS DIAS " . $dato_usuario[0]['cuotas'] . " DE CADA MES";
                }else {
                    $mesualQuinsena = " QUINCENAL";
                    $cod_diaMes = "LOS DIAS " . $dato_usuario[0]['cuotas'] . " Y 30 DE CADA MES";
                } 
                if ($pieces[0] == "V" ) $Nacionalidad = "VENEZOLANO(A)";
                    else $Nacionalidad = "Extranjer(A)"; 

               

                
                $monto = $dato_usuario[0]['subtotal'];
                $number1 =  $dato_usuario[0]['subtotal']/$dato_usuario[0]['cuotas'];
                $cuotas = $dato_usuario[0]['cuotas'];
                if($convenio->inicial>0){
                    $totalinicial=($dato_usuario[0]['abono_inicial']*$dato_usuario[0]['subtotal'])/100;
                    $monto = $dato_usuario[0]['subtotal'];
                    $monto = $monto - $totalinicial;
                    $number1 =  $monto/$dato_usuario[0]['cuotas'];
                    $cuotas = $number1;
                    $number2 =  $monto*$cod_bolibares;
                   
                  }

                  
                  $number2 =  $monto*$cod_bolibares;
                    

                foreach($borrado_html as $replacee){
                    $dataFind = [
                        "cod_first_name",
                        'cod_last_name',
                        'address1',
                        'cod_estado',
                        'cod_municipio',
                        'cod_parroquia',
                        'cod_Cedula',
                        'cod_civil',
                        'cod_Nacionalidad',
                        'cod_modalidad_pago',
                        'cod_dia',
                        'Cuotas1',
                        'Cod_CuotasEtreprecioTptal',
                        'Cod_CuotasEtrepreciotext',
                        'cod_mespago',
                        'cod_fechaEntrega',
                        'cod_subtotal',
                        'cod_nombreBS',
                        'cod_bolibares',
                        'nombreProduct',
                        'cod_phone',
                        'cod_email',
                        'cod_doreccion',
                        'cod_Fecha_De_Hoy',
                    ];
                    $dataReplace = [
                        $dato_usuario['first_name'],
                        $dato_usuario['last_name'],
                        $dato_usuario['address1'],
                        $dato_usuario['cod_estado'],
                        $dato_usuario['cod_municipio'],
                        $dato_usuario['cod_parroquia'],
                        $dato_usuario['cedula'],
                        $dato_usuario['estado_civil'],
                        'cod_Nacionalidad'=> $Nacionalidad,
                        'cod_modalidad_pago' => $mesualQuinsena,
                        'cod_dia'=> convertir1($cuotas),
                        number_format($cuotas),
                        'Cod_CuotasEtreprecioTptal'=> number_format($number1),
                        'Cod_CuotasEtrepreciotext'=> convertir1($number1),
                        'cod_mespago' => $cod_diaMes ,
                        'cod_fechaEntrega' =>$convenio->fecha_maxima_entrega,
                        $monto ,
                        'cod_nombreBS'=> convertir2($number2),
                        'cod_bolibares'=> number_format($number2, 2 ,',', ' '),
                        $dato_usuario[0]['nombreProduct'] ,
                        $dato_usuario['phone'],
                        $dato_usuario['email'],
                        $dato_usuario['address1'],
                        'cod_Fecha_De_Hoy'=> date('d-m-y'),
                        
                    ];
            
                    $resultado = str_replace($dataFind, $dataReplace, $replacee->contenido);
                }
                
                

        $pdf = Pdf::loadView($this->templatePathAdmin.'screen.comvenio_pdf', 
        ['borrado_html'=> $resultado],
        ['convenio'=> $convenio['nro_convenio'] ],

        );

        return $pdf->stream();
    }

    public function borrador_pdf($id){
        $estado = Estado::all();
        $municipio = Municipio::all();
        $parroquia = Parroquia::all();
        $order = ShopOrder::where('id',$id)->get();

        if (!$order) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }

        $convenio = Convenio::where('order_id',$id)->first();
        
        $usuario =  SC_shop_customer::where('email', $order[0]['email'])->get();
        $result = $usuario->all();
        $productoDetail = shop_order_detail::where('order_id' , $id)->get();
        $cantidaProduc = shop_order_detail::where('order_id',$id)->count();
        $nombreProduct = [];
        $fecha_maxima_entrega = [];
        $cuotas = [];
        $abono_inicial = [];
        $id_modalidad_pago = [];
        foreach($productoDetail as $key => $p){
            $nombreProduct = $p->name;
            $cuotas = $p->nro_coutas;
            $abono_inicial = $p->abono_inicial;
            $id_modalidad_pago = $p->id_modalidad_pago;
            $fecha_maxima_entrega = $p->fecha_maxima_entrega;
        }
        

        $nombreEstado=[];
        $nombreparroquias =[];
        $nombremunicipos =[];
        foreach($result as $c){
            foreach($estado as $estados){
           if($estados->codigoestado ==  $c['cod_estado']){$nombreEstado = $estados->nombre;}

                foreach($municipio as $municipos){
                    if($municipos->codigomunicipio ==$c['cod_municipio'])$nombremunicipos =$municipos->nombre;
                }
                foreach($parroquia as $parroquias){
                    if($parroquias->codigomunicipio == $c['cod_municipio']){
                        $nombreparroquias = $parroquias->nombre;}
                }
              
            }

            $dato_usuario = [
                'subtotal' => $c['subtotal'],
                'natural_jurídica' => $c['natural_jurídica'],
                'razon_social' => $c['razon_social'],
                'rif' => $c['rif'],
                'first_name' => $c['first_name'],
                'last_name' => $c['last_name'],
                'phone' => $c['phone'],
                'email' => $c['email'],
                'address1' => $c['address1'],
                'cedula' => $c['cedula'],
                'cod_estado' => $nombreEstado ,
                'cod_municipio' => $nombremunicipos,
                'cod_parroquia' => $nombreparroquias,
                'estado_civil' => $c['estado_civil'],
                
                [
        
                    'subtotal'=> $order[0]['subtotal'],
                    'cantidaProduc'=> $cantidaProduc,
                    'nombreProduct'=> $nombreProduct,
                    'cuotas' => $cuotas,
                    'abono_inicial' => $abono_inicial,
                    'id_modalidad_pago' => $id_modalidad_pago

                ]

            ];


        }

            
                function unidad($numuero){
                    switch ($numuero)
                    {
                        case 9:
                        {
                            $numu = "NUEVE";
                            break;
                        }
                        case 8:
                        {
                            $numu = "OCHO";
                            break;
                        }
                        case 7:
                        {
                            $numu = "SIETE";
                            break;
                        }
                        case 6:
                        {
                            $numu = "SEIS";
                            break;
                        }
                        case 5:
                        {
                            $numu = "CINCO";
                            break;
                        }
                        case 4:
                        {
                            $numu = "CUATRO";
                            break;
                        }
                        case 3:
                        {
                            $numu = "TRES";
                            break;
                        }
                        case 2:
                        {
                            $numu = "DOS";
                            break;
                        }
                        case 1:
                        {
                            $numu = "UNO";
                            break;
                        }
                        case 0:
                        {
                            $numu = "";
                            break;
                        }
                    }
                    return $numu;
                }
                
                function decenas($numdero){
                
                        if ($numdero >= 90 && $numdero <= 99)
                        {
                            $numd = "NOVENTA ";
                            if ($numdero > 90)
                                $numd = $numd."Y ".(unidad($numdero - 90));
                        }
                        else if ($numdero >= 80 && $numdero <= 89)
                        {
                            $numd = "OCHENTA ";
                            if ($numdero > 80)
                                $numd = $numd."Y ".(unidad($numdero - 80));
                        }
                        else if ($numdero >= 70 && $numdero <= 79)
                        {
                            $numd = "SETENTA ";
                            if ($numdero > 70)
                                $numd = $numd."Y ".(unidad($numdero - 70));
                        }
                        else if ($numdero >= 60 && $numdero <= 69)
                        {
                            $numd = "SESENTA ";
                            if ($numdero > 60)
                                $numd = $numd."Y ".(unidad($numdero - 60));
                        }
                        else if ($numdero >= 50 && $numdero <= 59)
                        {
                            $numd = "CINCUENTA ";
                            if ($numdero > 50)
                                $numd = $numd."Y ".(unidad($numdero - 50));
                        }
                        else if ($numdero >= 40 && $numdero <= 49)
                        {
                            $numd = "CUARENTA ";
                            if ($numdero > 40)
                                $numd = $numd."Y ".(unidad($numdero - 40));
                        }
                        else if ($numdero >= 30 && $numdero <= 39)
                        {
                            $numd = "TREINTA ";
                            if ($numdero > 30)
                                $numd = $numd."Y ".(unidad($numdero - 30));
                        }
                        else if ($numdero >= 20 && $numdero <= 29)
                        {
                            if ($numdero == 20)
                                $numd = "VEINTE ";
                            else
                                $numd = "VEINTI".(unidad($numdero - 20));
                        }
                        else if ($numdero >= 10 && $numdero <= 19)
                        {
                            switch ($numdero){
                            case 10:
                            {
                                $numd = "DIEZ ";
                                break;
                            }
                            case 11:
                            {
                                $numd = "ONCE ";
                                break;
                            }
                            case 12:
                            {
                                $numd = "DOCE ";
                                break;
                            }
                            case 13:
                            {
                                $numd = "TRECE ";
                                break;
                            }
                            case 14:
                            {
                                $numd = "CATORCE ";
                                break;
                            }
                            case 15:
                            {
                                $numd = "QUINCE ";
                                break;
                            }
                            case 16:
                            {
                                $numd = "DIECISEIS ";
                                break;
                            }
                            case 17:
                            {
                                $numd = "DIECISIETE ";
                                break;
                            }
                            case 18:
                            {
                                $numd = "DIECIOCHO ";
                                break;
                            }
                            case 19:
                            {
                                $numd = "DIECINUEVE ";
                                break;
                            }
                            }
                        }
                        else
                            $numd = unidad($numdero);
                    return $numd;
                }
                
                    function centena($numc){
                        if ($numc >= 100)
                        {
                            if ($numc >= 900 && $numc <= 999)
                            {
                                $numce = "NOVECIENTOS ";
                                if ($numc > 900)
                                    $numce = $numce.(decenas($numc - 900));
                            }
                            else if ($numc >= 800 && $numc <= 899)
                            {
                                $numce = "OCHOCIENTOS ";
                                if ($numc > 800)
                                    $numce = $numce.(decenas($numc - 800));
                            }
                            else if ($numc >= 700 && $numc <= 799)
                            {
                                $numce = "SETECIENTOS ";
                                if ($numc > 700)
                                    $numce = $numce.(decenas($numc - 700));
                            }
                            else if ($numc >= 600 && $numc <= 699)
                            {
                                $numce = "SEISCIENTOS ";
                                if ($numc > 600)
                                    $numce = $numce.(decenas($numc - 600));
                            }
                            else if ($numc >= 500 && $numc <= 599)
                            {
                                $numce = "QUINIENTOS ";
                                if ($numc > 500)
                                    $numce = $numce.(decenas($numc - 500));
                            }
                            else if ($numc >= 400 && $numc <= 499)
                            {
                                $numce = "CUATROCIENTOS ";
                                if ($numc > 400)
                                    $numce = $numce.(decenas($numc - 400));
                            }
                            else if ($numc >= 300 && $numc <= 399)
                            {
                                $numce = "TRESCIENTOS ";
                                if ($numc > 300)
                                    $numce = $numce.(decenas($numc - 300));
                            }
                            else if ($numc >= 200 && $numc <= 299)
                            {
                                $numce = "DOSCIENTOS ";
                                if ($numc > 200)
                                    $numce = $numce.(decenas($numc - 200));
                            }
                            else if ($numc >= 100 && $numc <= 199)
                            {
                                if ($numc == 100)
                                    $numce = "CIEN ";
                                else
                                    $numce = "CIENTO ".(decenas($numc - 100));
                            }
                        }
                        else
                            $numce = decenas($numc);
                
                        return $numce;
                }
                
                    function miles($nummero){
                        if ($nummero >= 1000 && $nummero < 2000){
                            $numm = "MIL ".(centena($nummero%1000));
                        }
                        if ($nummero >= 2000 && $nummero <10000){
                            $numm = unidad(Floor($nummero/1000))." MIL ".(centena($nummero%1000));
                        }
                        if ($nummero < 1000)
                            $numm = centena($nummero);
                
                        return $numm;
                    }
                
                    function decmiles($numdmero){
                        if ($numdmero == 10000)
                            $numde = "DIEZ MIL";
                        if ($numdmero > 10000 && $numdmero <20000){
                            $numde = decenas(Floor($numdmero/1000))."MIL ".(centena($numdmero%1000));
                        }
                        if ($numdmero >= 20000 && $numdmero <100000){
                            $numde = decenas(Floor($numdmero/1000))." MIL ".(miles($numdmero%1000));
                        }
                        if ($numdmero < 10000)
                            $numde = miles($numdmero);
                
                        return $numde;
                    }
                
                    function cienmiles($numcmero){
                        if ($numcmero == 100000)
                            $num_letracm = "CIEN MIL";
                        if ($numcmero >= 100000 && $numcmero <1000000){
                            $num_letracm = centena(Floor($numcmero/1000))." MIL ".(centena($numcmero%1000));
                        }
                        if ($numcmero < 100000)
                            $num_letracm = decmiles($numcmero);
                        return $num_letracm;
                    }
                
                    function millon($nummiero){
                        if ($nummiero >= 1000000 && $nummiero <2000000){
                            $num_letramm = "UN MILLON ".(cienmiles($nummiero%1000000));
                        }
                        if ($nummiero >= 2000000 && $nummiero <10000000){
                            $num_letramm = unidad(Floor($nummiero/1000000))." MILLONES ".(cienmiles($nummiero%1000000));
                        }
                        if ($nummiero < 1000000)
                            $num_letramm = cienmiles($nummiero);
                
                        return $num_letramm;
                    }
                
                    function decmillon2($numerodm){
                        if ($numerodm == 10000000)
                            $num_letradmm = "DIEZ MILLONES";
                        if ($numerodm > 10000000 && $numerodm <20000000){
                            $num_letradmm = decenas(Floor($numerodm/1000000))."MILLONES ".(cienmiles($numerodm%1000000));
                        }
                        if ($numerodm >= 20000000 && $numerodm <100000000){
                            $num_letradmm = decenas(Floor($numerodm/1000000))." MILLONES ".(millon($numerodm%1000000));
                        }
                        if ($numerodm < 10000000)
                            $num_letradmm = millon($numerodm);
                
                        return $num_letradmm;
                    }
                
                    function cienmillon2($numcmeros){
                        if ($numcmeros == 100000000)
                            $num_letracms = "CIEN MILLONES";
                        if ($numcmeros >= 100000000 && $numcmeros <1000000000){
                            $num_letracms = centena(Floor($numcmeros/1000000))." MILLONES ".(millon($numcmeros%1000000));
                        }
                        if ($numcmeros < 100000000)
                            $num_letracms = decmillon2($numcmeros);
                        return $num_letracms;
                    }
                
                    function milmillon2($nummierod){
                        if ($nummierod >= 1000000000 && $nummierod <2000000000){
                            $num_letrammd = "MIL ".(cienmillon2($nummierod%1000000000));
                        }
                        if ($nummierod >= 2000000000 && $nummierod <10000000000){
                            $num_letrammd = unidad(Floor($nummierod/1000000000))." MIL ".(cienmillon2($nummierod%1000000000));
                        }
                        if ($nummierod < 1000000000)
                            $num_letrammd = cienmillon2($nummierod);
                
                        return $num_letrammd;
                    }
                
                
                    function convertir1($numero){
                                $num = str_replace(",","",$numero);
                                $num = number_format($num,2,'.','');
                                $cents = substr($num,strlen($num)-2,strlen($num)-1);
                                $num = (int)$num;
                    
                                $numf = milmillon2($num);
                    
                            return $numf;
                    }
                    function convertir2($numero){
                        $num = str_replace(",","",$numero);
                        $num = number_format($num,2,'.','');
                        $cents = substr($num,strlen($num)-2,strlen($num)-1);
                        $num = (int)$num;
            
                        $numf = milmillon2($num);
            
                    return $numf ." CON " .$cents;
            }

                function basico($numero) {
                    $valor = array ('uno','dos','tres','cuatro','cinco','seis','siete','ocho',
                    'nueve','diez','once','doce','trece','catorce','quince','dieciseis','diecisiete','dieciocho','diecinueve','veinte','veintiuno ','vientidos ','veintitrés ', 'veinticuatro','veinticinco',
                    'veintiséis','veintisiete','veintiocho','veintinueve');
                    return $valor[$numero - 1];
                    }

                function decenass($n) {
                    $decenas = array (30=>'treinta',40=>'cuarenta',50=>'cincuenta',60=>'sesenta',
                    70=>'setenta',80=>'ochenta',90=>'noventa');
                    if( $n <= 29) return basico($n);
                    $x = $n % 10;
                    if ( $x == 0 ) {
                    return $decenas[$n];
                    } else return $decenas[$n - $x].' y '. basico($x);
                    
                    }

                    $Moneda_CAMBIOBS = sc_currency_all();
                    foreach($Moneda_CAMBIOBS as $cambio){
                        if($cambio->name == "Bolivares"){
                           $nombreBS =  decenass($cambio->exchange_rate);
                           $cod_bolibares =  $cambio->exchange_rate;
                        }
                    }

                $borrado_html = [];
                if($abono_inicial <= "0.00"){
                    $borrado_html = Sc_plantilla_convenio::where('id' , 1)->first()->where('name','sin_inicial')->get();
                    }else{
                        $borrado_html = Sc_plantilla_convenio::where('id' , 2)->first()->where('name','con_inicial')->get();
                    }


                $pieces = explode(" ", $dato_usuario['cedula']);
                if ($dato_usuario[0]['id_modalidad_pago']== 3) {
                    $mesualQuinsena = "MENSUAL";
                    $cod_diaMes = "LOS DIAS " . $dato_usuario[0]['cuotas'] . " DE CADA MES";
                }else {
                    $mesualQuinsena = " QUINCENAL";
                    $cod_diaMes = "LOS DIAS " . $dato_usuario[0]['cuotas'] . " Y 30 DE CADA MES";
                } 
                if ($pieces[0] == "V" ) $Nacionalidad = "VENEZOLANO(A)";
                    else $Nacionalidad = "Extranjer(A)"; 

               

                
                $monto = $dato_usuario[0]['subtotal'];
                $number1 =  $dato_usuario[0]['subtotal']/$dato_usuario[0]['cuotas'];
                $cuotas = $dato_usuario[0]['cuotas'];
                if($dato_usuario[0]['abono_inicial']>0){
                    $totalinicial=($dato_usuario[0]['abono_inicial']*$dato_usuario[0]['subtotal'])/100;
                    $monto = $dato_usuario[0]['subtotal'];
                    $monto = $monto - $totalinicial;
                    $number1 =  $monto/$dato_usuario[0]['cuotas'];
                    $cuotas = $number1;
                    $number2 =  $monto*$cod_bolibares;
                   
                  }

                  
                  $number2 =  $monto*$cod_bolibares;
                    

                foreach($borrado_html as $replacee){
                    $dataFind = [
                        "cod_first_name",
                        'cod_last_name',
                        'address1',
                        'cod_estado',
                        'cod_municipio',
                        'cod_parroquia',
                        'cod_Cedula',
                        'cod_civil',
                        'cod_Nacionalidad',
                        'cod_modalidad_pago',
                        'cod_dia',
                        'Cuotas1',
                        'Cod_CuotasEtreprecioTptal',
                        'Cod_CuotasEtrepreciotext',
                        'cod_mespago',
                        'cod_fechaEntrega',
                        'cod_subtotal',
                        'cod_nombreBS',
                        'cod_bolibares',
                        'nombreProduct',
                        'cod_phone',
                        'cod_email',
                        'cod_doreccion',
                        'cod_Fecha_De_Hoy',
                    ];
                    $dataReplace = [
                        $dato_usuario['first_name'],
                        $dato_usuario['last_name'],
                        $dato_usuario['address1'],
                        $dato_usuario['cod_estado'],
                        $dato_usuario['cod_municipio'],
                        $dato_usuario['cod_parroquia'],
                        $dato_usuario['cedula'],
                        $dato_usuario['estado_civil'],
                        'cod_Nacionalidad'=> $Nacionalidad,
                        'cod_modalidad_pago' => $mesualQuinsena,
                        'cod_dia'=> convertir1($cuotas),
                        number_format($cuotas),
                        'Cod_CuotasEtreprecioTptal'=> number_format($number1),
                        'Cod_CuotasEtrepreciotext'=> convertir1($number1),
                        'cod_mespago' => $cod_diaMes ,
                        'cod_fechaEntrega' =>$convenio->fecha_maxima_entrega ?? "",
                        $monto ,
                        'cod_nombreBS'=> convertir2($number2),
                        'cod_bolibares'=> number_format($number2, 2 ,',', ' '),
                        $dato_usuario[0]['nombreProduct'] ,
                        $dato_usuario['phone'],
                        $dato_usuario['email'],
                        $dato_usuario['address1'],
                        'cod_Fecha_De_Hoy'=> date('d-m-y'),
                        
                    ];
            
                    $resultado = str_replace($dataFind, $dataReplace, $replacee->contenido);
                }
                
                

                return view($this->templatePathAdmin.'screen.borrador_pdf',
                ['borrado_html'=>$resultado],
                
            );

    }
}
