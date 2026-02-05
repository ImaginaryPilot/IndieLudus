<?php 

namespace App\Models\League;
use Illuminate\Database\Eloquent\Model;

class MatchTemplate extends Model
{
    protected $fillable = ['league_id', 'stats', 'decider_stat_index', 'decider_mode'];

    protected $casts = [
        'stats' => 'array',
    ];

    public function league()
    {
        return $this->belongsTo(League::class);
    }
}
