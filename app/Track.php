<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $table = 'track';

    protected $appends = ['sport_name'];

    protected $fillable = [
        'year_id', 'team_level', 'date', 'scrimmage', 'tournament_name', 'team_id', 'time_id', 'host_id', 'boys_results', 'girls_results', 'location', 'created_by', 'modified_by',
    ];

    public function the_year()
    {
        return $this->belongsTo('App\Year', 'year_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function the_team()
    {
        return $this->belongsTo('App\Team', 'team_id');
    }

    public function game_time()
    {
        return $this->belongsTo('App\Time', 'time_id');
    }

    public function host_team()
    {
        return $this->belongsTo('App\Team', 'host_id');
    }

    public function user_created()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function user_modified()
    {
        return $this->belongsTo('App\User', 'modified_by');
    }

    public function getSportNameAttribute()
    {
        return 'track-and-field';
    }
}
