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
            'columns.*.stat_key' => 'required|string',
            'ranking_column' => 'required|integer'
        ]);

        // Create League
        $league = League::create($request->only('name', 'year'));

        $template = [];
        foreach ($request->dataPoints as $t){
            $key = Str::slug($t['name'], '_');

            if(isset($template[$key])){
                return back()->withErrors(["Duplicate stat name: {$t['name']}"]);
            }

            $template[$key] = 0;
        }

        $league->matchTemplate()->create([
            'template' => $template
        ]);

        $league->columns()->create([
            'name' => 'Team',       // default display
            'key_name' => Str::uuid()->toString(),
            'type' => 'string',
            'position' => 0,
            'is_team_name' => true
        ]);

        
        $createdColumns = [];
        $position = 1;

        foreach($request->columns as $index => $column){
            $statKey = $column['stat_key'];

            $createdColumns[] = $league->columns()->create([
                'name' => $column['name'],
                'type' => $column['type'],
                'key_name' => Str::uuid()->toString(),
                'stat_key' => $statKey,
                'position' => $position++
            ]);
        }

        $index = $request->ranking_column;

        if(isset($createdColumns[$index])){
            $league->ranking_column_id = $createdColumns[$index]->id;
            $league->save();
        }

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
        $columns = $league->columns()->orderBy('position')->get();
        $teams = $league->teams()->get();

        $rows = $league->rows()->get(); 
        $rowsByTeam = [];
        foreach ($rows as $row) {
            $rowsByTeam[$row->team_id] = $row->data ?? [];
        }

        return view('leagues.viewLeague', compact('league', 'columns', 'teams', 'rowsByTeam'));
    }
}
