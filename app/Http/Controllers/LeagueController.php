<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\League\League;

class LeagueController extends Controller
{
    public function create(){
        return view('leagues.createLeague');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|integer',
            'columns.*.name' => 'required|string|max:255',
            'columns.*.type' => 'required|in:integer,decimal,string,computed',
            'ranking_column' => 'required|integer'
        ]);

        // Create League
        $league = League::create($request->only('name', 'year'));

        $league->columns()->create([
            'name' => 'Team',       // default display
            'key_name' => Str::uuid()->toString(),
            'type' => 'string',
            'position' => 0,
            'is_team_name' => true
        ]);

        
        $createdColumns = [];
        $position = 1;

        foreach($request->columns as $column){
            $createdColumns[] = $league->columns()->create([
                'name' => $column['name'],
                'type' => $column['type'],
                'key_name' => Str::uuid()->toString(),
                'position' => $position++
            ]);
        }

        $rankingColumn = $createdColumns[$request->ranking_column];

        $league->update([
            'ranking_column_id' => $rankingColumn->id
        ]);

        return redirect()->route('leagues.viewLeague', $league->id)
                        ->with('success', 'League created');
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
        
    public function show(League $league)
    {
        // load columns ordered by 'position' to preserve coordinator ordering
        $columns = $league->columns()->orderBy('position')->get();

        // load teams (eager loaded)
        $teams = $league->teams()->get();

        // load all rows for this league in one query and build map: team_id => data array
        $rows = $league->rows()->get(); // returns collection of LeagueTableRow model instances

        $rowsByTeam = [];
        foreach ($rows as $row) {
            // ensure data is array (cast in model)
            $rowsByTeam[$row->team_id] = $row->data ?? [];
        }

        // pass everything to the view
        return view('leagues.viewLeague', compact('league', 'columns', 'teams', 'rowsByTeam'));
    }
}
