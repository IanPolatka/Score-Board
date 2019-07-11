<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FootballRoster extends Model
{
	protected $table = 'football_roster';

    protected $fillable = [
    	'year_id',
    	'team_id',
        'number',
        'name',
        'position',
        'student_year',
        'created_by',
        'modified_by'
    ];

    public function the_year()
    {
        return $this->belongsTo('App\Year', 'year_id');
    }
}
