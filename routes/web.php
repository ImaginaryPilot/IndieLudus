<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeagueController;

Route::get('/', function () {
    return view('index');
});

Route::get('/leagues/create', [LeagueController::class, 'create']);

Route::post('/leagues', [LeagueController::class, 'store']);
