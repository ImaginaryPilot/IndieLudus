<?php

namespace App\Models\League;

use Illuminate\Database\Eloquent\Model;

class LeagueTableColumn extends Model
{
    protected $fillable = ['league_id', 'name', 'key_name', 'type', 'position', 'is_team_name'];

    public function league(){
        return $this->belongsTo(League::class);
    }
}
