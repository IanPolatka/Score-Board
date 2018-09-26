<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamMeta extends Model
{

	protected $table = 'teams_meta';
    
	protected $fillable = ['team_id', 'year_id', 'baseball_region', 'baseball_district', 'basketball_region', 'basketball_district', 'football_class', 'football_district', 'soccer_region', 'soccer_district', 'softball_region', 'softball_district', 'volleyball_region', 'volleyball_district', 'modified_by'];

	public function school_year()
    {
        return $this->belongsTo('App\Year', 'year_id');
    }

}
