<?php

namespace App\Http\Controllers;

use App\BowlingGirls;
use App\Team;
use App\TeamMeta;
use App\Time;
use App\Tournament;
use App\Year;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;

class BowlingGirlsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'edit', 'delete']]);
    }

    public function index()
    {
        $teams = Team::orderBy('school_name')->get();

        $todaysGames = BowlingGirls::where('date', Carbon::today('America/New_York'))->get();

        $yesterdaysGames = BowlingGirls::where('date', Carbon::yesterday('America/New_York'))->get();

        $tomorrowsGames = BowlingGirls::where('date', Carbon::tomorrow('America/New_York'))->get();

        $games = BowlingGirls::all();

        return view('sports.bowling-girls.index', compact('games', 'teams', 'todaysGames', 'tomorrowsGames', 'yesterdaysGames'));
    }

    public function create()
    {
        $teams = Team::orderBy('school_name')->get();

        $times = Time::all();

        $years = Year::orderBy('year', 'desc')->get();

        return view('sports.bowling-girls.create', compact('teams', 'times', 'years'));
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

        BowlingGirls::create([
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

        return redirect('/girls-bowling');
    }

    public function show($id)
    {
        $game = BowlingGirls::where('id', $id)->with('away_team')
                                     ->with('home_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->first();

        return view('sports.bowling-girls.show', compact('game'));
    }

    public function edit($id)
    {
        $teams = Team::orderBy('school_name')->get();

        $times = Time::all();

        $years = Year::all();

        $match = BowlingGirls::where('id', $id)->with('away_team')
                                     ->with('home_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->first();

        return view('sports.bowling-girls.edit', compact('match', 'teams', 'times', 'years'));
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

        $game = BowlingGirls::findOrFail($id);
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

        return redirect('/girls-bowling/'.$id);
    }

    public function destroy($id)
    {
        $game = BowlingGirls::find($id);
        $game->delete();

        return redirect('/girls-bowling');
    }

    public function teamSchedule($team)
    {
        $id = Team::where('school_name', $team)->pluck('id');

        $selectedTeam = Team::where('school_name', $team)->first();

        $year = Year::pluck('id')->first();

        $wins = BowlingGirls::where('winning_team', $id)->where('team_level', 1)->count();

        $losses = BowlingGirls::where('losing_team', $id)->where('team_level', 1)->count();

        $teams = Team::orderBy('school_name')->get();

        $varsity = BowlingGirls::with('away_team')
                               ->with('home_team')
                               ->where(function ($query) use ($id) {
                                   $query->where('away_team_id', '=', $id)
                                    ->orWhere('home_team_id', '=', $id);
                               })
                               ->where('team_level', 1)
                               ->orderBy('date')
                               ->get();

        $juniorvarsity = BowlingGirls::with('away_team')
                               ->with('home_team')
                               ->where(function ($query) use ($id) {
                                   $query->where('away_team_id', '=', $id)
                                    ->orWhere('home_team_id', '=', $id);
                               })
                               ->where('team_level', 2)
                               ->orderBy('date')
                               ->get();

        $freshman = BowlingGirls::with('away_team')
                               ->with('home_team')
                               ->where(function ($query) use ($id) {
                                   $query->where('away_team_id', '=', $id)
                                    ->orWhere('home_team_id', '=', $id);
                               })
                               ->where('team_level', 3)
                               ->orderBy('date')
                               ->get();

        return view('sports.bowling-girls.teamschedule', compact('id', 'selectedTeam', 'team', 'teams', 'varsity', 'juniorvarsity', 'freshman', 'wins', 'losses'));
    }

    public function apiTeamSchedule($year, $team, $teamlevel)
    {
        $theteam = Team::where('school_name', '=', $team)->pluck('id');
        $theYear = Year::where('year', $year)->pluck('id')->first();

        $game = BowlingGirls::with('away_team')
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

        $game = BowlingGirls::with('away_team')
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
