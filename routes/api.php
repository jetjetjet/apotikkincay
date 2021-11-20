<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SupplierController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::group(['middleware' => 'auth:sanctum'], function() {
	Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
	Route::get('/role-grid', [RoleController::class, 'grid'])->middleware('can:peran-lihat');
	Route::get('/role-permissions', [RoleController::class, 'getPermission']);
	Route::get('/role/{id}', [RoleController::class, 'show'])->middleware('can:peran-lihat');
	Route::post('/role', [RoleController::class, 'store'])->middleware('can:peran-tambah');
	Route::put('/role/{id}', [RoleController::class, 'update'])->middleware('can:peran-ubah');
	Route::delete('/role/{id}',  [RoleController::class, 'destroy'])->middleware('can:peran-hapus');
	
	Route::get('/satuan-grid', [SatuanController::class, 'grid']);
	Route::get('/satuan/{id}', [SatuanController::class, 'show']);
	Route::post('/satuan', [SatuanController::class, 'store']);
	Route::put('/satuan/{id}', [SatuanController::class, 'update']);
	Route::delete('/satuan/{id}', [SatuanController::class, 'destroy']);

  Route::get('/kategori-grid', [KategoriController::class, 'grid']);
  Route::get('/kategori/{id}', [KategoriController::class, 'show']);
  Route::post('/kategori', [KategoriController::class, 'store']);
  Route::put('/kategori/{id}', [KategoriController::class, 'update']);
  Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']);

  Route::get('/merk-grid', [MerkController::class, 'grid']);
  Route::get('/merk/{id}', [MerkController::class, 'show']);
  Route::post('/merk', [MerkController::class, 'store']);
  Route::put('/merk/{id}', [MerkController::class, 'update']);
  Route::delete('/merk/{id}', [MerkController::class, 'destroy']);

  Route::get('/supplier-grid', [SupplierController::class, 'grid']);
  Route::get('/supplier/{id}', [SupplierController::class, 'show']);
  Route::post('/supplier', [SupplierController::class, 'store']);
  Route::put('/supplier/{id}', [SupplierController::class, 'update']);
  Route::delete('/supplier/{id}', [SupplierController::class, 'destroy']);

  Route::get('/item-grid', [ItemController::class, 'grid']);
  Route::get('/item/{id}', [ItemController::class, 'show']);
  Route::post('/item', [ItemController::class, 'store']);
  Route::put('/item/{id}', [ItemController::class, 'update']);
  Route::delete('/item/{id}', [ItemController::class, 'destroy']);

  Route::get('/pelanggan-grid', [PelangganController::class, 'grid']);
  Route::get('/pelanggan/{id}', [PelangganController::class, 'show']);
  Route::post('/pelanggan', [PelangganController::class, 'store']);
  Route::put('/pelanggan/{id}', [PelangganController::class, 'update']);
  Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy']);

  Route::get('/product-grid', [ProductController::class, 'grid']);
  Route::get('/product/{id}', [ProductController::class, 'show']);
  Route::post('/product', [ProductController::class, 'store']);
  Route::put('/product/{id}', [ProductController::class, 'update']);
  Route::delete('/product/{id}', [ProductController::class, 'destroy']);

  Route::get('/stok-grid', [StokController::class, 'grid']);
  Route::get('/stok/{id}', [StokController::class, 'show']);
  Route::post('/stok', [StokController::class, 'store']);
  Route::put('/stok/{id}', [StokController::class, 'update']);
  Route::delete('/stok/{id}', [StokController::class, 'destroy']);
});
