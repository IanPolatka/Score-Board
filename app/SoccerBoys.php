<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoccerBoys extends Model
{
    protected $appends = ['sport_name', 'away_score_sum', 'home_score_sum'];

    protected $fillable = [
        'year_id', 'team_level', 'date', 'scrimmage', 'tournament_name', 'away_team_id', 'home_team_id', 'time_id', 'district_game', 'game_status', 'game_minute', 'away_team_final_score', 'home_team_final_score', 'winning_team', 'losing_team', 'location', 'created_by', 'modified_by',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function away_team()
    {
        return $this->belongsTo(\App\Team::class, 'away_team_id');
    }

    public function home_team()
    {
        return $this->belongsTo(\App\Team::class, 'home_team_id');
    }

    public function game_time()
    {
        return $this->belongsTo(Time::class, 'time_id');
    }

    public function user_created()
    {
        return $this->belongsTo(\App\User::class, 'created_by');
    }

    public function user_modified()
    {
        return $this->belongsTo(\App\User::class, 'modified_by');
    }

    public function scores()
    {
        return $this->hasMany(SoccerBoysScore::class, 'match_id');
    }

    public function away_team_district()
    {
        return $this->hasOne(TeamMeta::class, 'team_id', 'away_team_id', 'year_id');
    }

    public function home_team_district()
    {
        return $this->hasOne(TeamMeta::class, 'team_id', 'home_team_id');
    }

    public function away_team_goals()
    {
        return $this->hasMany(SoccerBoysScore::class);
    }

    public function the_year()
    {
        return $this->belongsTo(\App\Year::class, 'year_id');
    }

    public function getSportNameAttribute()
    {
        return 'boys-soccer';
    }

    public function getAwayScoreSumAttribute()
    {
        $totalAwayScore = 0;

        foreach ($this->scores as $score) {
            $totalAwayScore += $score->away_team_score;
        }

        return $totalAwayScore;
    }

    public function getHomeScoreSumAttribute()
    {
        $totalHomeScore = 0;

        foreach ($this->scores as $score) {
            $totalHomeScore += $score->home_team_score;
        }

        return $totalHomeScore;
    }
    
}
