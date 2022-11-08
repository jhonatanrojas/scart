<?php

use App\Admin\Controllers\AdminOrderController;
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

Route::get('/downloadPdf/{id}', [AdminOrderController::class,'downloadPdf'])->name('downloadPdf');




