<?php

namespace App\Http\Controllers;

use Auth;

use Session;
use App\Team;
use App\Time;
use App\Year;
use App\TeamMeta;
use App\Crosscountry;
use App\CurrentYear;

use Carbon\Carbon;

use App\Tournament;

use Illuminate\Http\Request;

class CrossCountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'edit', 'delete']]);
    }

    public function index()
    {
        $teams = Team::orderBy('school_name')->get();

        $todaysMatches = Crosscountry::where('date', Carbon::today('America/New_York'))->get();

        $yesterdaysMatches = Crosscountry::where('date', Carbon::yesterday('America/New_York'))->get();

        $tomorrowsMatches = Crosscountry::where('date', Carbon::tomorrow('America/New_York'))->get();

        $currentYearId = CurrentYear::pluck('year_id');

        $theCurrentYear = Year::where('id', $currentYearId)->get();

        $games = Crosscountry::all();

        return view('sports.cross-country.index', compact('games', 'teams', 'theCurrentYear', 'todaysMatches', 'tomorrowsMatches', 'yesterdaysMatches'));
    }

    public function create()
    {
        $teams = Team::orderBy('school_name')->get();

        $times = Time::all();

        $years = Year::orderBy('year', 'desc')->get();

        return view('sports.cross-country.create', compact('teams', 'times', 'years'));
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $this->validate(request(), [
            'year_id'           => 'required',
            'team_level'        => 'required',
            'date'              => 'date|required',
            'team_id'      		=> 'required',
            'host_id'      		=> 'required',
            'time_id'           => 'required',
        ],
        [
            'year_id.required'          =>  'Please select a school year.',
            'team_level.required'       =>  'Please select a team level.',
            'team_id.required'     		=>  'Please select an team that this event is for.',
            'host_id.required'     		=>  'Please select a host.',
            'time_id.required'          =>  'Please select a match time.',
        ]);

        Crosscountry::create([
            'year_id'       => request('year_id'),
            'team_level'    => request('team_level'),
            'date'          => request('date'),
            'scrimmage'     => request('scrimmage'),
            'tournament_name' => request('tournament_name'),
            'location'      => request('location'),
            'team_id'  		=> request('team_id'),
            'host_id'  		=> request('host_id'),
            'time_id'       => request('time_id'),
            'created_by'    => $user_id,
        ]);

        Session::flash('success', 'Cross Country Event Has Been Created');

        return redirect('/cross-country');
    }

    public function show($id)
    {
        $match = Crosscountry::where('id', $id)->with('the_team')
                                     ->with('host_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->first();

        return view('sports.cross-country.show', compact('match'));
    }

    public function destroy($id)
    {
        $game = Crosscountry::find($id);
        $game->delete();

        return redirect('/cross-country');
    }

    public function edit($id)
    {
        $teams = Team::orderBy('school_name')->get();

        $times = Time::all();

        $years = Year::all();

        $match = Crosscountry::where('id', $id)->with('the_team')
                                     ->with('host_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->first();

        return view('sports.cross-country.edit', compact('match', 'teams', 'times', 'years'));
    }

    public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;

        $this->validate(request(), [
            'year_id'           => 'required',
            'team_level'        => 'required',
            'date'              => 'date|required',
            'team_id'      		=> 'required',
            'host_id'      		=> 'required',
            'time_id'           => 'required',
        ],
        [
            'year_id.required'          =>  'Please select a school year.',
            'team_level.required'       =>  'Please select a team level.',
            'team_id.required'     		=>  'Please select an team that this event is for.',
            'host_id.required'     		=>  'Please select a host.',
            'time_id.required'          =>  'Please select a match time.',
        ]);

        $game = Crosscountry::findOrFail($id);
        $game->team_id = request('team_id');
        $game->year_id = request('year_id');
        $game->team_level = request('team_level');
        $game->date = request('date');
        $game->scrimmage = request('scrimmage');
        $game->tournament_name = request('tournament_name');
        $game->host_id = request('host_id');
        $game->time_id = request('time_id');
        $game->location = request('location');
        $game->boys_result = request('boys_result');
        $game->girls_result = request('girls_result');
        $game->modified_by = $user_id;

        $game->update();

        Session::flash('success', 'Cross Country Match Has Been Updated');

        return redirect('/cross-country/'.$id);
    }

    public function teamSchedule($year, $team)
    {
        $id = Team::where('school_name', $team)->pluck('id');

        $selectedyear = Year::where('year', $year)->pluck('year');

        $selectedyearid = Year::where('year', $year)->pluck('id');

        $selectedTeam = Team::where('school_name', $team)->first();

        $year = Year::pluck('id')->first();

        $teams = Team::orderBy('school_name')->get();

        $varsity = Crosscountry::with('the_team')
                               ->with('host_team')
                               ->with('game_time')
                               ->where('team_id', $id)
                               ->where('team_level', 1)
                               ->where('year_id', $selectedyearid)
                               ->orderBy('date')
                               ->get();

        $juniorvarsity = Crosscountry::with('the_team')
                               ->with('host_team')
                               ->with('game_time')
                               ->where('team_id', $id)
                               ->where('team_level', 2)
                               ->where('year_id', $selectedyearid)
                               ->orderBy('date')
                               ->get();

        $freshman = Crosscountry::with('the_team')
                               ->with('host_team')
                               ->with('game_time')
                               ->where('team_id', $id)
                               ->where('team_level', 3)
                               ->where('year_id', $selectedyearid)
                               ->orderBy('date')
                               ->get();

        return view('sports.cross-country.teamschedule', compact('id', 'selectedTeam', 'team', 'teams', 'varsity', 'juniorvarsity', 'freshman'));
    }

    public function apiTeamSchedule($year, $team, $teamlevel)
    {
        $theteam = Team::where('school_name', '=', $team)->pluck('id');
        $theYear = Year::where('year', $year)->pluck('id')->first();

        $game = Crosscountry::with('the_team')
                                ->with('the_year')
                               ->with('host_team')
                               ->where('team_id', $theteam)
                               ->where('year_id', $theYear)
                               ->where('team_level', $teamlevel)
                               ->with('game_time')
                               ->orderBy('date')
                               ->get();

        return $game;
    }

    public function todaysEvents($team)
    {
        $theteam = Team::where('school_name', '=', $team)->pluck('id');

        $game = Crosscountry::with('the_team')
                                ->with('the_year')
                               ->with('host_team')
                               ->with('game_time')
                               ->where('team_id', $theteam)
                               ->where('team_level', 1)
                               ->where('date', Carbon::today('America/New_York'))
                               ->get();

        return $game;
    }
}
