<?php

namespace App\Http\Controllers;

use App\Team;
use App\Year;
use App\FootballRoster;

use Illuminate\Http\Request;

class FootballRosterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'edit', 'delete']]);
    }

    public function index($team, $year)
    {
        $selectedTeam = Team::where('school_name', $team)->pluck('id');
        $selectedYear = Year::where('year', $year)->pluck('id');
        $roster = FootballRoster::where('team_id', $selectedTeam)
                                        ->where('year_id', $selectedYear)
                                        ->orderBy('number')
                                        ->get();

        return $roster;
    }
}
