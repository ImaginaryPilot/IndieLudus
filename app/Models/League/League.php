<?php

namespace App\Models\League;

use Illuminate\Database\Eloquent\Model;
use App\Models\Team;
use App\Models\Fixture\Gameweek;

class League extends Model
{
    protected $fillable = ['name', 'year', 'points_win', 'points_draw', 'points_loss'];

    public function columns(){
        return $this->hasMany(LeagueTableColumn::class);
    }

    public function rows(){
        return $this->hasMany(LeagueTableRow::class);
    }

    public function teams(){
        return $this->hasMany(Team::class);
    }

    public function gameweeks() {
        return $this->hasMany(Gameweek::class);
    }

    public function ranking(){
        return $this->belongsTo(LeagueTableColumn::class);
    }
}
