<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Baseball extends Model
{
    protected $table = 'baseball';

    protected $appends = ['sport_name', 'away_score_sum', 'home_score_sum', 'pretty_date'];
    
    protected $dates = [ 'date' ];

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
        'inning',
        'game_second',
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
        return $this->belongsTo(\App\Team::class, 'away_team_id');
    }

    public function home_team()
    {
        return $this->belongsTo(\App\Team::class, 'home_team_id');
    }

    public function game_time()
    {
        return $this->belongsTo(\App\Time::class, 'time_id');
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
        return $this->hasMany(BaseballScores::class, 'game_id');
    }

    public function away_team_district()
    {
        return $this->hasOne(TeamMeta::class, 'team_id', 'away_team_id', 'year_id');
    }

    public function home_team_district()
    {
        return $this->hasOne(TeamMeta::class, 'team_id', 'home_team_id');
    }

    public function the_year()
    {
        return $this->belongsTo(\App\Year::class, 'year_id');
    }

    public function getSportNameAttribute()
    {
        return 'baseball';
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
    
    public function getPrettyDateAttribute( $value ) {
        return $this->date->format('l M jS, Y');
    }
    
}
