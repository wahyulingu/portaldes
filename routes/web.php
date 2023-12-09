<?php

use App\Http\Controllers\Dashboard\Content;
use App\Http\Controllers\Dashboard\Sid;
use App\Http\Controllers\Dashboard\Sid\Surat;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');

    Route::name('dashboard.')->prefix('dashboard')->group(function () {
        Route::name('content.')->prefix('content')->group(function () {
            Route::resource('article', Content\ArticleController::class);
            Route::resource('comment', Content\CommentController::class);
            Route::resource('page', Content\PageController::class);

            Route::resource('category', Content\Category\CategoryController::class);
            Route::resource('category.subcategory', Content\Category\SubcategoryController::class)->only('create', 'store');
        });

        Route::name('sid.')->prefix('sid')->group(function () {
            Route::name('identitas.')->group(function () {
                Route::get('identitas', [Sid\IdentitasController::class, 'show'])->name('show');
                Route::patch('identitas', [Sid\IdentitasController::class, 'update'])->name('update');

                Route::prefix('identitas')->group(function () {
                    Route::get('edit', [Sid\IdentitasController::class, 'edit'])->name('edit');
                });
            });

            Route::name('surat.')->prefix('surat')->group(function () {
                Route::resource('surat-keluar', Surat\SuratKeluarController::class);
            });

            Route::name('kelompok.')->prefix('kelompok')->group(function () {
                Route::resource('kategori', Sid\Kelompok\KategoriController::class);
            });

            Route::resource('kelompok', Sid\Kelompok\KelompokController::class);

            Route::resource('surat', Surat\SuratController::class)->only(['index', 'destroy']);
            Route::resource('keluarga', Sid\KeluargaController::class);
            Route::resource('pamong', Sid\PamongController::class);

            Route::resource('penduduk', Sid\PendudukController::class);

            Route::name('wilayah.')->prefix('wilayah')->group(function () {
                Route::resource('lingkungan', Sid\Wilayah\LingkunganController::class);
                Route::resource('rukun-tetangga', Sid\Wilayah\RukunTetanggaController::class);
                Route::resource('rukun-warga', Sid\Wilayah\RukunWargaController::class);
            });
        });
    });
});
