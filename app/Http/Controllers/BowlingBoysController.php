<?php

namespace App\Http\Controllers;

use Auth;

use Session;
use App\Team;
use App\Time;
use App\Year;
use App\TeamMeta;
use Carbon\Carbon;

use App\Tournament;

use App\BowlingBoys;

use Illuminate\Http\Request;

class BowlingBoysController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'edit', 'delete']]);
    }

    public function index()
    {
        $teams = Team::orderBy('school_name')->get();

        $todaysGames = BowlingBoys::where('date', Carbon::today('America/New_York'))->get();

        $yesterdaysGames = BowlingBoys::where('date', Carbon::yesterday('America/New_York'))->get();

        $tomorrowsGames = BowlingBoys::where('date', Carbon::tomorrow('America/New_York'))->get();

        $games = BowlingBoys::all();

        return view('sports.bowling-boys.index', compact('games', 'teams', 'todaysGames', 'tomorrowsGames', 'yesterdaysGames'));
    }

    public function create()
    {
        $teams = Team::orderBy('school_name')->get();

        $times = Time::all();

        $years = Year::all();

        return view('sports.bowling-boys.create', compact('teams', 'times', 'years'));
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $this->validate(request(), [
            'year_id'           => 'required',
            'team_level'        => 'required',
            'date'              => 'date|required',
            'away_team_id'      => 'required',
            'home_team_id'      => 'required',
            'time_id'           => 'required',
        ],
        [
            'year_id.required'          =>  'Please select a school year.',
            'team_level.required'       =>  'Please select a team level.',
            'away_team_id.required'     =>  'Please select an away team.',
            'home_team_id.required'     =>  'Please select a home team.',
            'time_id.required'          =>  'Please select a game time.',
        ]);

        BowlingBoys::create([
            'year_id'       => request('year_id'),
            'team_level'    => request('team_level'),
            'date'          => request('date'),
            'scrimmage'     => request('scrimmage'),
            'tournament_name' => request('tournament_name'),
            'location'      => request('location'),
            'away_team_id'  => request('away_team_id'),
            'home_team_id'  => request('home_team_id'),
            'time_id'       => request('time_id'),
            'district_game' => request('district_game'),
            'created_by'    => $user_id,
        ]);

        Session::flash('success', 'Boys Bowling Game Has Been Created');

        return redirect('/boys-bowling');
    }

    public function show($id)
    {
        $game = BowlingBoys::where('id', $id)->with('away_team')
                                     ->with('home_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->first();

        return view('sports.bowling-boys.show', compact('game'));
    }

    public function edit($id)
    {
        $teams = Team::orderBy('school_name')->get();

        $times = Time::all();

        $years = Year::all();

        $match = BowlingBoys::where('id', $id)->with('away_team')
                                     ->with('home_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->first();

        return view('sports.bowling-boys.edit', compact('match', 'teams', 'times', 'years'));
    }

    public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;

        $this->validate(request(), [
            'year_id'           => 'required',
            'team_level'        => 'required',
            'date'              => 'date|required',
            'away_team_id'      => 'required',
            'home_team_id'      => 'required',
            'time_id'           => 'required',
        ],
        [
            'year_id.required'          =>  'Please select a school year.',
            'team_level.required'       =>  'Please select a team level.',
            'away_team_id.required'     =>  'Please select an away team.',
            'home_team_id.required'     =>  'Please select a home team.',
            'time_id.required'          =>  'Please select a game time.',
        ]);

        $game = BowlingBoys::findOrFail($id);
        $game->year_id = request('year_id');
        $game->team_level = request('team_level');
        $game->date = request('date');
        $game->scrimmage = request('scrimmage');
        $game->tournament_name = request('tournament_name');
        $game->away_team_id = request('away_team_id');
        $game->home_team_id = request('home_team_id');
        $game->time_id = request('time_id');
        $game->location = request('location');
        $game->away_team_final_score = request('away_team_final_score');
        $game->home_team_final_score = request('home_team_final_score');
        $game->winning_team = request('winning_team');
        $game->losing_team = request('losing_team');
        $game->modified_by = $user_id;

        $game->update();

        Session::flash('success', 'Bowling Boys Game Has Been Updated');

        return redirect('/boys-bowling/'.$id);
    }

    public function destroy($id)
    {
        $game = BowlingBoys::find($id);
        $game->delete();

        return redirect('/boys-bowling');
    }

    public function teamSchedule($team)
    {
        $id = Team::where('school_name', $team)->pluck('id');

        $selectedTeam = Team::where('school_name', $team)->first();

        $year = Year::pluck('id')->first();

        $wins = BowlingBoys::where('winning_team', $id)->where('team_level', 1)->count();

        $losses = BowlingBoys::where('losing_team', $id)->where('team_level', 1)->count();

        $teams = Team::orderBy('school_name')->get();

        $varsity = BowlingBoys::with('away_team')
                               ->with('home_team')
                               ->where(function ($query) use ($id) {
                                   $query->where('away_team_id', '=', $id)
                                    ->orWhere('home_team_id', '=', $id);
                               })
                               ->where('team_level', 1)
                               ->orderBy('date')
                               ->get();

        $juniorvarsity = BowlingBoys::with('away_team')
                               ->with('home_team')
                               ->where(function ($query) use ($id) {
                                   $query->where('away_team_id', '=', $id)
                                    ->orWhere('home_team_id', '=', $id);
                               })
                               ->where('team_level', 2)
                               ->orderBy('date')
                               ->get();

        $freshman = BowlingBoys::with('away_team')
                               ->with('home_team')
                               ->where(function ($query) use ($id) {
                                   $query->where('away_team_id', '=', $id)
                                    ->orWhere('home_team_id', '=', $id);
                               })
                               ->where('team_level', 3)
                               ->orderBy('date')
                               ->get();

        return view('sports.bowling-boys.teamschedule', compact('id', 'selectedTeam', 'team', 'teams', 'varsity', 'juniorvarsity', 'freshman', 'wins', 'losses'));
    }

    public function apiTeamSchedule($year, $team, $teamlevel)
    {
        $theteam = Team::where('school_name', '=', $team)->pluck('id');
        $theYear = Year::where('year', $year)->pluck('id')->first();

        $game = BowlingBoys::with('away_team')
                                     ->with('home_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('the_year')
                                     ->where('year_id', $theYear)
                                     ->where(function ($query) use ($theteam) {
                                         $query->where('away_team_id', '=', $theteam)
                                        ->orWhere('home_team_id', '=', $theteam);
                                     })
                                     ->where('team_level', $teamlevel)

                                     ->orderBy('date', 'asc')
                                     ->get();

        return $game;
    }

    public function todaysEvents($team)
    {
        $theteam = Team::where('school_name', '=', $team)->pluck('id');

        $game = BowlingBoys::with('away_team')
                                     ->with('home_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('the_year')
                                     ->where(function ($query) use ($theteam) {
                                         $query->where('away_team_id', '=', $theteam)
                                        ->orWhere('home_team_id', '=', $theteam);
                                     })
                                     ->where('team_level', 1)
                                     ->where('date', Carbon::today('America/New_York'))
                                     ->orderBy('date', 'asc')
                                     ->get();

        return $game;
    }
}
