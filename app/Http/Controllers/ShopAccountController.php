<?php

namespace App\Http\Controllers;

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
use Cart;
use Illuminate\Support\Facades\File;

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
        $Payment->idNumber = '11994584'; //Número de cédula
      
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

        $PaymentProcess = new Biopago("72426762", "n3yENa9n"); //Instanciación de la API de pago con usuario y clave
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
            'metodo_pago_id' =>3,
            'fecha_pago' =>  $hoy,
            'importe_pagado' =>$Payment->amount,
            'comment' =>'BDV',
            'moneda' =>'Bs',
            'tasa_cambio' => $tasa_cambio,
            'comprobante'=>   '',
            'payment_status' => 1
   
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
                if (!empty($convenio) && $odenr->modalidad_de_compra == 1) $Combenio = $convenio;
            }
        }

        if (!isset($documento[0]['id_usuario']) == $id) {
            $dato = "Para procesar sus solicitudes de compras, se requiere que adjunte Cedula, RIF y constancia de trabajo";
        } else $dato = "";


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

        $v =  $this->validator($data);
        if ($v->fails()) {
            return redirect()->back()
                ->withErrors($v)
                ->withInput();
        }
        $user = $this->updateCustomer($data, $cId);

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
        $customer = auth()->user();
        $id = $customer['id'];
        $referencia = SC_referencia_personal::where('id_usuario', $id)->get();
        $order = AdminOrder::where('customer_id', $id)->get();
        $Combenio = [];
        $Order_resultado = [];
        if (!empty($order)) {
            $referencia = SC_referencia_personal::where('id_usuario', $id)->get();
            foreach ($order as $odenr) {
                $Order_resultado = $odenr;
                $convenio = Convenio::where('order_id', $odenr->id)->get();

                $productoDetail = shop_order_detail::where('id' , $id)->get();
                
                if (!empty($convenio) && $odenr->modalidad_de_compra == 1) $Combenio = $convenio;
            }
        }

        $statusOrder = ShopOrderStatus::getIdAll();
        sc_check_view($this->templatePath . '.account.order_list');
        return view($this->templatePath . '.account.order_list')
            ->with(
                [
                    'title'       => sc_language_render('customer.order_history'),
                    'statusOrder' => $statusOrder,
                    'orders'      => (new ShopOrder)->profile()->getData(),
                    'customer'    => $customer,
                    'order'    => $Order_resultado,
                    'productoDetail' => $productoDetail,
                    'combenio'    => $Combenio,
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


        if ($order->modalidad_de_compra == 0) {
            $historial_pagos =   HistorialPago::where('order_id', $id)->where('payment_status', '<>', 1)->orderBy('id', 'desc')->get();
        } {
            $historial_pagos =   HistorialPago::where('order_id', $id)->orderBy('fecha_venciento')->get();
        }





        $id = $customer['id'];
        $referencia = SC_referencia_personal::where('id_usuario', $id)->get();
        $documento = SC__documento::where('id_usuario', $id)->get();

        if (!isset($documento[0]['id_usuario']) == $id) {
            $dato = "Para procesar sus solicitudes de compras, se requiere que adjunte Cedula, RIF y constancia de trabajo";
        } else {
            $dato = "";
        }
        sc_check_view($this->templatePath . '.account.order_detail');
        return view($this->templatePath . '.account.order_detail')
            ->with(
                [
                    'title'           => $title,
                    'referencia'           => $referencia,
                    'statusOrder'     => $statusOrder,
                    'mensaje'     => $dato,
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

    public function reportarPago(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            $id = $params[1] ?? '';
            sc_lang_switch($lang);
        } else {
            $id = $params[0] ?? '';
        }
        $customer = auth()->user();
        $pago = explode("?", request('id_pago'));

      

        

        $order = ShopOrder::where('id', $id)->where('customer_id', $customer->id)->first();

        // $convenio = Convenio::where('order_id', $order->id)->first()->pluck('total');
        // dd($convenio);
       





        $referencia = SC_referencia_personal::where('id_usuario', $id)->get();
        $id_pago = request('id_pago');


        $historial_pago = HistorialPago::where('id', $id_pago)->first();
        $metodos_pagos = MetodoPago::all();
        sc_check_view($this->templatePath . '.account.reportar_pago');
        return view($this->templatePath . '.account.reportar_pago')
            ->with(
                [
                    'title'           => 'Reportar pago',
                    'id_pago' => $id_pago,
                    'lisPago' =>      $pago[1] ?? "",

                    'historial_pago' => $historial_pago,
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

        $order = AdminOrder::where('customer_id',$id1)->get();
        $referencia = SC_referencia_personal::where('id_usuario', $id1)->get();
        $historial_pagos=   HistorialPago::where('customer_id', $id1)->where('payment_status', '<>', 1)
        ->orderByDesc('id','DESC')->get();



        sc_check_view($this->templatePath . '.account.historial_pagos');
        return view($this->templatePath . '.account.historial_pagos')
            ->with(
                [
                    'title'           => 'Historial de pagos',
                    'customer'        => $customer,
                    'referencia'        => $referencia,
                    'layout_page'     => 'shop_profile',
                    'historial_pagos' => $historial_pagos,
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
                if (!empty($convenio) && $odenr->modalidad_de_compra == 1) $Combenio = $convenio;
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

            
                   
        

                    $Moneda_CAMBIOBS = sc_currency_all();
                    foreach($Moneda_CAMBIOBS as $cambio){
                        if($cambio->name == "Bolivares"){
                          
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
                $number2 =  $monto*$cod_bolibares;

                $cuotas = $dato_usuario[0]['cuotas'];
                if($dato_usuario[0]['abono_inicial'] >0){
                    $totalinicial=($dato_usuario[0]['abono_inicial']*$dato_usuario[0]['subtotal'])/100;
                    $monto = $dato_usuario[0]['subtotal'];
                    $monto = $monto - $totalinicial;
                    $number1 =  $monto/$dato_usuario[0]['cuotas'];
                    $cuotas = $number1;
                    $number2 =  $monto*$cod_bolibares;
                   
                  }

                  
                  
                    

                foreach($borrado_html as $replacee){
                    $dataFind = [
                        'cod_nombre',
                        'cod_apellido',
                        'cod_direccion',
                        'cod_estado',
                        'cod_municipio',
                        'cod_parroquia',
                        'cod_Cedula',
                        'cod_estado_civil',
                        'cod_Nacionalidad',
                        'cod_modalidad_pago',
                        'cod_dia',
                        'cod_cuotas',
                        'Cod_Cuota_total',
                        'Cod_cuotas_entre_precio_text',
                        'cod_mespago',
                        'cod_fecha_entrega',
                        'cod_subtotal',
                        'cod_bolivar_text',
                        'cod_bolibares',
                        'nombreProduct',
                        'cod_telefono',
                        'cod_email',
                        'cod_doreccion',
                        'cod_fecha_actual',
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
                        'cod_dia'=> $letraconvertir_nuber->decenass($dato_usuario[0]['cuotas']),
                        'cod_cuotas'=>  $dato_usuario[0]['cuotas'],
                        'Cod_Cuota_total'=> number_format($cuotas ,2 ,',', ' '),
                        'Cod_cuotas_entre_precio_text'=> $letraconvertir_nuber->convertir1($number1),
                        'cod_mespago' => $cod_diaMes ,
                        'cod_fechaEntrega' =>$convenio->fecha_maxima_entrega ?? "",
                        $monto ,
                        'cod_bolivar_text'=> $letraconvertir_nuber->convertir2($number2),
                        'cod_bolibares'=> number_format($number2, 2 ,',', ' '),
                        $dato_usuario[0]['nombreProduct'] ,
                        $dato_usuario['phone'],
                        $dato_usuario['email'],
                        $dato_usuario['address1'],
                        'cod_Fecha_De_Hoy'=> date('d-m-y'),
                        
                    ];
            
                    $resultado = str_replace($dataFind, $dataReplace, $replacee->contenido);
                }
                

            //     return view($this->templatePath.'.screen.borrador_pdf',
            //     ['borrado_html'=>$resultado],
                
            // );
            $pdf = Pdf::loadView($this->templatePath.'.screen.borrador_pdf', 
                    ['borrado_html'=> $resultado],
                

                    )->setOptions(['defaultFont' => 'sans-serif']);

                    return $pdf->stream();

    }

}
