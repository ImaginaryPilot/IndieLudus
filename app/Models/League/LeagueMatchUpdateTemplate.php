<?php

namespace App\Models\League;

use Illuminate\Database\Eloquent\Model;

class LeagueMatchUpdateTemplate extends Model
{
    protected $fillable = ['league_id', 'template'];

    protected $casts = [
        'template' => 'array'
    ];

    public function league(){
        return$this->belongsTo(League::class);
    }
}
