<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\shopcontroller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('inicio',[shopcontroller::class,'inicio'])->name('inicio');
Route::get('compradetalle',[shopcontroller::class,'compradetalle'])->name('compradetalle');
Route::get('contacto',[shopcontroller::class,'contacto'])->name('contacto');
Route::get('listaproductos',[shopcontroller::class,'listaproductos'])->name('listaproductos');
Route::get('login',[shopcontroller::class,'login'])->name('login');
Route::get('micuenta',[shopcontroller::class,'micuenta'])->name('micuenta');
Route::get('listadeseos',[shopcontroller::class,'listadeseos'])->name('listadeseos');
Route::get('verificar',[shopcontroller::class,'verificar'])->name('verificar');
Route::get('carrito',[shopcontroller::class,'carrito'])->name('carrito');


Route::get('catalogarmarcas', [Shopcontroller::class, 'catalogarmarcas'])->name('catalogarmarcas');
Route::post('catalogarmarcas/store', [Shopcontroller::class, 'store'])->name('marcas.store');
Route::put('catalogarmarcas/update/{idma}', [ShopController::class, 'update'])->name('marcas.update');
Route::delete('catalogarmarcas/destroy/{idma}', [Shopcontroller::class, 'destroy'])->name('marcas.destroy');


