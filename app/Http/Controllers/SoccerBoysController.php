<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\SoccerBoys;
use App\SoccerBoysScore;
use App\Team;
use App\Time;
use App\Tournament;
use App\Year;

use Session;

use Auth;

use Illuminate\Http\Request;

class SoccerBoysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $teams = Team::orderBy('school_name')->get();

        $todaysGames = SoccerBoys::where('date', Carbon::today())->get();

        $yesterdaysGames = SoccerBoys::where('date', Carbon::yesterday())->get();

        $tomorrowsGames = SoccerBoys::where('date', Carbon::tomorrow())->get();

        $games = SoccerBoys::all();

        return view('sports.soccer-boys.index', compact('games', 'teams', 'todaysGames', 'tomorrowsGames', 'yesterdaysGames'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teams = Team::orderBy('school_name')->get();

        $times = Time::all();

        $years = Year::all();

        return view('sports.soccer-boys.create', compact('teams','times','years'));
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
            'time_id'           => 'required'
        ],
        [
            'year_id.required'          =>  'Please select a school year.',
            'team_level.required'       =>  'Please select a team level.',
            'away_team_id.required'     =>  'Please select an away team.',
            'home_team_id.required'     =>  'Please select a home team.',
            'time_id.required'          =>  'Please select a game time.'
        ]);

        SoccerBoys::create([
            'year_id'       => request('year_id'),
            'team_level'    => request('team_level'),
            'date'          => request('date'),
            'scrimmage'     => request('scrimmage'),
            'tournament_name' => request('tournament_name'),
            'away_team_id'  => request('away_team_id'),
            'home_team_id'  => request('home_team_id'),
            'time_id'       => request('time_id'),
            'district_game' => request('district_game'),
            'created_by'    => $user_id
        ]);

        Session::flash('success', 'Boys Soccer Match Has Been Created');

        return redirect('/boys-soccer');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = SoccerBoys::where('id', $id)->with('away_team')
                                     ->with('home_team')
                                     ->with('away_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
                                     ->first();


        return view('sports.soccer-boys.show', compact('game'));
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

        $years = Year::all();

        $match = SoccerBoys::where('id',$id)->with('away_team')
                                     ->with('home_team')
                                     ->with('away_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
                                     ->first();

        return view('sports.soccer-boys.edit', compact('match', 'teams','times','years'));
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
            'time_id'           => 'required'
        ],
        [
            'year_id.required'          =>  'Please select a school year.',
            'team_level.required'       =>  'Please select a team level.',
            'away_team_id.required'     =>  'Please select an away team.',
            'home_team_id.required'     =>  'Please select a home team.',
            'time_id.required'          =>  'Please select a game time.'
        ]);

        $game = SoccerBoys::findOrFail($id);
        $game->year_id = request('year_id');
        $game->team_level = request('team_level');
        $game->date = request('date');
        $game->scrimmage = request('scrimmage');
        $game->tournament_name = request('tournament_name');
        $game->away_team_id = request('away_team_id');
        $game->home_team_id = request('home_team_id');
        $game->time_id = request('time_id');
        $game->district_game = request('district_game');
        $game->modified_by   = $user_id;

        $game->update();

        Session::flash('success', 'Boys Soccer Match Has Been Updated');

        return redirect('/boys-soccer/'.$id);
    }

    public function editScore($id)
    {

        $teams = Team::orderBy('school_name')->get();

        $times = Time::all();

        $years = Year::all();


        //  Get Away Team Wins And Losses
        $away_team_id = SoccerBoys::where('id', $id)->pluck('away_team_id');

        $away_team_losses_loop = SoccerBoys::where('losing_team', '=', $away_team_id)
                                ->where('team_level', '=', 1)
                                ->get();
        $away_losses = $away_team_losses_loop->count();

        $away_team_wins_loop = SoccerBoys::where('winning_team', '=', $away_team_id)
                                ->where('team_level', '=', 1)
                                ->get();
        $away_wins = $away_team_wins_loop->count();

        //  Get Home Team Wins And Losses
        $home_team_id = SoccerBoys::where('id', $id)->pluck('home_team_id');

        $home_team_losses_loop = SoccerBoys::where('losing_team', '=', $home_team_id)
                                ->where('team_level', '=', 1)
                                ->get();
        $home_losses = $home_team_losses_loop->count();

        $home_team_wins_loop = SoccerBoys::where('winning_team', '=', $home_team_id)
                                ->where('team_level', '=', 1)
                                ->get();
        $home_wins = $home_team_wins_loop->count();

        //  Get Scores from each half
        $scores = SoccerBoysScore::where('match_id', $id)->get();

        $match = SoccerBoys::where('id', $id)->with('away_team')
                                     ->with('home_team')
                                     ->with('away_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
                                     ->first();

        return view('sports.soccer-boys.edit-score', compact('away_losses', 'away_wins', 'home_losses', 'home_wins', 'game', 'match', 'scores', 'teams','times','years'));
    }

    public function gameUpdate(Request $request, $id)
    {
        $user_id = Auth::user()->id;

        $match = SoccerBoys::where('id', $id)->get();

        $game = SoccerBoys::findOrFail($id);
        $game->game_minute = request('game_minute');
        $game->game_status = request('game_status');
        $game->away_team_final_score = request('away_team_final_score');
        $game->home_team_final_score = request('home_team_final_score');
        $game->winning_team = request('winning_team');
        $game->losing_team = request('losing_team');
        $game->end_in_pks = request('end_in_pks');
        $game->modified_by   = $user_id;

        $game->update();

        Session::flash('success', 'Boys Soccer Match Has Been Updated');

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
        $game = SoccerBoys::find($id);
        $game->delete();
        return redirect('/boys-soccer');
    }



    public function teamSchedule($team)
    {

        $id = Team::where('school_name', $team)->pluck('id');

        $selectedTeam = Team::where('school_name', $team)->first();

        $wins = SoccerBoys::where('winning_team', $id)->count();

        $losses = SoccerBoys::where('losing_team', $id)->count();

        $teams = Team::orderBy('school_name')->get();

        $varsity = SoccerBoys::with('away_team')
                               ->with('home_team')
                               ->where(function ($query) use ($id) {
                                    $query->where('away_team_id', '=' , $id)
                                    ->orWhere('home_team_id', '=', $id);
                                })
                               ->where('team_level', 1)
                               ->orderBy('date')
                               ->get();

        $juniorvarsity = SoccerBoys::with('away_team')
                               ->with('home_team')
                               ->where(function ($query) use ($id) {
                                    $query->where('away_team_id', '=' , $id)
                                    ->orWhere('home_team_id', '=', $id);
                                })
                               ->where('team_level', 2)
                               ->orderBy('date')
                               ->get();

        $freshman = SoccerBoys::with('away_team')
                               ->with('home_team')
                               ->where(function ($query) use ($id) {
                                    $query->where('away_team_id', '=' , $id)
                                    ->orWhere('home_team_id', '=', $id);
                                })
                               ->where('team_level', 3)
                               ->orderBy('date')
                               ->get();

        return view('sports.soccer-boys.teamschedule', compact('id', 'selectedTeam', 'team', 'teams', 'varsity', 'juniorvarsity', 'freshman', 'wins', 'losses'));

    }


    public function scoreCreate($id)
    {

        $user_id = Auth::user()->id;

        SoccerBoysScore::create([
            'match_id'          =>  $id,
            'away_team_score'   =>  0,
            'home_team_score'   =>  0,
            'created_by'        =>  $user_id
        ]);

        Session::flash('success', 'Half Has Been Added');

        return back();

    }

    public function storeGameHalf(Request $request, $id)
    {

        $user_id = Auth::user()->id;

        $this->validate(request(), [
            'away_team_score'       =>  'required|numeric',
            'home_team_score'       =>  'required|numeric',
        ]);

        $half = SoccerBoysScore::findOrFail($id);
        $half->away_team_score  = request('away_team_score');
        $half->home_team_score  = request('home_team_score');
        $half->modified_by = $user_id;

        $half->update();

        Session::flash('success', 'Score Has Been Updated');

        return back();

    }

    public function scoreDelete($id)
    {
        SoccerBoysScore::find($id)->delete();

        Session::flash('success', 'Half Has Been Deleted');

        return back();
    }



    public function apiGameId($id)
    {

        $game = SoccerBoys::where('id', $id)->with('away_team')
                                     ->with('home_team')
                                     ->with('away_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
                                     ->first();

        return $game;

    }

    public function apiTeamSchedule($year, $team, $teamlevel)
    {

        $theteam = Team::where('school_name', '=', $team)->pluck('id');
        $theYear = Year::where('year', $year)->pluck('id')->first();

        $game = SoccerBoys::with('away_team')
                                     ->with('home_team')
                                     ->with('away_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
                                     ->with('the_year')
                                     ->where('year_id', $theYear)
                                     ->where(function ($query) use ($theteam) {
                                        $query->where('away_team_id', '=' , $theteam)
                                        ->orWhere('home_team_id', '=', $theteam);
                                     })
                                     ->where('team_level', $teamlevel)
                                     
                                     ->orderBy('date','asc')
                                     ->get();

        return $game;

    }

}
