<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\TeamController;

Route::get('/', function () {
    return view('home');
});

Route::prefix('leagues')->group(function () {
    Route::get('/create', [LeagueController::class, 'create'])->name('leagues.create');
    Route::get('/', [LeagueController::class, 'index'])->name('leagues.index');
    Route::post('/', [LeagueController::class, 'store'])->name('leagues.store');
    Route::delete('/', [LeagueController::class, 'destroy'])->name('leagues.destroy');
    Route::get('/{league}', [LeagueController::class, 'show'])->name('leagues.viewLeague');

    Route::prefix('{league}/teams')->group(function () {
        Route::get('/', [TeamController::class, 'index'])->name('teams.index');
        Route::get('/create', [TeamController::class, 'create'])->name('teams.create');
        Route::post('/', [TeamController::class, 'store'])->name('teams.store');
        Route::get('/{team}', [TeamController::class, 'show'])->name('teams.show');
        Route::delete('/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');
    });
});

Route::prefix('leagues/{league}/teams/{team}')->group(function () {
    // Route::resource('players', PlayerController::class)->names([
    //     'index' => 'indexPlayers',
    //     'create' => 'createPlayer',
    //     'store' => 'storePlayer',
    //     'show' => 'showPlayer',
    //     'destroy' => 'destroyPlayer',
    // ]);
});
