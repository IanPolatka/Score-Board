<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoccerGirlsScore extends Model
{
	protected $fillable = ['match_id', 'away_team_score', 'home_team_score', 'created_by', 'modified_by'];
}
