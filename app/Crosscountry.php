<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crosscountry extends Model
{
    protected $table = 'cross_country';

    protected $appends = ['sport_name'];

    protected $fillable = [
        'year_id', 'team_level', 'date', 'scrimmage', 'tournament_name', 'team_id', 'time_id', 'host_id', 'results', 'location', 'created_by', 'modified_by',
    ];

    public function the_year()
    {
        return $this->belongsTo(\App\Year::class, 'year_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function the_team()
    {
        return $this->belongsTo(\App\Team::class, 'team_id');
    }

    public function game_time()
    {
        return $this->belongsTo(\App\Time::class, 'time_id');
    }

    public function host_team()
    {
        return $this->belongsTo(\App\Team::class, 'host_id');
    }

    public function user_created()
    {
        return $this->belongsTo(\App\User::class, 'created_by');
    }

    public function user_modified()
    {
        return $this->belongsTo(\App\User::class, 'modified_by');
    }

    public function getSportNameAttribute()
    {
        return 'cross-country';
    }
}
