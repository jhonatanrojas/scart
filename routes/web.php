<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\Municipio;
use App\Http\Controllers\Parroquia;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
// Route::get('/', function () {
//     return view('welcome');
// });




Route::get('municipio/{id}', [Municipio::class , 'get_municipio']);
Route::get('parroquia/{municipio}/{estado}', [Parroquia::class , 'get_parroquia']);

Route::controller(PostController::class)->group(function(){
    Route::get('/adjuntar_document', 'index')->name('adjuntar_document');
    Route::post('/enviar_document', [PostController::class , 'enviar_document'])->name('enviar_document');
});




