<?php
namespace App\Admin\Controllers;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
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
use SCart\Core\Admin\Models\AdminProduct;
use SCart\Core\Front\Models\ShopOrderTotal;
use App\Models\ModalidadPago;
use App\Models\HistorialPago;
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
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


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
        
        $ruta_exel = route('descargar.excel');
        $listTh = [
            'Acción'          => 'Acción',
            'Nombre&Apellido'          => 'Nombre&Apellido',
            'N°'          => 'Solicitud°',
            'N°Convenio'          => 'N°Convenio',
            'status'         =>"Estatus",
            'Vendedor Asignado' => 'Vendedor Asignado',
            'Articulo'          => 'Articulo',
            'Cuotas' => 'Cuotas',
            'Cedula'          => 'Cedula',
            'Telefono'          => 'Telefono',
            'Correo'          => 'correo',
            'Estado'          => 'Estado',
            'Municipio'          => 'Municipio',
            'Parroquia'          => 'Parroquia',
            'total'          => '<i class="fas fa-coins" aria-hidden="true" title="'.sc_language_render('order.total').'"></i>',
            
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

        $data['menuLeft'][] = '<a class="btn btn-flat btn-success  btn-sm" href="' . $ruta_exel . '?from_to='.$from_to.'&end_to='.$from_to.'&from_to='.$from_to.'&email='.$email.'&order_status='.$order_status.'"><i class="fa fa-download"></i>Export Ecxel </a>';

   
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
    
         $dataSearch2 = [
            'keyword'      => $keyword,
            'email'        => $email,
            'Cedula'        => $email,
            'Telefono'        => $email,
            'Estado'        => $email,
            'from_to'      => $from_to,
            'end_to'       => $end_to,
            'sort_order'   => $sort_order,
            'order_status' => $order_status,
            'perfil'=> $perfil,
        ];

        $id_usuario_rol = Admin::user()->id;
        $dminUser = new AdminUser;
         $user_roles = $dminUser::where('sc_admin_user.id' ,$id_usuario_rol)->orderBy('id')
         ->join('sc_admin_role_user', 'sc_admin_user.id', '=', 'sc_admin_role_user.user_id')
         ->join('sc_admin_role', 'sc_admin_role.id', '=', 'sc_admin_role_user.role_id')
         ->select('sc_admin_user.id', 'sc_admin_user.id','sc_admin_role.name as rol','role_id' )->first();
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

            


            if($row->modalidad_de_compra == 0){
                $AlContado = "Al contado";
            }else if($row->modalidad_de_compra ==2){
                $AlContado = "Financiamiento/Entrega Inmediata" ;
            }else if($row->modalidad_de_compra ==1){
                $AlContado = "Financiamiento" ;
            }else{

                $AlContado = "Propuesta" ;

            }
            
                 
            $datos_cliente =  SC_shop_customer::where('sc_shop_customer.id',$row->customer_id)
            ->leftJoin('estado', 'estado.codigoestado', '=', 'sc_shop_customer.cod_estado')
            ->leftJoin('municipio', 'municipio.codigomunicipio', '=', 'sc_shop_customer.cod_municipio')
            ->leftJoin('parroquia', 'parroquia.codigoparroquia', '=', 'sc_shop_customer.cod_parroquia')
            ->select('sc_shop_customer.phone', 'sc_shop_customer.cedula', 'sc_shop_customer.cedula','sc_shop_customer.cedula', 'estado.nombre as estado','municipio.nombre as municipio','sc_shop_customer.email' ,'parroquia.nombre as parroquia')->first();


         
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
                'status'         => $styleStatus[$row['status']] ?? $row['status'],
                 'Vendedor Asignado:'=> $user_roles->name ?? 'N/A',
                'Articulo' => $Articulo->name ?? 'N/A',
                'Cuotas' => $Articulo->nro_coutas ?? 'N/A',
                'Cedula'          => $datos_cliente->cedula ?? 'N/A',
                'Telefono'          => $datos_cliente->phone ?? 'N/A',
                'Correo'          => $datos_cliente->email ?? 'N/A',
                'Estado'          =>$datos_cliente->estado ?? 'N/A',
                'Municipio'          =>$datos_cliente->municipio ?? 'N/A',
                'Parroquia'          =>$datos_cliente->parroquia ?? 'N/A',
                'total'          => sc_currency_render_symbol($row['total'] ?? 0, 'USD'),
                
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
        $inpuExcel = '' ;
    
        foreach ($this->statusOrder as $key => $status) {
            $optionStatus .= '<option  ' . (($order_status == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }

        


                foreach ($dataSearch2 as $key => $value){
                    $inpuExcel .= '<input type="hidden" name="'.$key.'" value="'.$value.'">';}
                     
                           


       

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
                                <select id="order_status"  class="form-control rounded-0" name="order_status">
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
                </form>



                    <div class="m-auto" >
                    <div class=" ml-1" style="width: 150px;">
                        <form action="'.$ruta_exel.'?from_to='.$from_to.'&end_to='.$from_to.'&from_to='.$from_to.'&email='.$email.'&order_status='.$order_status.'" method="GET" accept-charset="UTF-8">

                         '.$inpuExcel.'
                      
                        </form>
                    
                    </div>
                </div>
                
                
                
                ';

                
        //=menuSearch
        $data['page'] =  request()->all()['page'] ?? '';


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
      
        $id_usuario_rol = Admin::user()->id;
        $statusPayment = ShopPaymentStatus::pluck( 'name','id' )->all();

       
        $user_roles = $dminUser::where('sc_admin_user.id' ,$id_usuario_rol)->orderBy('id')
        ->join('sc_admin_role_user', 'sc_admin_user.id', '=', 'sc_admin_role_user.user_id')
        ->join('sc_admin_role', 'sc_admin_role.id', '=', 'sc_admin_role_user.role_id')
        ->select('sc_admin_user.id', 'sc_admin_user.id','sc_admin_role.name as rol','role_id' )->first();
        $role = AdminRole::find($user_roles->role_id);
        
       $id_status= $role ? $role->status->pluck('id')->toArray() :[];
       $this->statusOrder   = ShopOrderStatus::whereIn('id',$id_status)->orderBy('orden')->pluck('name', 'id')->all();


            $styleStatus = $this->statusOrder;



        
        $clasificacion =  SC_shop_customer::where('id' , $order->customer_id)->first();

       
            $Clasificacion =  $clasificacion->nivel;
  


        if (!$order) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }

        $convenio = Convenio::where('order_id',$id)->first();

       

        $nro_convenio = str_pad(Convenio::count()+1, 6, "0", STR_PAD_LEFT);
        $styleStatusPayment = $statusPayment;
        array_walk($styleStatusPayment, function (&$v, $k) {
            $v = '<span class="badge badge-' . (AdminOrder::$mapStyleStatus[$k] ?? 'light') . '">' . $v . '</span>';
        });

        

        if($convenio){
            $nro_convenio = $convenio->nro_convenio;


           
        }
        $historialPagos =  HistorialPago::Where('order_id',$id)
        ->orderBy('fecha_venciento')->get();

        $product = AdminProduct::getProductAdmin($order->product_id);


        $pagadoCount =  count($historialPagos);

        
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

            $Titulo = sc_language_render('order.order_detail');
            if($order->modalidad_de_compra == 3){
                $Titulo = 'Lista de la propuesta';

            }


        return view($this->templatePathAdmin.'screen.order_edit')->with(
            [
                "title" => $Titulo,
                "subTitle" => '',
                "monto_Inicial" => $product->monto_inicial ?? '',
                'monto_entrega' => $product->monto_cuota_entrega ?? '',
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
                "statu_en"=> ShopOrderStatus::whereIn('id',$id_status)->pluck('name', 'id')->all(),
                "statusPayment" => $this->statusPayment,
                "statusShipping" => $this->statusShipping,
                'dataTotal' => AdminOrder::getOrderTotal($id),
                'attributesGroup' => ShopAttributeGroup::pluck('name', 'id')->all(),
                'paymentMethod' => $paymentMethod,
                'shippingMethod' => $shippingMethod,
                'fecha_primer_pago' => $fecha_primer_pago,
                'styleStatusPayment'=> $styleStatusPayment,
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
     */    public function getInfoProduct()
    {
        // Get product id and order id
        $id = request('id');
        $orderId = request('order_id');
        // Get order info
        $oder = AdminOrder::getOrderAdmin($orderId);
        // Get product info
        $product = AdminProduct::getProductAdmin($id);
        // Check product
        if (!$product) {
            Log::error('msg');
            return response()->json(['error' => 1, 'msg' => sc_language_render('admin.data_not_found_detail', ['msg' => '#product:'.$id]), 'detail' => '']);
        }
        // Return product info
        $arrayReturn = $product->toArray();
        // Get attribute to render
        $arrayReturn['renderAttDetails'] = $product->renderAttributeDetailsAdmin($oder->currency, $oder->exchange_rate);
        // Get final price
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


        if ($code == 'modalidad_de_compra') {
            $options = [
                'Financiamento' => 1,
                'Al contado' => 0,
                'Entraga inmediata' => 2,
                'Propuesta' => 3,
            ];
            $esTatus = $options[$value] ?? null;
            $value=$esTatus;
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
        $add_monto_cuota_entrega = request('add_monto_cuota_entrega');
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
                    'monto_cuota_entrega' => $add_monto_cuota_entrega[$key],
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
        $product = AdminProduct::getProductAdmin($order->product_id);
        

        $convenio=Convenio::where('order_id',$orderId)->first();

        $constacia_trabajo='';
        $rif='';
        $cedula='';



      

       
       
        $nro_convenio = 'A/N';

        if(!empty($convenio))$nro_convenio = $convenio->nro_convenio ;

            
        $doc_cedula="";
        if ($order) {
            $documento = SC__documento::where('id_usuario', $order->customer_id)->first();


            $user_roles = AdminUser::where('id' ,$order->vendedor_id)->first();

           


            $referencias = SC_referencia_personal::where('id_usuario',$order->customer_id)->get();
            $datos_cliente =  SC_shop_customer::where('sc_shop_customer.id',$order->customer_id)
            ->leftJoin('estado', 'estado.codigoestado', '=', 'sc_shop_customer.cod_estado')
            ->leftJoin('municipio', 'municipio.codigomunicipio', '=', 'sc_shop_customer.cod_municipio')
            ->leftJoin('parroquia', 'parroquia.codigoparroquia', '=', 'sc_shop_customer.cod_parroquia')
            ->select('sc_shop_customer.*', 'estado.nombre as estado','municipio.nombre as municipio','parroquia.nombre as parroquia ,postcode ' )->first();


          

  
            if($documento){
                $constacia_trabajo= $documento->carta_trabajo ;
                $rif= $documento->rif ;
                $doc_cedula= $documento->cedula;

            }
            $data                    = array();
            $data['name']            = $order['first_name'] . ' ' . $order['last_name'];
            $data['address']         = $order['address1'] . ', ' . $order['address2'] . ', ' . $order['address3'].', '.$order['country'];
            $data['phone']           = $order['phone'];
            $data['phone2']           = $datos_cliente->phone2 ?? '';
            $data['conocio']           = $datos_cliente->nos_conocio ?? '';

            $data['vendedor']           = $user_roles->name ?? '';
            $data['email']           = $order['email'];
            
 
            $data['referencias']           = $referencias;
            $data['nro_coutas'] =   count($order->details) ? $order->details[0]->nro_coutas : 0;
            $data['nro_convenio'] =  $nro_convenio  ;
            $data['constacia_trabajo'] =  $constacia_trabajo;
            $data['rif'] =  $rif;
            $data['doc_cedula'] =  $doc_cedula;



            
           

            $data['order'] =  $order;
            
            $data['datos_cliente']    =  $datos_cliente;
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
            $data['other_fee']       = $order['other_fee'] ?? '';
            $data['comment']         = $order['comment'];
            $data['country']         = $order['country'];
            $data['id']              = $order->id;
            $data['details'] = [];


           

            $attributesGroup =  ShopAttributeGroup::pluck('name', 'id')->all();
            $id_attribute_modelo =ShopAttributeGroup::where('name','Modelo')->first()->id ?? '';

            if ($order->details) {
                foreach ($order->details as $key => $detail) {

                    
                    //cosultamos la marca y modelo del producto
                    $producto = AdminProduct::getProductAdmin($detail->product_id);
                    $modelo='';
                    if(  $producto->attributes->count()){                     
                            //obtener el atributo modelo por el id de $producto->attributes con $id_attribute_modelo
                        $first_attributes = $producto->attributes->where('attribute_group_id',$id_attribute_modelo)->first();
                        $modelo = $first_attributes->name ?? '';
                        
                    }


                    


                    
               
             
                    $arrAtt = json_decode($detail->attribute, true);
                    if ($arrAtt) {
                        $htmlAtt = '';
                        foreach ($arrAtt as $groupAtt => $att) {
                            $htmlAtt .= $attributesGroup[$groupAtt] .':'.sc_render_option_price($att, $order['currency'], $order['exchange_rate']);
                        }
                        $name = $detail->name;
                    } else {
                        $name = $detail->name;
                    }


                    $data['details'][] = [ 
                        'no' => $key + 1, 
                        'sku' => $detail->sku, 
                        'name' => $name, 
                        'qty' => $detail->qty, 
                        'marca'=>$producto->brand->name ?? '',
                        'id_modalidad_pago' => $detail->id_modalidad_pago, 
                        'modelo'=>$modelo ?? '',
                        'monto_cuota_entrega'=> $order->monto_cuota_entrega,
                        'monto_inicial'=>$product->monto_inicial,
                        'price' => $detail->price, 
                        'abono_inicial' => $detail->abono_inicial, 
                        'nro_coutas' => $detail->nro_coutas, 
                        'total_price' => $detail->total_price ?? '',
                    ];
                }
            }

           

            if ($action =='invoice_excel') {
                $options = ['filename' => 'Order ' . $orderId];
                return \Export::export($action, $data, $options);
            }
            
            return view($this->templatePathAdmin.'format.ficha_solicitud')
            ->with($data);
        } else {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }
    }

    public function ficha_propuesta()
    {
        $orderId = request('order_id') ?? null;
        $action = request('action') ?? '';
        $order = AdminOrder::getOrderAdmin($orderId);

        $convenio=Convenio::where('order_id',$orderId)->first();

        $constacia_trabajo='';
        $rif='';
        $cedula='';



      

       
       
        $nro_convenio = 'A/N';

        if(!empty($convenio))$nro_convenio = $convenio->nro_convenio ;

            
        $doc_cedula="";
        if ($order) {
            $documento = SC__documento::where('id_usuario', $order->customer_id)->first();


            $user_roles = AdminUser::where('id' ,$order->vendedor_id)->first();

           


            $referencias = SC_referencia_personal::where('id_usuario',$order->customer_id)->get();
            $datos_cliente =  SC_shop_customer::where('sc_shop_customer.id',$order->customer_id)
            ->leftJoin('estado', 'estado.codigoestado', '=', 'sc_shop_customer.cod_estado')
            ->leftJoin('municipio', 'municipio.codigomunicipio', '=', 'sc_shop_customer.cod_municipio')
            ->leftJoin('parroquia', 'parroquia.codigoparroquia', '=', 'sc_shop_customer.cod_parroquia')
            ->select('sc_shop_customer.*', 'estado.nombre as estado','municipio.nombre as municipio','parroquia.nombre as parroquia ,postcode ' )->first();


          

  
            if($documento){
                $constacia_trabajo= $documento->carta_trabajo ;
                $rif= $documento->rif ;
                $doc_cedula= $documento->cedula;

            }
            $data                    = array();
            $data['name']            = $order['first_name'] . ' ' . $order['last_name'];
            $data['address']         = $order['address1'] . ', ' . $order['address2'] . ', ' . $order['address3'].', '.$order['country'];
            $data['phone']           = $order['phone'];
            $data['phone2']           = $datos_cliente->phone2 ?? '';
            $data['conocio']           = $datos_cliente->nos_conocio ?? '';

            $data['vendedor']           = $user_roles->name ?? '';
            $data['email']           = $order['email'];
            
 
            $data['referencias']           = $referencias;
            $data['nro_coutas'] =   count($order->details) ? $order->details[0]->nro_coutas : 0;
            $data['nro_convenio'] =  $nro_convenio  ;
            $data['constacia_trabajo'] =  $constacia_trabajo;
            $data['rif'] =  $rif;
            $data['doc_cedula'] =  $doc_cedula;



            
           

            $data['order'] =  $order;
            
            $data['datos_cliente']    =  $datos_cliente;
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
            $data['other_fee']       = $order['other_fee'] ?? '';
            $data['comment']         = $order['comment'];
            $data['country']         = $order['country'];
            $data['id']              = $order->id;
            $data['details'] = [];


           

            $attributesGroup =  ShopAttributeGroup::pluck('name', 'id')->all();
            $id_attribute_modelo =ShopAttributeGroup::where('name','Modelo')->first()->id ?? '';

            if ($order->details) {
                foreach ($order->details as $key => $detail) {

                    
                    //cosultamos la marca y modelo del producto
                    $producto = AdminProduct::getProductAdmin($detail->product_id);
                    $modelo='';
                    if(  $producto->attributes->count()){                     
                            //obtener el atributo modelo por el id de $producto->attributes con $id_attribute_modelo
                        $first_attributes = $producto->attributes->where('attribute_group_id',$id_attribute_modelo)->first();
                        $modelo = $first_attributes->name ?? '';
                        
                    }
                
             
                    $arrAtt = json_decode($detail->attribute, true);
                    if ($arrAtt) {
                        $htmlAtt = '';
                        foreach ($arrAtt as $groupAtt => $att) {
                            $htmlAtt .= $attributesGroup[$groupAtt] .':'.sc_render_option_price($att, $order['currency'], $order['exchange_rate']);
                        }
                        $name = $detail->name;
                    } else {
                        $name = $detail->name;
                    }

                   

          
                    $data['details'][] = [ 
                        'no' => $key + 1, 
                        'sku' => $detail->sku, 
                        'name' => $name, 
                        'qty' => $detail->qty, 
                        'marca'=>$producto->brand->name ?? '',
                        'id_modalidad_pago' => $detail->id_modalidad_pago, 
                        'modelo'=>$modelo ?? '',
                        'monto_cuota_entrega'=> $detail->monto_cuota_entrega,
                        'price' => $detail->price, 
                        'abono_inicial' => $detail->abono_inicial, 
                        'nro_coutas' => $detail->nro_coutas, 
                        'total_price' => $detail->total_price ?? '',
                    ];
                }
            }

           

            if ($action =='invoice_excel') {
                $options = ['filename' => 'Order ' . $orderId];
                return \Export::export($action, $data, $options);
            }
            
            return view($this->templatePathAdmin.'format.ficha_propuesta')
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

                $order = ShopOrder::where('id',  $id)->first();

                function formatearFecha($fechas) {
                    $fecha = Carbon::createFromFormat('Y-m-d', $fechas);
                    $diaSemana = ucfirst($fecha->locale('es')->dayName);
                    $numeroDia = $fecha->day;
                    $nombreMes = ucfirst($fecha->locale('es')->monthName);
                    $anio = $fecha->year;
                
                    return "{$diaSemana} {$numeroDia} de {$nombreMes} del {$anio}";
                }
                
                

                

         

                
                $pdf = PDF::loadView($this->templatePathAdmin.'screen.comvenio_pdf', [
                    'borrado_html' => $plantilla->convenio,
                    'convenio' => $plantilla['nro_convenio'],
                    'fecha_convenio' => formatearFecha($order->fecha_primer_pago ?? date('d-m-y'))
                ]);
                

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

        $order = ShopOrder::where('id',$id)->first();
        $letraconvertir_nuber = new NumeroLetra;

        if (!$order) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }

     
        
        $datos_cliente =  SC_shop_customer::where('sc_shop_customer.id',$order->customer_id)
        ->leftJoin('estado', 'estado.codigoestado', '=', 'sc_shop_customer.cod_estado')
        ->leftJoin('municipio', 'municipio.codigomunicipio', '=', 'sc_shop_customer.cod_municipio')
        ->leftJoin('parroquia', 'parroquia.codigoparroquia', '=', 'sc_shop_customer.cod_parroquia')
        ->select('sc_shop_customer.*', 'estado.nombre as estado','municipio.nombre as municipio','parroquia.nombre as parroquia' )->first();

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
        



            $dato_usuario = [
                'subtotal' =>$order->subtotal,
                'natural_jurídica' =>$datos_cliente->natural_jurídica,
                'razon_social' => $datos_cliente->razon_social,
                'rif' => $datos_cliente->rif,
                'first_name' =>$datos_cliente->first_name,
                'last_name' =>$datos_cliente->last_name,
                'phone' =>$datos_cliente->phone,
                'email' => $datos_cliente->email,
                'address1' => $datos_cliente->address1,
                'address2' =>$datos_cliente->address2,
                'cedula' =>$datos_cliente->cedula,
                'cod_estado' => $datos_cliente->estado,
                'cod_municipio' => $datos_cliente->municipio,
                'cod_parroquia' =>$datos_cliente->parroquia,
                'estado_civil' =>$datos_cliente->estado_civil,
                
                
                [
        
                    'subtotal'=> $order->subtotal,
                    'cantidaProduc'=> $cantidaProduc,
                    'nombreProduct'=> $nombreProduct,
                    'cuotas' => $cuotas,
                    'abono_inicial' => $abono_inicial,
                    'id_modalidad_pago' => $id_modalidad_pago

                ]

            ];


        

            

                    $Moneda_CAMBIOBS = sc_currency_all();
                    foreach($Moneda_CAMBIOBS as $cambio){
                        if($cambio->name == "Bolivares"){
                           $cod_bolibares =  $cambio->exchange_rate;
                        }
                    }

                $borrado_html = [];
                $datos_cliente->natural_juridica=   $datos_cliente->natural_juridica ?? 'N';
                switch ($datos_cliente->natural_juridica) {
                    case 'N':
                        $borrado_html = $abono_inicial > 0
                            ? Sc_plantilla_convenio::where('id', 2)->first()->where('name', 'con_inicial')->first()
                            : Sc_plantilla_convenio::where('id', 1)->first()->where('name', 'sin_inicial')->first();
                        break;
                   default:
                        $borrado_html = Sc_plantilla_convenio::where('id', 3)->first()->where('name', 'persona_juridica')->first();
                        break;
                }


                $pieces = explode(" ", $datos_cliente->cedula);
                if ( $productoDetail[0]->id_modalidad_pago== 3) {
                    $mesualQuinsena = "MENSUAL";
                    $cod_diaMes = "LOS DIAS 30 DE CADA MES";
                }else {
                   
                    $mesualQuinsena = " QUINCENAL";
                    $cod_diaMes = "LOS DIAS 15 Y 30 DE CADA MES";
                } 
                if ($pieces[0] == "V" ) $Nacionalidad = "VENEZOLANO(A)";
                    else $Nacionalidad = "Extranjer(A)"; 

               

                    $total_price = $order->subtotal;
                    $precio_couta =  $order->subtotal/ $productoDetail[0]->nro_coutas;
                    $cuotas = $productoDetail[0]->nro_coutas;
                    if( $productoDetail[0]->abono_inicial>0){

                        $inicial = ($productoDetail[0]->abono_inicial * $order->subtotal) / 100;
                                                                $total_price = $order->subtotal - $inicial;
                                                                $precio_couta = number_format($total_price / $productoDetail[0]->nro_coutas, 2);

                                                             


                                                               
                       
                      }
    

                  
                  $number2 =  $total_price*$cod_bolibares;
                    

       
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
                        'razon_social' => $datos_cliente->razon_social,
                        'rif' => $datos_cliente->rif,
                        'nombre' => $datos_cliente->first_name,
                        'apellido' =>$datos_cliente->last_name,
                        'direccion' =>$datos_cliente->address1,
                        'direccion2' => $datos_cliente->address2 ?? 'no aplica',
                        'estado'=> $datos_cliente->cod_estado,
                        'municipio'=>$datos_cliente->cod_municipio,
                        'parroquia'=>$datos_cliente->cod_parroquia,
                        'cedula'=>$datos_cliente->cedula,
                        'estado_civil'=>$datos_cliente->estado_civil,
                        'nacionalidad'=>$Nacionalidad,
                        $mesualQuinsena,
                        $letraconvertir_nuber->convertir1($cuotas),
                        number_format($cuotas),
                        number_format($precio_couta, 2 ,',', ' '),
                         $letraconvertir_nuber->convertir2($precio_couta),
                        $cod_diaMes ,
                        'fecha_entrega'=>request()->fecha_maxima_entrega ?? 'no aplica',
                        $total_price ,
                         $letraconvertir_nuber->convertir2($number2),
                         number_format($number2, 2 ,',', ' '),
                        $dato_usuario[0]['nombreProduct'] ,
                        $dato_usuario['phone'],
                        $dato_usuario['email'],
                        'fecha_de_hoy' => 'N/A',
                        sc_file(sc_store('logo', ($storeId ?? null))),
                        sc_file(sc_store('logo', ($storeId ?? null))) ,
                        'logo_waika' =>sc_file(sc_store('logo', ($storeId ?? null))),
                        'logo_global' =>sc_file(sc_store('logo', ($storeId ?? null))),

                    ];


                    $content = preg_replace($dataFind, $dataReplace, $borrado_html->contenido);
                    $dataView = [
                        'content' => $content,
                    ];

                    $id_solicitud = $id;


            $pdf = Pdf::loadView($this->templatePathAdmin.'screen.comvenio_pdf', 
                    [
                        'borrado_html'=> $dataView['content'],
                        'id_solicitud'=> $id_solicitud
                    ]

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



    public function descargar()
    {

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

        

      
   
        $id_usuario_rol = Admin::user()->id;
        $dminUser = new AdminUser;
         $user_roles = $dminUser::where('sc_admin_user.id' ,$id_usuario_rol)->orderBy('id')
         ->join('sc_admin_role_user', 'sc_admin_user.id', '=', 'sc_admin_role_user.user_id')
         ->join('sc_admin_role', 'sc_admin_role.id', '=', 'sc_admin_role_user.role_id')
         ->select('sc_admin_user.id', 'sc_admin_user.id','sc_admin_role.name as rol','role_id' )->first();
         $role = AdminRole::find($user_roles->role_id);
         
      
            $id_status= $role ? $role->status->pluck('id')->toArray() :[];
         $this->statusOrder   = ShopOrderStatus::whereIn('id',$id_status)->pluck('name', 'id')
         ->all();
        






         $spreadsheet = new Spreadsheet();

         // Obtener la hoja activa
         $hoja = $spreadsheet->getActiveSheet();

        // Agregar el encabezado de las columnas
        $hoja->setCellValue('A1', 'Nombre&Apellido1');
        $hoja->setCellValue('B1', 'Solicitud');
        $hoja->setCellValue('C1', 'N°Convenio');
        $hoja->setCellValue('D1', 'Vendedor Asignado');
        $hoja->setCellValue('E1', 'Articulo');
        $hoja->setCellValue('F1', 'Cuotas');
        $hoja->setCellValue('G1', 'Cedula');
        $hoja->setCellValue('H1', 'Telefono');
        $hoja->setCellValue('I1', 'Correo');
        $hoja->setCellValue('J1', 'Estado');
        $hoja->setCellValue('K1', 'Municipio');
        $hoja->setCellValue('L1', 'Parroquia');
        $hoja->setCellValue('M1', 'Total');
        $hoja->setCellValue('N1', 'Estatus');
        $hoja->setCellValue('O1', 'Modalidad');
        $hoja->setCellValue('P1', 'Creado en');
       

        // Obtener los datos de la base de datos
        $datos = (new AdminOrder)->excel_export($dataSearch, $id_status);

        // Establecer los datos de la tabla
        $fila = 2;

        $Articulo = [];
        $convenio = [];
        $user_roles= [];

        $styleStatus = $this->statusOrder;
        
        foreach ($datos as $dato) {
            $Articulo = shop_order_detail::where('order_id', $dato->id)->first();
            $convenio = Convenio::where('order_id',$dato->id)->first();
            $user_roles = AdminUser::where('id' ,$dato->vendedor_id)->first();

            if($dato->modalidad_de_compra == 0)$AlContado = "Al contado";
                else $AlContado = "Financiamiento" ;

        
            $datos_cliente =  SC_shop_customer::where('sc_shop_customer.id',$dato->customer_id)
            ->leftJoin('estado', 'estado.codigoestado', '=', 'sc_shop_customer.cod_estado')
            ->leftJoin('municipio', 'municipio.codigomunicipio', '=', 'sc_shop_customer.cod_municipio')
            ->leftJoin('parroquia', 'parroquia.codigoparroquia', '=', 'sc_shop_customer.cod_parroquia')
            ->select('sc_shop_customer.*', 'estado.nombre as estado','municipio.nombre as municipio','sc_shop_customer.email'
            ,'parroquia.nombre as parroquia')->first();

            
            
      
          
            $hoja->setCellValue('A' . $fila, $datos_cliente->first_name . $datos_cliente->last_name);
            $hoja->setCellValue('B' . $fila, $datos_cliente->id);
            $hoja->setCellValue('C' . $fila, $convenio->nro_convenio ?? 'N/A');
            $hoja->setCellValue('D' . $fila, $user_roles->name ?? 'N/A');
            $hoja->setCellValue('E' . $fila,  $Articulo->name ?? 'N/A');
            $hoja->setCellValue('F' . $fila,  $Articulo->nro_coutas ?? 'N/A');
            $hoja->setCellValue('G' . $fila, $datos_cliente->cedula);
            $hoja->setCellValue('H' . $fila, $datos_cliente->phone);
            $hoja->setCellValue('I' . $fila, $datos_cliente->email);
            $hoja->setCellValue('J' . $fila, $datos_cliente->estado ?? 'N/A');
            $hoja->setCellValue('K' . $fila, $datos_cliente->municipio ?? 'N/A');
            $hoja->setCellValue('L' . $fila, $datos_cliente->parroquia);
            $hoja->setCellValue('M' . $fila, sc_currency_render_symbol($dato['total'] ?? 0, 'USD'));
            $hoja->setCellValue('N' . $fila, $styleStatus[$dato['status']] ?? $dato['status']);
            $hoja->setCellValue('O' . $fila, $AlContado ?? 'N/A');
            $hoja->setCellValue('P' . $fila, $dato->created_at);

            $fila++;
        }

        // Configurar la descarga del archivo
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="reporte.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');

        exit;
    }

    public function list_propuesta()
    {



          $arr_pach= explode('/',request()->path());
          $perfil =$arr_pach[2] ?? false;

          
        
        $data = [
            'title'         => 'Lista de las propuesta',
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
            'Modalidad'         =>"Modalidad",
            
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
    
         $dataSearch2 = [
            'keyword'      => $keyword,
            'email'        => $email,
            'Cedula'        => $email,
            'Telefono'        => $email,
            'Estado'        => $email,
            'from_to'      => $from_to,
            'end_to'       => $end_to,
            'sort_order'   => $sort_order,
            'order_status' =>  '3',
            'perfil'=> $perfil,
        ];

        $id_usuario_rol = Admin::user()->id;
        $dminUser = new AdminUser;
         $user_roles = $dminUser::where('sc_admin_user.id' ,$id_usuario_rol)->orderBy('id')
         ->join('sc_admin_role_user', 'sc_admin_user.id', '=', 'sc_admin_role_user.user_id')
         ->join('sc_admin_role', 'sc_admin_role.id', '=', 'sc_admin_role_user.role_id')
         ->select('sc_admin_user.id', 'sc_admin_user.id','sc_admin_role.name as rol','role_id' )->first();
         $role = AdminRole::find($user_roles->role_id);
         
         $id_status= '3';

        
        $dataTmp = (new AdminOrder)->getpropuesta($dataSearch, $id_status);


        


        if (sc_check_multi_shop_installed() && session('adminStoreId') == SC_ID_ROOT) {
            $arrId = $dataTmp->pluck('id')->toArray();
            // Only show store info if store is root
            if (function_exists('sc_get_list_store_of_order')) {
                $dataStores = sc_get_list_store_of_order($arrId);
            } else {
                $dataStores = [];

            }
        }


   
     
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

            


            if($row->modalidad_de_compra == 0){
                $AlContado = "Al contado";
            }else if($row->modalidad_de_compra ==2){
                $AlContado = "Financiamiento/Entrega Inmediata" ;
            }else if($row->modalidad_de_compra ==1){
                $AlContado = "Financiamiento" ;
            }else{

                $AlContado = "Propuesta" ;

            }
            
                 
            $datos_cliente =  SC_shop_customer::where('sc_shop_customer.id',$row->customer_id)
            ->leftJoin('estado', 'estado.codigoestado', '=', 'sc_shop_customer.cod_estado')
            ->leftJoin('municipio', 'municipio.codigomunicipio', '=', 'sc_shop_customer.cod_municipio')
            ->leftJoin('parroquia', 'parroquia.codigoparroquia', '=', 'sc_shop_customer.cod_parroquia')
            ->select('sc_shop_customer.phone', 'sc_shop_customer.cedula', 'sc_shop_customer.cedula','sc_shop_customer.cedula', 'estado.nombre as estado','municipio.nombre as municipio')->first();


         
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
                'Cedula'          => $datos_cliente->cedula ?? 'N/A',
                'Telefono'          => $datos_cliente->phone ?? 'N/A',
                'Estado'          =>$datos_cliente->estado ?? 'N/A',
                'Municipio'          =>$datos_cliente->municipio ?? 'N/A',
                'Parroquia'          =>$datos_cliente->parroquia ?? 'N/A',
                'total'          => sc_currency_render_symbol($row['total'] ?? 0, 'USD'),
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

     
            $dataMap['created_at'] = $row['created_at'];
          
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
        $data['urlSort'] = sc_route_admin('sc_admin/List_propuesta', request()->except(['_token', '_pjax', 'sort_order']));
        //=menuSort

        //menuSearch
        $optionStatus = '';
        $inpuExcel = '' ;
    
        foreach ($this->statusOrder as $key => $status) {
            $optionStatus .= '<option  ' . (($order_status == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }

        


                $ruta_exel= route('descargar.excel');
                foreach ($dataSearch2 as $key => $value){
                    $inpuExcel .= '<input type="hidden" name="'.$key.'" value="'.$value.'">';}
                     
                           


       

        $ruta_busqueda= sc_route_admin('sc_admin/List_propuesta');

        if( $perfil){
            $ruta_busqueda=  sc_route_admin('sc_admin/List_propuesta')."/$perfil";

           
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
                </form>



                
                
                
                ';

                
        //=menuSearch
        $data['page'] =  request()->all()['page'] ?? '';


        return view($this->templatePathAdmin.'screen.list')
            ->with($data);
    }


   

}
