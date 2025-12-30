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

        return view('fixtures.fixtures', compact('league', 'gameweeks', 'gameweekNumber'));
    }

    public function showGenerateForm(League $league)
    {
        return view('fixtures.generateFixtures', compact('league'));
    }

    public function generate(League $league, Request $request) {
        $roundsPerPair = (int) $request->input('rounds', 1);
        if($roundsPerPair < 1) $roundsPerPair = 1;

        $teams = $league->teams()->get()->toArray();
        $numTeams = count($teams);

        if($numTeams < 2){
            return redirect()->back()->with('error', 'Not enough teams to generate fixtures');
        }

        $league->gameweeks()->each(function($gw) {
            $gw->matches()->delete(); // delete matches first
            $gw->delete();            // delete old gameweek
        });

        shuffle($teams); 

        $dummy = null;
        if($numTeams % 2 != 0){
            $dummy = ['id' => null, 'name' => 'Dummy'];
            $teams[] = $dummy;
            $numTeams++;
        }

        $half = $numTeams / 2;

        $teamIndexes = range(0, $numTeams - 1);
        $singleRoundSchedule = [];

        for($round = 0; $round < $numTeams - 1; $round++){
            $matches = [];
            for($i = 0; $i < $half; $i++){
                $home = $teams[$teamIndexes[$i]];
                $away = $teams[$teamIndexes[$numTeams - 1 - $i]];

                if($home['id'] && $away ['id']){
                    if($round % 2 == 0){
                        $matches[] = ['home_team_id' => $home['id'], 'away_team_id' => $away['id']];
                    } else {
                        $matches[] = ['home_team_id' => $away['id'], 'away_team_id' => $home['id']];
                    }
                }
            }

            $singleRoundSchedule[] = $matches;
            
            $fixed = array_shift($teamIndexes);
            $last = array_pop($teamIndexes);
            array_unshift($teamIndexes, $last);
            array_unshift($teamIndexes, $fixed);
        }

        $gameweekCounter = 1;
        for($roundNumber = 0; $roundNumber < $roundsPerPair; $roundNumber++){
            $flip = $roundNumber % 2 == 1;

            foreach($singleRoundSchedule as $matches){
                $gameweek = Gameweek::create([
                    'league_id' => $league->id,
                    'number' => $gameweekCounter++,
                ]);

                foreach($matches as $match){
                    LeagueMatch::create([
                        'league_id' => $league->id,
                        'gameweek_id' => $gameweek->id,
                        'home_team_id' => $flip ? $match['away_team_id'] : $match['home_team_id'],
                        'away_team_id' => $flip ? $match['home_team_id'] : $match['away_team_id'],
                    ]);
                }
            }
        }

        return redirect()->route('fixtures.index', ['league' => $league->id])->with('success', 'Fixtures generated successfully');
    }

    public function show(League $league, LeagueMatch $match){
        if($match->league_id != $league->id){
            abort(404);
        }

        $match->load('homeTeam', 'awayTeam', 'gameweek');

        return view('fixtures.match', compact('league', 'match'));
    }

    public function updateScore(League $league, LeagueMatch $match, Request $request){
        $request->validate([
            'home_score' => 'required|integer|min:0',
            'away_score' => 'required|integer|min:0'
        ]);

        $match->update([
            'home_score' => $request->home_score,
            'away_score' => $request->away_score
        ]);

        $homeId = $match->home_team_id;
        $awayId = $match->away_team_id;
        $hs = $request->home_score;
        $as = $request->away_score;

        $homeRow = $league->rows()->firstOrCreate(['team_id' => $homeId]);
        $awayRow = $league->rows()->firstOrCreate(['team_id' => $awayId]);

        $home = $homeRow->data ?? [];
        $away = $awayRow->data ?? [];

        $home['points'] = $home['points'] ?? 0;
        $away['points'] = $away['points'] ?? 0;

        if ($hs > $as) {
            $home['points'] += $league->points_win;
            $home['wins'] = ($home['wins'] ?? 0) + 1;
            $away['losses'] = ($away['losses'] ?? 0) + 1;
        } elseif ($hs < $as) {
            $away['points'] += $league->points_win;
            $away['wins'] = ($away['wins'] ?? 0) + 1;
            $home['losses'] = ($home['losses'] ?? 0) + 1;
        } else {
            $home['points'] += $league->points_draw;
            $away['points'] += $league->points_draw;
            $home['draws'] = ($home['draws'] ?? 0) + 1;
            $away['draws'] = ($away['draws'] ?? 0) + 1;
        }

        $homeRow->update(['data' => $home]);
        $awayRow->update(['data' => $away]);

        return back()->with('success', 'Points updated automatically based on result.');
    }
}
