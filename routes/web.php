<?php

use App\Admin\Controllers\AdminOrderController;
use App\Admin\Controllers\AdminProductController;
use App\Admin\Controllers\HistorialPagosController;
use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\Municipio;
use App\Http\Controllers\Parroquia;
use App\Http\Controllers\Productos_cuota;
use Illuminate\Support\Facades\Route;


Route::get('municipio/{id}', [Municipio::class , 'get_municipio']);
Route::get('parroquia/{municipio}/{estado}', [Parroquia::class , 'get_parroquia']);



Route::controller(DocumentosController::class)->group(function(){
    Route::get('/adjuntar_document', 'index')->name('adjuntar_document');
    Route::post('/enviar_document', [DocumentosController::class , 'enviar_document'])->name('enviar_document');
});
Route::controller(Productos_cuota::class)->group(function(){
    Route::get('/product', [Productos_cuota::class ,'get_proct_cuotas']);
    Route::delete('/product/{id}/{id2}', [Productos_cuota::class , 'product_delete']);
});


Route::post('/reportar-pago', 'ShopAccountController@postReportarPago')->name('post_reporte_pago');
Route::get('convenio', 'ShopAccountController@convenio')->name('convenio');
Route::get('pago_exitoso', 'ShopAccountController@pago_exitoso')->name('pago_exitoso');
Route::get('biopago', 'ShopAccountController@biopago')->name('biopago');
Route::post('convenio', [HistorialPagosController::class ,'postUpdate'])->name('convenio');
//ruta para eliminar una pago de sc_historial_pagos ajax
Route::post('/sc_admin/historial_pagos/eliminar', [HistorialPagosController::class ,'eliminar_pago'])->name('historial_pagos.delete')->middleware('admin');;
//ruta para obtener pagos de un arden
Route::get('/sc_admin/historial_pagos/getpagosajax', [HistorialPagosController::class ,'getpagosajax'])->name('getPagosAjax');
Route::get('/sc_admin/historial_pagos/getPagosBdvAjax', [HistorialPagosController::class ,'getPagosBdvAjax'])->name('getPagosBdvAjax');

//ruta para crear un nuevo pago en sc_historial_pagos
Route::post('/sc_admin/historial_pagos/create', [HistorialPagosController::class ,'postCreate'])->name('historial_pagos.postCreate');

Route::get('/downloadPdf/{id}', [AdminOrderController::class,'downloadPdf'])->name('downloadPdf');


Route::get('/downloadJuradada/{id}', [AdminOrderController::class,'downloadJuradada'])->name('downloadJuradada');

Route::get('sc_admin/borrador_pdf/{id}', [AdminOrderController::class,'borrador_pdf'])->name('borrador_pdf');
Route::get('sc_admin/ficha_pedido', [AdminOrderController::class,'ficha_pedido'])->name('ficha_pedido')->middleware('admin');
Route::get('sc_admin/ficha_propuesta', [AdminOrderController::class,'ficha_propuesta'])->name('propuesta');

Route::get('sc_admin/list_propuesta', [AdminOrderController::class,'list_propuesta'])->name('list_propuesta')->middleware('admin');


Route::get('sc_admin/export_product', [AdminProductController::class,'export_product'])->name('export_product');
Route::get('sc_admin/actualizar_imagenes', [AdminProductController::class,'actualizar_imagenes'])->name('actualizar_imagenes');

 

//[ 'middleware' => 'admin']



Route::get('/borrador_pdf/{id}', 'ShopAccountController@borrador_pdf')->name('borrador_cliente');


Route::match(['get', 'post'], 'sc_admin/declaracion_jurada', [AdminOrderController::class,'declaracion_jurada'])->name('declaracion_jurada');

Route::get('sc_admin/edit_convenio', [AdminOrderController::class,'edit_convenio'])->name('edit_convenio');


Route::get('sc_admin/declaracion_jurada', [AdminOrderController::class,'declaracion_jurada'])->name('declaracion_jurada');

Route::get('sc_admin/editar_convenio/{id}', [AdminOrderController::class,'editar_convenio'])->name('editar_convenio');

Route::get('sc_admin/editar_plantilla/{id}', [AdminOrderController::class,'editar_convenio_cliente'])->name('editar_convenio_cliente');

Route::post('sc_admin/create_convenio/{id}', [AdminOrderController::class,'postCreate_convenio'])->name('create_convenio');

Route::get('/QR_historial/{id}', 'ShopAccountController@view_QR')->name('view_QR');

Route::get('sc_admin/descargar-excel', [AdminOrderController::class,'descargar'])->name('descargar.excel');
Route::get('sc_admin/descargar-excelpago', [HistorialPagosController::class,'descargar'])->name('descargar.excelpago');
Route::get('sc_admin/order/ventas',  [AdminOrderController::class,'index'])->name('pedidos_ventas');
Route::get('sc_admin/order/riesgo',  [AdminOrderController::class,'index'])->name('pedidos_riesgo');
Route::get('sc_admin/order/administracion',  [AdminOrderController::class,'index'])->name('pedidos_administracion');
Route::controller(AdminOrderController::class)->group(function(){
Route::get('/sc_admin/fecha_entrega', [AdminOrderController::class,'fecha_entrega'])->name('fecha_entrega');
Route::get('/sc_admin/fecha_create', [AdminOrderController::class,'fecha_create'])->name('fecha_create');
Route::post('/sc_admin/fecha_edit/{id}', [AdminOrderController::class,'fecha_edit'])->name('fecha_edit');

Route::get('sc_admin/reporte_de_pedido', [AdminOrderController::class,'reporte_de_pedido'])->name('reporte_de_pedido');

Route::post('/sc_admin/fecha_delete/{id}', [AdminOrderController::class,'fecha_delete'])->name('fecha_delete');



});


Route::post('convenio', [HistorialPagosController::class ,'postUpdate'])->name('convenio'); 

Route::get('/sc_admin/descargar-excel-pagos', [HistorialPagosController::class ,'descargarExcel'])->name('descargarExcelPagos');
 

Route::post('/sc_admin/tasa_cambio', [HistorialPagosController::class ,'post_crear_tasa'])->name('tasa_cambio.crear');
Route::get('/sc_admin/tasa_cambio', [HistorialPagosController::class ,'crear_tasa_cambio'])->name('tasa_cambio'); 
Route::get('/sc_admin/list_tasa_cambio', [HistorialPagosController::class ,'list_tasa_cambio'])->name('list_tasa_cambio');

Route::get('/sc_admin/pagos_realizado',[HistorialPagosController::class ,'pagos_realizado'])->name('pagos_realizado')->middleware('admin');

Route::get('/sc_admin/pago_diarios',[HistorialPagosController::class ,'pago_diarios'])->name('pago_diarios')->middleware('admin');

Route::get('/sc_admin/cobranza_mensual',[HistorialPagosController::class ,'cobranza_mensual'])->name('cobranza_mensual');

Route::get('sc_admin/historial_cliente', [HistorialPagosController::class,'historial_cliente'])->name('historial.cliente')->middleware(['admin']);

Route::get('sc_admin/notas_d_entrega', [HistorialPagosController::class,'notas_d_entrega'])->name('notas.entrega');

Route::get('sc_admin/actualizar_puntos_de_clientes', [HistorialPagosController::class,'actualizar_puntos_de_clientes'])->name('actualizar_puntos_de_clientes');












