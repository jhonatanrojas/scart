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


Route::group(['prefix' => $prefixCustomer.'/uploads', 'namespace' 
=> '\\UniSharp\\LaravelFilemanager\\Controllers\\',
'middleware' =>['auth']

], function () {

    // display main layout
    Route::get('/', [
        'uses' => 'LfmController@show',
        'as' => 'unisharp.lfm.show',
    ]);

    // display integration error messages
    Route::get('/errors', [
        'uses' => 'LfmController@getErrors',
        'as' => 'unisharp.lfm.getErrors',
    ]);

    // upload
    Route::post('/upload', [
        'uses' => 'UploadController@upload',
        'as' => 'unisharp.lfm.upload',
    ]);

    // list images & files
    Route::get('/jsonitems', [
        'uses' => 'ItemsController@getItems',
        'as' => 'unisharp.lfm.getItems',
    ]);

    Route::get('/move', [
        'uses' => 'ItemsController@move',
        'as' => 'unisharp.lfm.move',
    ]);

    Route::get('/domove', [
        'uses' => 'ItemsController@domove',
        'as' => 'unisharp.lfm.domove',
    ]);

    // folders
    Route::get('/newfolder', [
        'uses' => 'FolderController@getAddfolder',
        'as' => 'unisharp.lfm.getAddfolder',
    ]);

    // list folders
    Route::get('/folders', [
        'uses' => 'FolderController@getFolders',
        'as' => 'unisharp.lfm.getFolders',
    ]);

    // crop
    Route::get('/crop', [
        'uses' => 'CropController@getCrop',
        'as' => 'unisharp.lfm.getCrop',
    ]);
    Route::get('/cropimage', [
        'uses' => 'CropController@getCropimage',
        'as' => 'unisharp.lfm.getCropimage',
    ]);
    Route::get('/cropnewimage', [
        'uses' => 'CropController@getNewCropimage',
        'as' => 'unisharp.lfm.getCropnewimage',
    ]);

    // rename
    Route::get('/rename', [
        'uses' => 'RenameController@getRename',
        'as' => 'unisharp.lfm.getRename',
    ]);

    // scale/resize
    Route::get('/resize', [
        'uses' => 'ResizeController@getResize',
        'as' => 'unisharp.lfm.getResize',
    ]);
    Route::get('/doresize', [
        'uses' => 'ResizeController@performResize',
        'as' => 'unisharp.lfm.performResize',
    ]);

    // download
    Route::get('/download', [
        'uses' => 'DownloadController@getDownload',
        'as' => 'unisharp.lfm.getDownload',
    ]);

    // delete
    Route::get('/delete', [
        'uses' => 'DeleteController@getDelete',
        'as' => 'unisharp.lfm.getDelete',
    ]);
});

$nameSpaceAdminCustomer = 'App\Admin\Controllers';

Route::group(['prefix' => 'customer'], function () use ($nameSpaceAdminCustomer) {
    Route::get('/', $nameSpaceAdminCustomer.'\AdminCustomerController@index')->name('admin_customer.index');
    Route::get('create', $nameSpaceAdminCustomer.'\AdminCustomerController@create')->name('admin_customer.create');
    Route::post('/create', $nameSpaceAdminCustomer.'\AdminCustomerController@postCreate')->name('admin_customer.create');
    Route::get('/edit/{id}', $nameSpaceAdminCustomer.'\AdminCustomerController@edit')->name('admin_customer.edit');

    Route::get('/document/{id}', $nameSpaceAdminCustomer.'\AdminCustomerController@document')->name('admin_customer.document');

    Route::post('/edit/{id}', $nameSpaceAdminCustomer.'\AdminCustomerController@postEdit')->name('admin_customer.edit');
    Route::post('/delete', $nameSpaceAdminCustomer.'\AdminCustomerController@deleteList')->name('admin_customer.delete');
    Route::get('/update-address/{id}', $nameSpaceAdminCustomer.'\AdminCustomerController@updateAddress')->name('admin_customer.update_address');
    Route::post('/update-address/{id}', $nameSpaceAdminCustomer.'\AdminCustomerController@postUpdateAddress')->name('admin_customer.post_update_address');
    Route::post('/delete-address', $nameSpaceAdminCustomer.'\AdminCustomerController@deleteAddress')->name('admin_customer.delete_address');
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





 