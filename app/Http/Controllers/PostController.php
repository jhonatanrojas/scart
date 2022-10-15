<?php
  
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use App\Models\SC__documento;
use SCart\Core\Front\Models\ShopCountry;
use SCart\Core\Front\Models\ShopCustomField;

class PostController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $customer = auth()->user();
        $id = $customer['id'];
        
        $documento = SC__documento::where('id_usuario', $id)->get();

        // if($documento[0]['id_usuario'] == $id){
        //     // return with('error', 'porfavor adjunte los documentos para procesar su solicitudes de compras');
            
        // }

        return view('posts')
            ->with(
                [
                    'title'       => 'adjuntar documento',
                    'customer'    => $customer,
                    'mensaje' => "hola",
                    'countries'   => ShopCountry::getCodeAll(),
                    'layout_page' => 'shop_profile',
                    'customFields' => (new ShopCustomField())->getCustomField($type = 'customer'),
                    'breadcrumbs' => [
                        ['url'    => sc_route('customer.index'), 'title' => sc_language_render('front.my_account')],
                        ['url'    => '', 'title' => sc_language_render('customer.change_infomation')],
                    ],
                ]
            );
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function enviar_document(Request $request)
    {

        
        $validator = Validator::make($request->all(), [
            'cedula' => 'required',
            'carta_trabajo' => 'required',
            
        ]);
  
        if ($validator->fails()) {

            return redirect('/adjuntar_document')->with('error', 'Adjuntar Cedula  Rif y Carta de trabajo');
        }

       

        if($request->hasFile("cedula") && $request->hasFile("carta_trabajo")){
            $check = getimagesize($_FILES["cedula"]["tmp_name"]);
            $carta = getimagesize($_FILES["carta_trabajo"]["tmp_name"]);
            if($check !== false && $carta !== false){
            $cedula = $_FILES['cedula']['tmp_name'];
            $imgContent1 = addslashes(file_get_contents($cedula));
            $carta_trabajo = $_FILES['carta_trabajo']['tmp_name'];
            $imgContent2 = addslashes(file_get_contents($carta_trabajo));
      
        }
            $customer = auth()->user();
            $id = $customer['id'];

            $saveFile = new SC__documento;
            $saveFile->first_name =$request->first_name;
            $saveFile->email =$request->email;
            $saveFile->telefono =$request->phone;
            $saveFile->id_usuario = $id;
            $saveFile->cedula_rif = $imgContent1;
            $saveFile->carta_trabajo = $imgContent2;

            $documento = SC__documento::where('id_usuario', $id)->get();
         
            if(isset($documento[0]['id_usuario'])  == $id){
                return redirect('/adjuntar_document')->with('error', 'Disculpa ya completaste tu datos');
            }else{
                $saveFile->save();

            }
           
            

            if($saveFile){
                return redirect('/adjuntar_document')->with('success', 'Datos enviado con exito');
             }
            
        }
       
       
  
       
    }
}