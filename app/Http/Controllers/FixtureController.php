<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\League\League;
use App\Models\Team;
use App\Models\Fixture\Gameweek;
use App\Models\Fixture\LeagueMatch;

class FixtureController extends Controller
{
    public function index(League $league, Request $request){
        $gameweekNumber = $request->query('gameweek');

        $query = $league->gameweeks()->with('matches.homeTeam', 'matches.awayTeam');

        if($gameweekNumber){
            $query->where('number', $gameweekNumber);
        }

        $gameweeks = $query->get();

        return view('fixtures.index', compact('league', 'gameweeks', 'gameweekNumber'));
    }


}
