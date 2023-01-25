<?php
  
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\SC__documento;
use Illuminate\Notifications\Messages\MailMessage;
use SCart\Core\Front\Models\ShopCountry;
use SCart\Core\Front\Models\ShopCustomField;
use Illuminate\Support\Facades\Auth;
class DocumentosController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
  
        if (Auth::check()) {
            $customer = auth()->user();
       


            $id = $customer['id']; 
            $documento = SC__documento::where('id_usuario',$id)->get();

           
            $datos_del_documento =[];
            foreach ($documento as $documentos){
               

                $datos_del_documento = [
                    "id" => $documentos->id,
                    "carta_trabajo" => $documentos->carta_trabajo,
                    "cedula" => $documentos->cedula,
                    "rif" => $documentos->rif,
                    "id_usuario" => $documentos->id_usuario,

                ];

            }

           

            if(empty($datos_del_documento)){
           $dato = "Para procesar sus solicitudes de compras, se requiere que adjunte Cedula, RIF y constancia de trabajo";
           
        }else $dato = "";

        return view('templates/s-cart-light/account/documentos')
            ->with(
                [
                    'title'       => 'adjuntar documento',
                    'documentos'       => $datos_del_documento,
                    'id_cliente' => $id,
                    'cart'               => session('dataCheckout'),
                    'customer'    => $customer,
                    'mensaje' => $dato,
                    'countries'   => ShopCountry::getCodeAll(),
                    'layout_page' => 'shop_profile',
                    'customFields' => (new ShopCustomField())->getCustomField($type = 'customer'),
                    'breadcrumbs' => [
                        ['url'    => sc_route('customer.index'), 'title' => sc_language_render('front.my_account')],
                        ['url'    => '', 'title' => sc_language_render('customer.change_infomation')],
                    ],
                ]
            );
    }else{
        return redirect('/')->with('error', 'usuario no registrado');
    }
}
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function enviar_document(Request $request)
    {

        $customer = auth()->user();
        $id = $customer['id'];

        $documento = SC__documento::where('id_usuario', $id)->get();


        $Financiamiento  = session('dataCheckout');


            $result = $request->all();
             
            if(isset($documento[0]->cedula) || isset($documento[0]->rif) || isset($documento[0]->arta_trabajo)){
                if(isset($result['c_vacio'])){
                    $request->validate([
                        'cedula' => 'required',
                        
                    ]);
    
                    $saveFile = time().'.'.$request->cedula->extension();  
                    $cedulas= 'data/clientes/cedula'.'/'. $saveFile;
                    $request->cedula->move(public_path('data/clientes/cedula'), $saveFile);
                    $saveFile = SC__documento::find($result['id']);
                    $saveFile->cedula = $cedulas;
                    $saveFile->save();
                    return redirect('/adjuntar_document')->with('success', 'Adjunto los documentos cedula');

    
                }
    
    
                
                if(isset($result['r_vacio'])){
                    $request->validate([
                        'rif' => 'required',
                    ]);
    
                    
    
                    $saveFile = time().'.'.$request['rif']->extension();  
                        $rifs= 'data/clientes/rif'.'/'. $saveFile;
                        $request['rif']->move(public_path('data/clientes/rif'), $saveFile);
                    $saveFile = SC__documento::find($result['id']);
                    $saveFile->rif = $rifs;
                    $saveFile->save();
                    
                    return redirect('/adjuntar_document')->with('success', 'Adjunto los documentos rif');
    
                }
    
                if(isset($result['k_vacio'])){
                    $request->validate([
                        'carta_trabajo' => 'required',
                    ]);
                    $saveFile = time().'.'.$request->carta_trabajo->extension();  
                    $path_archivo= 'data/clientes/carta_trabajo'.'/'. $saveFile;
                    $request->carta_trabajo->move(public_path('data/clientes/carta_trabajo'), $saveFile);
    
                    
                    $saveFile = SC__documento::find($result['id']);
                    $saveFile->carta_trabajo = $path_archivo;
                    $saveFile->save();
                    
                    return redirect('/adjuntar_document')->with('success', 'Adjunto los documentos carta de trabajo');
    
                }
    

            }

           
           


        $request->validate([
            'cedula' => 'required',
            'carta_trabajo' => 'required',
            'rif' => 'required',
        ]);
        $documento = SC__documento::where('id_usuario', $id)->get();


        if(isset($documento[0]['id_usuario'])  == $id){
            return redirect('/adjuntar_document')->with('error', 'Disculpa ya se Adjunto los documentos');
        }

        $saveFile = time().'.'.$request->cedula->extension();  
        $cedulas= 'data/clientes/cedula'.'/'. $saveFile;
        $request->cedula->move(public_path('data/clientes/cedula'), $saveFile);


        $saveFile = time().'.'.$request->rif->extension();  
        $rifs= 'data/clientes/rif'.'/'. $saveFile;
        $request->rif->move(public_path('data/clientes/rif'), $saveFile);

        $saveFile = time().'.'.$request->carta_trabajo->extension();  
        $path_archivo= 'data/clientes/carta_trabajo'.'/'. $saveFile;
        $request->carta_trabajo->move(public_path('data/clientes/carta_trabajo'), $saveFile);

            $saveFile = new SC__documento;
            $saveFile->first_name =$request->first_name;
            $saveFile->email =$request->email;
            $saveFile->telefono =$request->phone;
            $saveFile->id_usuario = $id;
            $saveFile->cedula = $cedulas;
            $saveFile->rif = $rifs;
            $saveFile->carta_trabajo = $path_archivo;

            if($saveFile->save()){
                
                return redirect('/adjuntar_document')->with('success', 'Adjunto los documentos');


             }else{
                return redirect('/')->with('error', 'error a enviar los datos');

             }
            

    }
}