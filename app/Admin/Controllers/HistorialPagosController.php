<?php
namespace App\Admin\Controllers;

use SCart\Core\Admin\Admin;
use App\Http\Controllers\NumeroLetra;
use SCart\Core\Admin\Controllers\RootAdminController;
use Illuminate\Http\Request;
use App\Models\HistorialPago;
use App\Models\Convenio;
use App\Models\Catalogo\PaymentStatus;
use SCart\Core\Front\Models\ShopOrder;
use App\Models\Catalogo\MetodoPago;
use App\Models\AdminOrder;
use App\Models\SC_admin_role;
use App\Models\ClientLevelCalculator;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\Parroquia;
use App\Models\Sc_plantilla_convenio;
use App\Models\Declaracion_jurada;
use App\Models\SC_shop_customer;
use App\Models\shop_order_detail;
use SCart\Core\Admin\Models\AdminUser;
use App\Models\TipoCambioBcv;
use SCart\Core\Front\Models\ShopOrderTotal;
use SCart\Core\Front\Models\ShopCurrency;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use SCart\Core\Front\Models\ShopPaymentStatus;
use SCart\Core\Front\Models\ShopOrderDetail;
use DateTime;
use DateInterval;

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

    public function index()
    {




        $data = [
            'title' => 'Historial de pagos',
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route_admin('admin_customer.delete'),
            'removeList' => 0,
            // 1 - Enable function delete list item
            'buttonRefresh' => 1,
            // 1 - Enable button refresh
            'buttonSort' => 1,
            // 1 - Enable button sort
            'css' => '',
            'js' => '',
        ];



        //Process add content
        $data['menuRight'] = sc_config_group('menuRight', \Request::route()->getName());
        $data['menuLeft'] = sc_config_group('menuLeft', \Request::route()->getName());
        $data['topMenuRight'] = sc_config_group('topMenuRight', \Request::route()->getName());
        $data['topMenuLeft'] = sc_config_group('topMenuLeft', \Request::route()->getName());
        $data['blockBottom'] = sc_config_group('blockBottom', \Request::route()->getName());

        $listTh = [
            'Nro orden' => 'Nro de orden /<br> Cliente',
            'Importe pagado' => 'Pagado',
            'Referencia' => 'Referencia',
            'Metodo de pago' => 'Metodo',
            'Estatus' => 'Estatus',
            'Comentario' => 'Comentario',
            'fecha_pago' => 'Fecha pago',
            'Creado' => 'Creado',
            'action' => sc_language_render('action.title'),
        ];
        $sort_order = sc_clean(request('sort_order') ?? 'id_desc');




        $keyword = sc_clean(request('keyword') ?? '');
        $fechas1 = sc_clean(request('fecha1') ?? '');
        $fechas2 = sc_clean(request('fecha2') ?? '');
        $statusPayment = PaymentStatus::select(['name', 'id'])->get();







        foreach ($statusPayment as $key => $value) {
            $arrSort[$value->id] = $value->name;
            # code...
        }



        $arrSort['0'] = 'Todos';



        $dataSearch = [
            'keyword' => $keyword,
            'fechas1' => $fechas1,
            'fechas2' => $fechas2,
            'sort_order' => $sort_order,
            'arrSort' => $arrSort,
        ];



        $dataTmp = $this->getPagosListAdmin($dataSearch);








        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $Referencia = "";
            $NOta = "";

            $order = AdminOrder::getOrderAdmin($row->order_id);
            $btn_estatus = '';
            $btn_ver_pago_estatus = '';
            if ($row->payment_status == 2):
                $btn_estatus = '<a href="#" data-id="' . $row->id . '"><span  data-id="' . $row->id . '" title="Cambiar estatus" type="button" class="btn btn-flat mostrar_estatus_pago btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;';
            endif;
            //whereIn('payment_status',[3,4,5,6])-
            if ($row->payment_status == 2 || $row->payment_status == 5  || $row->payment_status == 6 || $row->payment_status == 4 || $row->payment_status == 3  ):
                $btn_ver_pago_estatus = ' <button  onclick="obtener_detalle_pago(' . $row->id . ')" ><span title="Detalle del pago" type="button" class="btn btn-flat btn-sm btn-success"><i class="fas fa-search"></i></span></button>';
                $NOta = ' <a   href="' . sc_route_admin('notas.entrega') . '?notas_entrega=true&keyword=' . $row->order_id . '"><span title="Nota de entrega" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fas fa-clipboard"></i></span></a>&nbsp;';

            endif;


            if ($row->comprobante) {
                $Referencia = ' <a   href="' . sc_file($row->comprobante) . '"><span title="Descargar Referencia" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-file"></i></span></a>&nbsp;';

            }





            $dataTr[$row->id] = [

                'Nro orden' => $row->order_id . '<br>' . $order->first_name . '  ' . $order->last_name,
                'Importe pagado' => $row->importe_pagado,
                'Referencia' => $row->referencia,

                'Metodo de pago' => isset($row->metodo_pago->name) ? $row->metodo_pago->name : '',
                'Estatus' => $row->estatus->name . '<br><small>' . $row->observacion . '</small>',
                'Comentario' => $row->comment,
                'fecha_pago' => $row->fecha_pago,

                'Creado' => $row->created_at->format('d/m/Y'),




                'action' => '
                ' . $btn_estatus . $btn_ver_pago_estatus . '

                   ' . $Referencia . '
                
                    <a href="' . sc_route_admin('admin_order.detail', ['id' => $row->order_id ? $row->order_id : 'not-found-id']) . '"><span title="Ir al pedido" type="button" class="btn btn-flat btn-sm btn-info"><i class="fas fa-arrow-right"></i></span></a>&nbsp;



                    ' . $NOta . '


                    
                    '



            ];
        }

        $data['listTh'] = $listTh;
        $data['statusPayment'] = $statusPayment;


        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links($this->templatePathAdmin . 'component.pagination');
        $data['resultItems'] = sc_language_render('admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'total' => $dataTmp->total()]);


        //=menuRight

        //menuSort

        //=menuSort
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }
        $data['urlSort'] = sc_route_admin('historial_pagos.index', request()->except(['_token', '_pjax', 'sort_order']));
        $data['optionSort'] = $optionSort;

        //menuSearch
        $data['topMenuRight'][] = '
                <form action="' . sc_route_admin('historial_pagos.index') . '" id="button_search">
                
                <div class="row align-items-center">
                <div class="col-md-3 form-group">
                        <label>' . 'Status' . ':</label>
                        <div class="input-group">
                        <select class="form-control rounded-0" name="sort_order" id="">
                       
                        <option value=""> Búsqueda por Estatus</option>
                        <option value="1">No pagado</option><option value="2">Pago reportado(Pendiente)</option><option value="3">Pago Pendiente</option><option value="4">Pago en mora (Vencido)</option><option value="5">Pagado</option><option value="0">Todos</option>
                
                      </select>
                        </div>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>' . sc_language_render('action.from') . ':</label>
                        <div class="input-group">
                        <input type="text" name="fecha1"  class="form-control input-sm date_time rounded-0" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd"/> 
                        </div>
                    </div>
               
               
                    <div class=" col-md-3 form-group">
                        <label>' . sc_language_render('action.to') . ':</label>
                        <div class="input-group">
                        <input type="text" name="fecha2" class="form-control input-sm date_time rounded-0" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd"  /> 
                        </div>
                    </div>

                    
                   
               
                      
                <div class="col-md-3 d-flex mt-4 align-items-center   form-group ">
                
              
                <input type="text" name="keyword" class="form-control input-sm  " placeholder="Buscar por numero de orden" value="' . $keyword . '">
                <button type="submit"  class="btn btn-primary"><i class="fas fa-search"></i></button>
                
               
                   
                
            </div>
           
                </div>
                
           
                

                
                </form>';


        //=menuSearch



        return view($this->templatePathAdmin . 'pagos.detalle')
            ->with($data);

    }

    /**
     *  function create para crear un nuevo pago post recibe los datas mediante el request
     *
     * @return void
     */
    public function postCreate(Request $request)
    {


        //si la validacion falla responde con un json Validator

        $validator = Validator::make($request->all(), [
            'importe_couta' => 'required',
            'order_id' => 'required',
            'fecha_vencimiento' => 'required',
            'nro_couta' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => 1,
                'msg' => $validator->errors()->all(),
            ]);
        }
        $order = ShopOrder::where('id',$request->order_id)->first();
        $data_pago = [
            'nro_coutas' => $request->nro_couta,
            'customer_id' => $order->customer_id,
            'order_id' => $request->order_id,
            'importe_couta' => $request->importe_couta,
            'fecha_venciento' => $request->fecha_vencimiento,
            'order_detail_id' => 0,
            'payment_status' => $request->payment_status ?? 1

        ];

      
        HistorialPago::create($data_pago);

        // reponse json
        return response()->json([
            'error' => 0,
            'msg' => 'Pago creado correctamente',
        ]);



    }
    public function detalle()
    {
        $data = [
            'title' => 'Detalle de pago',
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route_admin('admin_customer.delete'),
            'removeList' => 0,
            // 1 - Enable function delete list item
            'buttonRefresh' => 0,
            // 1 - Enable button refresh
            'buttonSort' => 1,
            // 1 - Enable button sort
            'css' => '',
            'js' => '',
        ];
        //Process add content
        $data['menuRight'] = sc_config_group('menuRight', \Request::route()->getName());
        $data['menuLeft'] = sc_config_group('menuLeft', \Request::route()->getName());
        $data['topMenuRight'] = sc_config_group('topMenuRight', \Request::route()->getName());
        $data['topMenuLeft'] = sc_config_group('topMenuLeft', \Request::route()->getName());
        $data['blockBottom'] = sc_config_group('blockBottom', \Request::route()->getName());

        $listTh = [
            'Nro orden' => 'Nro de orden',
            'Importe pagado' => 'Importe pagado',
            'Referencia' => 'Referencia',
            'Metodo de pago' => 'Metodo de pago',
            'Estatus' => 'Estatus',
            'Observación' => 'Comentario',
            'Creado' => 'Creado',
            'action' => sc_language_render('action.title'),
        ];
        $sort_order = sc_clean(request('sort_order') ?? 'id_desc');
        $id_orden = request('id');


        $keyword = sc_clean(request('keyword') ?? '');
        $statusPayment = PaymentStatus::select(['name', 'id'])->get();

        $arrSort = ['0' => 'Todos'];

        foreach ($statusPayment as $key => $value) {
            $arrSort[$value->id] = $value->name;
            # code...
        }




        $dataSearch = [
            'keyword' => $keyword,
            'sort_order' => $sort_order,
            'arrSort' => $arrSort,
        ];

        $dataTmp = (new HistorialPago);
        if ($sort_order && array_key_exists($sort_order, $arrSort)) {



            $dataTmp = $dataTmp->Where('payment_status', $sort_order)
                ->where('order_id', $id_orden)
                ->orderByDesc('id')
                ->paginate(20);
        } else {

            $dataTmp = $dataTmp
                ->where('order_id', $id_orden)
                ->orderByDesc('id')
                ->paginate(20);
        }




        if (isset($dataTmp[0]->cliente->first_name)) {
            $data['title'] = 'Detalle de pago- Cliente: ' . $dataTmp[0]->cliente->first_name . '  ' . $dataTmp[0]->cliente->last_name;
        }


        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[$row->id] = [
                'Nro orden' => $row->order_id,
                'Importe pagado' => $row->importe_pagado,
                'Referencia' => $row->referencia,

                'Metodo de pago' => $row->metodo_pago->name,
                'Estatus' => $row->estatus->name . '<br><small>' . $row->observacion . '</small>',
                'Comentario' => $row->comment,
                'Creado' => $row->created_at->format('d/m/Y'),


                'action' => '
                    <a href="#" data-id="' . $row->id . '"><span  data-id="' . $row->id . '" title="Cambiar estatus" type="button" class="btn btn-flat mostrar_estatus_pago btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                    <a target="_blank" href="' . sc_file($row->comprobante) . '"><span title="Descargar Referencia" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-file"></i></span></a>&nbsp;


                    
                    '
                ,
            ];
        }

        $data['listTh'] = $listTh;
        $data['statusPayment'] = $statusPayment;


        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links($this->templatePathAdmin . 'component.pagination');
        $data['resultItems'] = sc_language_render('admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'total' => $dataTmp->total()]);

        //menuRight
        $data['menuRight'][] = '<a href="' . sc_route_admin('admin_customer.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
                           <i class="fa fa-plus" title="' . sc_language_render('admin.add_new') . '"></i>
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

        return view($this->templatePathAdmin . 'pagos.detalle')
            ->with($data);
    }

    public function reportarPago(...$params)
    {

        $id = $params[0] ?? '';


        $data = [
            'title' => 'Reportar Pago',
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route_admin('admin_customer.delete'),
            'removeList' => 0,
            // 1 - Enable function delete list item
            'buttonRefresh' => 0,
            // 1 - Enable button refresh
            'buttonSort' => 1,
            // 1 - Enable button sort
            'css' => '',
            'js' => '',
        ];
        //Process add content
        $data['menuRight'] = sc_config_group('menuRight', \Request::route()->getName());
        $data['menuLeft'] = sc_config_group('menuLeft', \Request::route()->getName());
        $data['topMenuRight'] = sc_config_group('topMenuRight', \Request::route()->getName());
        $data['topMenuLeft'] = sc_config_group('topMenuLeft', \Request::route()->getName());
        $data['blockBottom'] = sc_config_group('blockBottom', \Request::route()->getName());

        $id_orden = request('id');
        $id_pago = request('id_pago');
        $data['id_pago'] = $id_pago;

        $historial_pago = HistorialPago::where('id', $id_pago)->first();

        $order = ShopOrder::where('id', $id_orden)->first();
        $statusPayment = ShopPaymentStatus::whereIn('id', [ 2, 3, 4, 5, 6])->get();
        $data['order'] = $order;
        $data['statusPayment'] = $statusPayment;
        $data['historial_pago'] = $historial_pago;

        $data['metodos_pagos'] = MetodoPago::all();


        return view($this->templatePathAdmin . 'pagos.crear_pago')
            ->with($data);

    }


    public function crear_tasa_cambio()
    {




        $data = [
            'title' => 'Registrar Tasa de cambio',
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => '',
            'removeList' => 0,
            // 1 - Enable function delete list item
            'buttonRefresh' => 0,
            // 1 - Enable button refresh
            'buttonSort' => 1,
            // 1 - Enable button sort
            'css' => '',
            'js' => '',
        ];
        //Process add content
        $data['menuRight'] = sc_config_group('menuRight', \Request::route()->getName());
        $data['menuLeft'] = sc_config_group('menuLeft', \Request::route()->getName());
        $data['topMenuRight'] = sc_config_group('topMenuRight', \Request::route()->getName());
        $data['topMenuLeft'] = sc_config_group('topMenuLeft', \Request::route()->getName());
        $data['blockBottom'] = sc_config_group('blockBottom', \Request::route()->getName());




        return view($this->templatePathAdmin . 'screen.tasa_cambio')
            ->with($data);

    }


    public function list_tasa_cambio()
    {



        $tipocambio = TipoCambioBcv::orderByDesc('fecha')->paginate(20);

        $data = [
            'title' => ' Tasa de cambio',
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => '',
            'tipocambio' => $tipocambio,
            'removeList' => 0,
            // 1 - Enable function delete list item
            'buttonRefresh' => 0,
            // 1 - Enable button refresh
            'buttonSort' => 1,
            // 1 - Enable button sort
            'css' => '',
            'js' => '',
        ];
        //Process add content
        $data['menuRight'] = sc_config_group('menuRight', \Request::route()->getName());
        $data['menuLeft'] = sc_config_group('menuLeft', \Request::route()->getName());
        $data['topMenuRight'] = sc_config_group('topMenuRight', \Request::route()->getName());
        $data['topMenuLeft'] = sc_config_group('topMenuLeft', \Request::route()->getName());
        $data['blockBottom'] = sc_config_group('blockBottom', \Request::route()->getName());



        return view($this->templatePathAdmin . 'screen.list_tasa_cambio')
            ->with($data);

    }


    public function post_crear_tasa(Request $request)
    {

        $request->validate([

            'valor' => 'required',
            'moneda' => 'required',
            'fecha' => 'required'
        ]);



        $data_pago = [
            'valor' => $request->valor,
            'moneda' => $request->moneda,
            'fecha' => $request->fecha,


        ];

        $tipo_cambio = TipoCambioBcv::where('fecha', $request->fecha)->first();


        if ($tipo_cambio == null) {
            TipoCambioBcv::create($data_pago);
        } else {
            TipoCambioBcv::where('id', $tipo_cambio->id)
                ->update($data_pago);

        }
        if ($request->fecha == date('Y-m-d')) {
            //  exchange_rate
            $currency = ShopCurrency::Where('code', 'Bs')->update([
                'exchange_rate' => $request->valor,

            ]);

        }


        return redirect(sc_route_admin('list_tasa_cambio'))
            ->with(['success' => 'Su tasa ha sido registrada de forma exitosa']);
    }

    public function postReportarPago(Request $request)
    {

        $request->validate([
            'capture' => 'mimes:pdf,jpg,jpge,png|max:2048',
            'referencia' => 'required',
            'order_id' => 'required'
        ]);



        $path_archivo = '';

        if ($request->capture) {
            $fileName = time() . '.' . $request->capture->extension();
            $path_archivo = 'data/clientes/pagos' . '/' . $fileName;
            $request->capture->move(public_path('data/clientes/pagos'), $fileName);

        }



        $id_pago = $request->id_pago;
        $order = AdminOrder::getOrderAdmin($request->order_id);
        $importe_cuota = $request->monto;
        if ($request->moneda == 'Bs') {
            $importe_cuota = number_format($request->monto / $request->tipo_cambio, 2);
        }
        $data_pago = [
            'order_id' => $request->order_id,
            'customer_id' => $order->customer_id,
            'referencia' => $request->referencia,
            'order_detail_id' => 0,
            'importe_couta' => $importe_cuota,
            'producto_id' => $request->product_id,
            'metodo_pago_id' => $request->forma_pago,
            'fecha_pago' => $request->fecha,
            'importe_pagado' => $request->monto,
            'comment' => $request->observacion,
            'moneda' => $request->moneda,
            'tasa_cambio' => $request->tipo_cambio,
            'comprobante' => $path_archivo,
            'payment_status' => $request->statusPayment ?? 5

        ];
        if ($id_pago == null) {
            HistorialPago::create($data_pago);
        } else {
            HistorialPago::where('id', $id_pago)
                ->update($data_pago);

        }


            // Obtén el ID del cliente
            $clientId = $order->customer_id;
            // Calcula el nivel del cliente
            $calculator = new ClientLevelCalculator();
            $level = $calculator->calculate($clientId);
            // Obtén el cliente a partir de su ID
            $client = SC_shop_customer::find($clientId);

            // Actualiza el nivel del cliente
            $client->nivel = $level;

            // Guarda los cambios en la base de datos
            $client->save();



        return redirect(sc_route_admin('admin_order.detail', ['id' => $request->order_id]))
            ->with(['success' => 'Su pago ha sido reportado de forma exitosa']);

    }
    public static function getPagosListAdmin(array $dataSearch)
    {
        $keyword = $dataSearch['keyword'] ?? '';
        $fechas1 = $dataSearch['fechas1'] ?? '';
        $fechas2 = $dataSearch['fechas2'] ?? '';
        $email = $dataSearch['email'] ?? '';
        $from_to = $dataSearch['from_to'] ?? '';
        $end_to = $dataSearch['end_to'] ?? '';
        $sort_order = $dataSearch['sort_order'] ?? '';
        $arrSort = $dataSearch['arrSort'] ?? '';
        $order_status = $dataSearch['order_status'] ?? '';
        $storeId = $dataSearch['storeId'] ?? '';
        $orderList = HistorialPago::join('sc_shop_order', 'sc_historial_pagos.order_id', '=', 'sc_shop_order.id')

            ->select('sc_historial_pagos.*', 'sc_shop_order.first_name', 'sc_shop_order.last_name');
        if ($storeId) {
            $orderList = $orderList->where('store_id', $storeId)->where('sc_historial_pagos.payment_status', '<>', 1)
                ->orderBy('fecha_pago', 'desc');
        }

        if ($order_status) {
            $orderList = $orderList->where('status', $order_status);
        }
        if ($keyword) {

            $orderList = $orderList->where(function ($sql) use ($keyword) {
                $sql->Where('order_id', $keyword);
            });
        }
        if ($fechas1 || $fechas2 || $keyword) {
            $orderList = $orderList->where(function ($sql) use ($fechas1, $fechas2, $keyword) {
                if ($keyword) {
                    $sql->Where('order_id', $keyword);
                }
                if ($keyword && $fechas1 && $fechas2) {
                    $sql->Where('order_id', $keyword)->Where('fecha_pago', '>=', $fechas1)
                    ;

                }
                if ($keyword && $fechas1 && $fechas2) {
                    $sql->Where('order_id', $keyword)->Where('fecha_pago', '<=', $fechas2)
                    ;

                }


            });

        }
        if ($fechas1 || $fechas2) {
            $orderList = $orderList->where(function ($sql) use ($fechas1, $fechas2, $sort_order) {

                if ($fechas1 && $fechas2) {
                    $sql->Where('fecha_pago', '>=', $fechas1)
                    ;
                }
                if ($fechas1 && $fechas2) {
                    $sql->Where('fecha_pago', '<=', $fechas2)
                    ;
                }

            });


        }

        if ($email) {
            $orderList = $orderList->where(function ($sql) use ($email) {
                $sql->Where('email', 'like', '%' . $email . '%');
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
            if ($sort_order == 4) {
                $fecha_hoy = date('y-m-d');
                $orderList = $orderList->Where('sc_historial_pagos.payment_status', $sort_order);

            } else if ($sort_order == 5) {
                $orderList = $orderList->Where('sc_historial_pagos.payment_status', $sort_order);
            } else if ($sort_order == 6) {
                $fecha_hoy = date('y-m-d');
                $orderList = $orderList->Where('sc_historial_pagos.payment_status', $sort_order)->Where('fecha_pago', '=', $fecha_hoy);
            } else if ($sort_order == 2) {
                $orderList = $orderList->Where('sc_historial_pagos.payment_status', $sort_order);
            } else if ($sort_order == 1) {
                $orderList = $orderList->Where('sc_historial_pagos.payment_status', $sort_order);
            } else if ($sort_order == 3) {
                $orderList = $orderList->Where('sc_historial_pagos.payment_status', $sort_order);

            }


        } else {
            $orderList->where('sc_historial_pagos.payment_status', '<>', 5)
                ->orderBy('fecha_pago', 'desc');
        }
        $orderList = $orderList->paginate(20);

        return $orderList;
    }

    /**
     * obtener la lista de pagos via ajax func getpagosajax where('sc_historial_pagos.order_id
     */

    public function getPagosAjax()
    {
        $result_pagos = HistorialPago::where('order_id', request()->pId)->get();
        $data_pagos = [];
        foreach ($result_pagos as $key => $item) {
            $item->fecha_pago = Carbon::parse($item->fecha_pago)->format('d-m-Y');
            $item->fecha_venciento = Carbon::parse($item->fecha_venciento)->format('d-m-Y');
            $data_pagos[] = $item;
            # code...
        }
        //   $fecha = Carbon::parse($fecha)->format('d-m-Y');
        /*$result_pagos->map(function($item){
        $item->fecha_pago =  $item->fecha_pago;
        $item->fecha_venciento =$item->fecha_pago;
        return $item;
        });*/

        return response()->json($data_pagos);

    }



    public static function getPagosListAdmin2(array $dataSearch)
    {


        $keyword = $dataSearch['keyword'] ?? '';
        $historial_pago = $dataSearch['historial_pago'] ?? '';
        $fechas1 = $dataSearch['fecha1'] ?? '';
        $fechas2 = $dataSearch['fecha2'] ?? '';
        $pdf_cobranzas = $dataSearch['pdf_cobranzas'] ?? '';
        $email = $dataSearch['email'] ?? '';
        $from_to = $dataSearch['from_to'] ?? '';
        $end_to = $dataSearch['end_to'] ?? '';
        $sort_order = $dataSearch['sort_order'] ?? '';
        $arrSort = $dataSearch['arrSort'] ?? '';
        $order_status = $dataSearch['order_status'] ?? '';
        $storeId = $dataSearch['storeId'] ?? '';
        $orderList = HistorialPago::join('sc_shop_order', 'sc_historial_pagos.order_id', '=', 'sc_shop_order.id')
            ->join('sc_convenios', 'sc_historial_pagos.order_id', '=', 'sc_convenios.order_id')->join('sc_metodos_pagos', 'sc_metodos_pagos.id', '=', 'sc_historial_pagos.metodo_pago_id')
            ->join('sc_shop_order_detail', 'sc_historial_pagos.order_id', '=', 'sc_shop_order_detail.order_id')
            ->join('sc_shop_customer', 'sc_shop_customer.id', '=', 'sc_shop_order.customer_id')
            ->orderBy('nro_coutas')
            ->select('sc_historial_pagos.*', 'sc_shop_order.first_name', 'sc_shop_order.last_name', 'sc_convenios.lote', 'nro_convenio', 'sc_shop_order.last_name', 'sc_metodos_pagos.name as metodoPago', 'sc_convenios.total as cb_total', 'sc_shop_order_detail.name as nombre_product', 'sc_shop_order_detail.qty as cantidad', 'sc_shop_order_detail.total_price as tota_product', 'sc_convenios.fecha_maxima_entrega', 'sc_convenios.nro_coutas as cuaotas_pendiente', 'sc_shop_customer.address1 as direccion', 'sc_shop_order.cedula', 'sc_shop_order.vendedor_id');







        if ($storeId) {
            $orderList = $orderList->where('store_id', $storeId)->where('sc_historial_pagos.payment_status', '<>', 2)
                ->orderBy('fecha_pago', 'desc');
        }


        if ($keyword) {
            $orderList->where('sc_historial_pagos.order_id', $keyword)
                ->whereIn('sc_historial_pagos.payment_status', [3, 4,5,6]);

        }

        if ($historial_pago && $keyword) {
            $orderList->whereIn('sc_historial_pagos.payment_status', [1, 5])
                ->where('sc_historial_pagos.order_id', $keyword);
        }

        if ($order_status) {

            $orderList = $orderList->where('status', $order_status);
        }


        if ($fechas1 || $fechas2) {
            $orderList = $orderList->where(function ($sql) use ($fechas1, $fechas2) {

                if ($fechas1) {
                    $sql->Where('fecha_pago', '=', $fechas1);

                    ;
                } else if ($fechas2) {
                    $fecha = explode('-', $fechas2);
                    $sql->whereYear('fecha_pago', $fecha[0])->whereMonth('fecha_pago', $fecha[1]);


                }






            });


        }

        if ($fechas1 && $pdf_cobranzas || $fechas2) {
            $orderList = $orderList->where(function ($sql) use ($fechas1, $fechas2, $pdf_cobranzas) {

                if ($fechas1) {
                    $sql->Where('fecha_pago', '=', $fechas1);

                    ;
                }
                if ($fechas2) {
                    $fechas2 = explode('-', $fechas2);
                    $sql->whereYear('fecha_pago', $fechas2[0])->whereMonth('fecha_pago', $fechas2[1]);


                }



            });


        }

        if ($email) {
            $orderList = $orderList->where(function ($sql) use ($email) {
                $sql->Where('email', 'like', '%' . $email . '%');
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
            if ($sort_order == 4) {
                $fecha_hoy = date('y-m-d');
                $orderList = $orderList->Where('sc_historial_pagos.payment_status', $sort_order);

            } else if ($sort_order == 5) {
                $orderList = $orderList->Where('sc_historial_pagos.payment_status', $sort_order);
            } else if ($sort_order == 6) {
                $fecha_hoy = date('y-m-d');
                $orderList = $orderList->Where('sc_historial_pagos.payment_status', $sort_order)->Where('fecha_pago', '=', $fecha_hoy);
            } else if ($sort_order == 2) {
                $orderList = $orderList->Where('sc_historial_pagos.payment_status', $sort_order);
            } else if ($sort_order == 1) {
                $orderList = $orderList->Where('sc_historial_pagos.payment_status', $sort_order);
            } else if ($sort_order == 3) {
                $orderList = $orderList->Where('sc_historial_pagos.payment_status', $sort_order);

            }


        } else {
            $orderList->where('sc_historial_pagos.payment_status', '<>', 2)
                ->orderBy('fecha_pago', 'desc');


        }
        $orderList = $orderList->paginate(20);

        return $orderList;
    }
    public function postCrearConvenio()
    {

        $data = request()->all();
        request()->validate([
            'c_order_id' => 'required',
            '_monto' => 'required',
            'c_fecha_inicial' => 'required',
            'nro_convenio' => 'required',
            'fecha_maxima_entrega' => 'required',

        ]);







        if (Convenio::where('nro_convenio', $data['nro_convenio'])->exists()) {
            return redirect()->back()
                ->with(['error' => 'Convenio ya creado']);
        } else {




            $estado = Estado::all();
            $municipio = Municipio::all();
            $parroquia = Parroquia::all();
            $order = ShopOrder::where('id', $data['c_order_id'])->first();
            $letraconvertir_nuber = new NumeroLetra;




            if (!$order) {
                return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
            }


            $usuario = SC_shop_customer::where('id', $order->customer_id)->get();
            $result = $usuario->all();
            $productoDetail = shop_order_detail::where('order_id', $data['c_order_id'])->get();
            $cantidaProduc = shop_order_detail::where('order_id', $data['c_order_id'])->count();
            $nombreProduct = [];
            $cuotas = [];
            $abono_inicial = [];
            $id_modalidad_pago = [];

            foreach ($productoDetail as $key => $p) {
                $nombreProduct = $p->name;
                $cuotas = $p->nro_coutas;
                $abono_inicial = $p->abono_inicial;
                $id_modalidad_pago = $p->id_modalidad_pago;
                $fecha_maxima_entrega = $p->fecha_maxima_entrega;
            }




            $nombreEstado = [];
            $nombreparroquias = [];
            $nombremunicipos = [];
            $dato_usuario = [];
            foreach ($result as $c) {
                foreach ($estado as $estados) {
                    if ($estados->codigoestado == $c['cod_estado']) {
                        $nombreEstado = $estados->nombre;
                    }
                    foreach ($municipio as $municipos) {
                        if ($municipos->codigomunicipio == $c['cod_municipio'])
                            $nombremunicipos = $municipos->nombre;
                    }
                    foreach ($parroquia as $parroquias) {
                        if ($parroquias->codigomunicipio == $c['cod_municipio']) {
                            $nombreparroquias = $parroquias->nombre;
                        }
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
                    'cod_estado' => $nombreEstado,
                    'cod_municipio' => $nombremunicipos,
                    'cod_parroquia' => $nombreparroquias,
                    'estado_civil' => $c['estado_civil'],
                    'nos_conocio' => $c->nos_conocio,

                    [

                        'subtotal' => $order['subtotal'],
                        'cantidaProduc' => $cantidaProduc,
                        'nombreProduct' => $nombreProduct,
                        'cuotas' => $cuotas,
                        'abono_inicial' => $abono_inicial,
                        'id_modalidad_pago' => $id_modalidad_pago

                    ]

                ];


            }



            $Moneda_CAMBIOBS = sc_currency_all();
            foreach ($Moneda_CAMBIOBS as $cambio) {
                if ($cambio->name == "Bolivares") {
                    $cod_bolibares = $cambio->exchange_rate;
                }
            }



            $borrado_html = [];
            $file_html = [];



            switch ($dato_usuario['natural_jurídica']) {
                case 'N':
                    $borrado_html = $abono_inicial > 0
                        ?
                        Sc_plantilla_convenio::where('id', 2)->first()->where('name', 'con_inicial')->get()

                        :
                        Sc_plantilla_convenio::where('id', 1)->first()->where('name', 'sin_inicial')->get();

                    break;
                case 'J':
                    $borrado_html = Sc_plantilla_convenio::where('id', 3)->first()->where('name', 'persona_juridica')->get();
                    break;
            }

            $file_html = Declaracion_jurada::all();

            $pieces = explode(" ", $dato_usuario['cedula']);
            if ($dato_usuario[0]['id_modalidad_pago'] == 3) {
                $mesualQuinsena = "MENSUAL";
                $cod_diaMes = "LOS DIAS " . $dato_usuario[0]['cuotas'] . " DE CADA MES";
            } else {
                $suma = $dato_usuario[0]['cuotas'] + $dato_usuario[0]['cuotas'];
                $mesualQuinsena = " QUINCENAL";
                $cod_diaMes = "LOS DIAS " . $dato_usuario[0]['cuotas'] . " Y " . $suma . " DE CADA MES";
            }
            if ($pieces[0] == "V")
                $Nacionalidad = "VENEZOLANO(A)";
            else
                $Nacionalidad = "Extranjer(A)";




            $monto = $dato_usuario[0]['subtotal'];
            $number1 = $dato_usuario[0]['subtotal'] / $dato_usuario[0]['cuotas'];
            $cuotas = $dato_usuario[0]['cuotas'];
            if ($dato_usuario[0]['abono_inicial'] > 0) {
                $totalinicial = ($dato_usuario[0]['abono_inicial'] * $dato_usuario[0]['subtotal']) / 100;
                $monto = $dato_usuario[0]['subtotal'];
                $monto = $monto - $totalinicial;
                $number1 = $monto / $dato_usuario[0]['cuotas'];
                $cuotas_entre_monto = $dato_usuario[0]['subtotal'] / $cuotas;
                $number2 = $monto * $cod_bolibares;

            }

            $number2 = $monto * $cod_bolibares;

            foreach ($borrado_html as $replacee) {
                $nro_convenio = $data['nro_convenio'];
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
                    '/\{\{\$nos_conocio\}\}/',
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
                    'numero_de_convenio' => $nro_convenio,
                    'razon_social' => $dato_usuario['razon_social'],
                    'rif' => $dato_usuario['rif'],
                    'nombre' => $dato_usuario['first_name'],
                    'apellido' => $dato_usuario['last_name'],
                    'direccion' => $dato_usuario['address1'],
                    'direccion2' => $dato_usuario['address2'] ?? 'no aplica',
                    'estado' => $dato_usuario['cod_estado'],
                    'municipio' => $dato_usuario['cod_municipio'],
                    'parroquia' => $dato_usuario['cod_parroquia'],
                    'cedula' => $dato_usuario['cedula'],
                    'nos_conocio' => $dato_usuario['nos_conocio'],
                    'estado_civil' => $dato_usuario['estado_civil'],
                    'nacionalidad' => $Nacionalidad,
                    $mesualQuinsena,
                    $letraconvertir_nuber->convertir1($cuotas),
                    number_format($cuotas),
                    number_format($number1, 2, ',', ' '),
                    $letraconvertir_nuber->convertir2($number1),
                    $cod_diaMes,
                    'fecha_entrega' => request()->fecha_maxima_entrega ?? 'no aplica',
                    $monto,
                    $letraconvertir_nuber->convertir2($number2),
                    number_format($number2, 2, ',', ' '),
                    $dato_usuario[0]['nombreProduct'],
                    $dato_usuario['phone'],
                    $dato_usuario['email'],
                    $this->fechaEs($order->fecha_primer_pago ?? date('d-m-y')),
                    sc_file(sc_store('logo', ($storeId ?? null))),
                    sc_file(sc_store('logo', ($storeId ?? null))),
                    'logo_waika' => sc_file(sc_store('logo', ($storeId ?? null))),
                    'logo_global' => sc_file(sc_store('logo', ($storeId ?? null))),
                ];
                $content = preg_replace($dataFind, $dataReplace, $replacee->contenido);
                $dataView = [
                    'content' => $content,
                ];

            }


            foreach ($file_html as $jurada) {
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
                    '/\{\{\$nos_conocio\}\}/',
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


                $dataReplaces = [
                    'numero_de_convenio' => $nro_convenio,
                    'razon_social' => $dato_usuario['razon_social'],
                    'rif' => $dato_usuario['rif'],
                    'nombre' => $dato_usuario['first_name'],
                    'apellido' => $dato_usuario['last_name'],
                    'direccion' => $dato_usuario['address1'],
                    'direccion2' => $dato_usuario['address2'] ?? 'no aplica',
                    'estado' => $dato_usuario['cod_estado'],
                    'municipio' => $dato_usuario['cod_municipio'],
                    'parroquia' => $dato_usuario['cod_parroquia'],
                    'cedula' => $dato_usuario['cedula'],
                    'nos_conocio' => $dato_usuario['nos_conocio'],
                    'estado_civil' => $dato_usuario['estado_civil'],
                    'nacionalidad' => $Nacionalidad,
                    $mesualQuinsena,
                    $letraconvertir_nuber->convertir1($cuotas),
                    number_format($cuotas),
                    number_format($number1, 2, ',', ' '),
                    $letraconvertir_nuber->convertir2($number1),
                    $cod_diaMes,
                    'fecha_entrega' => request()->fecha_maxima_entrega ?? 'no aplica',
                    $monto,
                    $letraconvertir_nuber->convertir2($number2),
                    number_format($number2, 2, ',', ' '),
                    $dato_usuario[0]['nombreProduct'],
                    $dato_usuario['phone'],
                    $dato_usuario['email'],
                    $this->fechaEs($order->fecha_primer_pago ?? date('d-m-y')),
                    sc_file(sc_store('logo', ($storeId ?? null))),
                    sc_file(sc_store('logo', ($storeId ?? null))),
                    'logo_waika' => sc_file(sc_store('logo', ($storeId ?? null))),
                    'logo_global' => sc_file(sc_store('logo', ($storeId ?? null))),

                ];


                $contente = preg_replace($dataFind, $dataReplace, $jurada->file_html);
                $dataViewe = [
                    'content' => $contente,
                ];


            }



            $r_convenio = Convenio::create([
                'order_id' => request()->c_order_id,
                'nro_convenio' => request()->nro_convenio,
                'lote' => request()->lote,
                'fecha_pagos' => fecha_to_sql(request()->c_fecha_inicial),
                'nro_coutas' => request()->c_nro_coutas,
                'total' => $monto,
                'inicial' => request()->c_inicial,
                'modalidad' => request()->c_modalidad,
                'convenio' => $dataView['content'],
                'declaracion_jurada' => $dataViewe['content'],
                'fecha_maxima_entrega' => request()->fecha_maxima_entrega ?? '',
            ]);




            $order = AdminOrder::getOrderAdmin(request()->c_order_id);
            //generar pagos
            $ncouta = 1;
            foreach (request()->coutas_calculo as $key => $value) {



                $data_pago = [
                    'order_id' => request()->c_order_id,
                    'customer_id' => $order->customer_id,
                    'payment_status' => 1,
                    'importe_couta' => $value,
                    'fecha_venciento' => fecha_to_sql(request()->fechas_pago_cuotas[$key]),
                    'nro_coutas' => $ncouta,
                ];

                $order = HistorialPago::create($data_pago);
                echo $ncouta++;
            }


            return redirect()->back()
                ->with(['success' => 'Accion completada']);
        }


    }

    public function postUpdate()
    {


        $id = request('pk');
        $code = request('name');
        $value = request('value');
        //actualiza
        Convenio::where('order_id', $id)->first()->update([
            "fecha_pagos" => $value

        ]);


        // return redirect()->back()
        // ->with(['success' => 'Accion completada']);
        return response()->json(['error' => 0, 'msg' => sc_language_render('action.update_success')]);


    }

    /**
     * funcion para eliminar una pago de sc_historial_pagos ajax
     *
     * @return void
     */
    public function eliminar_pago()
    {
        $id = request('pId');
        //valida si existe el pago
        $pago = HistorialPago::find($id);
        if (!$pago) {
            return response()->json(['error' => 1, 'msg' => sc_language_render('action.not_found')]);
        }
        $pago->delete();
        return response()->json(['error' => 0, 'msg' => sc_language_render('action.delete_success')]);
    }

    public function obtener_pago()
    {


        $id = request('id');
        $pago = HistorialPago::join('sc_shop_order', 'sc_historial_pagos.order_id', '=', 'sc_shop_order.id')
            ->join('sc_metodos_pagos', 'sc_historial_pagos.metodo_pago_id', '=', 'sc_metodos_pagos.id')
            ->join('sc_shop_payment_status', 'sc_historial_pagos.payment_status', '=', 'sc_shop_payment_status.id')
            ->where('sc_historial_pagos.id', $id)
            ->select('sc_historial_pagos.*', 'sc_shop_order.first_name', 'sc_metodos_pagos.name as metodo', 'sc_shop_payment_status.name as status', 'sc_shop_order.last_name')->first();

        $pago->comprobante = sc_file($pago->comprobante);



        // return redirect()->back()
        // ->with(['success' => 'Accion completada']);
        return response()->json(['error' => 0, 'data' => $pago]);


    }

    public function edit_pagos(Request $request)
    {

        $datos = $request->all();


        request()->validate([
            'metodo_pago_id' => 'required',
            'importe_pagado' => 'required',
            'moneda' => 'required',
            'fecha_pago' => 'required',
            'tasa_cambio' => 'required',


        ]);
        $importe_cuota = $request->importe_pagado;
        if ($request->moneda == 'Bs') {
            $importe_cuota = number_format($request->importe_pagado / $request->tasa_cambio, 2);
        }

        HistorialPago::where('id', $datos['id'])->first()->update([
            "metodo_pago_id" => $datos['metodo_pago_id'],
            'importe_couta' => $importe_cuota,
            "importe_pagado" => $datos['importe_pagado'],
            "moneda" => $datos['moneda'],
            "fecha_pago" => $datos['fecha_pago'],
            "payment_status" => $datos['payment_status'],
            "tasa_cambio" => $datos['tasa_cambio'],

        ]);

        return redirect()->back()
            ->with(['success' => 'Historial de pago  actualizado']);







    }

    public function postEstatusPago(Request $request)
    {

        $data = request()->all();

        $request->validate([

            'estatus_pagos' => 'required',
            'observacion' => 'required',
            'id_pago' => 'required'

        ]);


        $balance = 0;
        $pago = HistorialPago::where('id', $request->id_pago)->first();
        // Obtén el cliente a partir de su ID
        $client = SC_shop_customer::find($pago->customer_id);


        $estatus_pago = array(
            '1' => 'NO APAGADO',
            '2' => 'PAGO REPORTADO',
            '3' => 'PAGO PENDIENTE',
            '4' => 'PAGO EN MORA',
            '5' => 'PAGADO'
        );

        //   $Estatus = isset($estatus_pago[$pago->payment_status]) ? $estatus_pago[$pago->payment_status] : '';

        //   dd($estatus_pago);

        switch ($data['estatus_pagos']) {
            case 1:
                $Estatus = 'NO APAGADO';
                break;

            case 2:
                $Estatus = 'PAGO REPORTADO';
                break;

            case 3:
                $Estatus = 'PAGO PENDIENTE';
                break;
            case 4:
                $Estatus = 'PAGO EN MORA';
                break;
            case 5:
                $Estatus = 'PAGADO';
                break;

            default:
                # code...
                break;
        }


        $historial = [
            'first_name' => $client->first_name,
            'first_name' => $client->last_name,
            'email' => $client->email,
            'estatus' => $Estatus,
            'numero_del_pedido' => $pago->order_id,
            'numero_referencia' => $pago->referencia,
            'fecha_venciento' => $pago->fecha_venciento,
            'observacion' => $pago->comment,
            'id_del_pago' => $pago->customer_id
        ];

        estatus_de_pago($historial);


        $order = AdminOrder::getOrderAdmin($pago->order_id);
        if (!$order) {
            return response()->json(['error' => 1, 'msg' => sc_language_render('admin.data_not_found_detail', ['msg' => 'order#' . $pago->order_id]), 'detail' => '']);
        }
        if ($pago->importe_pagado == 0 && $request->estatus_pagos == 5) {
            return redirect()->back()
                ->with(['error' => ' El importe pagado debe ser mayor a 0']);
        }

        $pago->update([
            'payment_status' => $request->estatus_pagos,
            'observacion' => $request->observacion
        ]);
        //actulizar pagos

     
            $total_pagos = HistorialPago::where('order_id', $pago->order_id)
                ->whereIn('payment_status',[3,4,5,6])
                ->get();

            // Obtén el ID del cliente
            $clientId = $order->customer_id;
            // Calcula el nivel del cliente
            $calculator = new ClientLevelCalculator();
            $level = $calculator->calculate($clientId);
            // Obtén el cliente a partir de su ID
            $client = SC_shop_customer::find($clientId);

            // Actualiza el nivel del cliente
            $client->nivel = $level;

            // Guarda los cambios en la base de datos
            $client->save();

            foreach ($total_pagos as $key => $value) {
                $tasa = empty($pago->tasa_cambio) ? 1 : $pago->tasa_cambio;
                $balance += ($pago->importe_pagado * $tasa);
            }
            $dataTotal = [];

            $shopOrderTotal = ShopOrderTotal::where('order_id', $pago->order_id)->where('code', 'received')
                ->first();
            $dataTotal['id'] = $shopOrderTotal->id;
            $dataTotal['value'] = -$balance;
            $dataTotal['text'] = sc_currency_render_symbol($balance, $order->currency);

            AdminOrder::updateRowOrderTotal($dataTotal);

        

        return redirect()->back()
            ->with(['success' => 'Estatus actualizado']);

    }

    public function pagos_realizado()
    {
        return view($this->templatePathAdmin . 'component.notice')
            ->with("");
    }



    public function fechaEs($fechas)
    {
        $fecha = Carbon::createFromFormat('Y-m-d', $fechas);
        $diaSemana = ucfirst($fecha->locale('es')->dayName);
        $numeroDia = $fecha->day;
        $nombreMes = ucfirst($fecha->locale('es')->monthName);
        $anio = $fecha->year;

        return "{$diaSemana} {$numeroDia} de {$nombreMes} del {$anio}";
    }






    public function pago_diarios()
    {

        $data = [
            'title' => 'COBRANZAS DIARIAS',
            'subTitle' => '',
            'icon' => '',
            'urlDeleteItem' => sc_route_admin('admin_customer.delete'),
            'removeList' => 0,
            // 1 - Enable function delete list item
            'buttonRefresh' => 1,
            // 1 - Enable button refresh
            'buttonSort' => 1,
            // 1 - Enable button sort
            'css' => '',
            'js' => '',
        ];


        //Process add content
        $data['menuRight'] = sc_config_group('menuRight', \Request::route()->getName());
        $data['menuLeft'] = sc_config_group('menuLeft', \Request::route()->getName());
        $data['topMenuRight'] = sc_config_group('topMenuRight', \Request::route()->getName());
        $data['topMenuLeft'] = sc_config_group('topMenuLeft', \Request::route()->getName());
        $data['blockBottom'] = sc_config_group('blockBottom', \Request::route()->getName());

        $listTh = [
            'Nro orden' => 'Nro',
            'CLIENTES' => 'CLIENTES',
            'CEDULA' => 'CEDULA',
            'LOTE' => 'LOTE',
            'CONVENIO' => 'CONVENIO',
            'FORMA_DE_PAGO' => 'FORMA DE PAGO',
            'REFRENCIA' => 'REFRENCIA',
            'MONTO' => 'MONTO',
            'DIVISA' => 'DIVISA',
            'tasa_cambio' => 'TASA DE CAMBIO'


        ];
        $sort_order = sc_clean(request('sort_order') ?? 'id_desc');
        $keyword = sc_clean(request('keyword') ?? '');
        $fechas1 = sc_clean(request('fecha1') ?? '');
        $pdf_cobranzas = sc_clean(request('pdf_cobranzas') ?? '');
        $statusPayment = PaymentStatus::select(['name', 'id'])->get();

        foreach ($statusPayment as $key => $value) {
            $arrSort[$value->id] = $value->name;
            # code...
        }

        $arrSort['0'] = 'Todos';


        $dataSearch = [
            'keyword' => $keyword,
            'fecha1' => $fechas1,
            'pdf_cobranzas' => $pdf_cobranzas,
            'sort_order' => $sort_order,
            'arrSort' => $arrSort,
        ];





        $dataTmp = $this->getPagosListAdmin2($dataSearch);
        $Nr = 1;
        $dataTr = [];

        $totales = [];
        $totale = [];

        foreach ($dataTmp as $key => $row) {


            $pagados = [];

            $order = AdminOrder::getOrderAdmin($row->order_id);

            $forma_pago = $row['metodoPago'];
            $moneda = $row['moneda'];
            $monto = $row['importe_pagado'];
            $totalusd = '';

            if (!isset($pagados[$moneda])) {
                $pagados[$moneda] = [];
            }
            if (!isset($pagados[$moneda][$moneda])) {
                $pagados[$moneda][$monto] = 0;
            }
            $pagados[$moneda][$monto] = $monto;
            if (!isset($totales[$forma_pago])) {
                $totales[$forma_pago] = [];
            }
            if (!isset($totales[$forma_pago][$moneda])) {
                $totales[$forma_pago][$moneda] = 0;
            }
            $totales[$forma_pago][$moneda] += $monto;
            if (!isset($totale[$totalusd])) {
                $totale[$totalusd] = [];
            }
            if (!isset($totale[$totalusd][$moneda])) {
                $totale[$totalusd][$moneda] = 0;
            }
            $totale[$totalusd][$moneda] += $monto;




            foreach ($pagados as $forma_pagos => $monedas) {
                foreach ($monedas as $moneda => $totals) {
                    $divisa = $forma_pagos;
                    $monto = $totals;
                }
            }


            $dataTr[$row->id] = [
                'Nro orden' => $Nr++,
                'CLIENTES' => $row->first_name . ' ' . $row->last_name,
                'CEDULA' => $order->cedula,
                'LOTE' => $row->lote,
                'CONVENIO' => $row->nro_convenio,
                'FORMA_DE_PAGO' => $row->metodoPago,
                'REFRENCIA' => $row->referencia,
                'MONTO' => $monto,
                'DIVISA' => $divisa,
                'tasa_cambio' => $row->tasa_cambio
            ];
        }


        if ($dataSearch['pdf_cobranzas']) {
            $data['totales'] = $totales;
            $data['totaleudsBS'] = $totale;
            $data['listTh'] = $listTh;
            $data['dataTr'] = $dataTr;
            return view($this->templatePathAdmin . 'format.pagos_diariospdf')
                ->with($data);
        }


        $data['listTh'] = $listTh;
        $data['totales'] = $totales;
        $data['totaleudsBS'] = $totale;
        $data['statusPayment'] = $statusPayment;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links($this->templatePathAdmin . 'component.pagination');
        $data['resultItems'] = sc_language_render('admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'total' => $dataTmp->total()]);
        $fecha_hoy = date('y-m-d');

        //=menuSort
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }
        $data['urlSort'] = sc_route_admin('pago_diarios', request()->except(['_token', '_pjax', 'sort_order']));
        $data['optionSort'] = $optionSort;
        //menuSearch
        $data['topMenuRight'][] = '

           


                <form action="' . sc_route_admin('pago_diarios') . '" id="button_search">
                <div class="row  ">
                    <div class="col-md-6 form-group">
                        <label>' . 'fecha' . ':</label>
                        <div class="input-group">
                        <input value="' . $fecha_hoy . '" id="fecha1" type="text" name="fecha1"  class="form-control input-sm date_time rounded-0" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd"/>
                        </div>
                    </div>

                    <div class=" col-md-4 mt-4 form-group">
                    <button type="submit"  class="btn btn-primary"><i class="fas fa-search"></i></button>
                </div>

                </div>

                </form>
                ';

        //=menuSearch

        return view($this->templatePathAdmin . 'pagos-diarios.pagos-diarios')
            ->with($data);
    }




    public function cobranza_mensual()
    {

        $data = [
            'title' => 'COBRANZAS MENSUAL',
            'subTitle' => '',
            'icon' => '',
            'urlDeleteItem' => sc_route_admin('admin_customer.delete'),
            'removeList' => 0,
            // 1 - Enable function delete list item
            'buttonRefresh' => 1,
            // 1 - Enable button refresh
            'buttonSort' => 1,
            // 1 - Enable button sort
            'css' => '',
            'js' => '',
        ];


        //Process add content
        $data['menuRight'] = sc_config_group('menuRight', \Request::route()->getName());
        $data['menuLeft'] = sc_config_group('menuLeft', \Request::route()->getName());
        $data['topMenuRight'] = sc_config_group('topMenuRight', \Request::route()->getName());
        $data['topMenuLeft'] = sc_config_group('topMenuLeft', \Request::route()->getName());
        $data['blockBottom'] = sc_config_group('blockBottom', \Request::route()->getName());

        $listTh = [
            'Nro orden' => 'Nro',
            'CLIENTES' => 'CLIENTES',
            'CEDULA' => 'CEDULA',
            'LOTE' => 'LOTE',
            'CONVENIO' => 'CONVENIO',
            'MONTO' => 'MONTO',
            'DIVISA' => 'DIVISA',
            'FORMA_DE_PAGO' => 'FORMA DE PAGO',
            'REFRENCIA' => 'REFRENCIA',
            'FECHA' => 'FECHA',
            'tasa_cambio' => 'TASA DE CAMBIO',



        ];
        $sort_order = sc_clean(request('sort_order') ?? 'id_desc');
        $keyword = sc_clean(request('keyword') ?? '');
        $fechas2 = sc_clean(request('fecha2') ?? '');
        $pdf_cobranzas = sc_clean(request('pdf_cobranzas') ?? '');
        $statusPayment = PaymentStatus::select(['name', 'id'])->get();

        foreach ($statusPayment as $key => $value) {
            $arrSort[$value->id] = $value->name;
            # code...
        }

        $arrSort['0'] = 'Todos';


        $dataSearch = [
            'keyword' => $keyword,
            'fecha2' => $fechas2,
            'pdf_cobranzas' => $pdf_cobranzas,
            'sort_order' => $sort_order,
            'arrSort' => $arrSort,
        ];


        $dataTmp = $this->getPagosListAdmin2($dataSearch);
        $Nr = 1;
        $dataTr = [];

        $totales = [];
        $totale = [];

        foreach ($dataTmp as $key => $row) {


            $pagados = [];

            $order = AdminOrder::getOrderAdmin($row->order_id);

            $forma_pago = $row['metodoPago'];
            $moneda = $row['moneda'];
            $monto = $row['importe_pagado'];
            $totalusd = '';

            if (!isset($pagados[$moneda])) {
                $pagados[$moneda] = [];
            }
            if (!isset($pagados[$moneda][$moneda])) {
                $pagados[$moneda][$monto] = 0;
            }
            $pagados[$moneda][$monto] = $monto;
            if (!isset($totales[$forma_pago])) {
                $totales[$forma_pago] = [];
            }
            if (!isset($totales[$forma_pago][$moneda])) {
                $totales[$forma_pago][$moneda] = 0;
            }
            $totales[$forma_pago][$moneda] += $monto;
            if (!isset($totale[$totalusd])) {
                $totale[$totalusd] = [];
            }
            if (!isset($totale[$totalusd][$moneda])) {
                $totale[$totalusd][$moneda] = 0;
            }
            $totale[$totalusd][$moneda] += $monto;




            foreach ($pagados as $forma_pagos => $monedas) {
                foreach ($monedas as $moneda => $totals) {
                    $divisa = $forma_pagos;
                    $monto = $totals;
                }
            }


            $dataTr[$row->id] = [
                'Nro orden' => $Nr++,
                'CLIENTES' => $row->first_name . ' ' . $row->last_name,
                'CEDULA' => $order->cedula,
                'LOTE' => $row->lote,
                'CONVENIO' => $row->nro_convenio,
                'MONTO' => $monto,
                'DIVISA' => $divisa,
                'FORMA_DE_PAGO' => $row->metodoPago,
                'REFRENCIA' => $row->referencia,
                'FECHA' => $row->fecha_pago,
                'tasa_cambio' => $row->tasa_cambio
            ];
        }



        function fechaEs($fechas)
        {
            $fecha = Carbon::createFromFormat('Y-m-d', $fechas);
            $diaSemana = ucfirst($fecha->locale('es')->dayName);
            $numeroDia = $fecha->day;
            $nombreMes = ucfirst($fecha->locale('es')->monthName);
            $anio = $fecha->year;

            return "{$diaSemana} {$numeroDia} de {$nombreMes} del {$anio}";
        }




        if ($dataSearch['pdf_cobranzas']) {
            $data['totales'] = $totales;
            $data['fecha'] = fechaEs(date('d-m-y'));
            $data['totaleudsBS'] = $totale;
            $data['listTh'] = $listTh;
            $data['dataTr'] = $dataTr;
            return view($this->templatePathAdmin . 'format.cobranza_mensualpdf')
                ->with($data);
        }


        $data['listTh'] = $listTh;
        $data['totales'] = $totales;
        $data['totaleudsBS'] = $totale;
        $data['statusPayment'] = $statusPayment;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links($this->templatePathAdmin . 'component.pagination');
        $data['resultItems'] = sc_language_render('admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'total' => $dataTmp->total()]);
        $fecha_hoy = date('y-m-d');
        $año = date('Y', strtotime($fecha_hoy));
        $mes = date('m', strtotime($fecha_hoy));




        //=menuSort
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }
        $data['urlSort'] = sc_route_admin('cobranza_mensual', request()->except(['_token', '_pjax', 'sort_order']));
        $data['optionSort'] = $optionSort;
        //menuSearch
        $data['topMenuRight'][] = '
                <form action="' . sc_route_admin('cobranza_mensual') . '" id="button_search">
                <div class="row  ">
                    <div class="col-md-7 form-group">
                    <label>' . sc_language_render('action.from') . ':</label>
                        <div class="input-group">
                        <input value="' . $año . '-' . $mes . '" id="fecha2" type="month" name="fecha2"  class="form-control input-sm date_time rounded-0" data-date-format="yyyy-mm" placeholder="yyyy-mm"/>
                        </div>
                    </div>

                    


                   
                    <div class=" col-md-4 mt-4 form-group">
                    <button type="submit"  class="btn btn-primary"><i class="fas fa-search"></i></button>
                </div>

                </div>

                </form>
                ';

        //=menuSearch

        return view($this->templatePathAdmin . 'pagos-diarios.cobranza_mensual')
            ->with($data);


    }



    public function historial_cliente()
    {

        $dminUser = new AdminUser;
        $list_usuarios = $dminUser->pluck('name', 'id')->all();
        $user_roles = $dminUser::where('id', Admin::user()->id)->join('sc_admin_role_user', 'sc_admin_user.id', '=', 'sc_admin_role_user.user_id')->select('sc_admin_user.*', 'sc_admin_user.id', 'sc_admin_role_user.role_id as role_user')->get();

        $emitido_por = $user_roles[0]->name;






        $data = [];



        $listTh = [
            'N° de Pago' => 'N°',
            'MONTO' => 'Importe',
            'Reportado' => 'Reportado',
            'DIVISA' => 'Moneda',
            'CONVERSION' => 'Conversión',
            'tasa_cambio' => 'Tasa ',
            'estatus' => 'Estatus',
            'FORMA_DE_PAGO' => 'Forma de pago',
            'REFRENCIA' => 'Referencia',
            'FECHA_DE_PAGO' => 'Fecha de pago',

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






        $order = AdminOrder::getOrderAdmin($keyword);
     
        //  $dataTmp = $this->getPagosListAdmin2($dataSearch);
        $historialPago = HistorialPago::where('order_id',$keyword)->whereIn('payment_status',[3,4,5,6])->orderBy('nro_coutas')->get();
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

        $convenio = Convenio::where('order_id', $keyword)->first();


        $dataTr = [];

        $totales = [];
        $totale = [];
     
        $total_usd_pagado = 0;
        $vendedor = '';
 

        if (!$historialPago->count() >0) {
            return redirect(sc_route_admin('admin_order.detail', ['id' => $dataSearch['keyword']]))
                ->with(['error' => 'no se encontraron pagos reportado']);
        }
        $user_roles = AdminUser::where('id', $order->vendedor_id)->first();

        $pagado = 0;
        $total_bs=0;
        foreach ($historialPago as $key => $row) {


            $nro_total_pagos++;


            $statusPayment = ShopPaymentStatus::pluck('name', 'id')->all();
             $styleStatusPayment = $statusPayment;
            array_walk($styleStatusPayment, function (&$v, $k) {
                $v = '<span class="text-black badge badge-' . (AdminOrder::$mapStyleStatus[$k] ?? 'light') . '">' . $v . '</span>';
            });


         
            $pagado += $row->importe_couta;



            $fecha_formateada = date('d-m-Y', strtotime($row->fecha_pago));







       
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
        $data['order'] =   $order;

        $data['fecha_maxima_entrega'] = $order->fecha_maxima_entrega ? $this->fechaEs($order->fecha_maxima_entrega) : '';




    
        $data['totaleudsBS'] = $totale;
        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        return view($this->templatePathAdmin . 'format.historial_pagospdf')
            ->with($data);






    }

    public function notas_d_entrega()
    {
        $user_roles = AdminUser::where('id', Admin::user()->id)->join('sc_admin_role_user', 'sc_admin_user.id', '=', 'sc_admin_role_user.user_id')->select('sc_admin_user.*', 'sc_admin_user.id', 'sc_admin_role_user.role_id as role_user')->get();
        $User_roles = $user_roles[0]->role_user;
        $ademin = SC_admin_role::where('id', $User_roles)->get();
        $list_usuarios = $ademin[0]->name;


        $sort_order = sc_clean(request('sort_order') ?? 'id_desc');
        $keyword = sc_clean(request('keyword') ?? '');
        $historial_pago = sc_clean(request('notas_entrega') ?? '');
        $statusPayment = PaymentStatus::select(['name', 'id'])->get();



        foreach ($statusPayment as $key => $value) {
            $arrSort[$value->id] = $value->name;
            # code...
        }

        $dataSearch = [
            'keyword' => $keyword,
            'notas_entrega' => $historial_pago,
            'sort_order' => $sort_order,
            'arrSort' => $arrSort,
            'arrSort' => $arrSort,
        ];

        $id = $dataSearch['keyword'];


    


        $dataTr = [];
        $vendedor = '';

        if (empty($dataSearch['notas_entrega'])) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }

        $order = AdminOrder::getOrderAdmin($id);



        $historialPago = HistorialPago::where('order_id',$id)->whereIn('payment_status',[3,4,5,6])->orderBy('nro_coutas')->get();
        $cuota_pendientes = HistorialPago::where('order_id', $id)
        ->where('payment_status', 1)
        ->orWhere('payment_status', 7)->where('order_id', $id)
        ->orderBy('nro_coutas')->first();

        $convenio = Convenio::where('order_id',$id)->first();


       
           


      



        $historia = HistorialPago::where('order_id', $id)->where('payment_status', 1)->get();
        $lasuma = 0.00;

        foreach ($historia as $historias) {
            $lasuma += $historias->importe_couta;

        }

        $monedas = sc_currency_all();
        $tasa_cambio = $monedas[1]->exchange_rate;


        $cantidad = 0.00;
        $subtotal = 0.00;
        $lote = 0;
        $pagado = 0;
        $total_bs=0;

        foreach ($historialPago as $key => $row) {

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

    
            $fecha_pago = $row->fecha_pago;
           

        }


        $cliente = SC_shop_customer::where('id', $order->customer_id)->first();

       

        $data['cliente'] =$cliente->last_name ?? '';
        $data['vendedor'] = $vendedor ?? '';
        $data['serial_product'] = $serial_product ?? 'xxxx';
        $data['cedula'] = $cliente->cedula ?? '';
        $data['direccion'] = $cliente->address1 ?? '';
        $data['fecha_pago'] = $fecha_pago ?? '';
        $data['nro_convenio'] = $convenio->nro_convenio ?? '';
        $data['nombre_product'] = $nombre_product ?? '';
        $data['cantidad'] = $cantidad;
        $data['tota_product'] = $subtotal * $tasa_cambio ?? '';
        $data['tota_productusd'] = $subtotal ?? '';
        $data['lote'] = $convenio->lote;
        $data['tasa_cambio'] = $tasa_cambio ?? '';
        $data['referencia'] = $lasuma ?? '';
        $data['descuento'] = $order->discount ?? 0;
        $data['order'] =   $order;
        $data['fecha_maxima_entrega'] = $order->fecha_maxima_entrega ? $this->fechaEs($order->fecha_maxima_entrega) : '';

        if ($dataSearch['notas_entrega']) {
            $data['dataTr'] = $dataTr;
            return view($this->templatePathAdmin . 'format.notas_d_entrega')
                ->with($data);
        }


    }

    public function actualizar_puntos_de_clientes(){

        $orders = ShopOrder::all();

        foreach ($orders as $order) {
            $clientId = $order->customer_id;
            // Calcula el nivel del cliente
            $calculator = new ClientLevelCalculator();
            $level = $calculator->calculate($clientId);
            // Obtén el cliente a partir de su ID
            $client = SC_shop_customer::find($clientId);

            // Actualiza el nivel del cliente
            $client->nivel = $level;
            echo $client->nivel.' '.$client->first_name.' '.$client->last_name.'<br>';
            // Guarda los cambios en la base de datos
            $client->save();
        }
        $clientId = $order->customer_id;
      


    }
}