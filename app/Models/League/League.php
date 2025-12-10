<?php

namespace App\Models\League;

use Illuminate\Database\Eloquent\Model;
use App\Models\Team;

class League extends Model
{
    protected $fillable = ['name', 'year'];

    public function columns(){
        return $this->hasMany(LeagueTableColumn::class);
    }

    public function rows(){
        return $this->hasMany(LeagueTableRow::class);
    }

    public function teams(){
        return $this->hasMany(Team::class);
    }
}
