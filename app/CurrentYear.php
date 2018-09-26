<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrentYear extends Model
{
    protected $table = 'current_year';

    public function the_year()
    {
        return $this->belongsTo('App\Year', 'year_id');
    }
}
