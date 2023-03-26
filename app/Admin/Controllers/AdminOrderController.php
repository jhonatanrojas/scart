<?php
namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;



use App\Http\Controllers\NumeroLetra;
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
use App\Models\SC_fecha_de_entregas;
use App\Models\Sc_plantilla_convenio;
use App\Models\Declaracion_jurada;
use App\Models\SC_shop_customer;
use App\Models\SC_shop_order_status;
use App\Models\shop_order_detail;
use App\Models\ShopOrder;
use App\Models\SC_admin_role;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

use App\Models\Catalogo\MetodoPago;


use SCart\Core\Front\Models\ShopLanguage;
use App\Models\SC_referencia_personal;
use SCart\Core\Admin\Models\AdminUser;
use App\Models\AdminRole;
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
    public $languages;

    public function __construct()
    {
        parent::__construct();
        $this->statusOrder    = ShopOrderStatus::getIdAll();
        $this->currency       = ShopCurrency::getListActive();
        $this->country        = ShopCountry::getCodeAll();
        $this->statusPayment  = ShopPaymentStatus::getIdAll();
        $this->statusShipping = ShopShippingStatus::getIdAll();
        $this->languages = ShopLanguage::getListActive();
    }



 

    /**
     * Index interface.w
     *
     * @return Content
     */
    public function index($perfil=false)
    {



          $arr_pach= explode('/',request()->path());
          $perfil =$arr_pach[2] ?? false;

          
        
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
            'Acción'          => 'Acción',
            'Nombre&Apellido'          => 'Nombre&Apellido',
            'N°'          => 'Solicitud°',
            'N°Convenio'          => 'N°Convenio',
            'Vendedor Asignado' => 'Vendedor Asignado',
            'Articulo'          => 'Articulo',
            'Cuotas' => 'Cuotas',
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
            'perfil'=> $perfil,
        ];

        $id_usuario_rol = Admin::user()->id;
        $dminUser = new AdminUser;
         $user_roles = $dminUser::where('sc_admin_user.id' ,$id_usuario_rol)->orderBy('id')
         ->join('sc_admin_role_user', 'sc_admin_user.id', '=', 'sc_admin_role_user.user_id')
         ->join('sc_admin_role', 'sc_admin_role.id', '=', 'sc_admin_role_user.role_id')
         ->select('sc_admin_user.*', 'sc_admin_user.id','sc_admin_role.name as rol','role_id' )->first();
         $role = AdminRole::find($user_roles->role_id);
         
         $id_status= $role ? $role->status->pluck('id')->toArray() :[];
         $this->statusOrder   = ShopOrderStatus::whereIn('id',$id_status)->pluck('name', 'id')
         ->all();
        $dataTmp = (new AdminOrder)->getOrderListAdmin($dataSearch, $id_status);


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

           
            $Articulo = shop_order_detail::where('order_id', $row->id)->first();

            $convenio = Convenio::where('order_id',$row->id)->first();

           
            $user_roles = AdminUser::where('id' ,$row->vendedor_id)->first();

            


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
            $btn_pagos='';
            $btn_pagos='';

            $btn_reportar_pago="";

            if($row->modalidad_de_compra==0){
                $btn_reportar_pago='  <a href="' . sc_route_admin('historial_pagos.reportar', ['id' => $row['id'] ? $row['id'] : 'not-found-id']) . '"><span title="Reportar pago" type="button" class="btn btn-flat btn-sm btn-info"><i class=" fa fa-credit-card "></i></span></a>&nbsp;';
            }
            $dataMap = [
             
                'Acción' =>  '
                <a href="' . sc_route_admin('admin_order.detail', ['id' => $row['id'] ? $row['id'] : 'not-found-id']) . '"><span title="' . sc_language_render('action.edit') . '" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;
                '.$btn_pagos. $btn_reportar_pago.'
                <span onclick="deleteItem(\'' . $row['id'] . '\');"  title="' . sc_language_render('action.delete') . '" class="btn btn-flat btn-sm btn-danger"><i class="fas fa-trash-alt"></i></span >
                ',
                'Nombre&Apellido'          => $row['first_name'] . " ".$row['last_name'] ?? 'N/A',
                'N°'          =>  substr($row['id'], 0, -5)  ?? 'N/A',
                'N°Convenio' => $convenio->nro_convenio ?? 'N/A',
                 'Vendedor Asignado:'=> $user_roles->name ?? 'N/A',
                'Articulo' => $Articulo->name ?? 'N/A',
                'Cuotas' => $Articulo->nro_coutas ?? 'N/A',
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

            if($dataMap['pagos']>0)
            $btn_pagos=' <a href="' . sc_route_admin('historial_pagos.detalle', ['id' => $row['id'] ? $row['id'] : 'not-found-id']) . '"><span title="Historial de pagos" type="button" class="btn btn-flat btn-sm btn-info"><i class=" fa fa-university "></i></span></a>&nbsp;';
          
            $dataTr[$row['id']] = $dataMap;
        }

        

        $data['dataSearchs'] = $dataSearch;
        $data['page'] =  request()->all()['page'] ?? '';

       


        

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

        $ruta_busqueda= sc_route_admin('admin_order.index');

        if( $perfil){
            $ruta_busqueda=  sc_route_admin('admin_order.index')."/$perfil";

           
        }
        $data['topMenuRight'][] = '
                <form action="' .  $ruta_busqueda . '" id="button_search">
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
            'customer_id' => 'required',
            'fecha_de_pedido' => 'required'
            
    
        ];
        if (sc_config_admin('customer_lastname')) {
            $validate['last_name'] = 'required|max:100';
        }

        if (sc_config_admin('customer_lastname')) {
            $validate['fecha_de_pedido'] = 'required|max:100';
        }

      
       
        if (sc_config_admin('customer_phone')) {
            $validate['phone'] = config('validation.customer.phone_required', 'required|regex:/^0[^0][0-9\-]{6,12}$/');
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
            'comment'         => $data['comment']  ?? '',
            'usuario_id'         =>  Admin::user()->id,
            'created_at'         =>  $data['fecha_de_pedido']
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
        $dminUser = new AdminUser;
        $list_usuarios=  $dminUser->pluck('name', 'id')->all();
        $ademin = SC_admin_role::pluck('id' , 'name')->all();
        $id_usuario_rol = Admin::user()->id;
    

       
        $user_roles = $dminUser::where('sc_admin_user.id' ,$id_usuario_rol)->orderBy('id')
        ->join('sc_admin_role_user', 'sc_admin_user.id', '=', 'sc_admin_role_user.user_id')
        ->join('sc_admin_role', 'sc_admin_role.id', '=', 'sc_admin_role_user.role_id')
        ->select('sc_admin_user.*', 'sc_admin_user.id','sc_admin_role.name as rol','role_id' )->first();
        $role = AdminRole::find($user_roles->role_id);
        
       $id_status= $role ? $role->status->pluck('id')->toArray() :[];
       $this->statusOrder   = ShopOrderStatus::whereIn('id',$id_status)
       ->orderBy('orden')
       ->pluck('name', 'id')
      
       ->all();

    /*    if($user_roles->rol == 'Vendedor'){
             $id_status=[1,2,3,4,11];
             $estatus=  $this->statusOrder  = ShopOrderStatus::whereIn('id',$id_status)->pluck('name', 'id')->all();

        }
        else if($user_roles->rol == 'Riesgo'){
             $id_status=[5,6,7,8,9,4,3,21];
             $estatus=  $this->statusOrder   = ShopOrderStatus::whereIn('id',$id_status)->pluck('name', 'id')->all();
            }
        else if($user_roles->rol == 'Administrator'){
            $id_status=[8,9,10,12,13,16,17,19,22];
            $estatus=  $this->statusOrder   = ShopOrderStatus::whereIn('id',$id_status)->pluck('name', 'id')->all();

            }
            else {

                $estatus=  $this->statusOrder   = ShopOrderStatus::pluck('name', 'id')->all();
    
                }*/


            $styleStatus = $this->statusOrder;



        
        $clasificacion =  SC_shop_customer::where('id' , $order->customer_id)->get();

        if(!empty($clasificacion)){
            $Clasificacion =  $clasificacion[0]['nivel'];
        }


        if (!$order) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }

        $convenio = Convenio::where('order_id',$id)->first();

        $nro_convenio = str_pad(Convenio::count()+1, 6, "0", STR_PAD_LEFT);
       
        

        if($convenio){
            $nro_convenio = $convenio->nro_convenio;
        }
        $historialPagos =  HistorialPago::Where('order_id',$id)
        ->orderBy('fecha_venciento')->get();

        $pagadoCount =  HistorialPago::Where('order_id',$id)
        ->Where('payment_status' , 5)->count();

        
        $modalidad_pago =  ModalidadPago::pluck('name', 'id')->all();
        $documento = SC__documento::where('id_usuario', $order->customer_id)->get();
        
        $ducumentocliente=[];
        foreach ($documento as $verdument){
            
            $ducumentocliente = [
                "id" => $verdument->id,
                "first_name" => $verdument->first_name,
                "id_usuario" => $verdument->id_usuario
            ];


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
                'metodos_pagos' => MetodoPago::all() ,
                'pagadoCount'=> $pagadoCount ?? 0,
                'icon' => 'fa fa-file-text-o',
                'nro_convenio' =>$nro_convenio,
                'estatus_user' => $user_roles->rol,
                'list_usuarios' => $list_usuarios,
                'convenio'=>$convenio,
                'documento'=>$ducumentocliente,
                'clasificacion' => $Clasificacion ?? '',
                "order" => $order,
                'historial_pagos'=>$historialPagos,
                "modalidad_pago" =>  $modalidad_pago,
                "products" => $products,
                "statusOrder" => $styleStatus ,
                "statusOrdert" => $this->statusOrder ?? '',
                "statu_en"=> ShopOrderStatus::pluck('name', 'id')->all(),
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
        return response()->json([
            'orden' => AdminOrder::getOrderAdminCustomer($id),
            'cliente' => AdminCustomer:: getCustomerAdmin($id),
        ]);


      
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

        $estatus = SC_shop_order_status::where('id' , $value)->get();

        $Email = [];
        foreach($estatus as $estatu){
            $Email =[
                'first_name' =>$ordert->first_name ?? '',
                'last_name' =>$ordert->last_name ?? '',
                'email' => $ordert->email ?? '',
                'estatus' => $estatu['name'] ?? '',
                'estatus_mensaje' => $estatu['mensaje'] ?? '',
                'numero_del_pedido' => $ordert->id ?? '',
               
                
            ];

        }



      

        if(!empty($Email)){
        //    estatus_del_pedido($Email);
            
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

        
        if($code=='vendedor_id'){
            $userad = new AdminUser;
            if($oldValue !=''){
           $getuser=     $userad->where('id',$oldValue)->first();
           if($getuser)
           $oldValue= $getuser->name;
            }
            if($value !=''){
                $getuser=     $userad->where('id',$value)->first();
                if($getuser)
                $value= $getuser->name;
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
        $add_serial_product = request('add_serial');
        $add_inicial = request('add_inicial');
        $serial = request('add_serial');

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
                    'serial' => $serial[0] ?? 'serial del articulo',
                    
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

            $convenio=Convenio::where('order_id',$id)->first();
            if ($convenio) {
                return response()->json(['error' => 1, 'msg' => 'No se puede eliminar esta solicitud por que ya tiene un convenio asociado', 'detail' => '']);
            }
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


    public function ficha_pedido()
    {
        $orderId = request('order_id') ?? null;
        $action = request('action') ?? '';
        $order = AdminOrder::getOrderAdmin($orderId);
        $convenio=Convenio::where('order_id',$orderId)->first();
        $constacia_trabajo='';
        $rif='';
        $cedula='';



        

        
        
        if(empty($convenio)){
            
            return redirect()->back()
                ->with(['error' => ' Convenio aun no se ah creado']);
            
        }

        $nro_convenio = $convenio->nro_convenio;

        if ($order) {
            $documento = SC__documento::where('id_usuario', $order->customer_id)->first();
            $referencias = SC_referencia_personal::where('id_usuario',$order->customer_id)->get();
            if($documento){
                $constacia_trabajo= $documento->carta_trabajo ;
                $rif= $documento->rif ;
                $cedula= $documento->cedula ;
            }
            $data                    = array();
            $data['name']            = $order['first_name'] . ' ' . $order['last_name'];
            $data['address']         = $order['address1'] . ', ' . $order['address2'] . ', ' . $order['address3'].', '.$order['country'];
            $data['phone']           = $order['phone'];
            $data['email']           = $order['email'];
            $data['referencias']           = $referencias;
            $data['nro_coutas'] =   count($order->details) ? $order->details[0]->nro_coutas : 0;
            $data['nro_convenio'] =  $nro_convenio;
            $data['constacia_trabajo'] =  $constacia_trabajo;
            $data['rif'] =  $rif;
            $data['cedula'] =  $cedula;

            $data['order'] =  $order;
      
            $data['cedula']           = $order['cedula'];
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
                        'nro_coutas' => $detail->nro_coutas, 
                        'total_price' => $convenio->total,
                    ];
                }
            }

            if ($action =='invoice_excel') {
                $options = ['filename' => 'Order ' . $orderId];
                return \Export::export($action, $data, $options);
            }
            
            return view($this->templatePathAdmin.'format.ficha_pedido')
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
                $user = Admin::user();
                if ($user === null) {
                    return 'inicia secion';
                }

                $plantilla = Convenio::where('order_id', $id)->first();
                if (!$plantilla) {
                    return 'No se encontró la plantilla';
                }

                
                    $pdf = Pdf::loadView($this->templatePathAdmin.'screen.comvenio_pdf', 
                    ['borrado_html'=> $plantilla->convenio],
                    ['convenio'=> $plantilla['nro_convenio'] ],

                    );

                    return $pdf->stream();
            }

            public function downloadJuradada($id)
            {
                $user = Admin::user();
                if ($user === null) {
                    return 'inicia secion';
                }

                $plantilla = Convenio::where('order_id', $id)->first();


                if (!$plantilla) {
                    return 'No se encontró la plantilla';
                }
                    $pdf = Pdf::loadView($this->templatePathAdmin.'screen.declaracion_juradapdf', 
                    ['file_html'=> $plantilla->declaracion_jurada],
                    );

                    return $pdf->stream();
            }



    public static function fechaEs($fecha) {
                $fecha = substr($fecha, 0, 10);
                $numeroDia = date('d', strtotime($fecha));
                $dia = date('l', strtotime($fecha));
                $mes = date('F', strtotime($fecha));
                $anio = date('Y', strtotime($fecha));
                $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
                $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
                $nombredia = str_replace($dias_EN, $dias_ES, $dia);
                $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
                return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
    }


    public function borrador_pdf($id){

        $user = Admin::user();
        if ($user === null) {
            return 'inicia secion';
        }
        $estado = Estado::all();
        $municipio = Municipio::all();
        $parroquia = Parroquia::all();
        $order = ShopOrder::where('id',$id)->get();
        $letraconvertir_nuber = new NumeroLetra;

        if (!$order) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }

        $convenio = Convenio::where('order_id',$id)->first();
        
        $usuario =  SC_shop_customer::where('email', $order[0]['email'])->get();
        $result = $usuario->all();
        $productoDetail = shop_order_detail::where('order_id' , $id)->get();
        $cantidaProduc = shop_order_detail::where('order_id',$id)->count();
        $nombreProduct = [];
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
                'address2' => $c['address2'],
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

            

                    $Moneda_CAMBIOBS = sc_currency_all();
                    foreach($Moneda_CAMBIOBS as $cambio){
                        if($cambio->name == "Bolivares"){
                           $cod_bolibares =  $cambio->exchange_rate;
                        }
                    }

                $borrado_html = [];
                switch ($dato_usuario['natural_jurídica']) {
                    case 'N':
                        $borrado_html = $abono_inicial > 0
                            ? Sc_plantilla_convenio::where('id', 2)->first()->where('name', 'con_inicial')->get()
                            : Sc_plantilla_convenio::where('id', 1)->first()->where('name', 'sin_inicial')->get();
                        break;
                    case 'J':
                        $borrado_html = Sc_plantilla_convenio::where('id', 3)->first()->where('name', 'persona_juridica')->get();
                        break;
                }


                $pieces = explode(" ", $dato_usuario['cedula']);
                if ($dato_usuario[0]['id_modalidad_pago']== 3) {
                    $mesualQuinsena = "MENSUAL";
                    $cod_diaMes = "LOS DIAS " . $dato_usuario[0]['cuotas'] . " DE CADA MES";
                }else {
                    $suma = $dato_usuario[0]['cuotas'] + $dato_usuario[0]['cuotas'];
                    $mesualQuinsena = " QUINCENAL";
                    $cod_diaMes = "LOS DIAS " . $dato_usuario[0]['cuotas'] . " Y " .$suma ." DE CADA MES";
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
                        $cuotas_entre_monto =  $dato_usuario[0]['subtotal']/$cuotas;
                        $number2 =  $monto*$cod_bolibares;
                       
                      }
    

                  
                  $number2 =  $monto*$cod_bolibares;
                    

                  foreach($borrado_html as $replacee){
                    $dataFind = [
                        '/\{\{\$numero_de_convenio\}\}/',
                        '/\{\{\$razon_social\}\}/',
                        '/\{\{\$rif\}\}/',
                        '/\{\{\$nombre\}\}/',
                        '/\{\{\$apellido\}\}/',
                        '/\{\{\$direccion\}\}/',
                        '/\{\{\$direccion2\}\}/',
                        '/\{\{\$estado\}\}/',
                        '/\{\{\$municipio\}\}/',
                        '/\{\{\$parroquia\}\}/',
                        '/\{\{\$cedula\}\}/',
                        '/\{\{\$estado_civil\}\}/',
                        '/\{\{\$nacionalidad\}\}/',
                        '/\{\{\$modalidad_de_pago\}\}/',
                        '/\{\{\$dia_modalida_pago\}\}/',
                        '/\{\{\$cuotas\}\}/',
                        '/\{\{\$cuotas_total\}\}/',
                        '/\{\{\$cuotas_entre_precio_text\}\}/',
                        '/\{\{\$cod_mespago\}\}/',
                        '/\{\{\$fecha_entrega\}\}/',
                        '/\{\{\$subtotal\}\}/',
                        '/\{\{\$bolivar_text\}\}/',
                        '/\{\{\$bolibares_number\}\}/',
                        '/\{\{\$nombre_de_producto\}\}/',
                        '/\{\{\$telefono\}\}/',
                        '/\{\{\$email\}\}/',
                        '/\{\{\$fecha_de_hoy\}\}/',
                        '/\{\{\$logo_waika\}\}/',
                        '/\{\{\$logo_global\}\}/',
                        
                    ];

         
                  
                    

                    $dataReplace = [
                        'numero_de_convenio'=>  "sin convenio",
                        'razon_social' => $dato_usuario['razon_social'],
                        'rif' => $dato_usuario['rif'],
                        'nombre' => $dato_usuario['first_name'],
                        'apellido' =>$dato_usuario['last_name'],
                        'direccion' => $dato_usuario['address1'],
                        'direccion2' => $dato_usuario['address2'] ?? 'no aplica',
                        'estado'=> $dato_usuario['cod_estado'],
                        'municipio'=>$dato_usuario['cod_municipio'],
                        'parroquia'=>$dato_usuario['cod_parroquia'],
                        'cedula'=>$dato_usuario['cedula'],
                        'estado_civil'=>$dato_usuario['estado_civil'],
                        'nacionalidad'=>$Nacionalidad,
                        $mesualQuinsena,
                        $letraconvertir_nuber->convertir1($cuotas),
                        number_format($cuotas),
                        number_format($number1, 2 ,',', ' '),
                         $letraconvertir_nuber->convertir2($number1),
                        $cod_diaMes ,
                        'fecha_entrega'=>request()->fecha_maxima_entrega ?? 'no aplica',
                         $monto ,
                         $letraconvertir_nuber->convertir2($number2),
                         number_format($number2, 2 ,',', ' '),
                        $dato_usuario[0]['nombreProduct'] ,
                        $dato_usuario['phone'],
                        $dato_usuario['email'],
                        $this->fechaEs(date('d-m-y')),
                        sc_file(sc_store('logo', ($storeId ?? null))),
                        sc_file(sc_store('logo', ($storeId ?? null))) ,
                        'logo_waika' =>sc_file(sc_store('logo', ($storeId ?? null))),
                        'logo_global' =>sc_file(sc_store('logo', ($storeId ?? null))),

                    ];


                    $content = preg_replace($dataFind, $dataReplace, $replacee->contenido);
                    $dataView = [
                        'content' => $content,
                    ];

                    



                }



            $pdf = Pdf::loadView($this->templatePathAdmin.'screen.comvenio_pdf', 
                    ['borrado_html'=> $dataView['content']]

                    );

                    return $pdf->stream();

    }

    public function edit_convenio(){
       
        $user = Admin::user();
        if ($user === null) {
            return 'inicia secion';
        }
        $convenio_cliente = true;

    
        $borrado_html = Sc_plantilla_convenio::where('id' , 1)->first()->get();

        $data = [
            'title'             => "Editar plantilla ",
            'convenio_cliente' => $convenio_cliente,
            'subTitle'          => '',
            'borrado_html'          =>$borrado_html,
            'title_description' => sc_language_render('admin.news.add_new_des'),
            'icon'              => 'fa fa-plus',

        ];

        return view($this->templatePathAdmin.'screen.edit_convenio')
            ->with($data);

    }

    public function editar_convenio($id){

        $borrado_html = Sc_plantilla_convenio::where('id' , $id)->get();
        $convenio_cliente = true;
       

        

        $news = [];
        $data = [
            'title'             => "Editar plantilla ",
            'id_convenio'          => $id,
            'convenio_cliente' => $convenio_cliente,
            'borrado_html'          =>$borrado_html,
            'title_description' => sc_language_render('admin.news.add_new_des'),
            'icon'              => 'fa fa-plus',
            'languages'         => $this->languages,
            'news'              => $news,
            'url_action'        => sc_route_admin('admin_news.create'),
        ];


        return view($this->templatePathAdmin.'screen.editar_convenio')
            ->with($data);
    }

    public function editar_convenio_cliente($id){

        $borrado_html =  Convenio::where('order_id',$id)->first();
        // dd($borrado_html->convenio);
        $convenio_cliente = false;

        $order = ShopOrder::where('id',$id)->get();

        

       

       



        $news = [];
        $data = [
            'title'             => "convenio del cliente ",
            'convenio_cliente' => $convenio_cliente,
            'order' => $order[0]['id'],
            'id_convenio'          => $id,
            'borrado_html'          =>$borrado_html,
            'title_description' => sc_language_render('admin.news.add_new_des'),
            'icon'              => 'fa fa-plus',
            'languages'         => $this->languages,
            'news'              => $news,
            'url_action'        => sc_route_admin('admin_news.create'),
        ];


        return view($this->templatePathAdmin.'screen.editar_convenio')
            ->with($data);
    }



    public function postCreate_convenio($id)
    {
        $data = request()->all();

        $dataDes = [];
        $languages = $this->languages;
        foreach ($languages as $code => $value) {
           
       
            $dataDes[] = [
                'description' => $data['descriptions'][$code]['content'],
                'content'     => $data['descriptions']['es']['content'],
            ];
        }

            $dataDes = sc_clean($dataDes, ['content'], true);

       
            if($id == "1"){

                Sc_plantilla_convenio::where('id' ,1)->where('status', 1)->update(
                    ['contenido' => $data['descriptions'][$code]['content']
                ]);


            } else if($id == "2"){

                Sc_plantilla_convenio::where('id' , 2)->where('code', 1)->update(['contenido' => $data['descriptions'][$code]['content']]);
            }else if($id == "3"){
                Sc_plantilla_convenio::where('id' , 3)->where('code', 1)->update(['contenido' => $data['descriptions'][$code]['content']]);
            }else{
                Convenio::where('order_id',$id)->update(['convenio' => $data['descriptions'][$code]['content']]);

                sc_clear_cache('cache_news');
                return redirect()->route('admin_order.detail', ['id' => $id ? $id : 'not-found-id'])->with('success', 'convenio editado con exito');
               
                

            }


        sc_clear_cache('cache_news');

        return redirect()->route('edit_convenio')->with('success', sc_language_render('action.create_success'));
    }

    public function fecha_entrega(){
        $data = [
            'title'         => 'Fecha de entrega',
            'subTitle'      => '',
            'icon'          => 'fa fa-indent',
            'urlDeleteItem' => sc_route_admin('admin_customer.delete'),
            'removeList'    => 1, // 1 - Enable function delete list item
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
            'fecha de entrega'      => 'fecha de entrega',
            'status'     => 'Status',
            'created_at' => sc_language_render('admin.created_at'),
            'action'     => sc_language_render('action.title'),
        ];
        $sort_order = sc_clean(request('sort_order') ?? 'id_desc');
        $keyword    = sc_clean(request('keyword') ?? '');
        $arrSort = [
            'id__desc' => sc_language_render('filter_sort.id_desc'),
            'id__asc' => sc_language_render('filter_sort.id_asc'),
            'first_name__desc' => sc_language_render('filter_sort.first_name_desc'),
            'first_name__asc' => sc_language_render('filter_sort.first_name_asc'),
            'last_name__desc' => sc_language_render('filter_sort.last_name_desc'),
            'last_name__asc' => sc_language_render('filter_sort.last_name_asc'),
        ];

        $dataSearch = [
            'keyword'    => $keyword,
            'sort_order' => $sort_order,
            'arrSort'    => $arrSort,
        ];
        $dataTmp = SC_fecha_de_entregas::get();

          
       
        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[$row['id']] = [
                'fecha_entrega' => Carbon::parse($row['fecha_entrega'])->toFormattedDateString(),
                'status' => $row['activo'] ? '<span class="badge badge-success">ON</span>' : '<span class="badge badge-danger">OFF</span>',
                'created_at' => $row['created_at'],
                'action' => '
                    <a onclick="edit_fecha(\'' . $row['id'] . '\' , \'' . $row['activo'] . '\');"  href="#"><span title="' . sc_language_render('action.edit') . '" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                    
                    <span onclick="deleteItem(\'' . $row['id'] . '\');"  title="' . sc_language_render('action.delete') . '" class="btn btn-flat btn-sm btn-danger"><i class="fas fa-trash-alt"></i></span>'
                ,
            ];
        }

        $data['listTh'] = $listTh;

        
        $data['dataTr'] = $dataTr;

        //menuRight
        $data['menuRight'][] = '<a  href="#" class="btn  btn-success  btn-flat" title="New" id="button_create_new" data-bs-toggle="modal" data-bs-target="#exampleModal">
                           <i class="fa fa-plus" title="'.sc_language_render('admin.add_new').'"></i>
                           </a>';
        //=menuRight

        //menuSort
        $optionSort = '';
        $data['urlSort'] = sc_route_admin('admin_customer.index', request()->except(['_token', '_pjax', 'sort_order']));
        $data['optionSort'] = $optionSort;
        //=menuSort

        //menuSearch
        $data['topMenuRight'][] = '
                <form action="' . sc_route_admin('admin_customer.index') . '" id="button_search">
                <div class="input-group input-group" style="width: 350px;">
                    <input type="text" name="keyword" class="form-control rounded-0 float-right" placeholder="' . sc_language_render('search.placeholder') . '" value="' . $keyword . '">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                </form>';
        //=menuSearch

      

        return view($this->templatePathAdmin.'screen.fecha_entrega')->with($data);

    }

    public function fecha_create(){
        $user = Admin::user();
        if ($user === null) {
            return 'inicia secion';
        }
        $data = request()->all();
          if($data['modalidad'] == 0){

            $fecha = (new SC_fecha_de_entregas);
            $fecha-> fecha_entrega = $data['fecha_entrega'];
            $fecha->activo = $data['stado'] ?? 0;

        if($fecha->save()) return redirect()->route('fecha_entrega')->with('success', sc_language_render('action.create_success'));
            else return redirect()->route('fecha_entrega')->with('error', 'error al crear la fecha de entrega');

        }else{
            SC_fecha_de_entregas::where('id', $data['id_fecha'])
                ->update(
                    [
                        'activo' =>$data['stado'] ?? 0,
                        'fecha_entrega' =>$data['fecha_entrega']
                    ],

                );

                return redirect()->route('fecha_entrega')->with('success', sc_language_render('action.create_success'));
                

        }

    }

    public function fecha_edit($id){
        $user = Admin::user();
        if ($user === null) {
            return 'inicia secion';
        }

        $editFechaEntrega = SC_fecha_de_entregas::where('id' ,$id)->get();
        return response()->json(['success' => $editFechaEntrega, 'msg' => sc_language_render('action.update_success')]);

    }

    public function fecha_delete($id){
        $user = Admin::user();
        if ($user === null) {
            return 'inicia secion';
        }

        SC_fecha_de_entregas::where('id' ,$id)->delete();
        return response()->json(['success' => 'eliminado', 'msg' => sc_language_render('action.update_success')]);

    }

      public function reporte_de_pedido(){

        $user = Admin::user();
        if ($user === null) {
            return 'inicia secion';
        }
        return view($this->templatePathAdmin.'screen.reporte_de_pedido');
       
    }

    public function declaracion_jurada(){
        $request = request()->all();
        

        if(!empty($request)){
            $dataDes = [];
        $languages = $this->languages;
        foreach ($languages as $code => $value) {
           
       
            $dataDes[] = [
                'description' => $request['descriptions'][$code]['content'],
                'content'     => $request['descriptions']['es']['content'],
            ];
        }

            $dataDes = sc_clean($dataDes, ['content'], true);

            if($request['save'] == 'save_plantilla'){
                Declaracion_jurada::where('id', 1)
                ->update(
                    [
                        'status' => 1 ?? 0,
                        'file_html' =>$request['descriptions'][$code]['content']
                    ],

                );

            }
        }

        $file_html = Declaracion_jurada::all();




        $news = [];
        $data = [
            'title'             => "Declaración Jurada ",
            'file_html'             => $file_html,
            'title_description' => sc_language_render('admin.news.add_new_des'),
            'icon'              => 'fa fa-plus',
            'languages'         => $this->languages,
            'news'              => $news,
            'url_action'        => sc_route_admin('admin_news.create'),
        ];


        return view($this->templatePathAdmin.'screen.declaracion_jurada')
            ->with($data);
    }




    public function exporte($perfil=false){
        $arr_pach= explode('/',request()->path());
        $perfil =$arr_pach[2] ?? false;
        $estado = Estado::all();
        $municipio = Municipio::all();
        $parroquia = Parroquia::all();
        $search = request()->all();

      
        $dataSearch = [
            'keyword'      =>  $search['keyword'] ?? '',
            'email'        => $search['email'] ?? '',
            'Cedula'        => $search['Cedula'] ?? '',
            'Telefono'        => $search['Telefono'] ?? '',
            'Estado'        => $search['Estado'] ?? '',
            'from_to'      => $search['from_to'] ?? '',
            'end_to'       => $search['end_to'] ?? '',
            'order_status' => $search['order_status'] ?? '',
            'perfil'=>$search['perfil'] ?? '',
        ];


            $data_array=[];
            $data_array [] = array(
            "Nombre&Apellido",
            "Solicitud",
            "N°Convenio",
            "Vendedor Asignado",
            "Articulo",
            "Cuotas",
            "Cedula",
            "Telefono",
            "Estado",
            "Municipio",
            "Parroquia",
            "Total",
            "Estatus",
            "Modalidad",
            "Creado en",
            );




      


        $id_usuario_rol = Admin::user()->id;
        $dminUser = new AdminUser;
         $user_roles = $dminUser::where('sc_admin_user.id' ,$id_usuario_rol)->orderBy('id')
         ->join('sc_admin_role_user', 'sc_admin_user.id', '=', 'sc_admin_role_user.user_id')
         ->join('sc_admin_role', 'sc_admin_role.id', '=', 'sc_admin_role_user.role_id')
         ->select('sc_admin_user.*', 'sc_admin_user.id','sc_admin_role.name as rol','role_id' )->first();
         $role = AdminRole::find($user_roles->role_id);
         
         $id_status= $role ? $role->status->pluck('id')->toArray() :[];
         $this->statusOrder   = ShopOrderStatus::whereIn('id',$id_status)->pluck('name', 'id')
         ->all();


         
        $dataTmp = (new AdminOrder)->excel_export($dataSearch, $id_status);
        if (sc_check_multi_shop_installed() && session('adminStoreId') == SC_ID_ROOT) {
            $arrId = $dataTmp->pluck('id')->toArray();
            // Only show store info if store is root
            if (function_exists('sc_get_list_store_of_order')) {
                $dataStores = sc_get_list_store_of_order($arrId);
            } else {
                $dataStores = [];

            }
        }




            foreach ($dataTmp as $key => $row) {
        
            $Articulo = shop_order_detail::where('order_id', $row->id)->first();

            $convenio = Convenio::where('order_id',$row->id)->first();

           
            $user_roles = AdminUser::where('id' ,$row->vendedor_id)->first();

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

            
      
                $data_array[] = array(
                'Nombre&Apellido' => $row->first_name . $row->last_name,
                'Solicitud' => $row->id,
                'N°Convenio' => $convenio->nro_convenio ?? 'N/A',
                'Vendedor Asignado' => $user_roles->name ?? 'N/A',
                'Articulo' =>$Articulo->name ?? 'N/A',
                'Cuotas' =>$Articulo->nro_coutas ?? '0',
                'Cedula' => $row->cedula,
                'Telefono' => $row->phone,
                'Estado' => $nombreEstado ?? 'N/A',
                'Municipio' => $nombremunicipos ?? 'N/A',
                'Parroquia' =>$nombreparroquias ?? 'N/A',
                'Total' =>sc_currency_render_symbol($row['total'] ?? 0, 'USD'),
                'Estatus' => $styleStatus[$row['status']] ?? $row['status'],
                'Modalidad' => $AlContado ?? 'N/A',
                'Creado en' => $row->created_at,
                
            );

            

        }

        

            ini_set('max_execution_time', 0);
            ini_set('memory_limit', '4000M');

            try {
                $Excel_writer = null;
                $chunk_size = 1000;
                $offset = 0;

                do {
                    $chunk_data = array_slice($data_array, $offset, $chunk_size);
                    $offset += $chunk_size;

                    if (!empty($chunk_data)) {
                        $spreadSheet = new Spreadsheet();
                        $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
                        $spreadSheet->getActiveSheet()->fromArray($chunk_data);
                        
                        if (!$Excel_writer) {
                            $Excel_writer = new Xls($spreadSheet);
                            header('Content-Type: application/vnd.ms-excel');
                            header('Content-Disposition: attachment;filename="Customer_ExportedData.xls"');
                            header('Cache-Control: max-age=0');
                            ob_end_clean();
                        } else {
                            $Excel_writer->addSheet($spreadSheet);
                        }
                    }
                } while (!empty($chunk_data));

                $Excel_writer->save('php://output');
                

                
            } catch (Exception $e) {
                return;
            }


            //return redirect()->sc_route_admin('admin_order.index');
        }



    



}
