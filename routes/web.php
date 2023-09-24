<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Dashboard\Sid;
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
            Route::resource('article', Dashboard\Content\ArticleController::class);
            Route::resource('category', Dashboard\Content\CategoryController::class);
            Route::resource('comment', Dashboard\Content\CommentController::class);
            Route::resource('page', Dashboard\Content\PageController::class);
        });

        Route::name('sid.')->prefix('sid')->group(function () {
            Route::name('identitas.')->prefix('identitas')->group(function () {
                Route::get('/', [Sid\IdentitasController::class, 'show'])->name('show');
                Route::patch('/', [Sid\IdentitasController::class, 'update'])->name('update');
                Route::get('edit', [Sid\IdentitasController::class, 'edit'])->name('edit');
            });

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
