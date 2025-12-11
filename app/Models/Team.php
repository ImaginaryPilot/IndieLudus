<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'league_id'];

    public function league(){
        return $this->belongsTo(League::class);
    }

    public function players(){
        return $this->hasMany(Player::class);
    }

    public function homeMatches(){
        return $this->hasMany(LeagueMatch::class, 'home_team_id');
    }

    public function awayMatches(){
        return $this->hasMany(LeagueMatch::class, 'away_team_id');
    }

    public function matches() {
        return $this->homeMatches->merge($this->awayMatches);
    }
}
