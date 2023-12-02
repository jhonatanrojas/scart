<?php

namespace SCart\Core\Handlers;

class LfmConfigHandler extends \UniSharp\LaravelFilemanager\Handlers\ConfigHandler
{
    public function userField()
    {

   
        if (strlen(request('type'))=='36') {

          
       
            return trim(request('type'));
        }

    
        // If domain is root, dont split folder
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
