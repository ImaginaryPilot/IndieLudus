<?php

namespace App\Http\Controllers;

use App\Models\League\League;
use App\Models\League\MatchTemplate;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    // General dashboard
    public function generalDashboard()
    {
        $leagues = League::all();
        return view('League.generalDashboard', compact('leagues'));
    }

    // Show create league form
    public function register()
    {
        return view('League.registerLeague');
    }

    // Store new league
    public function storeLeague(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|int',
        ]);

        $league = League::create([
            'name' => $request->name,
            'year' => $request->year,
        ]);

        // Optionally create an empty match template
        MatchTemplate::create([
            'league_id' => $league->id,
            'decider_stat_index' => 0,
            'decider_mode' => 'higher',
            'stats' => [], // start empty
        ]);

        return redirect()->route('League.leagueDashboard', $league);
    }

    // League dashboard
    public function show(League $league)
    {
        $template = $league->template;
        return view('League.leagueDashboard', compact('league', 'template'));
    }
}
