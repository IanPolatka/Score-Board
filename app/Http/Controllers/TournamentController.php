<?php

namespace App\Http\Controllers;

use App\Tournament;

use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function listByYear($year)
    {
        $tournaments = Tournament::where('year_id', $year)->get();

        return $tournaments;
    }
}
