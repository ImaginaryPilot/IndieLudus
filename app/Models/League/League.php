<?php

namespace App\Models\League;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    protected $fillable = ['name', 'year'];

    public function matchTemplate()
    {
        return $this->hasOne(MatchTemplate::class);
    }

    public function tableColumns(){
        return $this->hasMany(LeagueTableColumn::class);
    }

    public function tableRows() {
        return $this->hasMany(LeagueTableRow::class);
    }
}