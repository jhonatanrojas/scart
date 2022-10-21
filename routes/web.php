<?php

use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\Municipio;
use App\Http\Controllers\Parroquia;
use Illuminate\Support\Facades\Route;


Route::get('municipio/{id}', [Municipio::class , 'get_municipio']);
Route::get('parroquia/{municipio}/{estado}', [Parroquia::class , 'get_parroquia']);

Route::controller(DocumentosController::class)->group(function(){
    Route::get('/adjuntar_document', 'index')->name('adjuntar_document');
    Route::post('/enviar_document', [DocumentosController::class , 'enviar_document'])->name('enviar_document');
});




