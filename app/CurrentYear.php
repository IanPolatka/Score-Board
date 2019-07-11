<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrentYear extends Model
{
    protected $table = 'current_year';

    protected $fillable = ['year_id'];

    public function the_year()
    {
        return $this->belongsTo(\App\Year::class, 'year_id');
    }
}
