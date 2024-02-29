<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HargaController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
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

Route::middleware(['guest:buy'])->group(function(){
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/proseslogin', [AuthController::class, 'proseslogin']);

    Route::get('/register', [PelangganController::class, 'register']);
    Route::post('/addreg', [PelangganController::class, 'addreg']);
});

Route::middleware(['guest:user'])->group(function(){
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');

    Route::post('/loginadmin', [AuthController::class, 'loginadmin']);
});


Route::middleware(['auth:buy'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/proseslogout', [AuthController::class, 'proseslogout']);
    //update profile

    //pesan jahit
    Route::get('/jahit/pesan', [PelangganController::class, 'pesan']);
    Route::post('/addPesanan', [PesananController::class, 'addPesanan']);
    Route::post('/pesanan/{pesanan_id}/edit', [PesananController::class, 'editPesanan']);
    Route::post('/pesanan/{pesanan_id}/delete', [PesananController::class, 'delete']);

    //metode
    Route::get('/metodebayar', [PembayaranController::class, 'metodebayar']);
    Route::get('/metodebayar/{pesanan_id}', [PembayaranController::class, 'bayar']);
    Route::post('/addPembayaran', [PembayaranController::class, 'addPembayaran']);
    Route::get('/editmetode/{pesanan_id}', [PembayaranController::class, 'editmetode']);
    Route::post('/pembayaran/{pembayaran_id}/edit', [PembayaranController::class, 'editPembayaran']);
    Route::post('/pembayaran/{pesanan_id}/editS', [PembayaranController::class, 'editPembayaranS']);
    Route::post('/pembayaran/{pembayaran_id}/deleteS', [PembayaranController::class, 'deleteS']);
    // pesanan
    Route::get('/lihatpesanan', [PesananController::class, 'lihatpesanan']);
    Route::get('/editpesan/{pesanan_id}', [PesananController::class, 'editpesan']);
    Route::post('/pesanan/{pesanan_id}/deleteS', [PesananController::class, 'deleteS']);
    //rate
    Route::get('/lihatrate', [RatingController::class, 'lihatrate']);
    //myrate
    Route::get('/myrate', [RatingController::class, 'myrate']);
    Route::get('/addrate', [RatingController::class, 'addrate']);
    Route::post('/addRating', [RatingController::class, 'addRating']);
    Route::post('/rating/{rating_id}/deleteS', [RatingController::class, 'deleteS']);
    //cetak
    Route::get('/cetak', [PembayaranController::class, 'cetak']);

    //add desain
    Route::post('/addDesain/{pesanan_id}', [PesananController::class, 'addDesain']);

    //profile
    Route::get('/editprofile', [PelangganController::class, 'editprofile']);
    Route::post('/profile/{pelanggan_id}/updateprofile', [PelangganController::class, 'updateprofile']);

    //req
    Route::get('/req', [SettingController::class, 'req']);
    Route::get('/addreq', [SettingController::class, 'addreq']);
    Route::post('/addRequest', [SettingController::class, 'addRequest']);
    Route::post('/req/{req_id}/deleteS', [SettingController::class, 'deleteS']);
});

Route::middleware(['auth:user'])->group(function(){
    Route::get('panel/dashboardadmin', [DashboardController::class, 'dashboardadmin']);
    Route::get('/proseslogoutadmin', [AuthController::class, 'proseslogoutadmin']);

    //Harga
    Route::get('/master/harga', [HargaController::class, 'index']);
    Route::post('/addHarga', [HargaController::class, 'addHarga']);
    Route::post('/jenis/{jenis_id}/edit', [HargaController::class, 'editHarga']);
    Route::post('/jenis/{jenis_id}/delete', [HargaController::class, 'delete']);

    //pelanggan
    Route::get('/master/pelanggan', [PelangganController::class, 'index']);
    Route::post('/addPelanggan', [PelangganController::class, 'addPelanggan']);
    Route::post('/pelanggan/{pelanggan_id}/edit', [PelangganController::class, 'editPelanggan']);
    Route::post('/pelanggan/{pelanggan_id}/delete', [PelangganController::class, 'delete']);
    Route::get('/lihatpelanggan/{pelanggan_id}', [PelangganController::class, 'lihatpelanggan']);

    //pesanan
    Route::get('/master/pesanan', [PesananController::class, 'index']);
    Route::post('/pesanan/{pesanan_id}/delete', [PesananController::class, 'delete']);

    Route::post('/pesanan/{pesanan_id}/editStatus', [PesananController::class, 'editStatus']);

    //Rating
    Route::get('/master/rating', [RatingController::class, 'index']);
    Route::post('/rating/{rating_id}/delete', [RatingController::class, 'delete']);

    Route::post('/rating/{rating_id}/editSRating', [RatingController::class, 'editSRating']);

    //pembayaran
    Route::get('/master/pembayaran', [PembayaranController::class, 'index']);
    Route::post('/pembayaran/{pembayaran_id}/delete', [PembayaranController::class, 'delete']);

    Route::post('/pembayaran/{pembayaran_id}/editSPembayaran', [PembayaranController::class, 'editSPembayaran']);

    //role
    Route::get('/master/role', [RoleController::class, 'index']);
    Route::post('/addRole', [RoleController::class, 'addRole']);
    Route::post('/role/{id_role}/edit', [RoleController::class, 'editRole']);
    Route::post('/role/{id_role}/delete', [RoleController::class, 'delete']);
    //bahan
    Route::get('/master/bahan', [BahanController::class, 'index']);
    Route::post('/addBahan', [BahanController::class, 'addBahan']);
    Route::post('/bahan/{bahan_id}/edit', [BahanController::class, 'editBahan']);
    Route::post('/bahan/{bahan_id}/delete', [BahanController::class, 'delete']);
    //report
    //harian
    Route::get('/laporan/harian', [PesananController::class, 'harian']);
    Route::post('/laporan/cetakharian', [PesananController::class, 'cetakharian']);
    //bulan
    Route::get('/laporan/bulanan', [PesananController::class, 'bulanan']);
    Route::post('/laporan/cetakbulanan', [PesananController::class, 'cetakbulanan']);

    Route::get('/settings', [SettingController::class, 'index']);
    Route::post('/upsetting', [SettingController::class, 'upsetting']);

    //set req
    Route::post('/req/{req_id}/editSReq', [SettingController::class, 'editSReq']);
    Route::post('/req/{req_id}/deleteS', [SettingController::class, 'deleteS']);
});