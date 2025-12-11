<?php

namespace App\Models\Fixture;

use Illuminate\Database\Eloquent\Model;
use App\Models\League\League;
use App\Models\Team;
use App\Models\Fixture\Gameweek; 


class LeagueMatch extends Model
{
    protected $fillable = ['league_id', 'gameweek_id', 'home_team_id', 'away_team_id', 'home_score', 'away_score'];

    public function league() { return $this->belongsTo(League::class); }
    public function gameweek() { return $this->belongsTo(Gameweek::class); }
    public function homeTeam() { return $this->belongsTo(Team::class, 'home_team_id'); }
    public function awayTeam() { return $this->belongsTo(Team::class, 'away_team_id'); }
}
