<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [LinkController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard/links', [LinkController::class, 'index'])->name('links.index');
    Route::get('/dashboard/links/create', [LinkController::class, 'create'])->name('links.create');
    Route::post('/dashboard/links', [LinkController::class, 'store'])->name('links.store');
    Route::get('/dashboard/links/{link}/edit', [LinkController::class, 'edit'])->name('links.edit');
    Route::put('/dashboard/links/{link}', [LinkController::class, 'update'])->name('links.update');
    Route::delete('/dashboard/links/{link}', [LinkController::class, 'destroy'])->name('links.destroy');
    Route::patch('/dashboard/links/{link}/toggle', [LinkController::class, 'toggleActive'])->name('links.toggle');
    Route::post('/dashboard/links/reorder', [LinkController::class, 'reorder'])->name('links.reorder');
});

Route::get('/links', [LinkController::class, 'publicIndex'])->name('links.public.index');
Route::get('/go/{link}', [LinkController::class, 'click'])->name('links.click');

require __DIR__ . '/auth.php';

Route::get('/locale/{locale}', LocaleController::class)->name('locale.switch');

// Public profile — registered last so it doesn't shadow app routes
Route::get('/{user:username}', [PublicProfileController::class, 'show'])->name('profile.public');
