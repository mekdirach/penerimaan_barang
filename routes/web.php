<?php

use App\Http\Controllers\PenerimaanBarangController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\PenerimaanBarangForm;

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



Route::get('/penerimaan-barang/create', PenerimaanBarangForm::class)->name('penerimaan-barang.create');
Route::get('/penerimaan-barang', [PenerimaanBarangController::class, 'index'])->name('penerimaan-barang.index');
