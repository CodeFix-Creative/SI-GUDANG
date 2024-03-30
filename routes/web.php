<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\BonusHistoryController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\DetailPemasukanController;
use App\Http\Controllers\DetailPemasukanSalesController;
use App\Http\Controllers\DetailPengeluaranController;
use App\Http\Controllers\DetailPengeluaranSalesController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranCreditController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProdukReturController;
use App\Http\Controllers\SuplierController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\TransaksiPemasukanController;
use App\Http\Controllers\TransaksiPemasukanSalesController;
use App\Http\Controllers\TransaksiPengeluaranController;
use App\Http\Controllers\TransaksiPengeluaranSalesController;
use App\Http\Controllers\ProdukMasukController;
use App\Http\Controllers\ProdukHargaController;

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
 return redirect()->route('dashboard.index');
});

Route::prefix('admin')->middleware('auth')->group(function() {
  // DASHBOARD
  Route::resource('dashboard', DashboardController::class);


  // User
  Route::resource('user', UserController::class);

  // Ganti Password
  Route::get('/ubah-password', [UserController::class, 'ubahPassword'])->name('password.change');
  Route::post('/ubah-password', [UserController::class, 'postNewPassword'])->name('password.post');

  // Sales
  Route::resource('sales', SalesController::class);

  // Toko
  Route::resource('toko', TokoController::class);

  // Pelanggan
  Route::resource('pelanggan', PelangganController::class);

  // Suplier
  Route::resource('suplier', SuplierController::class);

  // Kategori Produk
  Route::resource('kategori-produk', KategoriProdukController::class);

  // Produk
  Route::resource('produk', ProdukController::class);

  // Produk Masuk
  Route::resource('produk-masuk', ProdukMasukController::class);
  Route::get('/produk-masuk-diterima/{produkMasuk}', [ProdukMasukController::class, 'diterima'])->name('produk-masuk.diterima');
  Route::get('/produk-masuk-ditolak/{produkMasuk}', [ProdukMasukController::class, 'ditolak'])->name('produk-masuk.ditolak');

  // Produk Retur
  Route::resource('produk-retur', ProdukReturController::class);
  Route::get('/produk-retur-diterima/{produkRetur}', [ProdukReturController::class, 'diterima'])->name('produk-retur.diterima');
  Route::get('/produk-retur-ditolak/{produkRetur}', [ProdukReturController::class, 'ditolak'])->name('produk-retur.ditolak');

  // produk
  Route::resource('produk-harga', ProdukHargaController::class);

  // Bonus
  Route::resource('bonus', BonusController::class);

  // Bonus
  Route::resource('bonus-history', BonusHistoryController::class);

  // Pemasukan
  Route::resource('transaksi-pemasukan', TransaksiPemasukanController::class);
  Route::get('/transaksi-pemasukan-form/{id}', [TransaksiPemasukanController::class, 'form'])->name('transaksi-pemasukan.form');

  Route::post('/addToCart', [TransaksiPemasukanController::class, 'addToCart'])->name('addToCart');
  Route::post('/removeCart', [TransaksiPemasukanController::class, 'removeCart'])->name('removeCart');
  Route::post('/checkout', [TransaksiPemasukanController::class, 'checkout'])->name('checkout');
  
  
  // Credit
  Route::resource('credit', CreditController::class);
  Route::post('/lunas-detail-credit', [CreditController::class, 'detailLunas'])->name('lunas.detail');
  Route::post('/filter-credit', [CreditController::class, 'filter'])->name('credit.filter');
  Route::post('/jenis-credit', [CreditController::class, 'ubahJenis'])->name('credit.jenis');

  // Pemasukan Sales
  Route::resource('transaksi-pemasukan-sales', TransaksiPemasukanSalesController::class);
  Route::post('/addToCartSales', [TransaksiPemasukanSalesController::class, 'addToCart'])->name('addToCartSales');
  Route::post('/removeCartSales', [TransaksiPemasukanSalesController::class, 'removeCart'])->name('removeCartSales');
  Route::post('/checkoutSales', [TransaksiPemasukanSalesController::class, 'checkout'])->name('checkoutSales');

  // Pengeluaran
  Route::resource('transaksi-pengeluaran', TransaksiPengeluaranController::class);
  Route::post('/addToCartPengeluaran', [TransaksiPengeluaranController::class, 'addCartPengeluaran'])->name('addCartPengeluaran');
  Route::post('/removeCartPengeluaran', [TransaksiPengeluaranController::class, 'removeCartPengeluaran'])->name('removeCartPengeluaran');
  Route::post('/checkoutPengeluaran', [TransaksiPengeluaranController::class, 'checkoutPengeluaran'])->name('checkoutPengeluaran');

  // Pengeluaran Sales
  Route::resource('transaksi-pengeluaran-sales', TransaksiPengeluaranSalesController::class);
  Route::post('/addToCartPengeluaranSales', [TransaksiPengeluaranSalesController::class, 'addCartPengeluaran'])->name('addCartPengeluaranSales');
  Route::post('/removeCartPengeluaranSales', [TransaksiPengeluaranSalesController::class, 'removeCartPengeluaran'])->name('removeCartPengeluaranSales');
  Route::post('/checkoutPengeluaranSales', [TransaksiPengeluaranSalesController::class, 'checkoutPengeluaran'])->name('checkoutPengeluaranSales');


  // Report Pemasukan
  Route::get('/report-pemasukan', [TransaksiPemasukanController::class, 'Report'])->name('report.pemasukan.index');
  Route::get('/report-pemasukan/{id}', [TransaksiPemasukanController::class, 'ReportDetail'])->name('report.pemasukan.detail');
  Route::post('/report-pemasukan-export', [TransaksiPemasukanController::class, 'export'])->name('report.pemasukan.export');
  Route::post('/report-pemasukan-filter', [TransaksiPemasukanController::class, 'filter'])->name('report.pemasukan.filter');

  // Report Pemasukan Sales
  Route::get('/report-pemasukan-sales', [TransaksiPemasukanSalesController::class, 'Report'])->name('report.pemasukan.sales.index');
  Route::get('/report-pemasukan-sales/{id}', [TransaksiPemasukanSalesController::class, 'ReportDetail'])->name('report.pemasukan.sales.detail');

  // Report Pengeluaran
  Route::get('/report-pengeluaran', [TransaksiPengeluaranController::class, 'Report'])->name('report.pengeluaran.index');
  Route::get('/report-pengeluaran/{id}', [TransaksiPengeluaranController::class, 'ReportDetail'])->name('report.pengeluaran.detail');
  Route::post('/report-pengeluaran-export', [TransaksiPengeluaranController::class, 'export'])->name('report.pengeluaran.export');
  Route::post('/report-pengeluaran-filter', [TransaksiPengeluaranController::class, 'filter'])->name('report.pengeluaran.filter');

  // Report Pengeluaran Sales
  Route::get('/report-pengeluaran-sales', [TransaksiPengeluaranSalesController::class, 'Report'])->name('report.pengeluaran.sales.index');
  Route::get('/report-pengeluaran-sales/{id}', [TransaksiPengeluaranSalesController::class, 'ReportDetail'])->name('report.pengeluaran.sales.detail');
});


Auth::routes();

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
