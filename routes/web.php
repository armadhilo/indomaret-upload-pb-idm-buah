<?php

use App\Http\Controllers\ClusterBuahController;
use App\Http\Controllers\DaftarPluHadiahController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalKirimBuahController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterTimbanganController;
use App\Http\Controllers\UploadPbIdmController;
use Illuminate\Support\Facades\Route;

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

//LOGIN
Route::post('/login', [LoginController::class, 'login']);
Route::get('/login', [LoginController::class, 'index']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::middleware(['mylogin'])->group(function () {
    //HOME
    Route::group(['prefix' => 'home'], function(){

        Route::get('/', [HomeController::class, 'index']);
    });

    //MASTER TIMBANGAN
    Route::group(['prefix' => 'master-timbangan'], function(){

        Route::get('/', [MasterTimbanganController::class, 'index']);
        Route::get('/detail/{pluigr}', [MasterTimbanganController::class, 'detail']);
        Route::get('/datatables', [MasterTimbanganController::class, 'datatables']);
        Route::get('/datatables-help-timbangan', [MasterTimbanganController::class, 'datatablesHelpTimbangan']);

        Route::group(['prefix' => 'action'], function(){
            Route::post('add', [MasterTimbanganController::class, 'actionAdd']);
            Route::delete('hapus/{pluigr}/{nama_barang}', [MasterTimbanganController::class, 'actionHapus']);
            Route::get('update-all-data', [MasterTimbanganController::class, 'actionUpdateAllData']);
            Route::get('kirim', [MasterTimbanganController::class, 'actionKirim']);
        });
    });

    //JADWAL KIRIM
    Route::group(['prefix' => 'jadwal-kirim'], function(){

        Route::get('/', [JadwalKirimBuahController::class, 'index']);
        Route::get('/load-toko', [JadwalKirimBuahController::class, 'loadToko']);
        Route::get('/datatables', [JadwalKirimBuahController::class, 'datatables']);
        Route::get('/load-detail-hari/{toko}', [JadwalKirimBuahController::class, 'loadDetailHari']);

        Route::group(['prefix' => 'action'], function(){
            Route::post('save', [JadwalKirimBuahController::class, 'actionSave']);
            Route::delete('hapus/{kode_toko}', [JadwalKirimBuahController::class, 'actionHapus']);
        });
    });

    //CLUSTER BUAH
    Route::group(['prefix' => 'cluster-buah'], function(){

        Route::get('/', [ClusterBuahController::class, 'index']);
        Route::get('/load-toko', [ClusterBuahController::class, 'loadToko']);
        Route::get('/datatables', [ClusterBuahController::class, 'datatables']);


        Route::group(['prefix' => 'action'], function(){
            Route::post('save', [ClusterBuahController::class, 'actionSave']);
            Route::delete('hapus/{kode_toko}', [ClusterBuahController::class, 'actionHapus']);
        });
    });

    //UPLOAD PB IDM
    Route::group(['prefix' => 'upload-pb-idm'], function(){

        Route::get('/', [UploadPbIdmController::class, 'index']);
        Route::get('/datatablesHeader', [UploadPbIdmController::class, 'showDatatablesHeader']);
        Route::get('/datatablesDetail/{noPB}/{tglPB}/{KodeToko}', [UploadPbIdmController::class, 'showDatatablesDetail']);


        Route::group(['prefix' => 'action'], function(){
            Route::post('upload-csv', [UploadPbIdmController::class, 'actionF3']);
            Route::get('proses-alokasi', [UploadPbIdmController::class, 'actionF6']);
        });
    });

    //PLU HADIAH
    Route::group(['prefix' => 'plu-hadiah'], function(){

        Route::get('/', [DaftarPluHadiahController::class, 'index']);
        Route::get('/datatables-master', [DaftarPluHadiahController::class, 'datatablesProdMaster']);
        Route::get('/datatables-hadiah', [DaftarPluHadiahController::class, 'datatablesHadiahPerishable']);


        Route::group(['prefix' => 'action'], function(){
            Route::post('insert', [DaftarPluHadiahController::class, 'actionInsertHadiahPerishable']);
            Route::delete('hapus/{prdcd}', [DaftarPluHadiahController::class, 'actionHapusHadiahPerishable']);
        });
    });
});
