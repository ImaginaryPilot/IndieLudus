<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\League;
use App\Models\Team;

class TeamController extends Controller
{
    public function create(League $league){
        return view('teams.createTeam', compact('league'));
    }

    public function store(Request $request, League $league){
        $request->validate([
            'name' => 'required'
        ]);

        $league->teams()->create($request->all());

        return redirect()->route('leagues.viewLeague', $league)->with('success', 'Team created!');
    }

    public function index(League $league){
        $teams = $league->teams;
        return view('leagues.viewLeague', compact('league', 'teams'));
    }

    public function destroy(League $league, Team $team){
        $team->delete();

        return redirect()->route('leagues.viewLeague', $league)->with('success', 'Team deleted!');
    }
}
