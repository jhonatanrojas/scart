<?php

namespace App\Http\Controllers;

use SCart\Core\Admin\Models\AdminCustomer;
use App\Models\AdminOrder;
use App\Models\SC__documento;
use SCart\Core\Front\Controllers\RootFrontController;
use SCart\Core\Front\Models\ShopCountry;
use SCart\Core\Front\Models\ShopOrder;
use SCart\Core\Front\Models\ShopOrderStatus;
use SCart\Core\Front\Models\ShopShippingStatus;
use SCart\Core\Front\Models\ShopCustomer;
use SCart\Core\Front\Models\ShopCustomField;
use SCart\Core\Front\Models\ShopAttributeGroup;
use SCart\Core\Front\Models\ShopCustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use SCart\Core\Front\Controllers\Auth\AuthTrait;
use App\Models\Catalogo\MetodoPago;

use App\Models\Catalogo\PaymentStatus;
use App\Models\Convenio;
use App\Models\Estado;
use App\Models\HistorialPago;
use App\Models\Municipio;
use App\Models\Parroquia;
use App\Models\Sc_plantilla_convenio;
use App\Models\SC_referencia_personal;
use App\Models\SC_shop_customer;
use App\Models\shop_order_detail;
use App\Events\Biopago;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Cart;
use App\Models\Catalogo\Banco;
use App\DTOs\ConciliacionMovimientoDTO;
use App\Services\ConciliacionMovimientosService;
use SCart\Core\Admin\Models\AdminProduct;


use SCart\Core\Front\Models\ShopPaymentStatus;

class RifaClientController extends RootFrontController
{
    use AuthTrait;

    public function __construct()
    {
        parent::__construct();
    }

    
    public function registrarRifa(){


        return view(
            
            $this->templatePath . '.rifa.register',
            array(
                'title'       => sc_language_render('customer.title_register'),
                'countries'   => ShopCountry::getCodeAll(),
                'layout_page' => 'shop_auth',

                'customFields'=> (new ShopCustomField)->getCustomField($type = 'customer'),
                'breadcrumbs' => [
                    ['url'    => '', 'title' => 'Adquirir Rifa'],
                ],
            )
        );
    }


    public function add_numero(){

        return view(
            
            $this->templatePath . '.rifa.add_number',
            array(
                'title'       => sc_language_render('customer.title_register'),
                'countries'   => ShopCountry::getCodeAll(),
                'layout_page' => 'shop_auth',

                'customFields'=> (new ShopCustomField)->getCustomField($type = 'customer'),
                'breadcrumbs' => [
                    ['url'    => '', 'title' => 'Seleccionar Numero'],
                ],
            )
        );

    }
}
