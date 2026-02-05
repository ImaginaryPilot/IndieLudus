<?php

namespace App\Http\Controllers;

use App\Models\League\League;
use App\Models\League\MatchTemplate;
use Illuminate\Http\Request;

class LeagueTableController extends Controller
{
    public function editTable(League $league)
    {
        $columns = $league->tableColumns;
        return view('League.editLeagueTable', compact('league', 'columns'));
    }

    public function updateTable(Request $request, League $league)
    {
        $request->validate([
            'columns' => 'required|array',
            'columns.new.*.name' => 'required|string|max:255',
            'columns.*.name' => 'sometimes|string|max:255',
        ]);

        foreach ($request->columns as $key => $colData) {

            // NEW COLUMNS
            if ($key === 'new') {
                foreach ($colData as $newCol) {
                    $league->tableColumns()->create([
                        'league_id' => $league->id,
                        'name' => $newCol['name'],
                        'type' => $newCol['type'] ?? 'int',
                        'scope' => $newCol['scope'] ?? 'team',
                    ]);
                }

                continue;
            }

            // EXISTING COLUMNS
            $column = $league->tableColumns()->find($key);

            if ($column) {
                $column->update([
                    'name' => $colData['name'],
                    'type' => $colData['type'] ?? $column->type,
                    'scope' => $colData['scope'] ?? $column->scope,
                ]);
            }
        }

        return redirect()->route('Table.edit', $league)->with('success', 'Columns updated!');
    }
}
