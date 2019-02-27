<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasketballBoys extends Model
{
    
    protected $table = 'basketball_boys';

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
        'game_status',
        'game_minute', 
        'game_second',
        'away_team_final_score',
        'home_team_final_score',
        'winning_team',
        'losing_team',
        'location',
        'created_by',
        'modified_by'
    ];

    public function users()
	{
	  return $this->belongsToMany(User::class);
	}

	public function away_team()
    {
    	return $this->belongsTo('App\Team', 'away_team_id');
    }

    public function home_team()
    {
        return $this->belongsTo('App\Team', 'home_team_id');
    }

    public function game_time()
    {
        return $this->belongsTo('App\Time', 'time_id');
    }

    public function user_created()
    {
    	return $this->belongsTo('App\User', 'created_by');
    }

    public function user_modified()
    {
    	return $this->belongsTo('App\User', 'modified_by');
    }

    public function scores()
    {
      return $this->hasMany(BasketballBoysScores::class, 'game_id');
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
        return $this->belongsTo('App\Year', 'year_id');
    }

    public function currentyear()
    {
        return $this->belongsTo('App\CurrentYear', 'year_id');
    }

}
