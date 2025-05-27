<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/cards', [CardController::class, 'index'])->name('cards.index');
Route::post('/cards', [CardController::class, 'store'])->name('cards.store');
Route::get('/cards/{card}/edit', [CardController::class, 'edit'])->name('cards.edit');
Route::put('/cards/{card}', [CardController::class, 'update'])->name('cards.update');
Route::delete('/cards/{card}', [CardController::class, 'destroy'])->name('cards.destroy');

