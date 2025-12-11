<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\League\League;
use App\Models\Team;

class TeamController extends Controller
{
    public function create(League $league){
        return view('teams.createTeam', compact('league'));
    }

    public function store(Request $request, \App\Models\League\League $league)
    {
        $team = $league->teams()->create([
            'name' => $request->name,
        ]);

        // Create a league table row for this team
        $rowData = [];
        foreach ($league->columns as $column) {
            if ($column->is_team_name) {
                $rowData[$column->key_name] = $team->name;
            } else {
                $rowData[$column->key_name] = 0; // or default based on type
            }
        }

        $league->rows()->create([
            'team_id' => $team->id,
            'data' => $rowData,
        ]);


        return redirect()->route('leagues.viewLeague', $league);
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
