<?php

namespace App\Handlers;

class LfmConfigHandler extends \UniSharp\LaravelFilemanager\Handlers\ConfigHandler
{
    public function userField()
    {
     
  
        if (session('perfil')=='cliente') {

          
            $customer=json_decode(session('customer'));

       
            return trim($customer->id);
        }

    

        if (session('adminStoreId') == SC_ID_ROOT) {
       
            return ;
        }


        if (sc_check_multi_vendor_installed()) {
            return session('adminStoreId');
        } else {
            return;
        }
    }
}
