<?php

namespace App\Http\Controllers;

use Auth;

use Session;
use App\Team;
use App\Time;
use App\Year;
use App\Volleyball;
use App\TeamMeta;
use Carbon\Carbon;
use App\Tournament;

use App\CurrentYear;

use App\VolleyballScores;

use Illuminate\Http\Request;

class VolleyballController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'edit', 'editScore', 'delete']]);
    }

    public function index()
    {
        $teams = Team::orderBy('school_name')->get();

        $todaysMatches = Volleyball::where('date', Carbon::today('America/New_York'))->get();

        $yesterdaysMatches = Volleyball::where('date', Carbon::yesterday('America/New_York'))->get();

        $tomorrowsMatches = Volleyball::where('date', Carbon::tomorrow('America/New_York'))->get();

        $matches = Volleyball::all();

        $currentYearId = CurrentYear::pluck('year_id');

        $theCurrentYear = Year::where('id', $currentYearId)->get();

        return view('sports.volleyball.index', compact('matches', 'teams', 'theCurrentYear', 'todaysMatches', 'tomorrowsMatches', 'yesterdaysMatches'));
    }

    public function create()
    {
        $teams = Team::orderBy('school_name')->get();

        $times = Time::all();

        $years = Year::orderBy('year', 'desc')->get();

        return view('sports.volleyball.create', compact('teams', 'times', 'years'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            'time_id.required'          =>  'Please select a match time.',
        ]);

        Volleyball::create([
            'year_id'       	=> request('year_id'),
            'team_level'    	=> request('team_level'),
            'date'          	=> request('date'),
            'scrimmage'     	=> request('scrimmage'),
            'tournament_name' 	=> request('tournament_name'),
            'location'      	=> request('location'),
            'away_team_id'  	=> request('away_team_id'),
            'home_team_id'  	=> request('home_team_id'),
            'time_id'       	=> request('time_id'),
            'district_game' 	=> request('district_game'),
            'created_by'    	=> $user_id,
        ]);

        Session::flash('success', 'Volleyball Match Has Been Created');

        return redirect('/volleyball');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $match = Volleyball::where('id', $id)
        				   ->with('away_team')
		                   ->with('home_team')
		                   ->with('away_team')
		                   ->with('game_time')
		                   ->with('user_created')
		                   ->with('user_modified')
		                   ->with('the_year')
		                   ->with('scores')
		                   ->first();

        return view('sports.volleyball.show', compact('match'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teams = Team::orderBy('school_name')->get();

        $times = Time::all();

        $years = Year::orderBy('year', 'desc')->get();

        $match = Volleyball::where('id', $id)->with('away_team')
                                     		 ->with('home_team')
                                             ->with('away_team')
                                             ->with('game_time')
                                             ->with('user_created')
                                             ->with('user_modified')
                                             ->with('scores')
                                             ->first();

        return view('sports.volleyball.edit', compact('match', 'teams', 'times', 'years'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            'time_id.required'          =>  'Please select a match time.',
        ]);

        $match 					= Volleyball::findOrFail($id);
        $match->year_id 		= request('year_id');
        $match->team_level 		= request('team_level');
        $match->date 			= request('date');
        $match->scrimmage 		= request('scrimmage');
        $match->tournament_name = request('tournament_name');
        $match->away_team_id 	= request('away_team_id');
        $match->home_team_id 	= request('home_team_id');
        $match->time_id 		= request('time_id');
        $match->district_game 	= request('district_game');
        $match->location 		= request('location');
        $match->modified_by 	= $user_id;

        $match->update();

        Session::flash('success', 'Volleyball Match Has Been Updated');

        return redirect('/volleyball/'.$id);
    }

    public function editScore($id)
    {
        $teams = Team::orderBy('school_name')->get();

        $times = Time::all();

        $years = Year::all();

        $selectedYear = Volleyball::where('id', $id)->pluck('year_id');

        //  Get Away Team Wins And Losses
        $away_team_id = Volleyball::where('id', $id)->pluck('away_team_id');

        $away_team_losses_loop = Volleyball::where('losing_team', '=', $away_team_id)
                                		   ->where('team_level', '=', 1)
                                           ->where('year_id', $selectedYear)
                                           ->get();
        $away_losses = $away_team_losses_loop->count();

        $away_team_wins_loop = Volleyball::where('winning_team', '=', $away_team_id)
                                         ->where('team_level', '=', 1)
                                         ->where('year_id', $selectedYear)
                                         ->get();
        $away_wins = $away_team_wins_loop->count();

        //  Get Home Team Wins And Losses
        $home_team_id = Volleyball::where('id', $id)->pluck('home_team_id');

        $home_team_losses_loop = Volleyball::where('losing_team', '=', $home_team_id)
                                           ->where('team_level', '=', 1)
                                           ->where('year_id', $selectedYear)
                                           ->get();
        $home_losses = $home_team_losses_loop->count();

        $home_team_wins_loop = Volleyball::where('winning_team', '=', $home_team_id)
                                         ->where('team_level', '=', 1)
                                         ->where('year_id', $selectedYear)
                                         ->get();
        $home_wins = $home_team_wins_loop->count();

        //  Get Scores from each half
        $scores = VolleyballScores::where('game_id', $id)->get();

        $match = Volleyball::where('id', $id)->with('away_team')
                                     		 ->with('home_team')
                                     		 ->with('away_team')
                                     		 ->with('game_time')
                                     		 ->with('user_created')
                                     		 ->with('user_modified')
                                     		 ->with('the_year')
                                     		 ->with('scores')
                                     		 ->first();

        return view('sports.volleyball.edit-score', compact('away_losses', 'away_wins', 'home_losses', 'home_wins', 'match', 'scores', 'teams', 'times', 'years'));
    }

    public function gameUpdate(Request $request, $id)
    {
        $user_id = Auth::user()->id;

        $match 							= Volleyball::findOrFail($id);
        $match->current_game 			= request('current_game');
        $match->away_team_final_score 	= request('away_team_final_score');
        $match->home_team_final_score 	= request('home_team_final_score');
        $match->winning_team 			= request('winning_team');
        $match->losing_team 			= request('losing_team');
        $match->modified_by 			= $user_id;

        $match->update();

        Session::flash('success', 'Volleyball Match Has Been Updated');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $match = Volleyball::find($id);
        $match->delete();

        return redirect('/volleyball');
    }

    public function teamSchedule($year, $team)
    {
        $id = Team::where('school_name', $team)->pluck('id');

        $selectedyear = Year::where('year', $year)->pluck('year');

        $selectedyearid = Year::where('year', $year)->pluck('id');

        $selectedTeam = Team::where('school_name', $team)->first();

        $year = Year::pluck('id')->first();

        $years = Year::orderBy('year')->get();

        $wins = Volleyball::where('winning_team', $id)->where('team_level', 1)->where('year_id', $selectedyearid)->count();

        $losses = Volleyball::where('losing_team', $id)->where('team_level', 1)->where('year_id', $selectedyearid)->count();

        $districtWins = Volleyball::where('winning_team', $id)->where('team_level', 1)->where('year_id', $selectedyearid)->where('district_game', 1)->count();

        $districtLosses = Volleyball::where('losing_team', $id)->where('team_level', 1)->where('year_id', $selectedyearid)->where('district_game', 1)->count();

        $teams = Team::orderBy('school_name')->get();

        $varsity = Volleyball::with('away_team')
                             ->with('home_team')
                             ->with('away_team_district')
                             ->with('home_team_district')
                             ->where(function ($query) use ($id) {
                                $query->where('away_team_id', '=', $id)
                                    ->orWhere('home_team_id', '=', $id);
                             })
                             ->where('team_level', 1)
                             ->where('year_id', $selectedyearid)
                             ->orderBy('date')
                             ->get();

        $juniorvarsity = Volleyball::with('away_team')
                               	   ->with('home_team')
                                   ->with('away_team_district')
                                   ->with('home_team_district')
                                   ->where(function ($query) use ($id) {
                                   		$query->where('away_team_id', '=', $id)
                                    	->orWhere('home_team_id', '=', $id);
                               	   })
                                   ->where('team_level', 2)
                                   ->where('year_id', $selectedyearid)
                                   ->orderBy('date')
                                   ->get();

        $freshman = Volleyball::with('away_team')
                              ->with('home_team')
                              ->with('away_team_district')
                              ->with('home_team_district')
                              ->where(function ($query) use ($id) {
                                $query->where('away_team_id', '=', $id)
                                ->orWhere('home_team_id', '=', $id);
                              })
                              ->where('team_level', 3)
                              ->where('year_id', $selectedyearid)
                              ->orderBy('date')
                              ->get();

        return view('sports.volleyball.teamschedule', compact('id', 'selectedTeam', 'team', 'teams', 'varsity', 'juniorvarsity', 'freshman', 'wins', 'losses', 'selectedyear', 'selectedyearid', 'districtWins', 'districtLosses', 'years'));
    }

    public function scoreCreate($id)
    {
        $user_id = Auth::user()->id;

        VolleyballScores::create([
            'game_id'          	=>  $id,
            'away_team_score'   =>  0,
            'home_team_score'   =>  0,
            'created_by'        =>  $user_id,
        ]);

        Session::flash('success', 'Game Has Been Added');

        return back();
    }

    public function storeGameScore(Request $request, $id)
    {
        $user_id = Auth::user()->id;

        $this->validate(request(), [
            'away_team_score'	=>  'required|numeric',
            'home_team_score'   =>  'required|numeric',
        ]);

        $match 					    = VolleyballScores::findOrFail($id);
        $match->away_team_score 	= request('away_team_score');
        $match->home_team_score 	= request('home_team_score');
        $match->game_winner         = request('game_winner');
        $match->modified_by 		= $user_id;

        $match->update();

        Session::flash('success', 'Score Has Been Updated');

        return back();
    }

    public function scoreDelete($id)
    {
        VolleyballScores::find($id)->delete();

        Session::flash('success', 'Game Has Been Deleted');

        return back();
    }

    public function apiGameId($id)
    {
        $match = Volleyball::where('id', $id)->with('away_team')
                                             ->with('home_team')
                                             ->with('away_team')
                                             ->with('game_time')
                                             ->with('user_created')
                                             ->with('user_modified')
                                             ->with('the_year')
                                             ->with('scores')
                                             ->first();

        return $match;
    }

    public function apiTeamSchedule($year, $team, $teamlevel)
    {
        $theteam = Team::where('school_name', '=', $team)->pluck('id');
        $theYear = Year::where('year', $year)->pluck('id')->first();

        $match = Volleyball::with('away_team')
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
