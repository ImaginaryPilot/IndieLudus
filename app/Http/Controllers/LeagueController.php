<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\League;

class LeagueController extends Controller
{
    public function create(){
        return view('leagues.createLeague');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'year' => 'required|integer'
        ]);

        League::create($request->all());

        return redirect('/')->with('success', 'League created!');
    }
}
