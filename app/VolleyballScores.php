<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VolleyballScores extends Model
{
    protected $fillable = ['game_id', 'away_team_score', 'home_team_score', 'game_winner', 'created_by', 'modified_by'];
}
