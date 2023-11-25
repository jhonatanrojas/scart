<?php

namespace App\Http\Controllers;
use SCart\Core\Admin\Models\AdminCustomer;
use App\Models\AdminOrder;
use App\Models\SC__documento;
use SCart\Core\Front\Controllers\RootFrontController;
use SCart\Core\Front\Models\ShopCountry;
use SCart\Core\Front\Models\ShopOrder;
use SCart\Core\Front\Models\ShopOrderStatus;
use SCart\Core\Front\Models\ShopShippingStatus;
use SCart\Core\Front\Models\ShopCustomer;
use SCart\Core\Front\Models\ShopCustomField;
use SCart\Core\Front\Models\ShopAttributeGroup;
use SCart\Core\Front\Models\ShopCustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use SCart\Core\Front\Controllers\Auth\AuthTrait;
use App\Models\Catalogo\MetodoPago;
use App\Models\Catalogo\Banco;
use App\Models\Catalogo\PaymentStatus;
use App\Models\Convenio;
use App\Models\Estado;
use App\Models\HistorialPago;
use App\Models\Municipio;
use App\Models\Parroquia;
use App\Models\Sc_plantilla_convenio;
use App\Models\SC_referencia_personal;
use App\Models\SC_shop_customer;
use App\Models\shop_order_detail;
use App\Events\Biopago;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Cart;
use Illuminate\Support\Facades\File;
use SCart\Core\Admin\Models\AdminProduct;
use SCart\Core\Admin\Models\AdminUser;
use SCart\Core\Front\Models\ShopOrderDetail;
use SCart\Core\Front\Models\ShopPaymentStatus;

class ShopAccountController extends RootFrontController
{
    use AuthTrait;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Process front index profile
     *
     * @param [type] ...$params
     * @return void
     */

    public function biopago(Request $request)
    {

        $request->validate([
   
            'id' => 'required',
                  ]);
        $dataUser = Auth::user();
        $id_pedido = $request->get('id');
        $id_pago= $request->get('id_pago');

      
        $order = ShopOrder::where('id', $id_pedido)->first();
  
        $monedas = sc_currency_all();
        $tasa_cambio = $monedas[0]->exchange_rate;
       
        //Creación de solicitud de pago
        $Payment = new \stdClass;
        $Payment->idLetter = 'V'; //Letra de la cédula - V, E o P
        $Payment->idNumber =  trim(substr($order->cedula,1)); //Número de cédula
      //  dd( substr($order->cedula,1) ); 
        if( $id_pago==null){
        $Payment->amount = $order->total * $tasa_cambio; //Monto a combrar, DECIMAL
        }else{
       

            $historial_pago= HistorialPago::where('id',$id_pago)->first();
           $Payment->amount =  $historial_pago->importe_couta  * $tasa_cambio;
        }
       
      

        $Payment->currency = 1; //Moneda del pago, 0 - Bolivar Fuerte, 1 - Dolar
        $Payment->reference =  $id_pedido; //Código de referecia o factura
        $Payment->title = $order->details[0]->name; //Titulo para el pago, Ej: Servicio de Cable
        $Payment->description = 'Pago de cuota '; //Descripción del pago, Ej: Abono mes de marzo 2017
        $Payment->email =  $order->email;
        $Payment->cellphone = $order->phone;
        $Payment->urlToReturn = route('pago_exitoso'); //URL de retrono al finalizar el pago

        $PaymentProcess = new Biopago($_ENV['AFILIADOBDV'],$_ENV['CLAVEBDV']); //Instanciación de la API de pago con usuario y clave
        $response = $PaymentProcess->createPayment($Payment);
     //   dd(  $response->paymentId );
        if ($response->success == true) // Se procesó correctamente y es necesario redirigir a la página de pago
        {
            $user = Auth::user();
            $cId = $user->id;
      $hoy = date("Y-m-d H:i:s");  
        $data_pago =[
                       
            'customer_id' => $cId,
           'referencia' =>$response->paymentId,      
            'metodo_pago_id' =>7,
            'fecha_pago' =>  $hoy,
            'importe_pagado' =>$Payment->amount,
            'comment' =>'BDV',
            'moneda' =>'Bs',
            'tasa_cambio' => $tasa_cambio,
            'comprobante'=>   '',
            'payment_status' => 5
   
           ];
           if( $id_pago==null){
            $data_pago['order_id'] = $id_pedido;
             HistorialPago::create($data_pago);
           }else{
               HistorialPago::where('id',$id_pago)
           ->update($data_pago);
               
           
           }


            if (strtolower(filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest') { //si es ajax
                // echo $response->urlPayment;
                header('Content-type: application/json');
                echo json_encode($response);
            } else { //si no es ajax
                header("Location: " . $response->urlPayment); //W
                die();
            }
        } else {
            return redirect()->back()->with(['error' =>$response->responseMessage ]);
        }
    }

    public function indexProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_index();
    }


    public function pago_exitoso(){

        request()->id_pedido;
        request()->id;
        $historial_pago= HistorialPago::where('referencia',request()->id)->first();

    

     if( $historial_pago){

        $id_usuario = $historial_pago->customer_id;
        $datosUsuario = [];
        $user = ShopCustomer::where('id' , $id_usuario)->get();
        foreach($user as $key => $usuarios){ 
        $datosUsuario = [
                'first_name' =>  $usuarios->first_name,
                'last_name' =>  $usuarios->last_name,
                'email' =>  $usuarios->email,
                'phone' =>  $usuarios->phone,
                'address1'=>  $usuarios->address1,
                'cedula' =>  $usuarios->cedula,
        ];

        }


        
        HistorialPago::where('referencia',request()->id)  ->update([
                 
                     
            'metodo_pago_id' =>3,           
            'payment_status' => 5,
            'observacion' => 'Pago realizado a traves de BDV BIOPAGO'
   
           ]);

           exito_biopago_email($datosUsuario);
      
     }
      
     return view(
            $this->templatePath . '.screen.pago_exitoso',
            [
                'title'       => 'PAGO RECIBIDO',
                'orderInfo'   => '',
                'layout_page' => 'shop_order_success',
                'breadcrumbs' => [
                    ['url'    => '', 'title' => 'PAGO RECIBIDO'],
                ],
            ]
        );
    }
    /**
     * Index user profile
     *
     * @return  [view]
     */


    private function _index()
    {
        $customer = auth()->user();
        $id = $customer['id'];


       


 
        $documento = SC__documento::where('id_usuario', $id)->get();
        $order = AdminOrder::where('customer_id', $id)->get();
        $Combenio = [];
        $Order_resultado = [];
        if (!empty($order)) {
            $referencia = SC_referencia_personal::where('id_usuario', $id)->get();
            foreach ($order as $odenr) {
                $Order_resultado = $odenr;
                $convenio = Convenio::where('order_id', $odenr->id)->get();
                if (!empty($convenio) && $odenr->modalidad_de_compra >= 1) $Combenio = $convenio;
            }
        }

       

        if (!empty($documento[0]['id_usuario']) == $id) {
            $dato = "Para procesar sus solicitudes de compras, se requiere que adjunte Cedula, RIF y constancia de trabajo";
        } else $dato = "";

        // dd($dato);
   

        sc_check_view($this->templatePath . '.account.index');
        return view($this->templatePath . '.account.index')
            ->with(
                [
                    'title'       => sc_language_render('customer.my_account'),
                    'customer'    => $customer,
                    'cart'    =>   Cart::content(),
                    'convenio'    => $Combenio,
                 
                    'order'    => $Order_resultado,
                    'referencia'    => $referencia,
                    'mensaje'    => $dato,
                    'layout_page' => 'shop_profile',
                    'breadcrumbs' => [
                        ['url'    => '', 'title' => sc_language_render('customer.my_account')],
                    ],
                ]
            );
    }

    /**
     * Process front change passord
     *
     * @param [type] ...$params
     * @return void
     */
    public function changePasswordProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_changePassword();
    }

    /**
     * Form Change password
     *
     * @return  [view]
     */
    private function _changePassword()
    {
        $customer = auth()->user();
        $id = $customer['id'];
        $referencia = SC_referencia_personal::where('id_usuario', $id)->get();
        sc_check_view($this->templatePath . '.account.change_password');
        return view($this->templatePath . '.account.change_password')
            ->with(
                [
                    'title'       => sc_language_render('customer.change_password'),
                    'customer'    => $customer,
                    'referencia'    => $referencia,
                    'layout_page' => 'shop_profile',
                    'breadcrumbs' => [
                        ['url'    => sc_route('customer.index'), 'title' => sc_language_render('front.my_account')],
                        ['url'    => '', 'title' => sc_language_render('customer.change_password')],
                    ],
                ]
            );
    }

    /**
     * Post change password
     *
     * @param   Request  $request  [$request description]
     *
     * @return  [redirect]
     */
    public function postChangePassword(Request $request)
    {
        $dataUser = Auth::user();
        $password = $request->get('password');
        $password_old = $request->get('password_old');
        if (trim($password_old) == '') {
            return redirect()->back()
                ->with(
                    [
                        'password_old_error' => sc_language_render('customer.password_old_required')
                    ]
                );
        } else {
            if (!\Hash::check($password_old, $dataUser->password)) {
                return redirect()->back()
                    ->with(
                        [
                            'password_old_error' => sc_language_render('customer.password_old_notcorrect')
                        ]
                    );
            }
        }
        $messages = [
            'password.required' => sc_language_render('validation.required', ['attribute' => sc_language_render('customer.password')]),
            'password.confirmed' => sc_language_render('validation.confirmed', ['attribute' => sc_language_render('customer.password')]),
            'password_old.required' => sc_language_render('validation.required', ['attribute' => sc_language_render('customer.password_old')]),
        ];
        $v = Validator::make(
            $request->all(),
            [
                'password_old' => 'required',
                'password' => config('validation.customer.password_confirm', 'required|string|min:6|confirmed'),
            ],
            $messages
        );
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }
        $dataUser->password = bcrypt($password);
        $dataUser->save();

        return redirect(sc_route('customer.index'))
            ->with(['success' => sc_language_render('customer.update_success')]);
    }

    /**
     * Process front change info
     *
     * @param [type] ...$params
     * @return void
     */
    public function changeInfomationProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_changeInfomation();
    }

    /**
     * Form change info
     *
     * @return  [view]
     */
    private function _changeInfomation()
    {
        $customer = auth()->user();
        $id = $customer['id'];
        $referencia = SC_referencia_personal::where('id_usuario', $id)->get();
        sc_check_view($this->templatePath . '.account.change_infomation');
        return view($this->templatePath . '.account.change_infomation')
            ->with(
                [
                    'title'       => sc_language_render('customer.change_infomation'),
                    'customer'    => $customer,
                    'referencia'    => $referencia,
                    'countries'   => ShopCountry::getCodeAll(),
                    'layout_page' => 'shop_profile',
                    'customFields' => (new ShopCustomField)->getCustomField($type = 'customer'),
                    'breadcrumbs' => [
                        ['url'    => sc_route('customer.index'), 'title' => sc_language_render('front.my_account')],
                        ['url'    => '', 'title' => sc_language_render('customer.change_infomation')],
                    ],
                ]
            );
    }


    /**
     * Process update info
     *
     * @param   Request  $request  [$request description]
     *
     * @return  [redirect]
     */
    public function postChangeInfomation(Request $request)
    {
        $user = Auth::user();
        $cId = $user->id;
        $data = request()->all();

        $usuario = AdminCustomer::find($cId);

            if (!$usuario) {
                return redirect()->back()
                    ->withErrors(['message' => 'Usuario no encontrado'])
                    ->withInput();
            }

            $validatedData = [
                'first_name' => $data['first_name'] ?? '',
                'last_name' => $data['last_name'] ?? '',
                'phone' => $data['phone'] ?? '',
                'postcode' => $data['postcode'] ?? '',
                'address1' => $data['address1'] ?? '',
                'address2' => $data['address2'] ?? '',
                'sex' => $data['sex'] ?? '',
            ];

            $socialMediaFields = ['re_facebook', 're_Twitter', 're_Instagram', 'LinkedIn'];

            foreach ($socialMediaFields as $field) {
                if (isset($data[$field]) && !filter_var($data[$field], FILTER_VALIDATE_URL)) {
                    return redirect()->back()
                        ->withErrors(['message' => 'URL no válida para ' . $field])
                        ->withInput();
                }
                $validatedData[$field] = $data[$field] ?? '';
            }

            $usuario->update($validatedData);


        

        return redirect(sc_route('customer.index'))
            ->with(['success' => sc_language_render('customer.update_success')]);
    }

    /**
     * Validate data input
     */
    protected function validator(array $data)
    {
        $dataMapp = $this->mappingValidatorEdit($data);
        return Validator::make($data, $dataMapp['validate'], $dataMapp['messages']);
    }

    /**
     * Update data customer
     */
    protected function updateCustomer(array $data, string $cId)
    {
        $dataMapp = $this->mappingValidatorEdit($data);
        $user = ShopCustomer::updateInfo($dataMapp['dataUpdate'], $cId);

        return $user;
    }

    /**
     * Process front order list
     *
     * @param [type] ...$params
     * @return void
     */
    public function orderListProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_orderList();
    }

    /**
     * Render order list
     * @return [view]
     */
    private function _orderList()
    {

        $mapStyleStatus = AdminOrder::$mapStyleStatus;



        $customer = auth()->user();
        $id = $customer['id'];
        $referencia = SC_referencia_personal::where('id_usuario', $id)->get();
        $order = AdminOrder::where('customer_id', $id)->get();
        $numeroCombenio = [];
        $Order_resultado = [];


       
            $Name_product = [];
       
            $referencia = SC_referencia_personal::where('id_usuario', $id)->get();

            $REFERENCIA=ShopOrder::where('customer_id' , $id)->leftJoin('sc_convenios', 'sc_shop_order.id', '=', 'sc_convenios.order_id')->leftJoin('sc_shop_order_detail', 'sc_shop_order.id', '=', 'sc_shop_order_detail.order_id')->leftJoin('sc_shop_customer', 'sc_shop_customer.id', '=', 'sc_shop_order.customer_id')
            ->select('sc_shop_order.*', 'sc_shop_order.first_name', 'sc_shop_order.last_name', 'sc_convenios.lote', 'nro_convenio', 'sc_shop_order.last_name' , 'sc_convenios.total as cb_total' ,  'sc_convenios.fecha_maxima_entrega' ,'sc_convenios.nro_coutas as cuaotas' , 'sc_shop_order_detail.name as name_product' ,'sc_shop_order_detail.qty as cantidad' , 'sc_shop_customer.address1 as Direccion')->get();




        $statusOrder = ShopOrderStatus::getIdAll();

        
        sc_check_view($this->templatePath . '.account.order_list');
        return view($this->templatePath . '.account.order_list')
            ->with(
                [
                    'title'       => sc_language_render('customer.order_history'),
                    'statusOrder' => $statusOrder,
                    'orders'      => $REFERENCIA,
                    'customer'    => $customer,
                    'mapStyleStatus' => $mapStyleStatus,
                    'order'    => $Order_resultado,
                    'productoDetail' => $productoDetail ?? '',
                    'Name_product' => $REFERENCIA,
                    'combenio'    => $numeroCombenio ?? 'Nr°convenio no aprobado',
                    'referencia'    => $referencia,
                    'layout_page' => 'shop_profile',
                    'breadcrumbs' => [
                        ['url'    => sc_route('customer.index'), 'title' => sc_language_render('front.my_account')],
                        ['url'    => '', 'title' => sc_language_render('customer.order_history')],
                    ],
                ]
            );
            
    }

    /**
     * Process front order detail
     *
     * @param [type] ...$params
     * @return void
     */
    public function orderDetailProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            $id = $params[1] ?? '';
            sc_lang_switch($lang);
        } else {
            $id = $params[0] ?? '';
        }
        return $this->_orderDetail($id);
    }

    /**
     * Render order detail
     * @return [view]
     */
    private function _orderDetail($id)
    {

        $mapStyleStatus = AdminOrder::$mapStyleStatus;
        $customer = auth()->user();
        $statusOrder = ShopOrderStatus::getIdAll();
        $statusShipping = ShopShippingStatus::getIdAll();
        $attributesGroup = ShopAttributeGroup::pluck('name', 'id')->all();
        $order = ShopOrder::where('id', $id)->where('customer_id', $customer->id)->first();
        $order2 = AdminOrder::getOrderAdmin($order->id);
        if ($order) {
            $title = sc_language_render('customer.order_detail') . ' #' . $order->id;
        } else {
            return $this->pageNotFound();
        }
        $fecha_actual = date('Y-m-d');

        $fech_p = date('Y-m-d',strtotime($fecha_actual . "+30 day"));

        if ($order->modalidad_de_compra == 0) {
            $historial_pagos =   HistorialPago::where('order_id', $id)->whereIn('payment_status',[1,8])->orderBy('id', 'desc')->get();

            
        }else{
            $historial_pagos =   HistorialPago::where('order_id', $id)
            ->where('fecha_venciento','<' ,$fech_p)
            ->whereIn('payment_status',[1,8])
            ->orderBy('fecha_venciento')->limit(1)
            ->get();

            
        }



        $fecha_de_hoy = date('d-m-y');
        $parse_fecha_hoy  = date_parse($fecha_de_hoy );
        //dia de la fecha actual
        $dia_hoy = $parse_fecha_hoy['day'];
        //mes de la fecha actual
        $mes_hoy = $parse_fecha_hoy['month'];


        $id = $customer['id'];
        $referencia = SC_referencia_personal::where('id_usuario', $id)->get();
        $documento = SC__documento::where('id_usuario', $id)->get();

        if (!isset($documento[0]['id_usuario']) == $id) {
            $dato = "Para procesar sus solicitudes de compras, se requiere que adjunte Cedula, RIF y constancia de trabajo";
        } else {
            $dato = "";
        }

        $product = AdminProduct::getProductAdmin($order2->product_id);

        
        sc_check_view($this->templatePath . '.account.order_detail');
        return view($this->templatePath . '.account.order_detail')
            ->with(
                [
                    'title'           => $title,
                    'referencia'           => $referencia,
                    'cuotas_inmediatas' =>$product->cuotas_inmediatas ?? 0,
                    'monto_inicial' => $product->monto_inicial?? 0,
                    'statusOrder'     => $statusOrder,
                    'mensaje'     => $dato,
                    'mapStyleStatus' => $mapStyleStatus,
                    'statusShipping'  => $statusShipping,
                    'countries'       => ShopCountry::getCodeAll(),
                    'attributesGroup' => $attributesGroup,
                    'order'           => $order,
                    'customer'        => $customer,
                    'layout_page'     => 'shop_profile',
                    'historial_pagos'   => $historial_pagos,
                    'breadcrumbs'     => [
                        ['url'        => sc_route('customer.index'), 'title' => sc_language_render('front.my_account')],
                        ['url'        => '', 'title' => $title],
                    ],
                ]
            );
    }

    public function pagosPendientes(...$params){

        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            $id = $params[1] ?? '';
            sc_lang_switch($lang);
        } else {
            $id = $params[0] ?? '';
        }


        $mapStyleStatus = AdminOrder::$mapStyleStatus;
        $customer = auth()->user();
        $statusOrder = ShopOrderStatus::getIdAll();
        $statusShipping = ShopShippingStatus::getIdAll();
        $attributesGroup = ShopAttributeGroup::pluck('name', 'id')->all();
        $order = ShopOrder::where('id', $id)->where('customer_id', $customer->id)->first();

        if ($order) {
            $title = sc_language_render('customer.order_detail') . ' #' . $order->id;
        } else {
            return $this->pageNotFound();
        }
        $fecha_actual = date('Y-m-d');

        $fech_p = date('Y-m-d',strtotime($fecha_actual . "+30 day"));

        if ($order->modalidad_de_compra == 0) {
            $historial_pagos =   HistorialPago::where('order_id', $id)->whereIn('payment_status',[1,8])->orderBy('id', 'desc')->get();

            
        }else{
            $historial_pagos =   HistorialPago::where('order_id', $id)
            ->where('fecha_venciento','<' ,$fech_p)
            ->whereIn('payment_status',[1,8])
            ->orderBy('fecha_venciento')->limit(1)
            ->get();

            
        }


        return view($this->templatePath . '.account.pagos_pendientes')
        ->with(
            [
                'title'           => 'Pagos Pendientes',

                'statusOrder'     => $statusOrder,
 
                'mapStyleStatus' => $mapStyleStatus,
                'statusShipping'  => $statusShipping,
                'countries'       => ShopCountry::getCodeAll(),
                'attributesGroup' => $attributesGroup,
                'order'           => $order,
                'customer'        => $customer,
                'layout_page'     => 'shop_profile',
                'historial_pagos'   => $historial_pagos,
                'breadcrumbs'     => [
                    ['url'        => sc_route('customer.index'), 'title' => sc_language_render('front.my_account')],
                    ['url'        => '', 'title' => $title],
                ],
            ]
        );

    }
    /**
     * Process front address list
     *
     * @param [type] ...$params
     * @return void
     */
    public function addressListProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_addressList();
    }

    public function reportarPago(Request $request , ...$params)
    {


        
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            $id = $params[1] ?? '';
            sc_lang_switch($lang);
        } else {
            $id = $params[0] ?? '';
        }
        $customer = auth()->user();
        $pago = $request->all();

        

        $bancos = Banco::all();

        $order = ShopOrder::where('id', $id)->where('customer_id', $customer->id)->first();

        $referencia = SC_referencia_personal::where('id_usuario', $id)->get();
        $id_pago = $request->all();


        $historial_pago = HistorialPago::where('order_id', $params[1])->first();


       
            


       
        $metodos_pagos = MetodoPago::whereIn('id',[2,4])->get();

       
        sc_check_view($this->templatePath . '.account.reportar_pago');
        
        return view($this->templatePath . '.account.reportar_pago')
            ->with(
                [
                    'title'           => 'Reportar pago',
                    'id_pago' => $id_pago['id_pago'] ?? "",
                    'lisPago' =>      $id_pago ?? "",
                    'historial_pago' => $historial_pago,
                    'bancos' =>$bancos,
                    'customer'        => $customer,
                    'referencia'        => $referencia,
                    'metodos_pagos'  => $metodos_pagos,
                    'order' => $order,
                    'layout_page'     => 'shop_profile',
                    'breadcrumbs'     => [
                        ['url'        => sc_route('customer.reportar_pago'), 'title' => sc_language_render('front.my_account')],
                        ['url'        => '', 'title' => 'Historial de pagos'],
                    ],
                ]
            );
    }

    public function convenio()
    {

        return view($this->templatePath . '.convenio');
    }

    public function postReportarPago(Request $request)
    {


       
        $user = Auth::user();
        $cId = $user->id;
        $data = request()->all();


        $request->validate([
            'capture' => 'required|mimes:pdf,jpg,jpge,png|max:2048',
            'monto' => 'required',
            'referencia' => 'required',
            'telefono_origen' => 'required',
            'cedula_origen' => 'required',
            'codigo_banco' =>'required',
            'order_id' => 'required',
            'tipo_cambio' => 'required'
        ]);
        $fileName = time() . '.' . $request->capture->extension();
        $path_archivo = 'data/clientes/pagos' . '/' . $fileName;
        $request->capture->move(public_path('data/clientes/pagos'), $fileName);
        $id_pago = $request->id_pago;



       


        $data_pago = [
            'order_id' => $request->order_id,
            'customer_id' => $cId,
            'referencia' => $request->referencia,
            'tasa_cambio' => $request->tipo_cambio,
            'order_detail_id' => $request->id_detalle_orden,
            'producto_id' => $request->product_id,
            'telefono_origen'=>$request->telefono_origen,
            'codigo_banco'=>$request->codigo_banco,
            'cedula_origen'=>$request->cedula_origen,
            'metodo_pago_id' => $request->forma_pago,
            'fecha_pago' => $request->fecha,
            'importe_pagado' => $request->monto,
            'comment' => $request->observacion,
            'moneda' => $request->moneda,
            'comprobante' =>   $path_archivo,
            'payment_status' => 2

        ];

       
      
        if ($id_pago == null) {
            HistorialPago::create($data_pago);
        } else {
            HistorialPago::where('id', $id_pago)
                ->update($data_pago);


        }


        return redirect(sc_route('customer.historial_pagos'))
            ->with(['success' => 'Su pago ha sido reportado de forma exitosa']);
    }

    public function reportePagos(){
        
    

        $data = [];
    


        $listTh = [
            'N° de Pago' => 'N°',
         
            'Reportado' => 'Reportado',
            'DIVISA' => 'Moneda',
            'CONVERSION' => 'Conversión',
            'tasa_cambio' => 'Tasa ',
            'estatus' => 'Estatus',
            'FORMA_DE_PAGO' => 'Forma de pago',
            'REFRENCIA' => 'Referencia',
            'FECHA_DE_PAGO' => 'Fecha de pago',
            'observacion' => 'Nota',

        ];
        $sort_order = sc_clean(request('sort_order') ?? 'id_desc');
        $keyword = sc_clean(request('keyword') ?? '');
        $historial_pago = sc_clean(request('historial_pago') ?? '');
        $statusPayment = PaymentStatus::select(['name', 'id'])->get();



        foreach ($statusPayment as $key => $value) {
            $arrSort[$value->id] = $value->name;
            # code...
        }

        $dataSearch = [
            'keyword' => $keyword,
            'historial_pago' => $historial_pago,
            'sort_order' => $sort_order,
            'arrSort' => $arrSort,
            'arrSort' => $arrSort,
        ];


        $monto_cuota_pendiente=0;
        $convenio = Convenio::where('order_id', $keyword)->first();

        $emitido_por = '';


        $order = AdminOrder::getOrderAdmin($keyword);
     
        //  $dataTmp = $this->getPagosListAdmin2($dataSearch);
        $historialPago = HistorialPago::where('order_id',$keyword)->whereIn('payment_status',[3,4,5,6,8])->orderBy('nro_coutas')->get();
        $cuota_pendientes = HistorialPago::where('order_id', $keyword)
        ->where('payment_status', 1)
        ->orWhere('payment_status', 7)->where('order_id', $keyword)
        ->orderBy('nro_coutas')->first();

                $cuota_pendiente = 0;

                if ($cuota_pendientes != null) {
                    if ($cuota_pendientes->exists()) {
                        $cuota_pendiente = $cuota_pendientes->importe_couta;
                    }
                }

        $nro_total_pagos = 0;

       


        $dataTr = [];

     
        $totale = [];
     
        $total_usd_pagado = 0;
       
 

        if (!$historialPago->count() >0) {
            return redirect(sc_route_admin('admin_order.detail', ['id' => $dataSearch['keyword']]))
                ->with(['error' => 'no se encontraron pagos reportado']);
        }
      

        $pagado = 0;
        $total_bs=0;
        foreach ($historialPago as $key => $row) {


            $nro_total_pagos++;


            $statusPayment = ShopPaymentStatus::pluck('name', 'id')->all();
             $styleStatusPayment = $statusPayment;
            array_walk($styleStatusPayment, function (&$v, $k) {
                $v = '<span class="text-black badge badge-' . (AdminOrder::$mapStyleStatus[$k] ?? 'light') . '">' . $v . '</span>';
            });

    
         

           

         
           

            $moneda = '';
          

           
            if($row->payment_status == 3 || $row->payment_status == 4 || $row->payment_status == 5 || $row->payment_status == 6){

                $pagado += $row->importe_couta;

                $fecha_formateada = date('d-m-Y', strtotime($row->fecha_pago));
    
                $moneda = $row->moneda;
                $monto = $row->importe_pagado;
                

                if ($moneda == 'USD') {
                // El monto está en dólares
                $monto_dolares = number_format($monto,2);
                $monto_bolivares = number_format($monto * $row->tasa_cambio,2);
                $Referencia = $monto_bolivares."Bs";
                $diVisA = $moneda;
                $Reportado = $monto;
            } else if ($moneda == 'Bs') {
                // El monto está en bolívares
                $monto_bolivares = number_format($monto ,2);
                $monto_dolares = number_format($monto / $row->tasa_cambio ,2);
                $Referencia = $monto_dolares."$";
                $diVisA = $moneda;
                $Reportado = $monto;
                $total_bs += $Reportado ;

                

            }

            }else if($row->payment_status == 8 ){
                $monto_dolares = 0.00;
                $monto_bolivares =0.00;
                $Referencia =0;
                $diVisA = 0;
                $Reportado = 0;
                
            }
            
            


            $dataTr[$row->id] = [
                'N° de Pago' => $row->nro_coutas,
       
                'Reportado' => $Reportado ?? 0,
                'DIVISA' => $diVisA ?? 'N/A',
                'CONVERSION' => $Referencia ?? 0 ,
                'tasa_cambio' => $row->tasa_cambio ?? 0,
                'estatus' => $styleStatusPayment[$row->payment_status],
                'FORMA_DE_PAGO' => $row->metodo_pago->name ?? 'N/A',
                'REFRENCIA' => $row->referencia ?? 0,
                'FECHA_DE_PAGO' => $fecha_formateada ?? 'N/A',
                'observacion' =>  $row->observacion

            ];


        } //fin foreach


        

        $fechaActual = Carbon::now()->format('d \d\e F \d\e Y');
        $cliente = SC_shop_customer::where('id', $order->customer_id)->first();
        $data['id_solicitud'] = $order->id ?? 0;
        $data['descuento'] = $order->discount ?? 0;
        $data['subtotal'] = $order->subtotal ?? 0;
        $data['totales'] = $order->total;
        $data['emitido_por'] = $emitido_por ?? '';
        $data['totalPor_pagar'] = $order->total - $pagado;
        $data['cliente'] = $cliente->first_name . ' ' . $cliente->last_name ?? '';
        $data['vendedor'] =  '';
        $data['cedula'] = $order->cedula ?? '';
        $data['cuota_pendiente'] =$cuota_pendiente ;
        $data['lote'] = $convenio->lote ?? '';
        $data['total_bs'] = $total_bs ;
        
        $data['direccion'] = $cliente->address1 ?? '';
        $data['total_monto_pagado'] = $pagado;
        $data['total_usd_pagado'] = $total_usd_pagado;
        $data['Cuotas_Pendientes'] =  $convenio->nro_coutas -$nro_total_pagos < 0 ? 0 :  $convenio->nro_coutas -$nro_total_pagos;
        $data['fecha_pago'] = $fechaActual ?? '';
        $data['order_id'] = $order->id ?? '';
        $data['nro_convenio'] = $convenio->nro_convenio ?? '';
        $data['order'] =   $order;

        $data['fecha_maxima_entrega'] = $order->fecha_maxima_entrega ? $this->fechaEs($order->fecha_maxima_entrega) : '';




      
        $data['totaleudsBS'] = $totale;
        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        return view($this->templatePath . '.account.reporte_pagos_pdf')
            ->with($data);



    }
    public function historialPagos()
    {

        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            $id = $params[1] ?? '';
            sc_lang_switch($lang);
        } else {
            $id = $params[0] ?? '';
        }
        $customer = auth()->user();
        $id1 = $customer['id'];
        $mapStyleStatus = AdminOrder::$mapStyleStatus;

    //    $order = AdminOrder::where('customer_id',$id1)->get();

        $order =   AdminOrder::with(['details', 'orderTotal'])
        ->join('sc_convenios', 'sc_shop_order.id', '=','sc_convenios.order_id' )
        ->leftjoin('sc_admin_user', 'sc_shop_order.usuario_id', '=', 'sc_admin_user.id')
        ->select('sc_shop_order.*','nro_convenio')
        ->where('sc_shop_order.customer_id', $id1)->get();
     
        
        $referencia = SC_referencia_personal::where('id_usuario', $id1)->get();

  

        sc_check_view($this->templatePath . '.account.historial_pagos');
        return view($this->templatePath . '.account.historial_pagos')
            ->with(
                [
                    'title'           => 'Historial de pagos',
                    'mapStyleStatus' => $mapStyleStatus,
                    'customer'        => $customer,
                    'order'=> $order,
                    'referencia'        => $referencia,
                    'layout_page'     => 'shop_profile',
         
                    'breadcrumbs'     => [
                        ['url'        => sc_route('customer.historial_pagos'), 'title' => sc_language_render('front.my_account')],
                        ['url'        => '', 'title' => 'Reportar  pago'],
                    ],
                ]
            );
    }

    /**
     * Render address list
     * @return [view]
     */
    private function _addressList()
    {
        $customer = auth()->user();

        $id1 = $customer['id'];
        $referencia = SC_referencia_personal::where('id_usuario', $id1)->get();
        sc_check_view($this->templatePath . '.account.address_list');
        return view($this->templatePath . '.account.address_list')
            ->with(
                [
                    'title'       => sc_language_render('customer.address_list'),
                    'addresses'   => $customer->addresses,
                    'countries'   => ShopCountry::getCodeAll(),
                    'customer'    => $customer,
                    'referencia'    => $referencia,
                    'layout_page' => 'shop_profile',
                    'breadcrumbs' => [
                        ['url'    => sc_route('customer.index'), 'title' => sc_language_render('front.my_account')],
                        ['url'    => '', 'title' => sc_language_render('customer.address_list')],
                    ],
                ]
            );

           
    }

    /**
     * Process front address update
     *
     * @param [type] ...$params
     * @return void
     */
    public function updateAddressProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            $id = $params[1] ?? '';
            sc_lang_switch($lang);
        } else {
            $id = $params[0] ?? '';
        }
        return $this->_updateAddress($id);
    }

    /**
     * Render address detail
     * @return [view]
     */
    private function _updateAddress($id)
    {
        $customer = auth()->user();
        $address =  (new ShopCustomerAddress)->where('customer_id', $customer->id)
            ->where('id', $id)
            ->first();
        if ($address) {
            $title = sc_language_render('customer.address_detail');
        } else {
            return $this->pageNotFound();
        }
        sc_check_view($this->templatePath . '.account.update_address');
        return view($this->templatePath . '.account.update_address')
            ->with(
                [
                    'title'       => $title,
                    'address'     => $address,
                    'customer'    => $customer,
                    'countries'   => ShopCountry::getCodeAll(),
                    'layout_page' => 'shop_profile',
                    'breadcrumbs' => [
                        ['url'    => sc_route('customer.index'), 'title' => sc_language_render('front.my_account')],
                        ['url'    => '', 'title' => $title],
                    ],
                ]
            );
    }

    /**
     * Process update address
     *
     * @param   Request  $request  [$request description]
     *
     * @return  [redirect]
     */
    public function postUpdateAddressFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            $id = $params[1] ?? '';
            sc_lang_switch($lang);
        } else {
            $id = $params[0] ?? '';
        }
        return $this->_postUpdateAddress($id);
    }

    /**
     * Process update address
     *
     * @param   Request  $request  [$request description]
     *
     * @return  [redirect]
     */
    private function _postUpdateAddress($id)
    {
        $customer = auth()->user();
        $data = request()->all();
        $address =  (new ShopCustomerAddress)->where('customer_id', $customer->id)
            ->where('id', $id)
            ->first();

        $dataMapp = sc_customer_address_mapping($data);
        $dataUpdate = $dataMapp['dataAddress'];
        $validate = $dataMapp['validate'];
        $messages = $dataMapp['messages'];

        $v = Validator::make(
            $dataUpdate,
            $validate,
            $messages
        );
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        $address->update(sc_clean($dataUpdate));

        if (!empty($data['default'])) {
            (new ShopCustomer)->find($customer->id)->update(['address_id' => $id]);
        }
        return redirect(sc_route('customer.address_list'))
            ->with(['success' => sc_language_render('customer.update_success')]);
    }

    /**
     * Get address detail
     *
     * @return  [json]
     */
    public function getAddress()
    {
        $customer = auth()->user();
        $id = request('id');
        $address =  (new ShopCustomerAddress)->where('customer_id', $customer->id)
            ->where('id', $id)
            ->first();
        if ($address) {
            return $address->toJson();
        } else {
            return $this->pageNotFound();
        }
    }

    /**
     * Get address detail
     *
     * @return  [json]
     */
    public function deleteAddress()
    {
        $customer = auth()->user();
        $id = request('id');
        (new ShopCustomerAddress)->where('customer_id', $customer->id)
            ->where('id', $id)
            ->delete();
        return json_encode(['error' => 0, 'msg' => sc_language_render('customer.delete_address_success')]);
    }

    /**
     * Process front address update
     *
     * @param [type] ...$params
     * @return void
     */
    public function verificationProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_verification();
    }

    /**
     * _verification function
     *
     * @return void
     */
    private function _verification()
    {
        $customer = auth()->user();
        if (!$customer->hasVerifiedEmail()) {
            return redirect(sc_route('customer.index'));
        }
        sc_check_view($this->templatePath . '.account.verify');
        return view($this->templatePath . '.account.verify')
            ->with(
                [
                    'title' => sc_language_render('customer.verify_email.title_page'),
                    'customer' => $customer,
                ]
            );
    }

    /**
     * Resend email verification
     *
     * @return void
     */
    public function resendVerification()
    {
        $customer = auth()->user();
        if (!$customer->hasVerifiedEmail()) {
            return redirect(sc_route('customer.index'));
        }
        $resend = $customer->sendEmailVerify();

        if ($resend) {
            return redirect()->back()->with('resent', true);
        }
    }

    /**
     * Process Verification
     *
     * @param [type] $id
     * @param [type] $token
     * @return void
     */
    public function verificationProcessData(Request $request, $id = null, $token = null)
    {
        $arrMsg = [
            'error' => 0,
            'msg' => '',
            'detail' => '',
        ];
        $customer = auth()->user();
        if (!$customer) {
            $arrMsg = [
                'error' => 1,
                'msg' => sc_language_render('customer.verify_email.link_invalid'),
            ];
        } elseif ($customer->id != $id) {
            $arrMsg = [
                'error' => 1,
                'msg' => sc_language_render('customer.verify_email.link_invalid'),
            ];
        } elseif (sha1($customer->email) != $token) {
            $arrMsg = [
                'error' => 1,
                'msg' => sc_language_render('customer.verify_email.link_invalid'),
            ];
        }
        if (!$request->hasValidSignature()) {
            abort(401);
        }
        if ($arrMsg['error']) {
            return redirect(route('home'))->with(['error' => $arrMsg['msg']]);
        } else {
            $customer->update(['email_verified_at' => \Carbon\Carbon::now()]);
            return redirect(sc_route('customer.index'))->with(['message' => sc_language_render('customer.verify_email.verify_success')]);
        }
    }

    public function lista_referencia()
    {

        $customer = auth()->user();
        $id = $customer['id'];
        $order = AdminOrder::where('customer_id', $id)->get();
        $Combenio = [];
        $Order_resultado = [];
        if (!empty($order)) {
            $referencia = SC_referencia_personal::where('id_usuario', $id)->get();
            foreach ($order as $odenr) {
                $Order_resultado = $odenr;
                $convenio = Convenio::where('order_id', $odenr->id)->get();
                if (!empty($convenio) && $odenr->modalidad_de_compra >= 1) $Combenio = $convenio;
            }
        }
        return view($this->templatePath . '.account.lista_referencia')->with(
            [
                'title'       => "Referencia-personal",
                'customer'    => $customer,
                'convenio'    => $Combenio,
                'order'    => $Order_resultado,
                'referencia'    => $referencia,
                'layout_page' => 'shop_profile',
                'breadcrumbs' => [
                    ['url'    => '', 'title' => sc_language_render('customer.my_account')],
                ],
            ]
        );;
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





            $pdf = Pdf::loadView($this->templatePath.'.screen.borrador_pdf', 
                    ['borrado_html'=> $dataView['content']]

                    )->setOptions(['defaultFont' => 'sans-serif']);

                    return $pdf->stream();
            // $pdf = Pdf::loadView($this->templatePath.'.screen.borrador_pdf', 
            // ['borrado_html'=> $plantilla->convenio],
            // )->setOptions(['defaultFont' => 'sans-serif']);

            //  return $pdf->stream();

    }


     public function view_QR($id){

        $orderList = HistorialPago::where('sc_historial_pagos.order_id', $id)->whereIn('sc_historial_pagos.payment_status',[3,4,5,6])
        ->leftJoin('sc_shop_order', 'sc_historial_pagos.order_id', '=', 'sc_shop_order.id')
        ->leftJoin('sc_convenios', 'sc_historial_pagos.order_id', '=', 'sc_convenios.order_id')
        ->leftJoin('sc_metodos_pagos', 'sc_historial_pagos.metodo_pago_id', '=', 'sc_metodos_pagos.id')
        ->leftJoin('sc_shop_order_detail', 'sc_historial_pagos.order_id', '=', 'sc_shop_order_detail.order_id')
        ->leftJoin('sc_shop_customer', 'sc_shop_order.customer_id', '=', 'sc_shop_customer.id')
        ->select('sc_historial_pagos.*', 
            'sc_shop_order.first_name', 
            'sc_shop_order.last_name', 
            'sc_convenios.lote', 
            'sc_convenios.nro_convenio', 
            'sc_metodos_pagos.name as metodoPago', 
            'sc_convenios.total as cb_total',  
            'sc_shop_order_detail.name as nombre_product', 
            'sc_shop_order_detail.qty as cantidad', 
            'sc_shop_order_detail.total_price as tota_product', 
            'sc_convenios.fecha_maxima_entrega', 
            'sc_convenios.nro_coutas as cuotas_pendiente', 
            'sc_shop_customer.address1 as direccion', 
            'sc_shop_order.cedula', 
            'sc_shop_order.vendedor_id')->get();


            $monto_cuota_pendiente=0;
            $order = AdminOrder::getOrderAdmin($id);
            $historialPago = HistorialPago::where('order_id',$id)->whereIn('payment_status',[3,4,5,6])
            
            ->orderBy('nro_coutas')->get();
        $cuota_pendientes = HistorialPago::where('order_id', $id)
        ->whereNotIn('payment_status',[3,4,5,6])

        ->orderBy('nro_coutas')->first();

                $cuota_pendiente = 0;

                if ($cuota_pendientes != null) {
                    if ($cuota_pendientes->exists()) {
                        $cuota_pendiente = $cuota_pendientes->importe_couta;
                    }
                }

            
        $nro_total_pagos = 0;
      

        $convenio = Convenio::where('order_id', $id)->first();


        $dataTr = [];


        $total_usd_pagado = 0;
        $vendedor = '';
 

        if (!$historialPago->count() >0) {
            return redirect('/')
                ->with(['error' => 'no se encontraron pagos reportado']);
        }
        

        $pagado = 0;
        $total_bs=0;

    
        foreach($orderList as $row){



            $user_roles = '';

       
           
            $nro_total_pagos++;


            $statusPayment = ShopPaymentStatus::pluck('name', 'id')->all();
             $styleStatusPayment = $statusPayment;
            array_walk($styleStatusPayment, function (&$v, $k) {
                $v = '<span class="text-black badge badge-' . (AdminOrder::$mapStyleStatus[$k] ?? 'light') . '">' . $v . '</span>';
            });


         
            $pagado += $row->importe_couta;



            $fecha_formateada = date('d-m-Y', strtotime($row->fecha_pago));


            $list_usuarios = $user_roles->name ?? 'N/A';
            $moneda = $row->moneda;
            $monto = $row->importe_pagado;
            $total_bs += round($monto * $row->tasa_cambio, 2);

            if ($moneda == 'USD') {
                // El monto está en dólares
                $monto_dolares = round($monto, 2);
                $monto_bolivares = round($monto * $row->tasa_cambio, 2);
                $Referencia = $monto_bolivares."Bs";
                $diVisA = $moneda;
                $Reportado = $monto;
            } elseif ($moneda == 'Bs') {
                // El monto está en bolívares
                $monto_bolivares = round($monto, 2);
                $monto_dolares = round($monto / $row->tasa_cambio, 2);
                $Referencia = $monto_dolares."$";
                $diVisA = $moneda;
                $Reportado = $monto;

            }


            $dataTr[$row->id] = [
                'N° de Pago' => $row->nro_coutas,
                'MONTO' => $row->importe_couta . '$',
                'Reportado' => $Reportado ?? 0,
                'DIVISA' => $diVisA,
                'CONVERSION' => $Referencia  ,
                'tasa_cambio' => $row->tasa_cambio ?? 0,
                'estatus' => $styleStatusPayment[$row->payment_status],
                'FORMA_DE_PAGO' => $row->metodo_pago->name ?? '',
                'REFRENCIA' => $row->referencia,
                'FECHA_DE_PAGO' => $fecha_formateada

            ];


        } //fin foreach

        $fechaActual = Carbon::now()->format('d \d\e F \d\e Y');


        $cliente = SC_shop_customer::where('id', $order->customer_id)->first();




        $data['id_solicitud'] = $order->id ?? 0;

        $data['descuento'] = $order->discount ?? 0;
        $data['subtotal'] = $order->subtotal ?? 0;
        $data['totales'] = $order->total;
        $data['emitido_por'] = $emitido_por ?? '';
        $data['totalPor_pagar'] = $order->total - $pagado;
        $data['cliente'] = $cliente->first_name . ' ' . $cliente->last_name ?? '';
        $data['vendedor'] = $user_roles->name ?? '';
        $data['cedula'] = $order->cedula ?? '';
        $data['cuota_pendiente'] =$cuota_pendiente;
        $data['lote'] = $convenio->lote ?? '';
        $data['total_bs'] = $total_bs ;
        
        $data['direccion'] = $cliente->address1 ?? '';
        $data['total_monto_pagado'] = $pagado;
        $data['total_usd_pagado'] = $total_usd_pagado;
        $data['Cuotas_Pendientes'] =  round($convenio->nro_coutas -$nro_total_pagos < 0 ? 0 :  $convenio->nro_coutas -$nro_total_pagos);
        $data['fecha_pago'] = $fechaActual ?? '';
        $data['order_id'] = $order->id ?? '';
        $data['nro_convenio'] = $convenio->nro_convenio ?? '';
        $data['order'] =  $cuota_pendiente;

        $data['fecha_maxima_entrega'] = $order->fecha_maxima_entrega ? $this->fechaEs($order->fecha_maxima_entrega) : '';
               
    

                return view($this->templatePath.'.screen.vista_qr')->with($data);
    }


}
