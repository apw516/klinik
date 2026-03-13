<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\dataMasterController;
use App\Http\Controllers\kasirFarmasiController;
use App\Http\Controllers\poliklinikController;
use App\Http\Controllers\rekamedisController;
use Illuminate\Support\Facades\Route;

Route::get('/', [authController::class, 'index']);
Route::get('/login', [authController::class, 'index'])->middleware('guest')->name('login');
Route::get('/logout', [authController::class, 'logout'])->name('logout');
Route::post('/login', [authController::class, 'authenticate']);

Route::get('/dashboard', [dashboardController::class, 'index']);


Route::get('/indexmasterpasien', [dataMasterController::class, 'indexmasterpasien'])->name('indexmasterpasien');
Route::get('/indexmasterbarang', [dataMasterController::class, 'indexmasterbarang'])->name('indexmasterbarang');
Route::get('/indexdataobatgenerik', [dataMasterController::class, 'indexdataobatgenerik'])->name('indexdataobatgenerik');
Route::get('/indexdataicd10', [dataMasterController::class, 'indexdataicd10'])->name('indexdataicd10');
Route::get('/indexdataicd9', [dataMasterController::class, 'indexdataicd9'])->name('indexdataicd9');
Route::get('/indexdatatarifpelayanan', [dataMasterController::class, 'indexdatatarifpelayanan'])->name('indexdatatarifpelayanan');
Route::get('/indexdatapegawai', [dataMasterController::class, 'indexdatapegawai'])->name('indexdatapegawai');
Route::get('/indexdataunit', [dataMasterController::class, 'indexdataunit'])->name('indexdataunit');
Route::get('/indexdataprovinsi', [dataMasterController::class, 'indexdataprovinsi'])->name('indexdataprovinsi');
Route::get('/indexdatakabupatenkota', [dataMasterController::class, 'indexdatakabupatenkota'])->name('indexdatakabupatenkota');
Route::get('/indexdatakecamatan', [dataMasterController::class, 'indexdatakecamatan'])->name('indexdatakecamatan');
Route::get('/indexdatadesa', [dataMasterController::class, 'indexdatadesa'])->name('indexdatadesa');
Route::get('/indexdatauser', [dataMasterController::class, 'indexdatauser'])->name('indexdatauser');
Route::get('/route.cari.generik', [dataMasterController::class, 'cariGenerik'])->name('route.cari.generik');
Route::get('/route.cari.provinsi', [dataMasterController::class, 'cariProvinsi'])->name('route.cari.provinsi');
Route::get('/route.cari.kabupaten', [dataMasterController::class, 'cariKabupaten'])->name('route.cari.kabupaten');
Route::get('/route.cari.kecamatan', [dataMasterController::class, 'cariKecamatan'])->name('route.cari.kecamatan');
Route::get('/route.cari.desa', [dataMasterController::class, 'cariDesa'])->name('route.cari.desa');
Route::get('/cari-supplier', [dataMasterController::class, 'cariSupplier'])->name('cari-supplier');
Route::post('/simpanmasterbarang', [dataMasterController::class, 'simpanmasterbarang'])->name('simpanmasterbarang');
Route::post('/simpanmastergenerik', [dataMasterController::class, 'simpanmastergenerik'])->name('simpanmastergenerik');
Route::post('/simpansupplier', [dataMasterController::class, 'simpansupplier'])->name('simpansupplier');
Route::post('/simpanstokbaranginjek', [dataMasterController::class, 'simpanstokbaranginjek'])->name('simpanstokbaranginjek');
Route::post('/hapusunit', [dataMasterController::class, 'hapusunit'])->name('hapusunit');
Route::post('/simpanunit', [dataMasterController::class, 'simpanunit'])->name('simpanunit');
Route::post('/simpaneditunit', [dataMasterController::class, 'simpaneditunit'])->name('simpaneditunit');
Route::post('/simpaneditharga', [dataMasterController::class, 'simpaneditharga'])->name('simpaneditharga');
Route::post('/simpanpasien', [dataMasterController::class, 'simpanpasien'])->name('simpanpasien');
Route::post('/simpanstatuspasien', [dataMasterController::class, 'simpanstatuspasien'])->name('simpanstatuspasien');
Route::post('/ambilformeditpasien', [dataMasterController::class, 'ambilformeditpasien'])->name('ambilformeditpasien');
Route::post('/simpaneditpasien', [dataMasterController::class, 'simpaneditpasien'])->name('simpaneditpasien');
Route::post('/ambilinfosediaan', [dataMasterController::class, 'ambilinfosediaan'])->name('ambilinfosediaan');



Route::get('/indexdaftarpelayanan', [rekamedisController::class, 'indexdaftarpelayanan'])->name('indexdaftarpelayanan');
Route::get('/indexriwayatpendaftaran', [rekamedisController::class, 'indexriwayatpendaftaran'])->name('indexriwayatpendaftaran');
Route::post('/caridatapasien', [rekamedisController::class, 'caridatapasien'])->name('caridatapasien');
Route::post('/ambilformpendaftaran', [rekamedisController::class, 'ambilformpendaftaran'])->name('ambilformpendaftaran');
Route::post('/simpanpendaftaranpasien', [rekamedisController::class, 'simpanpendaftaranpasien'])->name('simpanpendaftaranpasien');
Route::post('/formeditkunjungan', [rekamedisController::class, 'formeditkunjungan'])->name('formeditkunjungan');
Route::post('/simpaneditstatus', [rekamedisController::class, 'simpaneditstatus'])->name('simpaneditstatus');
Route::post('/ambildetailkunjungan', [rekamedisController::class, 'ambildetailkunjungan'])->name('ambildetailkunjungan');
Route::post('/ambildetailkunjungan_billing', [rekamedisController::class, 'ambildetailkunjungan_billing'])->name('ambildetailkunjungan_billing');
Route::post('/ambilriwayatpendaftaran', [rekamedisController::class, 'ambilriwayatpendaftaran'])->name('ambilriwayatpendaftaran');
Route::post('/ambilforminputlayanan', [rekamedisController::class, 'ambilforminputlayanan'])->name('ambilforminputlayanan');
Route::post('/simpanbilling', [rekamedisController::class, 'simpanbilling'])->name('simpanbilling');
Route::post('/simpanbatalkunjungan', [rekamedisController::class, 'simpanbatalkunjungan'])->name('simpanbatalkunjungan');

//antrian
Route::get('/indexdataantrian', [rekamedisController::class, 'indexdataantrian'])->name('indexdataantrian');
Route::post('/ambildataantrian', [rekamedisController::class, 'ambildataantrian'])->name('ambildataantrian');
Route::post('/ambilformupdateantrian', [rekamedisController::class, 'ambilformupdateantrian'])->name('ambilformupdateantrian');
Route::post('/simpaneditstatusantrian', [rekamedisController::class, 'simpaneditstatusantrian'])->name('simpaneditstatusantrian');


//poliklinik
Route::get('/indexdatapasienpoli', [poliklinikController::class, 'indexdatapasienpoli'])->name('indexdatapasienpoli');
Route::post('/ambildatapasien', [poliklinikController::class, 'ambildatapasien'])->name('ambildatapasien');
Route::post('/ambilformerm', [poliklinikController::class, 'ambilformerm'])->name('ambilformerm');
Route::post('/simpancatatanmedis', [poliklinikController::class, 'simpancatatanmedis'])->name('simpancatatanmedis');
Route::post('/ambilriwayatbilling', [poliklinikController::class, 'ambilriwayatbilling'])->name('ambilriwayatbilling');
Route::post('/ambilriwayatresep', [poliklinikController::class, 'ambilriwayatresep'])->name('ambilriwayatresep');


Route::get('/indexkartustokobat', [kasirFarmasiController::class, 'indexkartustokobat'])->name('indexkartustokobat');
Route::get('/indexdatapasienkasirfarmasi', [kasirFarmasiController::class, 'indexdatapasienkasirfarmasi'])->name('indexdatapasienkasirfarmasi');
Route::get('/indexlogtransaksikasir', [kasirFarmasiController::class, 'indexlogtransaksikasir'])->name('indexlogtransaksikasir');
Route::get('/indexriwayattagihan', [kasirFarmasiController::class, 'indexriwayattagihan'])->name('indexriwayattagihan');
Route::post('/ambildatapasienkasirfarmasi', [kasirFarmasiController::class, 'ambildatapasienkasirfarmasi'])->name('ambildatapasienkasirfarmasi');
Route::post('/ambillogtransaksikasir', [kasirFarmasiController::class, 'ambillogtransaksikasir'])->name('ambillogtransaksikasir');
Route::post('/ambilriwayattagihanpasien', [kasirFarmasiController::class, 'ambilriwayattagihanpasien'])->name('ambilriwayattagihanpasien');
Route::post('/ambilformpembayarankasir', [kasirFarmasiController::class, 'ambilformpembayarankasir'])->name('ambilformpembayarankasir');
Route::post('/ambildataorderresep', [kasirFarmasiController::class, 'ambildataorderresep'])->name('ambildataorderresep');
Route::post('/ambildatatagihan', [kasirFarmasiController::class, 'ambildatatagihan'])->name('ambildatatagihan');
Route::post('/terimaresep', [kasirFarmasiController::class, 'terimaresep'])->name('terimaresep');
Route::post('/simpanpembayaran', [kasirFarmasiController::class, 'simpanpembayaran'])->name('simpanpembayaran');
Route::post('/returorderobat', [kasirFarmasiController::class, 'returorderobat'])->name('returorderobat');
Route::post('/returlayanan', [kasirFarmasiController::class, 'returlayanan'])->name('returlayanan');
Route::get('/kartu-stok.data', [kasirFarmasiController::class, 'getKartuStok'])->name('kartu-stok.data');
