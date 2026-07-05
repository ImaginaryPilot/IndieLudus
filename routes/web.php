<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeagueController;

Route::get('/', function () {
    return view('home');
});

Route::prefix('leagues')->group(function () {
    Route::get('/', [LeagueController::class, 'generalDashboard'])->name('League.generalDashboard');
    Route::post('/', [LeagueController::class, 'storeLeague'])->name('League.storeLeague');
    Route::get('/register', [LeagueController::class, 'register'])->name('League.registerLeague');

    Route::prefix('{league}')->group(function () {
        Route::get('/', [LeagueController::class, 'show'])->name('League.leagueDashboard');
        Route::get('/match-template', [MatchTemplateController::class, 'showMatchTemplate'])->name('MatchTemplate.show');
        Route::put('/match-template', [MatchTemplateController::class, 'updateMatchTemplate'])->name('MatchTemplate.update');
        Route::get('/edit-table', [LeagueTableController::class, 'editTable'])->name('Table.edit');
        Route::post('/edit-table', [LeagueTableController::class, 'updateTable'])->name('Table.update');
        Route::get('/table', [LeagueTableController::class, 'viewTable'])->name('Table.show');
    });
});