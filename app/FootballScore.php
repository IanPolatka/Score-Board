<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FootballScore extends Model
{
    protected $fillable = ['game_id', 'away_team_score', 'home_team_score', 'created_by', 'modified_by'];
}
