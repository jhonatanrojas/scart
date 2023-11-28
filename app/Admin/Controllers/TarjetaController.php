<?php

namespace App\Admin\Controllers;

use App\Models\AdminOrder;
use App\Models\ModalidadPago;
use App\Models\Catalogo\ModalidadVenta;

use SCart\Core\Admin\Controllers\RootAdminController;
use App\Models\AdminCustomer;
use App\Models\Tarjeta;
use App\Models\Catalogo\TipoTarjeta;
use App\Models\MontoTarjetaModalidad;
use App\Models\TransaccionesTarjetas;
use Barryvdh\DomPDF\Facade\Pdf;
use Validator;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class TarjetaController extends RootAdminController
{

    public function index()
    {

        $data = [
            'title'         => 'Lista de Tarjetas',
            'subTitle'      => '',
            'icon'          => 'fa fa-indent',
            'urlDeleteItem' => sc_route_admin('Eliminar tarjetas'),
            'removeList'    => 0, // 1 - Enable function delete list item
            'buttonRefresh' => 1, // 1 - Enable button refresh
            'buttonSort'    => 1, // 1 - Enable button sort
            'css'           => '',
            'js'            => '',
        ];

        $data['menuRight']    = sc_config_group('menuRight', \Request::route()->getName());
        $data['menuLeft']     = sc_config_group('menuLeft', \Request::route()->getName());
        $data['topMenuRight'] = sc_config_group('topMenuRight', \Request::route()->getName());
        $data['topMenuLeft']  = sc_config_group('topMenuLeft', \Request::route()->getName());
        $data['blockBottom']  = sc_config_group('blockBottom', \Request::route()->getName());

        $listTh = [
            'Acción'          => 'Acción',
            'Nombre&Apellido'          => 'Nombre& Apellido',
            'nro_tarjeta'          => 'N° tarjeta',
            'Tipo'          => 'Tipo',
            'Codigo' => 'Codigo de Seguridad',
            'Creado'          => 'Creado',

        ];



        $arrSort = [
            'id__desc'         => sc_language_render('filter_sort.id_desc'),
            'id__asc'          => sc_language_render('filter_sort.id_asc'),
            'email__desc'      => sc_language_render('filter_sort.alpha_desc', ['alpha' => 'Email']),
            'email__asc'       => sc_language_render('filter_sort.alpha_asc', ['alpha' => 'Email']),
            'created_at__desc' => sc_language_render('filter_sort.value_desc', ['value' => 'Date']),
            'created_at__asc'  => sc_language_render('filter_sort.value_asc', ['value' => 'Date']),
        ];

        $sort_order   = sc_clean(request('sort_order') ?? 'id_desc');
        $keyword      = sc_clean(request('keyword') ?? '');
        $email        = sc_clean(request('email') ?? '');
        $from_to      = sc_clean(request('from_to') ?? '');
        $from_to      = sc_clean(request('from_to') ?? '');
        $end_to       = sc_clean(request('end_to') ?? '');
        $estatus       = sc_clean(request('estatus') ?? '');
        $dataSearch = [
            'keyword'      => $keyword,
            'email'        => $email,

            'from_to'      => $from_to,
            'end_to'       => $end_to,
            'sort_order'   => $sort_order,
            'arrSort'      => $arrSort,
            'estatus' => $estatus,

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
            'order_status' => $estatus,

        ];


        $data['listTh'] = $listTh;
        $data['dataTr'] = [];


        $dataTmp = Tarjeta::listTarjetasAdmin();


        $dataTr = [];
        $AlContado = [];
        foreach ($dataTmp as $key => $row) {


            $tipoTajeta = TipoTarjeta::find($row['tipo_tarjeta_id']);

            $nombreTipoTarjeta = $tipoTajeta->tipo ?? 'N/A';


            $dataMap = [

                'Acción' =>  '
                <a href="' . sc_route_admin('tarjetas.detail', ['id' => $row['id'] ? $row['id'] : 'not-found-id']) . '"><span title="' . sc_language_render('action.edit') . '" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;
                
                ',
                'Nombre & Apellido'          => $row['first_name'] . " " . $row['last_name'] ?? 'N/A',
                'nro_tarjeta'          =>  $row['nro_tarjeta'] ?? 'N/A',
                'Tipo' =>      $nombreTipoTarjeta ?? 'N/A',
                'codigo'         => $row['codigo_seguridad'],
                'Creado' => $row['created_at'],


            ];
            $dataTr[$row['id']] = $dataMap;
        }

        $data['dataTr'] = $dataTr;
        $optionStatus = '';
        //menuRight
        $data['menuRight'][] = '<a href="' . sc_route_admin('tarjetas.create') . '" class="btn  btn-success  btn-flat" title="Crear pedido" id="button_create_new">
                           <i class="fa fa-plus" title="' . sc_language_render('action.add') . '"></i>
                           </a>';
        $ruta_busqueda = '/';
        $data['topMenuRight'][] = '
        <form action="' .  $ruta_busqueda . '" id="button_search">
            <div class="input-group float-left">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>' . sc_language_render('action.from') . ':</label>
                        <div class="input-group">
                        <input type="text" name="from_to" id="from_to" value="' . $from_to . '" class="form-control input-sm date_time rounded-0" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" /> 
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>' . sc_language_render('action.to') . ':</label>
                        <div class="input-group">
                        <input type="text" name="end_to" value="' . $end_to . '" id="end_to" class="form-control input-sm date_time rounded-0" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" /> 
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>' . sc_language_render('order.admin.status') . ':</label>
                        <div class="input-group">
                        <select id="order_status"  class="form-control rounded-0" name="order_status">
                        <option value="">' . sc_language_render('order.admin.search_order_status') . '</option>
                        ' . $optionStatus . '
                        </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Buscar por Numero de tarjeta:</label>
                        <div class="input-group">
                            <input type="text" name="email" class="form-control rounded-0 float-right" placeholder="Nro de tarjeta" value="' . $email . '">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary  btn-flat"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
      
        
        
        ';


        return view($this->templatePathAdmin . 'screen.list')
            ->with($data);
    }

    public function create()
    {

        $data = [
            'title'             => sc_language_render('Crear nueva tarjeta'),
            'subTitle'          => '',
            'title_description' => sc_language_render('Asociar tarjeta al cliente'),
            'icon'              => 'fa fa-plus',
        ];

        $users = AdminCustomer::getListAll();
        $data['users']          = $users;
        $data['modalidadVentas'] =   ModalidadVenta::where('es_tarjeta', 1)->get();
        $data['tipoTarjeta'] =   TipoTarjeta::all();
        $paymentMethod = [];
        $shippingMethod = [];
        return view($this->templatePathAdmin . 'tarjetas.add')
            ->with($data);
    }

    public function postCreate()
    {


        $dataOrigin = request()->all();

        $validator = Validator::make($dataOrigin, [
            'first_name' => 'required',
            'customer_id' => 'required',
            'tipoTajeta' => 'required',
            'nro_tarjeta' => 'required',
            'valor_tarjeta' => 'required',
            'codigo_seguridad' => 'required'

        ], [
            'first_name.required' => sc_language_render('validation.required'),
            'valor_tarjeta.required' => sc_language_render('validation.required'),
        ]);

    
        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $dataOrigin = (object)$dataOrigin;

        //  $fechaFormateada = Carbon::createFromFormat('d/m/Y', $dataOrigin->fecha_de_vencimiento)->format('Y-m-d');

        $dataTarjeta = [
            'customer_id' => $dataOrigin->customer_id,
            'nro_tarjeta' => $dataOrigin->nro_tarjeta,
            'tipo_tarjeta_id'  => $dataOrigin->tipoTajeta,
            'fecha_de_vencimiento' => $dataOrigin->fecha_de_vencimiento,
            'codigo_seguridad' => $dataOrigin->codigo_seguridad

        ];


        $NuevaTarjeta =  Tarjeta::create($dataTarjeta);
        $id_tarjeta = $NuevaTarjeta->id;

        foreach ($dataOrigin->id_modalidad as $key => $value) {

            MontoTarjetaModalidad::create([
                'tarjeta_id'        => $id_tarjeta,
                'modalida_venta_id' => $value,
                'monto' => $dataOrigin->valor_tarjeta[$key]

            ]);

            TransaccionesTarjetas::create([
                'tarjeta_id'        => $id_tarjeta,
                'modalida_venta_id' => $value,
                'monto' => $dataOrigin->valor_tarjeta[$key],
                'tipo_movimiento' => 'credito',
                'descripcion' => 'Abono Credito'

            ]);



            # code...
        }

        return redirect()->route('tarjetas.detail', ['id' => $id_tarjeta ? $id_tarjeta : 'not-found-id'])->with('success', sc_language_render('action.create_success'));
    }

    public function detail($id)
    {


        $classTarjeta = new Tarjeta;
        $totalLimite  =    $classTarjeta->totalLimite($id);
        $totalTransaccion =  $classTarjeta->totalTransaccion($id);
        $trasacciones =  TransaccionesTarjetas::where('tarjeta_id', $id)->paginate(20);
        $montosTarjetaModalidad =  MontoTarjetaModalidad::where('tarjeta_id', $id)->paginate(20);

        $datosTarjeta = $classTarjeta->getTarjetaAdmin($id);

        $dataTarjeta = [
            "title"         => 'Detatalle de la tarjeta',
            "totalLimite"   => $totalLimite,
            "trasacciones" => $trasacciones,
            "montosTarjetaModalidad" => $montosTarjetaModalidad,
            "id" => $id,
            "totalTransaccion" => $totalTransaccion,
            "subTitle"      => '',
            'order'         => $datosTarjeta
        ];


        return view($this->templatePathAdmin . 'tarjetas.detail')->with($dataTarjeta);
    }

    public function tarjeta_pdf($id)
    {

        $classTarjeta = new Tarjeta;
        $datosTarjeta = $classTarjeta->getTarjetaAdmin($id);

        $qrImage = public_path('qrcodes/qr-code.png');
        $urlLink = sc_route('customer.verificar-tarjeta', [$id]);
        QrCode::format('png')->size(200)->generate($urlLink, $qrImage);


        $pdf = PDF::loadView($this->templatePathAdmin . 'tarjetas.tarjeta_pdf', [
            'datosTarjeta' => $datosTarjeta,
            "qrImage" => $qrImage

        ]);



        $pdf->setPaper([0, 0, 1006, 640]);

   return $pdf->stream('tajerta');
       //  return view($this->templatePathAdmin . 'tarjetas.tarjeta_pdf')->with(compact('datosTarjeta','qrImage'));
    }

    public function obtenerTarjeta(){

       /* if (!request()->ajax()) {
            return response()->json(['error' => 1, 'msg' => sc_language_render('admin.method_not_allow')]);
        }*/ 
        $idCliente =request('id');
  
        $modalidad_compra =request('modalidad_compra');
        $classTarjeta = new Tarjeta;
        $datosTarjeta = $classTarjeta->getTarjetasCliente($idCliente);

        $dataTarjeta = [];
        foreach ($datosTarjeta as $key => $value) {
            $value->totalLimite = $classTarjeta->totalLimiteModalidad($value->id_tarjeta,$modalidad_compra);
            $value->totalTransaccion = $classTarjeta->totalTransaccionModalidad($value->id_tarjeta,$modalidad_compra);
            $dataTarjeta[] =$value;
        }


  
 
        return response()->json($dataTarjeta);
    }
}
