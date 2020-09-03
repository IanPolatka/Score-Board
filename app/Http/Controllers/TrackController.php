<?php

namespace App\Http\Controllers;

use App\Team;
use App\TeamMeta;
use App\Time;
use App\Tournament;
use App\Track;
use App\Year;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;

class TrackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'edit', 'delete']]);
    }

    public function index()
    {
        $teams = Team::orderBy('school_name')->get();

        $todaysMatches = Track::where('date', Carbon::today('America/New_York'))->get();

        $yesterdaysMatches = Track::where('date', Carbon::yesterday('America/New_York'))->get();

        $tomorrowsMatches = Track::where('date', Carbon::tomorrow('America/New_York'))->get();

        $games = Track::all();

        return view('sports.track.index', compact('games', 'teams', 'todaysMatches', 'tomorrowsMatches', 'yesterdaysMatches'));
    }

    public function create()
    {
        $teams = Team::orderBy('school_name')->get();

        $times = Time::all();

        $years = Year::orderBy('year', 'desc')->get();

        return view('sports.track.create', compact('teams', 'times', 'years'));
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

        Track::create([
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

        Session::flash('success', 'Track Event Has Been Created');

        return redirect('/track-and-field');
    }

    public function show($id)
    {
        $match = Track::where('id', $id)->with('the_team')
                                     ->with('host_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->first();

        return view('sports.track.show', compact('match'));
    }

    public function edit($id)
    {
        $teams = Team::orderBy('school_name')->get();

        $times = Time::all();

        $years = Year::all();

        $match = Track::where('id', $id)->with('the_team')
                                     ->with('host_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->first();

        return view('sports.track.edit', compact('match', 'teams', 'times', 'years'));
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

        $game = Track::findOrFail($id);
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

        Session::flash('success', 'Track Event Has Been Updated');

        return redirect('/track-and-field/'.$id);
    }

    public function destroy($id)
    {
        $event = Track::find($id);
        $event->delete();

        Session::flash('success', 'Track Event Has Been Deleted');

        return redirect('/track-and-field');
    }

    public function teamSchedule($team)
    {
        $id = Team::where('school_name', $team)->pluck('id');

        $selectedTeam = Team::where('school_name', $team)->first();

        $year = Year::pluck('id')->first();

        $teams = Team::orderBy('school_name')->get();

        $varsity = Track::with('the_team')
                               ->with('host_team')
                               ->where('team_id', $id)
                               ->where('team_level', 1)
                               ->orderBy('date')
                               ->get();

        $juniorvarsity = Track::with('the_team')
                               ->with('host_team')
                               ->where('team_id', $id)
                               ->where('team_level', 1)
                               ->orderBy('date')
                               ->get();

        $freshman = Track::with('the_team')
                               ->with('host_team')
                               ->where('team_id', $id)
                               ->where('team_level', 3)
                               ->orderBy('date')
                               ->get();

        return view('sports.track.teamschedule', compact('id', 'selectedTeam', 'team', 'teams', 'varsity', 'juniorvarsity', 'freshman'));
    }

    public function apiTeamSchedule($year, $team, $teamlevel)
    {
        $theteam = Team::where('school_name', '=', $team)->pluck('id');
        $theYear = Year::where('year', $year)->pluck('id')->first();

        $game = Track::with('the_team')
                                ->with('the_year')
                               ->with('host_team')
                               ->with('game_time')
                               ->where('team_id', $theteam)
                               ->where('year_id', $theYear)
                               ->where('team_level', $teamlevel)
                               ->orderBy('date')
                               ->get();

        return $game;
    }

    public function todaysEvents($team)
    {
        $theteam = Team::where('school_name', '=', $team)->pluck('id');

        $game = Track::with('the_team')
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
