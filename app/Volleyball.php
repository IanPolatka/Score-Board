<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Volleyball extends Model
{
    protected $table = 'volleyball';

    protected $appends = ['sport_name'];

    protected $fillable = [
        'year_id',
        'team_level',
        'date',
        'scrimmage',
        'tournament_name',
        'away_team_id',
        'home_team_id',
        'time_id',
        'district_game',
        'current_game',
        'away_team_final_score',
        'home_team_final_score',
        'winning_team',
        'losing_team',
        'location',
        'created_by',
        'modified_by',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function away_team()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function home_team()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function game_time()
    {
        return $this->belongsTo(Time::class, 'time_id');
    }

    public function user_created()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function user_modified()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    public function scores()
    {
        return $this->hasMany(VolleyballScores::class, 'game_id');
    }

    public function the_year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }

    public function getSportNameAttribute()
    {
        return 'volleyball';
    }
}
