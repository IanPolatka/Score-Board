<?php

namespace App\Http\Controllers;

use App\Team;
use App\Year;
use App\SoccerBoysRoster;

use Illuminate\Http\Request;

class SoccerBoysRosterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'edit', 'delete']]);
    }

    public function index($year, $team)
    {
        $selectedTeam = Team::where('school_name', $team)->pluck('id');
        $selectedYear = Year::where('year', $year)->pluck('id');
        $roster = SoccerBoysRoster::where('team_id', $selectedTeam)
                                        ->where('year_id', $selectedYear)
                                        ->orderBy('number')
                                        ->get();

        return $roster;
    }
}
