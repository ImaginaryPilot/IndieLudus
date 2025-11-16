<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeagueController;

Route::get('/', function () {
    return view('home');
});

Route::get('/leagues/create', [LeagueController::class, 'create'])->name('leagues.create');
Route::get('/leagues', [LeagueController::class, 'index'])->name('leagues.index');

Route::post('/leagues', [LeagueController::class, 'store'])->name('leagues.store');

Route::delete('/leagues', [LeagueController::class, 'destroy'])->name('leagues.destroy');
