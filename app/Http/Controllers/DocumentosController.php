<?php
  
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Models\Post;
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
        if(!isset($documento[0]['id_usuario']) == $id){
           $dato = "Para procesar sus solicitudes de compras, se requiere que adjunte Cedula, RIF y constancia de trabajo";
           
        }else $dato = "";

        return view('templates/s-cart-light/account/documentos')
            ->with(
                [
                    'title'       => 'adjuntar documento',
                    'documentos'       => $documento,
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
        $request->validate([
            'cedula' => 'required',
            'carta_trabajo' => 'required',
            'rif' => 'required',
        ]);
       
        $validator = Validator::make($request->all(), [
    
            'cedula' => 'required',
            'carta_trabajo' => 'required',
            'rif' => 'required',
            
        ]);
  
        // if ($validator->fails()) {
        //     return redirect('/adjuntar_document')->with('error', 'Adjuntar Cedula  Rif y Contancia de trabajo');
        // }

            $customer = auth()->user();
            $id = $customer['id'];

            $saveFile = new SC__documento;
            $saveFile->first_name =$request->first_name;
            $saveFile->email =$request->email;
            $saveFile->telefono =$request->phone;
            $saveFile->id_usuario = $id;
            $saveFile->cedula = $request->cedula;
            $saveFile->rif = $request->rif;
            $saveFile->carta_trabajo = $request->carta_trabajo;

            $documento = SC__documento::where('id_usuario', $id)->get();
         
            if(isset($documento[0]['id_usuario'])  == $id){
                return redirect('/adjuntar_document')->with('error', 'Disculpa ya se Adjunto los documentos');
            }else $saveFile->save();

            if($saveFile){
                return redirect('/adjuntar_document')->with('success', 'Datos enviado con exito');
             }
            

       
    }
}