<?php

namespace App\Http\Controllers;

use App\Models\League\League;
use App\Models\League\MatchTemplate;
use Illuminate\Http\Request;

class MatchTemplateController extends Controller
{
    public function showMatchTemplate(League $league){
        $template = $league->matchTemplate;

        $stats = $template && is_array($template->stats) ? $template->stats : [];
        return view('League.editMatchTemplate', compact('league', 'template', 'stats'));
    }

    public function updateMatchTemplate(Request $request, League $league)
    {
        $request->validate([
            'stats' => 'required|array',
            'stats.*.name' => 'required|string',
            'stats.*.type' => 'required|string',
            'stats.*.scope' => 'required|in:team,neutral',
            'decider_stat_index' => 'required|integer|min:0',
            'decider_mode' => 'required|in:higher,lower',
        ]);

        $template = $league->matchTemplate;

        if (!$template) {
            // Create it only if it doesn’t exist
            $template = MatchTemplate::create([
                'league_id' => $league->id,
                'stats' => [],
            ]);
        }

        // Update stats
        $template->update([
            'stats' => $request->stats,
            'decider_stat_index' => $request->decider_stat_index,
            'decider_mode' => $request->decider_mode,
        ]);

        return redirect()->route('League.leagueDashboard', $league)
                        ->with('success', 'Match template updated!');
    }
}
