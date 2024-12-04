<?php

use App\Http\Controllers\AttributeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\NilaiAttributeController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\SubAttributeController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login')->middleware('guest');
Route::get('siswa', [GuestController::class, 'siswa'])->name('guest.siswa.index');
Route::get('hasil-penjurusan', [GuestController::class, 'result'])->name('guest.result.index');
Route::middleware(['auth:sanctum', 'verified'])->prefix('admin')->group(function () {

    // Route for the getting the data feed
    Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed'])->name('json_data_feed');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /* Route for Mahasiswa */
    Route::get('siswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::get('siswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
    Route::post('siswa/create', [MahasiswaController::class, 'save'])->name('mahasiswa.save');
    Route::get('siswa/show/{id}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
    Route::post('siswa/delete', [MahasiswaController::class, 'destroy'])->name('mahasiswa.delete');

    /* Route for Attribute */
    Route::get('kriteria', [AttributeController::class, 'index'])->name('attribute.index');
    Route::get('kriteria/create', [AttributeController::class, 'create'])->name('attribute.create');
    Route::post('kriteria/create', [AttributeController::class, 'save'])->name('attribute.save');
    Route::get('kriteria/edit/{id}', [AttributeController::class, 'edit'])->name('attribute.edit');
    Route::put('kriteria/edit/{id}', [AttributeController::class, 'update'])->name('attribute.update');
    Route::get('kriteria/delete/{id}', [AttributeController::class, 'delete'])->name('attribute.delete');

    Route::get('jurusan', [JurusanController::class, 'index'])->name('jurusan.index');
    Route::get('jurusan/create', [JurusanController::class, 'create'])->name('jurusan.create');
    Route::post('jurusan/create', [JurusanController::class, 'save'])->name('jurusan.save');
    Route::get('jurusan/edit/{id}', [JurusanController::class, 'edit'])->name('jurusan.edit');
    Route::put('jurusan/edit/{id}', [JurusanController::class, 'update'])->name('jurusan.update');
    Route::get('jurusan/delete/{id}', [JurusanController::class, 'destroy'])->name('jurusan.delete');

    Route::get('nilai', [NilaiController::class, 'index'])->name('nilai.index');
    Route::get('nilai/create', [NilaiController::class, 'create'])->name('nilai.create');
    Route::post('nilai/create', [NilaiController::class, 'save'])->name('nilai.save');
    Route::post('nilai/delete', [NilaiController::class, 'destroy'])->name('nilai.delete');

    Route::get('sub-kriteria', [SubAttributeController::class, 'index'])->name('sub-attribute.index');
    Route::get('sub-kriteria/create', [SubAttributeController::class, 'create'])->name('sub-attribute.create');
    Route::post('sub-kriteria/save', [SubAttributeController::class, 'save'])->name('sub-attribute.save');
    Route::post('sub-kriteria/delete', [SubAttributeController::class, 'destroy'])->name('sub-attribute.delete');

    /* Route for Nilai Attribute */
    // Route::get('nilai-attribute', [NilaiAttributeController::class, 'index'])->name('nilai-attribute.index');
    // Route::get('nilai-attribute/create/{id}', [NilaiAttributeController::class, 'create'])->name('nilai-attribute.create');
    // Route::post('nilai-attribute/create/{id}', [NilaiAttributeController::class, 'save'])->name('nilai-attribute.save');
    // Route::get('nilai-attribute/edit/{id}', [NilaiAttributeController::class, 'edit'])->name('nilai-attribute.edit');
    // Route::put('nilai-attribute/edit/{id}', [NilaiAttributeController::class, 'update'])->name('nilai-attribute.update');
    // Route::post('nilai-attribute/delete', [NilaiAttributeController::class, 'delete'])->name('nilai-attribute.delete');

    /* Route for Hasil */
    Route::get('hasil', [HasilController::class, 'index'])->name('hasil.index');
    Route::get('hasil/export', [HasilController::class, 'export'])->name('hasil.export');

    /* Route for Perhitungan SMART */
    Route::get('perhitungan',[PerhitunganController::class, 'index'])->name('perhitungan.index');
    Route::post('perhitungan/save', [PerhitunganController::class, 'save'])->name('perhitungan.save');

    Route::fallback(function() {
        return view('pages/utility/404');
    });    
});