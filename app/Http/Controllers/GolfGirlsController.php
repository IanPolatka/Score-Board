<?php

namespace App\Http\Controllers;

use Auth;

use Session;
use Twitter;
use App\Team;
use App\Time;
use App\Year;
use App\TeamMeta;
use App\GolfGirls;

use App\CurrentYear;

use Carbon\Carbon;

use Illuminate\Http\Request;

class GolfGirlsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'edit', 'delete']]);
    }

    public function index()
    {
        $teams = Team::orderBy('school_name')->get();

        $todaysMatches = GolfGirls::where('date', Carbon::today('America/New_York'))->get();

        $yesterdaysMatches = GolfGirls::where('date', Carbon::yesterday('America/New_York'))->get();

        $tomorrowsMatches = GolfGirls::where('date', Carbon::tomorrow('America/New_York'))->get();

        $matches = GolfGirls::all();

        $currentYearId = CurrentYear::pluck('year_id');

        $theCurrentYear = Year::where('id', $currentYearId)->get();

        return view('sports.golf-girls.index', compact('matches', 'teams', 'theCurrentYear', 'todaysMatches', 'tomorrowsMatches', 'yesterdaysMatches'));
    }

    public function create()
    {
        $teams = Team::orderBy('school_name')->get();

        $times = Time::all();

        $years = Year::orderBy('year', 'desc')->get();

        return view('sports.golf-girls.create', compact('teams', 'times', 'years'));
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
            'away_team_id.required'     =>  'Please select a away team.',
            'home_team_id.required'     =>  'Please select a home team.',
            'time_id.required'          =>  'Please select a match time.',
        ]);

        GolfGirls::create([
            'year_id'       	=> request('year_id'),
            'team_level'    	=> request('team_level'),
            'date'          	=> request('date'),
            'tournament_name' 	=> request('tournament_name'),
            'location'      	=> request('location'),
            'away_team_id'  	=> request('away_team_id'),
            'home_team_id'  	=> request('home_team_id'),
            'time_id'       	=> request('time_id'),
            'created_by'    	=> $user_id,
        ]);

        Session::flash('success', 'Girls Golf Match Has Been Created');

        return redirect('/girls-golf');
    }

    public function show($id)
    {
        $match = GolfGirls::where('id', $id)->with('away_team')
                        ->with('home_team')
                        ->with('away_team')
                        ->with('game_time')
                        ->with('user_created')
                        ->with('user_modified')
                        ->first();

        return view('sports.golf-girls.show', compact('match'));
    }

    public function edit($id)
    {
        $teams = Team::orderBy('school_name')->get();

        $times = Time::all();

        $years = Year::orderBy('year', 'desc')->get();

        $match = GolfGirls::where('id', $id)->with('away_team')
                         ->with('home_team')
                         ->with('away_team')
                         ->with('game_time')
                         ->with('user_created')
                         ->with('user_modified')
                         ->first();

        return view('sports.golf-girls.edit', compact('match', 'teams', 'times', 'years'));
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

        $match 							= GolfGirls::findOrFail($id);
        $match->year_id 				= request('year_id');
        $match->team_level 				= request('team_level');
        $match->date 					= request('date');
        $match->tournament_name 		= request('tournament_name');
        $match->away_team_id 			= request('away_team_id');
        $match->home_team_id 			= request('home_team_id');
        $match->time_id 				= request('time_id');
        $match->away_team_final_score 	= request('away_team_final_score');
        $match->home_team_final_score 	= request('home_team_final_score');
        $match->winning_team 			= request('winning_team');
        $match->losing_team 			= request('losing_team');
        $match->location 				= request('location');
        $match->modified_by 			= $user_id;

        $match->update();

        Session::flash('success', 'Girls Golf Match Has Been Updated');

        return redirect('/girls-golf/'.$id);
    }

    public function destroy($id)
    {
        $match = GolfGirls::find($id);
        $match->delete();

        return redirect('/girls-golf');
    }

    public function teamSchedule($year, $team)
    {
        $id = Team::where('school_name', $team)->pluck('id');

        $selectedyear = Year::where('year', $year)->pluck('year');

        $selectedyearid = Year::where('year', $year)->pluck('id');

        $selectedTeam = Team::where('school_name', $team)->first();

        $year = Year::pluck('id')->first();

        $years = Year::orderBy('year')->get();

        $wins = GolfGirls::where('winning_team', $id)->where('team_level', 1)->where('year_id', $selectedyearid)->count();

        $losses = GolfGirls::where('losing_team', $id)->where('team_level', 1)->where('year_id', $selectedyearid)->count();

        $teams = Team::orderBy('school_name')->get();

        $varsity = GolfGirls::with('away_team')
                               ->with('home_team')
                               ->where(function ($query) use ($id) {
                                   $query->where('away_team_id', '=', $id)
                                    ->orWhere('home_team_id', '=', $id);
                               })
                               ->where('team_level', 1)
                               ->where('year_id', $selectedyearid)
                               ->orderBy('date')
                               ->get();

        $juniorvarsity = GolfGirls::with('away_team')
                               ->with('home_team')
                               ->where(function ($query) use ($id) {
                                   $query->where('away_team_id', '=', $id)
                                    ->orWhere('home_team_id', '=', $id);
                               })
                               ->where('team_level', 2)
                               ->where('year_id', $selectedyearid)
                               ->orderBy('date')
                               ->get();

        $freshman = GolfGirls::with('away_team')
                               ->with('home_team')
                               ->where(function ($query) use ($id) {
                                   $query->where('away_team_id', '=', $id)
                                    ->orWhere('home_team_id', '=', $id);
                               })
                               ->where('team_level', 3)
                               ->where('year_id', $selectedyearid)
                               ->orderBy('date')
                               ->get();

        return view('sports.golf-girls.teamschedule', compact('id', 'selectedTeam', 'selectedyear', 'selectedyearid', 'team', 'teams', 'varsity', 'juniorvarsity', 'freshman', 'wins', 'losses', 'years'));
    }

    public function apiMatchId($id)
    {
        $match = GolfGirls::where('id', $id)->with('away_team')
                        ->with('home_team')
                        ->with('away_team')
                        ->with('game_time')
                        ->with('user_created')
                        ->with('user_modified')
                        ->with('the_year')
                        ->first();

        return $match;
    }

    public function apiTeamSchedule($year, $team, $teamlevel)
    {
        $theteam = Team::where('school_name', '=', $team)->pluck('id');
        $theYear = Year::where('year', $year)->pluck('id')->first();

        $match = GolfGirls::with('away_team')
                         ->with('home_team')
                         ->with('away_team')
                         ->with('game_time')
                         ->with('user_created')
                         ->with('user_modified')
                         ->with('scores')
                         ->with('the_year')
                         ->where('year_id', $theYear)
                         ->where(function ($query) use ($theteam) {
                            $query->where('away_team_id', '=', $theteam)
                            ->orWhere('home_team_id', '=', $theteam);
                         })
                         ->where('team_level', $teamlevel)
						 ->orderBy('date', 'asc')
                         ->get();

        return $match;
    }
}
