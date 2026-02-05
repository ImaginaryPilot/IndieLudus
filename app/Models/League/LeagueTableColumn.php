<?php

namespace App\Models\League;

use Illuminate\Database\Eloquent\Model;

class LeagueTableColumn extends Model
{
    protected $fillable = ['league_id', 'name', 'type', 'scope', 'formula'];

    public function league(){
        return $this->belongsTo(League::class);
    }
}
