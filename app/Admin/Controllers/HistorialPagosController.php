<?php
namespace App\Admin\Controllers;

use SCart\Core\Admin\Controllers\RootAdminController;
use Illuminate\Http\Request;
use App\Models\HistorialPago;
use App\Models\Convenio;
use App\Models\Catalogo\PaymentStatus;
use SCart\Core\Front\Models\ShopOrder;
use App\Models\Catalogo\MetodoPago;
use App\Models\AdminOrder;

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

        $data = [
            'title'         => 'Historial de pagos', 
            'subTitle'      => '',
            'icon'          => 'fa fa-indent',
            'urlDeleteItem' => sc_route_admin('admin_customer.delete'),
            'removeList'    => 0, // 1 - Enable function delete list item
            'buttonRefresh' => 1, // 1 - Enable button refresh
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
            'Nro orden'      => 'Nro de orden /<br> Cliente',
            'Importe pagado'       => 'Pagado',
            'Referencia'       => 'Referencia',
            'Metodo de pago'      => 'Metodo',
            'Estatus' => 'Estatus',
            'Comentario' => 'Comentario',
            'fecha_pago' => 'Fecha pago',
            'Creado'   =>  'Creado',
            'action'     => sc_language_render('action.title'),
        ];
        $sort_order = sc_clean(request('sort_order') ?? 'id_desc');
  
  

   
        $keyword    = sc_clean(request('keyword') ?? '');
      $statusPayment = PaymentStatus::select(['name','id'])->get();



      foreach ($statusPayment as $key => $value) {
        $arrSort[$value->id] = $value->name;
        # code...
      }
      $arrSort['0'] ='Todos';



        $dataSearch = [
            'keyword'    => $keyword,
            'sort_order' => $sort_order,
            'arrSort'    => $arrSort,
        ];
     
        $dataTmp = $this->getOrderListAdmin($dataSearch);




    

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {

            $order = AdminOrder::getOrderAdmin($row->order_id);
            
            $dataTr[$row->id ] = [
                
                'Nro orden' =>  $row->order_id .'<br>'.$order->first_name.'  '.$order->last_name,
                'Importe pagado' =>  $row->importe_pagado,
                'Referencia' =>  $row->referencia,
                
                'Metodo de pago' =>  isset($row->metodo_pago->name)?$row->metodo_pago->name :'',
                'Estatus' => $row->estatus->name .'<br><small>'.$row->observacion.'</small>' ,
                'Comentario' =>  $row->comment,
                'fecha_pago' =>  $row->fecha_pago,
                
                'Creado' =>  $row->created_at->format('d/m/Y'),
         
            
                'action' => '
                    <a href="#" data-id="'.$row->id.'"><span  data-id="'.$row->id.'" title="Cambiar estatus" type="button" class="btn btn-flat mostrar_estatus_pago btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                    <a target="_blank" href="'. sc_file( $row->comprobante).'"><span title="Descargar Referencia" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-file"></i></span></a>&nbsp;


                    
                    '
                ,
            ];
        }

        $data['listTh'] = $listTh;
        $data['statusPayment'] = $statusPayment;
      
        
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
        $data['urlSort'] = sc_route_admin('historial_pagos.index', request()->except(['_token', '_pjax', 'sort_order']));
        $data['optionSort'] = $optionSort;
        //=menuSort

        //menuSearch
        $data['topMenuRight'][] = '
                <form action="' . sc_route_admin('historial_pagos.index') . '" id="button_search">
                <div class="input-group input-group" style="width: 350px;">
                    <input type="text" name="keyword" class="form-control rounded-0 float-right" placeholder="Buscar por numero de orden" value="' . $keyword . '">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                </form>';
        //=menuSearch

        return view($this->templatePathAdmin.'pagos.detalle')
            ->with($data);
   
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
            'Referencia'       => 'Referencia',
            'Metodo de pago'      => 'Metodo de pago',
            'Estatus' => 'Estatus',
            'Observación' =>'Comentario',
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
     
        $dataTmp = (new HistorialPago);
        if ($sort_order && array_key_exists($sort_order, $arrSort)) {



            $dataTmp = $dataTmp->Where('payment_status',  $sort_order)
            ->where('order_id',$id_orden)
            ->orderByDesc('id')
            ->paginate(20);
        } else {
         
            $dataTmp = $dataTmp
            ->where('order_id',$id_orden)
            ->orderByDesc('id')
            ->paginate(20);
        }

  


        if(isset($dataTmp[0]->cliente->first_name)){
            $data ['title'] ='Detalle de pago- Cliente: '.$dataTmp[0]->cliente->first_name.'  '.$dataTmp[0]->cliente->last_name;
        }


        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[$row->id ] = [
                'Nro orden' =>  $row->order_id,
                'Importe pagado' =>  $row->importe_pagado,
                'Referencia' =>  $row->referencia,
                
                'Metodo de pago' =>  $row->metodo_pago->name,
                'Estatus' => $row->estatus->name .'<br><small>'.$row->observacion.'</small>' ,
                'Comentario' =>  $row->comment,
                'Creado' =>  $row->created_at->format('d/m/Y'),
         
            
                'action' => '
                    <a href="#" data-id="'.$row->id.'"><span  data-id="'.$row->id.'" title="Cambiar estatus" type="button" class="btn btn-flat mostrar_estatus_pago btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                    <a target="_blank" href="'. sc_file( $row->comprobante).'"><span title="Descargar Referencia" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-file"></i></span></a>&nbsp;


                    
                    '
                ,
            ];
        }

        $data['listTh'] = $listTh;
        $data['statusPayment'] = $statusPayment;
      
        
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

    public function reportarPago(...$params)
    {
     
            $id = $params[0] ?? '';
        
   
            $data = [
                'title'         => 'Reportar Pago', 
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
    
         
            $id_orden=request('id');
      

    
            $order = ShopOrder::where('id', $id_orden)->first();

            $data['order']=$order;
            $data['metodos_pagos']= MetodoPago::all();
    
           

    
    
         
    
            return view($this->templatePathAdmin.'pagos.crear_pago')
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
                $sql->Where('order_id', $keyword);
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
    public function postCrearConvenio(){
     
        $data = request()->all();

        // dd($data);
      
  
        request()->validate([
           
            'c_order_id' => 'required',
            '_monto' => 'required',
            'c_fecha_inicial' => 'required',
            'nro_convenio' => 'required',

          
        ]);
      

        $tiene_convenio = Convenio::where('order_id', request()->c_order_id)->first();
        $countConvenio = Convenio::count();    


     

        if(!$tiene_convenio ){
         $r_convenio=   Convenio::create([
                'order_id'=> request()->c_order_id,
                'nro_convenio' => str_pad($countConvenio+1, 0, 6, ),
                'lote' =>  request()->lote,
                'fecha_pagos'=> fecha_to_sql(request()->c_fecha_inicial),
                'nro_coutas'=> request()->c_nro_coutas,
                'total'=> request()->_monto,
                'inicial'=> request()->c_inicial,
                'modalidad'=> request()->c_modalidad,

            ]);
          
       

            //generar pagos
                $ncouta=1;
            foreach (request()->coutas_calculo as $key => $value) {
           

    
     $data_pago =[
                'order_id' =>request()->c_order_id,
                'customer_id' => 0,              
                'payment_status' => 1,
                'importe_couta'=>$value,
                'fecha_venciento' =>fecha_to_sql(request()->fechas_pago_cuotas[$key]),
                'nro_coutas' =>$ncouta,
               ];
       
               $order = HistorialPago::create($data_pago);
              echo  $ncouta++;
            }

        }else{
            //actualiza
            Convenio::update([
                'order_id'=> request()->c_order_id,
                'nro_convenio' => str_pad($countConvenio+1, 0, 6, ),
                'lote' =>  request()->lote,
                'fecha_pagos'=> fecha_to_sql(request()->c_fecha_inicial),
                'nro_coutas'=> request()->c_nro_coutas,
                'total'=> request()->_monto,
                'inicial'=> request()->c_inicial,
                'modalidad'=> request()->c_modalidad,

            ]);
            
            

        }


    
   

        return redirect()->back()
        ->with(['success' => 'Accion completada']);
      
       
    }

    public function postEstatusPago(Request $request){
     
        $data = request()->all();
      
        $request->validate([
           
            'estatus_pagos' => 'required',
            'observacion' => 'required',
            'id_pago' => 'required'
          
        ]);
      

        $order = HistorialPago::where('id', $request->id_pago)
        ->update([
            'payment_status' =>$request->estatus_pagos,
            'observacion' => $request->observacion
            
        
        ]);
   

        return redirect()->back()
        ->with(['success' => 'Accion completada']);
      
       
    }
}
