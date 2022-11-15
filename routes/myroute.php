<?php
$prefixCustomer = sc_config('PREFIX_MEMBER') ?? 'customer';
if (file_exists(app_path('Http/Controllers/ShopAccountController.php'))) {
    $nameSpaceFrontCustomer = 'App\Http\Controllers';
} else {
    $nameSpaceFrontCustomer = 'SCart\Core\Front\Controllers';
}

if (sc_config('customer_verify')) {
    $midlware = ['auth','email.verify'];
} else {
    $midlware = ['auth'];
}




$nameSpaceAdminCustomer = 'App\Admin\Controllers';

Route::group(['prefix' => 'customer'], function () use ($nameSpaceAdminCustomer) {
    Route::get('/', $nameSpaceAdminCustomer.'\AdminCustomerController@index')->name('admin_customer.index');
    Route::get('create', $nameSpaceAdminCustomer.'\AdminCustomerController@create')->name('admin_customer.create');
    Route::post('/create', $nameSpaceAdminCustomer.'\AdminCustomerController@postCreate')->name('admin_customer.create');
    Route::get('/edit/{id}', $nameSpaceAdminCustomer.'\AdminCustomerController@edit')->name('admin_customer.edit');

    Route::get('/document/{id}', $nameSpaceAdminCustomer.'\AdminCustomerController@document')->name('admin_customer.document');
    Route::post('/document_admin', $nameSpaceAdminCustomer.'\AdminCustomerController@documentn')->name('document_admin');

    Route::post('/edit/{id}', $nameSpaceAdminCustomer.'\AdminCustomerController@postEdit')->name('admin_customer.edit');
    Route::post('ref_personales', $nameSpaceAdminCustomer.'\AdminCustomerController@ref_personales')->name('ref_personales');
    Route::post('/delete', $nameSpaceAdminCustomer.'\AdminCustomerController@deleteList')->name('admin_customer.delete');
    Route::get('/update-address/{id}', $nameSpaceAdminCustomer.'\AdminCustomerController@updateAddress')->name('admin_customer.update_address');
    Route::post('/update-address/{id}', $nameSpaceAdminCustomer.'\AdminCustomerController@postUpdateAddress')->name('admin_customer.post_update_address');
    Route::post('/delete-address', $nameSpaceAdminCustomer.'\AdminCustomerController@deleteAddress')->name('admin_customer.delete_address');

    // Route::get('/downloadpdf',$nameSpaceAdminCustomer.'\AdminCustomerController@downloadPdf' );
});

if (file_exists(app_path('Admin/Controllers/AdminProductController.php'))) {
    $nameSpaceAdminProduct = 'App\Admin\Controllers';
} 
Route::group(['prefix' => 'product'], function () use ($nameSpaceAdminProduct) {
    Route::get('/', $nameSpaceAdminProduct.'\AdminProductController@index')->name('admin_product.index');
    Route::get('create', $nameSpaceAdminProduct.'\AdminProductController@create')->name('admin_product.create');
    Route::get('build_create', $nameSpaceAdminProduct.'\AdminProductController@createProductBuild')->name('admin_product.build_create');
    Route::get('group_create', $nameSpaceAdminProduct.'\AdminProductController@createProductGroup')->name('admin_product.group_create');
    Route::post('/create', $nameSpaceAdminProduct.'\AdminProductController@postCreate')->name('admin_product.create');
    Route::get('/edit/{id}', $nameSpaceAdminProduct.'\AdminProductController@edit')->name('admin_product.edit');
    Route::post('/edit/{id}', $nameSpaceAdminProduct.'\AdminProductController@postEdit')->name('admin_product.edit');
    Route::post('/delete', $nameSpaceAdminProduct.'\AdminProductController@deleteList')->name('admin_product.delete');
    Route::post('/clone', $nameSpaceAdminProduct.'\AdminProductController@cloneProduct')->name('admin_product.clone');

});

Route::group(['prefix' => 'order'], function () use ($nameSpaceAdminProduct) {

    Route::get('/detalle_pago','App\Admin\Controllers\HistorialPagosController@detalle')->name('historial_pagos.detalle');
    Route::post('/estatus-pago', 'App\Admin\Controllers\HistorialPagosController@postEstatusPago')->name('post_status_pago');
    Route::get('/historial_pagos','App\Admin\Controllers\HistorialPagosController@index')->name('historial_pagos.index');
    Route::get('/reportar_pago','App\Admin\Controllers\HistorialPagosController@reportarPago')->name('historial_pagos.reportar');
    Route::get('/obtener_orden','App\Admin\Controllers\AdminOrderController@geDetailorder')->name('obtener_orden');
    Route::post('/crear_convenio', 'App\Admin\Controllers\HistorialPagosController@postCrearConvenio')->name('crear_convenio');


});




$nameSpaceFrontCustomer = 'App\Http\Controllers';
$suffix = sc_config('SUFFIX_URL')??'';
$prefixCustomerClient = sc_config('PREFIX_MEMBER') ?? 'customer';


Route::group(
    [
        'prefix' => $langUrl.$prefixCustomerClient,
        'middleware' => $midlware
    ],
    function ($router) use ($suffix, $nameSpaceFrontCustomer) {
        $router->get('/historial-pagos', $nameSpaceFrontCustomer.'\ShopAccountController@historialPagos')
            ->name('customer.historial_pagos');

            $router->get('/reportar-pago/{id}', $nameSpaceFrontCustomer.'\ShopAccountController@reportarPago')
            ->name('customer.reportar_pago');
       

    }
);





 