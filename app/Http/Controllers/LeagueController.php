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

        return redirect('/leagues')->with('success', 'League created!');
    }

    public function index(){
        $leagues = League::all();
        return view('leagues.leagues', compact('leagues'));
    }

    public function destroy(Request $request){
        $league = League::findOrFail($request->league_id);
        $league->delete();

        return redirect()->route('leagues.index');
    }
}
