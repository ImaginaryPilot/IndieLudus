<?php

namespace App\Models\League;

use Illuminate\Database\Eloquent\Model;

class LeagueTableRow extends Model
{
    protected $fillable = ['league_id', 'team_id', 'data'];

    protected $casts = [
        'data' => 'array'
    ];

    public function league(){
        return $this->belongsTo(League::class);
    }

    public function team(){
        return $this->belongsTo(Team::class);
    }
}
