<?php
namespace App\Admin\Controllers;

use SCart\Core\Admin\Controllers\RootAdminController;
use SCart\Core\Front\Models\ShopOrderStatus;
use  App\Models\Catalogo\TipoTarjeta;
use Validator;

class TipoTarjetaController extends RootAdminController
{
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
            'title' => 'Tipos de Tarjetas',
            'title_action' => '<i class="fa fa-plus" aria-hidden="true"></i> ' . 'Nueva Tipo',
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'urlDeleteItem' => sc_route_admin('tipo_tarjetas.delete'),
            'removeList' => 0, // 1 - Enable function delete list item
            'buttonRefresh' => 0, // 1 - Enable button refresh
            'buttonSort' => 0, // 1 - Enable button sort
            'css' => '',
            'js' => '',
            'url_action' => sc_route_admin('tipo_tarjetas.create'),
        ];

        $listTh = [
            'id' => 'ID',
            'name' => sc_language_render('admin.order_status.name'),
            'limite' => 'Limite de la tarjeta',

            'action' => sc_language_render('action.title'),

         
        ];
        $obj = new TipoTarjeta;
        $obj = $obj->orderBy('id', 'desc');
        $dataTmp = $obj->paginate(20);
     
        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[$row['id']] = [
                'id' => $row['id'],
                'name' => $row['tipo'] ?? 'N/A',
                'limite' => $row['limite'] ?? 0,
           
                
                'action' => '
                    <a href="' . sc_route_admin('tipo_tarjetas.edit', ['id' => $row['id'] ? $row['id'] : 'not-found-id']) . '"><span title="' . sc_language_render('action.edit') . '" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                  <span onclick="deleteItem(\'' . $row['id'] . '\');"  title="' . sc_language_render('action.delete') . '" class="btn btn-flat btn-sm btn-danger"><i class="fas fa-trash-alt"></i></span>
                  ',
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links($this->templatePathAdmin.'component.pagination');
        $data['resultItems'] = sc_language_render('admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'total' =>  $dataTmp->total()]);

        $data['layout'] = 'index';
        return view($this->templatePathAdmin.'screen.tipo_tarjetas')
            ->with($data);
    }


    public function postCreate()
    {
        $data = request()->all();
        $dataOrigin = request()->all();
        $validator = Validator::make($dataOrigin, [
            'name' => 'required',
            'limite' => 'required',
        ], [
            'name.required' => sc_language_render('validation.required'),
        ]);

        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $dataCreate = [
            'tipo' => $data['name'],
            'monto_limite' => $data['limite'],
        ];
        $dataCreate = sc_clean($dataCreate, [], true);
        $obj = TipoTarjeta::create($dataCreate);

        return redirect()->route('tipo_tarjetas.edit', ['id' => $obj['id']])->with('success', sc_language_render('action.create_success'));
    }

    public function edit($id)
    {

       
        $order_status = TipoTarjeta::find($id);
        if (!$order_status) {
            return 'No data';
        }
     
        $data = [
        'title' => 'Tipos de tarjetas',
        'title_action' => '<i class="fa fa-edit" aria-hidden="true"></i> ' . sc_language_render('action.edit'),
        'subTitle' => '',
        'icon' => 'fa fa-indent',
        'urlDeleteItem' => sc_route_admin('tipo_tarjetas.delete'),
        'removeList' => 0, // 1 - Enable function delete list item
        'buttonRefresh' => 0, // 1 - Enable button refresh
        'buttonSort' => 0, // 1 - Enable button sort
        'css' => '',
        'js' => '',
        'url_action' => sc_route_admin('tipo_tarjetas.edit', ['id' => $order_status['id']]),
        'order_status' => $order_status,
        'id' => $id,
    ];

        $listTh = [
        'id' => 'ID',
        'name' => sc_language_render('admin.order_status.name'),
        'limite' => 'Limite',
     
        'action' => sc_language_render('action.title'),
    ];
        $obj = new TipoTarjeta;
        $obj = $obj->orderBy('id', 'desc');
        $dataTmp = $obj->paginate(20);

       
        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[$row['id']] = [
            'id' => $row['id'],
            'name' => $row['tipo'] ?? 'N/A',
            'limite' => $row['monto_limite'] ?? 'N/A',
      
        
            'action' => '
                <a href="' . sc_route_admin('tipo_tarjetas.edit', ['id' => $row['id'] ? $row['id'] : 'not-found-id']) . '"><span title="' . sc_language_render('action.edit') . '" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

              <span onclick="deleteItem(\'' . $row['id'] . '\');"  title="' . sc_language_render('action.delete') . '" class="btn btn-flat btn-sm btn-danger"><i class="fas fa-trash-alt"></i></span>
              ',
        ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links($this->templatePathAdmin.'component.pagination');
        $data['resultItems'] = sc_language_render('admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'total' =>  $dataTmp->total()]);

        $data['layout'] = 'edit';
        return view($this->templatePathAdmin.'screen.tipo_tarjetas')
        ->with($data);
    }

    public function postEdit($id)
    {
        $data = request()->all();
 
        $dataOrigin = request()->all();
        $validator = Validator::make($dataOrigin, [
            'name' => 'required',
            'limite' => 'required',
        ], [
            'name.required' => sc_language_render('validation.required'),
        ]);

        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        //Edit
        $dataUpdate = [
            'tipo' => $data['name'],
            'monto_limite' => $data['limite'],
    
        ];
        $obj = TipoTarjeta::find($id);
        $dataUpdate = sc_clean($dataUpdate, [], true);
        $obj->update($dataUpdate);
//
        return redirect()->back()->with('success', sc_language_render('action.edit_success'));
    }


}
