<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function () {
    Route::prefix('gerenciador')->group(function () {
        Route::get('/', function () {
            return Inertia::render('Gerenciador');
        })->name('gerenciador');
        Route::get('/menu', [MenuController::class, 'menuIndex'])->name('menu.index');
        Route::get('/api-menu', [MenuController::class, 'index'])->name('api.menu.index');
        // Route::get('/menu/criar', [MenuController::class, 'criarMenu'])->name('menu.create');
        Route::post('/menu', [MenuController::class, 'salvarMenu'])->name('menu.store');
        // Route::get('/menu/{menu}', [MenuController::class, 'editarMenu'])->name('menu.edit');
        Route::put('/menu/{menu}', [MenuController::class, 'atualizarMenu'])->name('menu.update');
        Route::delete('/menu/{menu}', [MenuController::class, 'deletarMenu'])->name('menu.destroy');
    });
});

require __DIR__ . '/auth.php';
