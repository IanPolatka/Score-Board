<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Baseball;
use App\BaseballScores;
use App\Team;
use App\TeamMeta;
use App\Time;
use App\Tournament;
use App\Year;

use Twitter;

use Session;

use Auth;

use Illuminate\Http\Request;

class BaseballController extends Controller
{
    
    public function __construct() 
    {
      $this->middleware('auth', ['only' => [ 'create', 'edit', 'editScore', 'delete' ]]);
    }



    public function index()
    {

        $teams = Team::orderBy('school_name')->get();

        $todaysGames = Baseball::where('date', Carbon::today('America/New_York'))->get();

        $yesterdaysGames = Baseball::where('date', Carbon::yesterday('America/New_York'))->get();

        $tomorrowsGames = Baseball::where('date', Carbon::tomorrow('America/New_York'))->get();

        $games = Baseball::all();

        return view('sports.baseball.index', compact('games', 'teams', 'todaysGames', 'tomorrowsGames', 'yesterdaysGames'));
    }



    public function create()
    {
        $teams = Team::orderBy('school_name')->get();

        $times = Time::all();

        $years = Year::all();

        return view('sports.baseball.create', compact('teams','times','years'));
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
            'time_id'           => 'required'
        ],
        [
            'year_id.required'          =>  'Please select a school year.',
            'team_level.required'       =>  'Please select a team level.',
            'away_team_id.required'     =>  'Please select an away team.',
            'home_team_id.required'     =>  'Please select a home team.',
            'time_id.required'          =>  'Please select a game time.'
        ]);

        Baseball::create([
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
            'created_by'    => $user_id
        ]);

        Session::flash('success', 'Baseball Game Has Been Created');

        return redirect('/baseball');
    }



    public function show($id)
    {
        $game = Baseball::where('id', $id)->with('away_team')
                                     ->with('home_team')
                                     ->with('home_team_district')
                                     ->with('away_team')
                                     ->with('away_team_district')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
                                     ->first();

        return view('sports.baseball.show', compact('game'));
    }



    public function edit($id)
    {

        $teams = Team::orderBy('school_name')->get();

        $times = Time::all();

        $years = Year::all();

        $match = Baseball::where('id',$id)->with('away_team')
                                     ->with('home_team')
                                     ->with('away_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
                                     ->first();

        return view('sports.baseball.edit', compact('match', 'teams','times','years'));
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
            'time_id'           => 'required'
        ],
        [
            'year_id.required'          =>  'Please select a school year.',
            'team_level.required'       =>  'Please select a team level.',
            'away_team_id.required'     =>  'Please select an away team.',
            'home_team_id.required'     =>  'Please select a home team.',
            'time_id.required'          =>  'Please select a game time.'
        ]);

        $game = Baseball::findOrFail($id);
        $game->year_id = request('year_id');
        $game->team_level = request('team_level');
        $game->date = request('date');
        $game->scrimmage = request('scrimmage');
        $game->tournament_name = request('tournament_name');
        $game->away_team_id = request('away_team_id');
        $game->home_team_id = request('home_team_id');
        $game->time_id = request('time_id');
        $game->district_game = request('district_game');
        $game->location     = request('location');
        $game->modified_by   = $user_id;

        $game->update();

        Session::flash('success', 'Baseball Game Has Been Updated');

        return redirect('/baseball/'.$id);
    }

    public function editScore($id)
    {

        $data = Twitter::getUserTimeline(['count' => 10, 'format' => 'array']);



        //  Get Away Team Wins And Losses
        $away_team_id = Baseball::where('id', $id)->pluck('away_team_id');

        $away_team_losses_loop = Baseball::where('losing_team', '=', $away_team_id)
                                ->where('team_level', '=', 1)
                                ->get();
        $away_losses = $away_team_losses_loop->count();

        $away_team_wins_loop = Baseball::where('winning_team', '=', $away_team_id)
                                ->where('team_level', '=', 1)
                                ->get();
        $away_wins = $away_team_wins_loop->count();

        //  Get Home Team Wins And Losses
        $home_team_id = Baseball::where('id', $id)->pluck('home_team_id');

        $home_team_losses_loop = Baseball::where('losing_team', '=', $home_team_id)
                                ->where('team_level', '=', 1)
                                ->get();
        $home_losses = $home_team_losses_loop->count();

        $home_team_wins_loop = Baseball::where('winning_team', '=', $home_team_id)
                                ->where('team_level', '=', 1)
                                ->get();
        $home_wins = $home_team_wins_loop->count();



        $scores = BaseballScores::where('game_id', $id)->get();

        $match = Baseball::where('id', $id)->with('away_team')
                                     ->with('home_team')
                                     ->with('away_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
                                     ->first();

        return view('sports.baseball.edit-score', compact('away_losses', 'away_wins', 'data', 'home_losses', 'home_wins', 'match', 'scores'));
    }



    public function gameUpdate(Request $request, $id)
    {
        $user_id = Auth::user()->id;

        $match = Baseball::where('id', $id)->get();

        $game = Baseball::findOrFail($id);
        $game->inning = request('inning');
        $game->away_team_final_score = request('away_team_final_score');
        $game->home_team_final_score = request('home_team_final_score');
        $game->winning_team = request('winning_team');
        $game->losing_team = request('losing_team');
        $game->modified_by   = $user_id;

        $game->update();

        Session::flash('success', 'Baseball Game Has Been Updated');

        return back();
    }



    public function destroy($id)
    {
        $game = Baseball::find($id);
        $game->delete();
        return redirect('/baseball');
    }



    public function teamSchedule($team)
    {

        $id = Team::where('school_name', $team)->pluck('id');

        $selectedTeam = Team::where('school_name', $team)->first();

        $year = Year::pluck('id')->first();

        $wins = Baseball::where('winning_team', $id)->where('team_level', 1)->count();

        $losses = Baseball::where('losing_team', $id)->where('team_level', 1)->count();

        $teams = Team::orderBy('school_name')->get();

        $varsity = Baseball::with('away_team')
                               ->with('home_team')
                               ->with('away_team_district')
                               ->with('home_team_district')
                               ->where(function ($query) use ($id) {
                                    $query->where('away_team_id', '=' , $id)
                                    ->orWhere('home_team_id', '=', $id);
                               })
                               ->where('team_level', 1)
                               // ->where('team_level', 1)
                               ->orderBy('date')
                               ->get();

        $juniorvarsity = Baseball::with('away_team')
                               ->with('home_team')
                               ->where(function ($query) use ($id) {
                                    $query->where('away_team_id', '=' , $id)
                                    ->orWhere('home_team_id', '=', $id);
                                })
                               ->where('team_level', 2)
                               ->orderBy('date')
                               ->get();

        $freshman = Baseball::with('away_team')
                               ->with('home_team')
                               ->where(function ($query) use ($id) {
                                    $query->where('away_team_id', '=' , $id)
                                    ->orWhere('home_team_id', '=', $id);
                                })
                               ->where('team_level', 3)
                               ->orderBy('date')
                               ->get();

        return view('sports.baseball.teamschedule', compact('id', 'selectedTeam', 'team', 'teams', 'varsity', 'juniorvarsity', 'freshman', 'wins', 'losses'));

    }


    public function scoreCreate($id)
    {

        $user_id = Auth::user()->id;

        BaseballScores::create([
            'game_id'          =>  $id,
            'away_team_score'   =>  0,
            'home_team_score'   =>  0,
            'created_by'        =>  $user_id
        ]);

        Session::flash('success', 'Quarter Has Been Added');

        return back();

    }



    public function storeGameHalf(Request $request, $id)
    {

        $user_id = Auth::user()->id;

        $this->validate(request(), [
            'away_team_score'       =>  'required|numeric',
            'home_team_score'       =>  'required|numeric',
        ]);

        $half = BaseballScores::findOrFail($id);
        $half->away_team_score  = request('away_team_score');
        $half->home_team_score  = request('home_team_score');
        $half->modified_by = $user_id;

        $half->update();

        Session::flash('success', 'Score Has Been Updated');

        return back();

    }



    public function scoreDelete($id)
    {
        BaseballScores::find($id)->delete();

        Session::flash('success', 'Quarter Has Been Deleted');

        return back();
    }



    public function apiGameId($id)
    {

        $game = Baseball::where('id', $id)->with('away_team')
                                     ->with('home_team')
                                     ->with('away_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
                                     ->with('the_year')
                                     ->first();

        return $game;

    }



    public function apiTeamSchedule($year, $team, $teamlevel)
    {

        $theteam = Team::where('school_name', '=', $team)->pluck('id');
        $theYear = Year::where('year', $year)->pluck('id')->first();

        $game = Baseball::with('away_team')
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



    public function todaysEvents($team)
    {

        $theteam = Team::where('school_name', '=', $team)->pluck('id');

        $game = Baseball::with('away_team')
                                     ->with('home_team')
                                     ->with('away_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
                                     ->with('total_score')
                                     ->with('the_year')
                                     ->where(function ($query) use ($theteam) {
                                        $query->where('away_team_id', '=' , $theteam)
                                        ->orWhere('home_team_id', '=', $theteam);
                                     })
                                     ->where('team_level', 1)
                                     ->where('date', Carbon::today('America/New_York'))
                                     ->orderBy('date','asc')
                                     ->get();

        return $game;

    }



    public function singleMatch($id)
    {

        $game = Baseball::with('away_team')
                                     ->with('home_team')
                                     ->with('away_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
                                     ->with('the_year')
                                     ->first();

        return $game;

    }



    public function yearSummary($year, $team)
    {

        $selectedyear = Year::where('year', $year)->pluck('year');

        $selectedyearid = Year::where('year', $year)->pluck('id');

        $selectedteam = Team::where('school_name', $team)->get();

        $selectedteamid =   Team::where('school_name', $team)->pluck('id');

        $the_standings = \DB::select('SELECT school_name as Team, Sum(W) AS Wins, Sum(L) AS Losses, SUM(F) as F, SUM(A) AS A, SUM(DW) AS DistrictWins, SUM(DL) AS DistrictLoses
                        FROM(

                            SELECT
                                home_team_id Team,
                                IF(home_team_final_score > away_team_final_score,1,0) W,
                                IF(home_team_final_score < away_team_final_score,1,0) L,
                                home_team_final_score F,
                                away_team_final_score A,
                                IF(district_game = 1 && home_team_final_score > away_team_final_score,1,0) DW,
                                IF(district_game = 1 && home_team_final_score < away_team_final_score,1,0) DL
                                
                            FROM baseball
                            WHERE team_level = 1 AND year_id = ?
                            
                            UNION ALL
                              SELECT
                                away_team_id,
                                IF(home_team_final_score < away_team_final_score,1,0),
                                IF(home_team_final_score > away_team_final_score,1,0),
                                away_team_final_score,
                                home_team_final_score,
                                IF(district_game = 1 && home_team_final_score < away_team_final_score,1,0),
                                IF(district_game = 1 && home_team_final_score > away_team_final_score,1,0)
                               
                            FROM baseball
                            WHERE team_level = 1 AND year_id = ?
                              
                        )
                        as tot
                        JOIN teams t ON tot.Team = t.id
                        WHERE school_name = ?
                        GROUP BY Team, school_name', array($selectedyearid[0], $selectedyearid[0], $selectedteam[0]['school_name']));

        return $the_standings;

    }
}
