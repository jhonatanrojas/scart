<?php
namespace App\Admin\Controllers;

use App\Models\AdminOrder;
use App\Models\Convenio;
use App\Models\Estado;
use App\Models\HistorialPago;
use App\Models\ModalidadPago;
use App\Models\Municipio;
use App\Models\Parroquia;
use App\Models\SC__documento;
use App\Models\SC_referencia_personal;
use App\Models\SC_shop_customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use SCart\Core\Admin\Controllers\RootAdminController;
use SCart\Core\Front\Models\ShopCountry;
use SCart\Core\Front\Models\ShopLanguage;
use App\Models\AdminCustomer;
use SCart\Core\Front\Models\ShopCustomField;
use SCart\Core\Front\Models\ShopCustomFieldDetail;
use SCart\Core\Front\Controllers\Auth\AuthTrait;
use Illuminate\Support\Facades\Validator;

class AdminCustomerController extends RootAdminController
{
    use AuthTrait;
    public $languages;
    public $countries;

    public function __construct()
    {
        parent::__construct();
        $this->languages = ShopLanguage::getListActive();
        $this->countries = ShopCountry::getListAll();
    }

    public function index()
    {
        $data = [
            
            'title'         => sc_language_render('customer.admin.list'),
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
            'action'=> 'Acciones',
            'email'      => sc_language_render('customer.email'),
            'name'       => sc_language_render('customer.name'),
            'cedula'       => sc_language_render('customer.cedula'),
            'phone'      => sc_language_render('customer.phone'),
            'address1'   => sc_language_render('customer.address1'),
            'Estado'   => 'Estado',
            'Municipio'   => 'Municipio',
            'Parroquia'    => 'Parroquia',
            'status'     => 'Status',
            'created_at' => sc_language_render('admin.created_at'),
            
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
            'keyword'    => $keyword ,
            'sort_order' => $sort_order,
            'arrSort'    => $arrSort,
            'perfil'    => request('perfil') ?? '',
        ];




        $dataTmp = (new AdminCustomer)->getCustomerListAdmin($dataSearch);



       

       

        



       


        


        $estado = Estado::all();
        $municipio = Municipio::all();
        $parroquia = Parroquia::all();
        $nombreEstado=[];
        $nombreparroquias =[];
        $nombremunicipos =[];
        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
                foreach($estado as $estados){
                    if($estados->codigoestado == $row['cod_estado']){$nombreEstado = $estados->nombre;}
                         foreach($municipio as $municipos){
                             if($municipos->codigomunicipio ==$row['cod_municipio']){
                                 $nombremunicipos = $municipos->nombre;
                             }
                         }
                         foreach($parroquia as $parroquias){
                             if($parroquias->codigomunicipio == $row['cod_municipio']){
                                 $nombreparroquias = $parroquias->nombre;
                                 
                             }
                            
                         }
                       
                     }

            $dataTr[$row['id']] = [
                'action' => '
                    <a href="' . sc_route_admin('admin_customer.edit', ['id' => $row['id'] ? $row['id'] : 'not-found-id']) . '"><span title="' . sc_language_render('action.edit') . '" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                    <a href="' . sc_route_admin('admin_customer.document', ['id' => $row['id'] ? $row['id'] : 'not-found-id']) . '"><span title="' . sc_language_render('action.documetos') . '" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-file"></i></span></a>&nbsp;

                    <span onclick="deleteItem(\'' . $row['id'] . '\');"  title="' . sc_language_render('action.delete') . '" class="btn btn-flat btn-sm btn-danger"><i class="fas fa-trash-alt"></i></span>'
                ,
                'email' => $row['email'],
                'name' => $row['name'],
                'cedula' => $row['cedula'],
                'phone' => $row['phone'],
                'address1' => $row['address1'],
                'Estado' => $nombreEstado,
                'Municipio' => $nombremunicipos,
                'Parroquia' =>  $nombreparroquias ,
                'status' => $row['status'] ? '<span class="badge badge-success">ON</span>' : '<span class="badge badge-danger">OFF</span>',
                'created_at' => $row['created_at'],
                
            ];
        }

        $data['listTh'] = $listTh;

        
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links($this->templatePathAdmin.'component.pagination') ?? '';
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
        $data['urlSort'] = sc_route_admin('admin_customer.index', request()->except(['_token', '_pjax', 'sort_order']));
        $data['optionSort'] = $optionSort;
        //=menuSort

        //menuSearch
        $data['topMenuRight'][] = '
                <form action="' . sc_route_admin('admin_customer.index') . '" id="button_search">
                <div class="input-group input-group" style="width: 350px;">
                    <input type="text" name="keyword" class="form-control rounded-0 float-right" placeholder="' . 'buscar por cedula/nombre/email' . '" value="' . $keyword . '">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
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

        $estado = Estado::get();
        $data = [
            'title'             => sc_language_render('customer.admin.add_new_title'),
            'subTitle'          => '',
            'estado'          => $estado,
            'title_description' => sc_language_render('customer.admin.add_new_des'),
            'icon'              => 'fa fa-plus',
            'countries'         => (new ShopCountry)->getCodeAll(),
            'customer'          => [],
            'url_action'        => sc_route_admin('admin_customer.create'),
            'customFields'         => (new ShopCustomField)->getCustomField($type = 'customer'),

        ];

        return view($this->templatePathAdmin.'screen.customer_add')
            ->with($data);
    }

    /**
     * Post create new item in admin
     * @return [type] [description]
     */
    public function postCreate()
    {
        $data = request()->all();
        $data['status'] = empty($data['status']) ? 0 : 1;
        $data['store_id'] = session('adminStoreId');
        $dataMapping = $this->mappingValidator($data);
       
        $validator =  Validator::make($data, $dataMapping['validate'], $dataMapping['messages']);

        
        if ($validator->fails()) {
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = request()->all();
        $data['status'] = empty($data['status']) ? 0 : 1;
        $data['store_id'] = session('adminStoreId');

        $customer = AdminCustomer::createCustomer($dataMapping['dataInsert']);

        if ($customer) {
            sc_customer_created_by_admin($customer, $dataMapping['dataInsert']);
        }

        return redirect()->route('admin_customer.index')->with('success', sc_language_render('action.create_success'));
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $customer = (new AdminCustomer)->getCustomerAdmin($id);
        if (!$customer) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }

        $respuesta = SC_referencia_personal::where('id_usuario' , $id)->get();
         
        $estado = Estado::get();
        $municipio = Municipio::get();
        $parroquia = Parroquia::get();
        $data = [
            'title' => sc_language_render('action.edit'),
            'subTitle' => '',
            'title_description' => '',
            'estado' => $estado,
            'municipio' => $municipio,
            'parroquia' => $parroquia,
            'referencia' => $respuesta,
            'icon' => 'fa fa-edit',
            'customer' => $customer,
            'countries' => (new ShopCountry)->getCodeAll(),
            'addresses' => $customer->addresses,
            'url_action' => sc_route_admin('admin_customer.edit', ['id' => $customer['id']]),
            'customFields'         => (new ShopCustomField)->getCustomField($type = 'customer'),
        ];

       

        return view($this->templatePathAdmin.'screen.customer_edit')
            ->with($data);
    }

    public function ref_personales(Request $request){
        $datos = $request->all();
        $referencia = new SC_referencia_personal(); 
        $referencia->nombre_ref = $datos['nombre_ref'];
        $referencia->apellido_ref = $datos['apellido_ref'];
        $referencia->cedula_ref = $datos['cedula_ref'];
        $referencia->telefono = $datos['telefono_ref'];
        $referencia->id_usuario = $datos['id_usuario'];
        $referencia->parentesco = $datos['parentesco'];
        $referencia->nota = $datos['nota'] ?? '';

        if($referencia->save()){
            return json_encode(['respuesta' => $referencia]);

        }else{
            return json_encode(['error' => 'erro en la consulta']);

        }



       

    }

    public function editar_referencia(Request $request){
        $datos = $request->all();
        $referencia =  SC_referencia_personal::find($datos['id_usuario']);
        $referencia->nombre_ref = $datos['nombre_ref'];
        $referencia->apellido_ref = $datos['apellido_ref'];
        $referencia->cedula_ref = $datos['cedula_ref'];
        $referencia->telefono = $datos['telefono_ref'];
        $referencia->parentesco = $datos['parentesco'];
        $referencia->nota = $datos['nota'] ?? '';

        if($referencia->save()){
            return json_encode(['respuesta' => $referencia]);

        }else{
            return json_encode(['error' => 'erro en la consulta']);

        }



       

    }

    public function delete_ref(Request $request){


        $itemDetail = (new SC_referencia_personal)->where('id', $request->id)->first();

        $itemDetail->delete();

        

         return json_encode(['error' => 'erro en la consulta']);

    }



    public function document($id)
    {
        $customer = (new AdminCustomer)->getCustomerAdmin($id);
        if (!$customer) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }

        $documento = SC__documento::where('id_usuario', $id)->get();

        if(!$documento->isNotEmpty()){
             $documento= [];

        }
        
        
       
        $estado = Estado::get();
        $municipio = Municipio::get();
        $parroquia = Parroquia::get();
        $data = [
            'title' => "Documentos",
            'subTitle' => '',
            'documento' => $documento,
            'id_cliente' => $id,
            'title_description' => '',
            'estado' => $estado,
            'municipio' => $municipio,
            'parroquia' => $parroquia,
            'icon' => 'fa fa-edit',
            'customer' => $customer,
            'countries' => (new ShopCountry)->getCodeAll(),
            'addresses' => $customer->addresses,
            'url_action' => sc_route_admin('admin_customer.document', ['id' => $customer['id']]),
            'customFields'         => (new ShopCustomField)->getCustomField($type = 'customer'),
        ];
        return view($this->templatePathAdmin.'screen.customer_document')
            ->with($data);
    }

    /**
     * update status
     */
    public function postEdit($id)
    {
       
        $data = request()->all();
        $customer = (new AdminCustomer)->getCustomerAdmin($id);
        if (!$customer) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }

        $data['status'] = empty($data['status']) ? 0 : 1;
        $data['store_id'] = session('adminStoreId');
        $data['id'] = $id;
        $dataMapping = $this->mappingValidatorEdit($data);

        $validator =  Validator::make($data, $dataMapping['validate'], $dataMapping['messages']);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        AdminCustomer::updateInfo($dataMapping['dataUpdate'], $id);

        return redirect()->route('admin_customer.index')->with('success', sc_language_render('action.edit_success'));
    }

    /*
    Delete list Item
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
            }
            AdminCustomer::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }


    /**
     * Render address detail
     * @return [view]
     */
    public function updateAddress($id)
    {
        $address =  AdminCustomer::getAddress($id);
        if ($address) {
            $title = sc_language_render('customer.address_detail').' #'.$address->id;
        } else {
            $title = sc_language_render('customer.address_detail_notfound');
        }
        return view($this->templatePathAdmin.'screen.customer_update_address')
        ->with(
            [
            'title'       => $title,
            'address'     => $address,
            'customer'    => (new AdminCustomer)->getCustomerAdmin($address->customer_id),
            'countries'   => ShopCountry::getCodeAll(),
            'layout_page' => 'shop_profile',
            'url_action'  => sc_route_admin('admin_customer.update_address', ['id' => $id]),
            ]
        );
    }

    /**
     * Process update address
     *
     *
     * @return  [redirect]
     */
    public function postUpdateAddress($id)
    {
        $data = request()->all();
        $address =  AdminCustomer::getAddress($id);
        $dataUpdate = [
            'first_name' => $data['first_name'],
            'address1' => $data['address1'],
        ];
        $validate = [
            'first_name' => 'required|string|max:100',
        ];
        
        if (sc_config_admin('customer_lastname')) {
            if (sc_config_admin('customer_lastname_required')) {
                $validate['last_name'] = 'required|string|max:150';
            } else {
                $validate['last_name'] = 'nullable|string|max:150';
            }
            $dataUpdate['last_name'] = $data['last_name']??'';
        }

        if (sc_config_admin('customer_address1')) {
            if (sc_config_admin('customer_address1_required')) {
                $validate['address1'] = 'required|string|max:250';
            } else {
                $validate['address1'] = 'nullable|string|max:250';
            }
            $dataUpdate['address1'] = $data['address1']??'';
        }

        if (sc_config_admin('customer_address2')) {
            if (sc_config_admin('customer_address2_required')) {
                $validate['address2'] = 'required|string|max:200';
            } else {
                $validate['address2'] = 'nullable|string|max:200';
            }
            $dataUpdate['address2'] = $data['address2']??'';
        }

        if (sc_config_admin('customer_address3')) {
            if (sc_config_admin('customer_address3_required')) {
                $validate['address3'] = 'required|string|max:200';
            } else {
                $validate['address3'] = 'nullable|string|max:200';
            }
            $dataUpdate['address3'] = $data['address3']??'';
        }

        if (sc_config_admin('customer_phone')) {
            if (sc_config_admin('customer_phone_required')) {
                $validate['phone'] = config('validation.customer.phone_required', 'required|regex:/^0[^0][0-9\-]{6,12}$/');
            } else {
                $validate['phone'] = config('validation.customer.phone_null', 'nullable|regex:/^0[^0][0-9\-]{6,12}$/');
            }
            $dataUpdate['phone'] = $data['phone']??'';
        }

        if (sc_config_admin('customer_country')) {
            $arraycountry = (new ShopCountry)->pluck('code')->toArray();
            if (sc_config_admin('customer_country_required')) {
                $validate['country'] = 'required|string|min:2|in:'. implode(',', $arraycountry);
            } else {
                $validate['country'] = 'nullable|string|min:2|in:'. implode(',', $arraycountry);
            }
            
            $dataUpdate['country'] = $data['country']??'';
        }

        if (sc_config_admin('customer_postcode')) {
            if (sc_config_admin('customer_postcode_required')) {
                $validate['postcode'] = 'required|min:4';
            } else {
                $validate['postcode'] = 'nullable|min:4';
            }
            $dataUpdate['postcode'] = $data['postcode']??'';
        }

        if (sc_config_admin('customer_name_kana')) {
            if (sc_config_admin('customer_name_kana_required')) {
                $validate['first_name_kana'] = 'required|string|max:100';
                $validate['last_name_kana'] = 'required|string|max:100';
            } else {
                $validate['first_name_kana'] = 'nullable|string|max:100';
                $validate['last_name_kana'] = 'nullable|string|max:100';
            }
            $dataUpdate['first_name_kana'] = $data['first_name_kana']?? '';
            $dataUpdate['last_name_kana'] = $data['last_name_kana']?? '';
        }

        $messages = [
            'last_name.required'  => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.last_name')]),
            'first_name.required' => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.first_name')]),
            'address1.required'   => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.address1')]),
            'address2.required'   => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.address2')]),
            'address3.required'   => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.address3')]),
            'phone.required'      => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.phone')]),
            'country.required'    => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.country')]),
            'postcode.required'   => sc_language_render('validation.required', ['attribute'=> sc_language_render('customer.postcode')]),
            'phone.regex'         => sc_language_render('customer.phone_regex'),
            'postcode.min'        => sc_language_render('validation.min', ['attribute'=> sc_language_render('customer.postcode')]),
            'country.min'         => sc_language_render('validation.min', ['attribute'=> sc_language_render('customer.country')]),
            'first_name.max'      => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.first_name')]),
            'address1.max'        => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.address1')]),
            'address2.max'        => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.address2')]),
            'address3.max'        => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.address3')]),
            'last_name.max'       => sc_language_render('validation.max', ['attribute'=> sc_language_render('customer.last_name')]),
        ];

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
            $customer = (new AdminCustomer)->getCustomerAdmin($address->customer_id);
            $customer->address_id = $id;
            $customer->save();
        }
        return redirect()->route('admin_customer.edit', ['id' => $address->customer_id])
            ->with(['success' => sc_language_render('customer.update_success')]);
    }

    /**
     * Get address detail
     *
     * @return  [json]
     */
    public function deleteAddress()
    {
        $id = request('id');
        AdminCustomer::deleteAddress($id);
        return json_encode(['error' => 0, 'msg' => sc_language_render('customer.delete_address_success')]);
    }
    public function documentn(Request $request)
    {

       $datos =  $request->all();

        $request->validate([
            'cedula' => 'required',
            'carta_trabajo' => 'required',
            'rif' => 'required',
        ]);

        $saveFile = time().'.'.$datos['cedula']->extension();  
        $cedulas= 'data/clientes/cedula'.'/'. $saveFile;
        $datos['cedula']->move(public_path('data/clientes/cedula'), $saveFile);


        $saveFile = time().'.'.$datos['rif']->extension();  
        $rifs= 'data/clientes/rif'.'/'. $saveFile;
        $datos['rif']->move(public_path('data/clientes/rif'), $saveFile);

        $saveFile = time().'.'.$datos['carta_trabajo']->extension();  
        $path_archivo= 'data/clientes/carta_trabajo'.'/'. $saveFile;
        $datos['carta_trabajo']->move(public_path('data/clientes/carta_trabajo'), $saveFile);
       
        
  
            $id = $datos['id_usuario'];
            $saveFile = new SC__documento;
            $saveFile->first_name =$datos["first_name"];
            $saveFile->email =$datos['email'];
            $saveFile->telefono =$datos['phone'];
            $saveFile->id_usuario = $datos['id_usuario'];
            $saveFile->cedula = $cedulas;
            $saveFile->rif =  $rifs;
            $saveFile->carta_trabajo = $path_archivo;

            $documento = SC__documento::where('id_usuario', $id)->get();
         
            if(isset($documento[0]['id_usuario'])  == $id){
                return redirect('')->with('error', 'Disculpa ya se Adjunto los documentos');

                return redirect()->route('admin_customer.document', ['id' => $datos['id_usuario']])
                ->with(['error' => "error al guardar los datos"]);
            }else $saveFile->save();

            if($saveFile){
                return redirect()->route('admin_customer.document', ['id' => $datos['id_usuario']])
            ->with(['success' => sc_language_render('customer.update_success')]);
             }

        
       
    }

    public function document_delete (Request $request){
            if($request->documento == 'cedula'){
            $user = SC__documento::find($request->id);
            $user->cedula = '';
            $user->save();

            return response()->json(['success' => 1, 'msg' => 'eliminado']);

           }

           if($request->documento == 'rif'){
            $user = SC__documento::find($request->id);
            $user->rif = '';
            $user->save();

            return response()->json(['success' => 1, 'msg' => 'eliminado']);

           }

           if($request->documento == 'contacia'){
            $user = SC__documento::find($request->id);
            $user->carta_trabajo = '';
            $user->save();

            return response()->json(['success' => 1, 'msg' => 'eliminado']);

           }

            


    }

    public function document_update(Request $request){

                $datos =  $request->all();

                if(isset($datos['upCedula']) == 'cedula'){
                   
                $saveFile = time().'.'.$datos['cedula']->extension();  
                $cedulas= 'data/clientes/cedula'.'/'. $saveFile;
                $datos['cedula']->move(public_path('data/clientes/cedula'), $saveFile);

                $saveFile = SC__documento::find($datos['id_document']);

                $saveFile->cedula = $cedulas;
                $saveFile->save();
                    if($saveFile){
                        return redirect()->route('admin_customer.document', ['id' => $datos['id_usuario']])
                    ->with(['success' => sc_language_render('customer.update_success')]);
                     }

                }else if(isset($datos['uprif']) =='rif'){
                    $saveFile = time().'.'.$datos['rif']->extension();  
                    $rifs= 'data/clientes/rif'.'/'. $saveFile;
                    $datos['rif']->move(public_path('data/clientes/rif'), $saveFile);

                    $saveFile = SC__documento::find($datos['id_document']);

                    $saveFile->rif = $rifs;
                    $saveFile->save();
                    if($saveFile){
                        return redirect()->route('admin_customer.document', ['id' => $datos['id_usuario']])
                    ->with(['success' => sc_language_render('customer.update_success')]);
                     }
    

                }else if(isset($datos['upcarta']) =='carta'){

                    $saveFile = time().'.'.$datos['carta_trabajo']->extension();  
                    $path_archivo= 'data/clientes/carta_trabajo'.'/'. $saveFile;
                    $datos['carta_trabajo']->move(public_path('data/clientes/carta_trabajo'), $saveFile);


                    $saveFile = SC__documento::find($datos['id_document']);

                    $saveFile->carta_trabajo = $path_archivo;
                    $saveFile->save();
                    if($saveFile){
                        return redirect()->route('admin_customer.document', ['id' => $datos['id_usuario']])
                    ->with(['success' => sc_language_render('customer.update_success')]);
                     }

                }

                

                
           

    }

    /**
     * Check permisison item
     */
    public function checkPermisisonItem($id)
    {
        return (new AdminCustomer)->getCustomerAdmin($id);
    }


 
}
