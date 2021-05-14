<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\ProductoController;

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

Route::get('/', function () {
    return view('welcome');
});



Route::get('/kardex', [KardexController::class, 'getViewKardex'])->name('kardex.getViewKardex');

Route::post('/kardex', [KardexController::class, 'aggKardex']);





Route::get('/producto', [ProductoController::class, 'getViewProducto'])->name('producto.getViewProduct');

Route::post('/producto', [ProductoController::class, 'aggProducto']);

Route::delete('/producto', [ProductoController::class, 'destroy']);

Route::put('/producto', [ProductoController::class, 'update']);
