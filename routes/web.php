<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\ResponseController;

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
    return view('index');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('store',[DonorController::class,'store'])->name('store');

Route::post('/auth',[DonorController::class,'auth'])->name('auth');
Route::middleware(['isLogin', 'CekRole:petugas'])->group(function(){
    Route::get('/data/petugas', [DonorController::class,'dataPetugas'])->name('data_petugas');
    //menampilkan form tambah atau response
    Route::get('/response/edit/{report_id}',[ResponseController::class, 'edit'])->name('response.edit');
    //kirim data respon. menggunakan patch, karena dia bisa berupa tambah data atau  update data
    Route::patch('/response/update/{report_id}', [ResponseController::class, 'update'])->name('response.update');
    });

    Route::middleware(['isLogin', 'CekRole:admin,petugas'])->group(function(){
        Route::get('/logout',[DonorController::class, 'logout'])->name('logout');
    });

    Route::middleware(['isLogin', 'CekRole:admin'])->group(function() {
        Route::get('/data',[DonorController::class, 'data'])->name('data');
        Route::delete('/delete/{id}',[DonorController::class, 'destroy'])->name('destroy');
        Route::get('/export/pdf',[DonorController::class,'exportPDF'])->name('export-pdf');
        Route::get('created/pdf/{id}', [DonorController::class, 'createdPDF'])->name('created.pdf');
        Route::get('/export/excel', [DonorController::class,'exportExcel'])->name('export-excel');
    });
    
