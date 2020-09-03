<?php

namespace App\Http\Controllers;

use App\Team;
use App\VolleyballRoster;
use App\Year;
use Illuminate\Http\Request;

class VolleyballRosterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'edit', 'delete']]);
    }

    public function index($team, $year)
    {
        $selectedTeam = Team::where('school_name', $team)->pluck('id');
        $selectedYear = Year::where('year', $year)->pluck('id');
        $roster = VolleyballRoster::where('team_id', $selectedTeam)
                                        ->where('year_id', $selectedYear)
                                        ->orderBy('number')
                                        ->get();

        return $roster;
    }
}
