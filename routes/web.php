<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\PagesController::class, 'inicio'])->name('inicio');
Route::get('pokemones', [App\Http\Controllers\PagesController::class, 'pokemones'])->name('pokemones');
Route::get('nosotros/{nombre?}',[App\Http\Controllers\PagesController::class, 'nosotros'])->name('nosotros');
