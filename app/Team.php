<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

	protected $fillable = ['school_name', 'abbreviated_name', 'mascot', 'city', 'state', 'logo'];

}
