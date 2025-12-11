<?php

namespace App\Models\Fixture;

use Illuminate\Database\Eloquent\Model;
use App\Models\Fixture\Match;

class Gameweek extends Model
{
    protected $fillable = ['league_id', 'number'];

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function matches()
    {
        return $this->hasMany(LeagueMatch::class);
    }
}
