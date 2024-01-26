<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
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
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::prefix('posts')->group(function () {
        Route::get('/create', [PostController::class, 'create'])->name('post.create');
        Route::post('/', [PostController::class, 'store'])->name('post.store');
        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
        Route::patch('/{id}', [PostController::class, 'update'])->name('post.update');
        Route::delete('/{id}', [PostController::class, 'destroy'])->name('post.destroy');
        Route::post('/cache/store', [PostController::class, 'storeCache'])->name('post.cache.store');
    });
});

Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('post.index');
    Route::get('/{id}', [PostController::class, 'show'])->name('post.show');
});

require __DIR__ . '/auth.php';
