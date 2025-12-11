<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\TeamController;

Route::get('/', function () {
    return view('home');
});

Route::get('/leagues/create', [LeagueController::class, 'create'])->name('leagues.create');
Route::get('/leagues', [LeagueController::class, 'index'])->name('leagues.index');
Route::post('/leagues', [LeagueController::class, 'store'])->name('leagues.store');
Route::delete('/leagues', [LeagueController::class, 'destroy'])->name('leagues.destroy');

Route::resource('leagues', LeagueController::class);
Route::prefix('leagues/{league}')->group(function () {
    Route::get('/', [LeagueController::class, 'show'])->name('leagues.viewLeague');
    Route::resource('teams', TeamController::class)->names([
        'create' => 'createTeam',
        'store' => 'storeTeam',
        'index' => 'indexTeam',
        'destroy' => 'destroyTeam'
    ]);
});