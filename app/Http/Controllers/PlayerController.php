<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\League\League;
use App\Models\Team;
use App\Models\Player;

class PlayerController extends Controller
{
    public function create(League $league, Team $team)
    {
        return view('players.createPlayer', compact('league', 'team'));
    }


    // Store the new player
    public function store(Request $request, League $league, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $team->players()->create([
            'name' => $request->name,
        ]);

        return redirect()->route('players.index', ['league' => $league->id, 'team' => $team->id])->with('success', 'Player added!');
    }

    public function index(League $league, Team $team)
    {
        $players = $team->players;
        return view('teams.viewTeam', compact('league', 'team', 'players'));
    }

    public function destroy(League $league, Team $team, Player $player)
    {
        // extra safety: ensure the player belongs to the team
        if ($player->team_id !== $team->id) {
            abort(404);
        }

        $player->delete();

        return redirect()
            ->route('players.index', ['league' => $league->id, 'team' => $team->id])
            ->with('success', 'Player removed!');
    }

}
