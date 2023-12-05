<?php

namespace App\Admin\Controllers;

use SCart\Core\Admin\Admin;

use SCart\Core\Admin\Controllers\RootAdminController;
use App\Models\AdminCustomer;
use App\Models\Rifa;
use App\Models\RifaCliente;

use SCart\Core\Admin\Models\AdminUser;
use Barryvdh\DomPDF\Facade\Pdf;
use Validator;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Catalogo\MetodoPago;
use App\Models\Catalogo\Banco;
use App\Models\AdminRole;
use Illuminate\Http\Request;
class RifaController extends RootAdminController
{

    public function index()
    {

        $data = [
            'title'         => 'Lista de Rifas',
            'subTitle'      => '',
            'icon'          => 'fa fa-indent',
            'urlDeleteItem' => sc_route_admin('Eliminar rifa'),
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
            'nombre_rifa'          => 'Nombre Rifa',
            'premio'          => 'Premio',
            'Lugar'          => 'Lugar',
            'Fecha sorteo' => 'Fecha sorteo',
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



        $data['listTh'] = $listTh;
        $data['dataTr'] = [];


        $dataTmp = Rifa::paginate(20);


        $dataTr = [];
        $AlContado = [];
        foreach ($dataTmp as $key => $row) {




            $dataMap = [

                'Acción' =>  '
                <a href="' . sc_route_admin('rifa.detail', ['id' => $row['id'] ? $row['id'] : 'not-found-id']) . '"><span title="' . sc_language_render('action.edit') . '" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;
                
                ',
                'nombre_rifa'          => $row['nombre_solteo'] ?? 'N/A',
                'premio'          =>  $row['premio'] ?? 'N/A',
                'Lugar' =>     $row['lugar_solteo'] ?? 'N/A',
                'Fecha sorteo'         => $row['fecha_solteo'],
                'Creado' => $row['created_at'],


            ];
            $dataTr[$row['id']] = $dataMap;
        }

        $data['dataTr'] = $dataTr;
        $optionStatus = '';
        //menuRight
        $data['menuRight'][] = '<a href="' . sc_route_admin('rifa.create') . '" class="btn  btn-success  btn-flat" title="Crear pedido" id="button_create_new">
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
                        <label>Buscar por Premio:</label>
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
            'title'             => sc_language_render('Crear nueva rifa'),
            'subTitle'          => '',
            'title_description' => sc_language_render(''),
            'icon'              => 'fa fa-plus',
        ];

        $users = AdminCustomer::getListAll();

        $paymentMethod = [];
        $shippingMethod = [];
        return view($this->templatePathAdmin . 'rifas.add')
            ->with($data);
    }


    public function createRifaCliente()
    {

        $modalidad = MetodoPago::all();
        $bancos = Banco::all();
        $id_rifa = request('id');
        if (!$id_rifa) {
            return redirect()->back();
        }



        $rifas = RifaCliente::where('rifa_id', $id_rifa)->pluck('numero_rifa')->toArray();
        $rifa = Rifa::find($id_rifa);

        $data = [
            'title'             => sc_language_render('Nuevo numero rifa -' . $rifa->nombre_solteo),
            'subTitle'          => '',
            'accion' => 'crear',
            'rifa' => $rifa,
            'bancos' => $bancos,
            'rifas' =>  $rifas,
            'id_rifa' => $id_rifa,
            'modalidad' => $modalidad,
            'title_description' => sc_language_render(''),
            'icon'              => 'fa fa-plus',
        ];

        $users = AdminCustomer::getListAll();

        $paymentMethod = [];
        $shippingMethod = [];
        return view($this->templatePathAdmin . 'rifas.add_rifa')
            ->with($data);
    }



    public function editRifaCliente($id_cliente)
    {

        $modalidad = MetodoPago::all();
        $bancos = Banco::all();
        $id_rifa = request('id');
        if (!$id_rifa) {
            return redirect()->back();
        }



        $rifas = RifaCliente::where('rifa_id', $id_rifa)->pluck('numero_rifa')->toArray();
        $datoRifa = RifaCliente::where('rifa_id', $id_rifa)
            ->where('id', $id_cliente)->first();

        $rifa = Rifa::find($id_rifa);

        $data = [
            'title'             => sc_language_render('Editar rifa -' . $rifa->nombre_solteo),
            'subTitle'          => '',
            'accion' => 'edit',
            'rifa' => $rifa,
            'bancos' => $bancos,
            'datoRifa' => $datoRifa,
            'id_cliente_rifa' => $id_cliente,
            'rifas' =>  $rifas,
            'id_rifa' => $id_rifa,
            'modalidad' => $modalidad,
            'title_description' => sc_language_render(''),
            'icon'              => 'fa fa-plus',
        ];

        $users = AdminCustomer::getListAll();

        $paymentMethod = [];
        $shippingMethod = [];
        return view($this->templatePathAdmin . 'rifas.add_rifa')
            ->with($data);
    }

    public function postCreateCliente()
    {


        $dataOrigin = request()->all();

        $validator = Validator::make($dataOrigin, [
            'forma_pago_id' => 'required',
            'nombre_cliente' => 'required',
            'email' => 'required',
            'telefono' => 'required',

            'cedula' => 'required',
            'numero_rifa' => 'required',
            'created_at' => 'required'

        ]);




        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $dataOrigin = (object)$dataOrigin;

        if ($dataOrigin->forma_pago_id == 4 || $dataOrigin->forma_pago_id == 2) {
            $tiene_referencia = RifaCliente::where('codigo_banco', $dataOrigin->codigo_banco)
                ->where('nro_referencia', $dataOrigin->nro_referencia)
                ->exists();

            if ($tiene_referencia) {
                return redirect()->back()->withInput()->with(['warning' => "Lo sentimos, el numero de referencia $dataOrigin->nro_referencia  ya se encuentra registrado "]);
            }
        }

        //  $fechaFormateada = Carbon::createFromFormat('d/m/Y', $dataOrigin->fecha_de_vencimiento)->format('Y-m-d');
        $tiene_rifa = RifaCliente::where('numero_rifa', $dataOrigin->numero_rifa)
            ->where('rifa_id', $dataOrigin->id_rifa)
            ->exists();

        if ($tiene_rifa) {

            return redirect()->back()->withInput()->with(['warning' => "Lo sentimos, el numero de rifa $dataOrigin->numero_rifa  se encuentra registrado "]);
        }

        $id_usuario_rol = Admin::user()->id;
        $dataTarjeta = [
            'vendor_id' => $id_usuario_rol,
            'rifa_id' => $dataOrigin->id_rifa,
            'nombre_cliente' => $dataOrigin->nombre_cliente,
            'telefono' => $dataOrigin->telefono,
            'numero_rifa'  => $dataOrigin->numero_rifa,
            'created_at' => $dataOrigin->created_at,
            'cedula' => $dataOrigin->cedula,
            'email' => $dataOrigin->email,
            'forma_pago_id' => $dataOrigin->forma_pago_id,
            'nro_referencia' => $dataOrigin->nro_referencia,
            'codigo_banco' => $dataOrigin->codigo_banco,


        ];


        $rifa =  RifaCliente::create($dataTarjeta);




        # code...


        return redirect()->route('rifa.detail', ['id' => $dataOrigin->id_rifa ? $dataOrigin->id_rifa : 'not-found-id'])->with('success', sc_language_render('action.create_success'));
    }


    public function postEditCliente($id)
    {


        $dataOrigin = request()->all();

        $validator = Validator::make($dataOrigin, [
            'forma_pago_id' => 'required',
            'nombre_cliente' => 'required',
            'email' => 'required',
            'telefono' => 'required',
            'cedula' => 'required',
            'numero_rifa' => 'required'

        ]);




        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $dataOrigin = (object)$dataOrigin;


        //  $fechaFormateada = Carbon::createFromFormat('d/m/Y', $dataOrigin->fecha_de_vencimiento)->format('Y-m-d');
        $tiene_rifa = RifaCliente::where('numero_rifa', $dataOrigin->numero_rifa)
            ->where('rifa_id', $dataOrigin->id_rifa)
            ->exists();


        $dataTarjeta = [


            'nombre_cliente' => $dataOrigin->nombre_cliente,
            'telefono' => $dataOrigin->telefono,
            'numero_rifa'  => $dataOrigin->numero_rifa,
            'cedula' => $dataOrigin->cedula,
            'email' => $dataOrigin->email,
            'forma_pago_id' => $dataOrigin->forma_pago_id,
            'nro_referencia' => $dataOrigin->nro_referencia,
            'codigo_banco' => $dataOrigin->codigo_banco,


        ];


        $rifa =  RifaCliente::where('id', $id)->update($dataTarjeta);




        # code...


        return redirect()->route('rifa.detail', ['id' => $dataOrigin->id_rifa ? $dataOrigin->id_rifa : 'not-found-id'])->with('success', sc_language_render('action.create_success'));
    }


    public function postCreate(Request $request)
    {


        $dataOrigin = request()->all();

        $validator = Validator::make($dataOrigin, [
            'nombre_solteo' => 'required',
            'precio' => 'required',
            'fecha_solteo' => 'required',
            'lugar_solteo' => 'required',

            'premio' => 'required',
            'total_numeros' => 'required',
            'imagen_recibo' => 'required|mimes:pdf,jpg,jpge,png|max:2048',

        ], [
            'fecha_solteo.required' => 'Fecha del Sorteo es requerido',
            'lugar_solteo.required' => 'Lugar del Sorteo es requerido',
            'nombre_solteo.required' => 'Nombre del Sorteo es requerido'
        ]);


        
        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        $path_archivo = '';
      
        $imagen_recibo =$request->imagen_recibo;

        if ($imagen_recibo) {
            $fileName = time() . '.' . $imagen_recibo->extension();
     
           $path_archivo  = 'images/rifas' . '/' . $fileName;
            $imagen_recibo->move(public_path('images/rifas/'), $fileName);

        }


  
        $dataOrigin = (object)$dataOrigin;


        //  $fechaFormateada = Carbon::createFromFormat('d/m/Y', $dataOrigin->fecha_de_vencimiento)->format('Y-m-d');

        $dataTarjeta = [
            'premio' => $dataOrigin->premio,
            'nombre_solteo' => $dataOrigin->nombre_solteo,
            'precio' => $dataOrigin->precio,
            'fecha_solteo'  => $dataOrigin->fecha_solteo,
            'nombre_solteo' => $dataOrigin->nombre_solteo,
            'lugar_solteo' => $dataOrigin->lugar_solteo,
            'total_numeros' => $dataOrigin->total_numeros,
            'imagen_rifa' => $path_archivo

        ];


        $rifa =  Rifa::create($dataTarjeta);




        # code...


        return redirect()->route('rifa.detail', ['id' => $rifa->id ? $rifa->id : 'not-found-id'])->with('success', sc_language_render('action.create_success'));
    }

    public function detail($id)
    {


        $classRifa =  Rifa::find($id);




        $arrSort = [
            'numero_rifa__desc' => sc_language_render('Numero de rifa desc'),
            'numero_rifa__asc' => sc_language_render('Numero de rida asc'),

        ];

        $sort_order = sc_clean(request('order_sort') ?? 'id_desc');
        $keyword    = sc_clean(request('keyword') ?? '');

        $dataSearch = [
            'keyword'    => $keyword,
            'sort_order' => $sort_order,
            'arrSort'    => $arrSort,
        ];

        $dataFilRifa = RifaCliente::obtenerRifas($dataSearch,  $id);


        $dataRifa = [];

        foreach ($dataFilRifa as $key => $value) {

            $usuario =   AdminUser::find($value->vendor_id);


            $value->vendedor = $usuario->name ?? '';
            # code...
            $dataRifa[] = $value;
        }


        $dataTarjeta = [
            "title"         => 'Detatalle de la Rifa',
            "rifas" => $dataRifa,
            "id" => $id,

            'rifa'         => $classRifa
        ];


        return view($this->templatePathAdmin . 'rifas.detail')->with($dataTarjeta);
    }

    public function rifa_pdf($id)
    {


        $numero_rifa = request('numero_rifa');

        $rifaCliente = RifaCliente::where('numero_rifa', $numero_rifa)->where('rifa_id', $id)->first();

        $dataRifa =  Rifa::find($id);
        $relleno = "0";
        $numero = str_pad($dataRifa->numero_rifa, 3, $relleno, STR_PAD_LEFT);
        $qrImage = public_path('qrcodes/qr-code.png');
        $urlLink = strtoupper($rifaCliente->nombre_cliente) . "  numero de rifa" . $numero;
        QrCode::format('png')->size(200)->generate($urlLink, $qrImage);


        $pdf = PDF::loadView($this->templatePathAdmin . 'rifas.rifa_pdf', [
            'rifaCliente' => $rifaCliente,
            'dataRifa' =>  $dataRifa,
            "qrImage" => $qrImage

        ]);



        $pdf->setPaper([0, 0, 1006, 640]);

        return $pdf->stream('rifa');
        return view($this->templatePathAdmin . 'rifas.rifa_pdf')->with(compact('rifaCliente', 'qrImage'));
    }

    public function obtenerTarjeta()
    {

        /* if (!request()->ajax()) {
            return response()->json(['error' => 1, 'msg' => sc_language_render('admin.method_not_allow')]);
        }*/
        $idCliente = request('id');

        $modalidad_compra = request('modalidad_compra');
        $classTarjeta = new Tarjeta;
        $datosTarjeta = $classTarjeta->getTarjetasCliente($idCliente);

        $dataTarjeta = [];
        foreach ($datosTarjeta as $key => $value) {
            $value->totalLimite = $classTarjeta->totalLimiteModalidad($value->id_tarjeta, $modalidad_compra);
            $value->totalTransaccion = $classTarjeta->totalTransaccionModalidad($value->id_tarjeta, $modalidad_compra);
            $dataTarjeta[] = $value;
        }




        return response()->json($dataTarjeta);
    }
}
