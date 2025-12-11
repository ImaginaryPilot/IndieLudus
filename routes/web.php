<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\FixtureController;

Route::get('/', function () {
    return view('home');
});

Route::prefix('leagues')->group(function () {
    Route::get('/create', [LeagueController::class, 'create'])->name('leagues.create');
    Route::get('/', [LeagueController::class, 'index'])->name('leagues.index');
    Route::post('/', [LeagueController::class, 'store'])->name('leagues.store');
    Route::delete('/', [LeagueController::class, 'destroy'])->name('leagues.destroy');
    Route::get('/{league}', [LeagueController::class, 'show'])->name('leagues.viewLeague');

    Route::prefix('{league}')->group(function (){
        Route::post('/generate-fixtures', [FixtureController::class, 'generate'])->name('fixtures.generate');
        Route::get('/matches', [FixtureController::class, 'index'])->name('fixtures.index');

        Route::prefix('teams')->group(function () {
            Route::get('/', [TeamController::class, 'index'])->name('teams.index');
            Route::get('/create', [TeamController::class, 'create'])->name('teams.create');
            Route::post('/', [TeamController::class, 'store'])->name('teams.store');
            Route::get('/{team}', [TeamController::class, 'show'])->name('teams.show');
            Route::delete('/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');

            Route::prefix('{team}')->group(function () {
                Route::get('players/create', [PlayerController::class, 'create'])->name('players.create');
                Route::post('players', [PlayerController::class, 'store'])->name('players.store');
                Route::get('players', [PlayerController::class, 'index'])->name('players.index');
                Route::delete('players/{player}', [PlayerController::class, 'destroy'])->name('players.destroy');
                // Route::get('players/{player}', [PlayerController::class, 'show'])->name('players.show');
            });
        });
    });
});
