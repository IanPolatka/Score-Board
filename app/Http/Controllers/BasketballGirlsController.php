<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\BasketballGirls;
use App\BasketballGirlsScores;
use App\Team;
use App\TeamMeta;
use App\Time;
use App\Tournament;
use App\Year;

use Session;

use Auth;

use Illuminate\Http\Request;

class BasketballGirlsController extends Controller
{
    public function __construct() 
    {
      $this->middleware('auth', ['only' => [ 'create', 'edit', 'editScore', 'delete' ]]);
    }
	
    public function index()
    {

        $teams = Team::orderBy('school_name')->get();

        $todaysGames = BasketballGirls::where('date', Carbon::today('America/New_York'))->get();

        $yesterdaysGames = BasketballGirls::where('date', Carbon::yesterday('America/New_York'))->get();

        $tomorrowsGames = BasketballGirls::where('date', Carbon::tomorrow('America/New_York'))->get();

        $games = BasketballGirls::all();

        return view('sports.basketball-girls.index', compact('games', 'teams', 'todaysGames', 'tomorrowsGames', 'yesterdaysGames'));
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

        return view('sports.basketball-girls.create', compact('teams','times','years'));
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

        BasketballGirls::create([
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

        Session::flash('success', 'Girls Basketball Game Has Been Created');

        return redirect('/girls-basketball');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = BasketballGirls::where('id', $id)->with('away_team')
                                     ->with('home_team')
                                     ->with('home_team_district')
                                     ->with('away_team')
                                     ->with('away_team_district')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
                                     ->first();

        return view('sports.basketball-girls.show', compact('game'));
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

        $match = BasketballGirls::where('id',$id)->with('away_team')
                                     ->with('home_team')
                                     ->with('away_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
                                     ->first();

        return view('sports.basketball-girls.edit', compact('match', 'teams','times','years'));
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

        $game = BasketballGirls::findOrFail($id);
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

        Session::flash('success', 'Girls Basketball Game Has Been Updated');

        return redirect('/girls-basketball/'.$id);
    }

    public function editScore($id)
    {

        $teams = Team::orderBy('school_name')->get();

        $times = Time::all();

        $years = Year::all();

        //  Get Away Team Wins And Losses
        $away_team_id = BasketballGirls::where('id', $id)->pluck('away_team_id');

        $away_team_losses_loop = BasketballGirls::where('losing_team', '=', $away_team_id)
                                ->where('team_level', '=', 1)
                                ->get();
        $away_losses = $away_team_losses_loop->count();

        $away_team_wins_loop = BasketballGirls::where('winning_team', '=', $away_team_id)
                                ->where('team_level', '=', 1)
                                ->get();
        $away_wins = $away_team_wins_loop->count();

        $away_team_ties = BasketballGirls::where(function ($query) use ($away_team_id) {
                            $query->where('away_team_id', '=' , $away_team_id)
                            ->orWhere('home_team_id', '=', $away_team_id);
                        })
                        ->where('game_status', '=', 1)
                        ->whereRaw('away_team_final_score = home_team_final_score')
                        ->count();

        //  Get Home Team Wins And Losses
        $home_team_id = BasketballGirls::where('id', $id)->pluck('home_team_id');

        $home_team_losses_loop = BasketballGirls::where('losing_team', '=', $home_team_id)
                                ->where('team_level', '=', 1)
                                ->get();
        $home_losses = $home_team_losses_loop->count();

        $home_team_wins_loop = BasketballGirls::where('winning_team', '=', $home_team_id)
                                ->where('team_level', '=', 1)
                                ->get();
        $home_wins = $home_team_wins_loop->count();

        $home_team_ties = BasketballGirls::where(function ($query) use ($home_team_id) {
                            $query->where('away_team_id', '=' , $home_team_id)
                            ->orWhere('home_team_id', '=', $home_team_id);
                        })
                        ->where('game_status', '=', 1)
                        ->whereRaw('away_team_final_score = home_team_final_score')
                        ->count();

        //  Get Scores from each half
        $scores = BasketballGirlsScores::where('game_id', $id)->get();

        $match = BasketballGirls::where('id', $id)->with('away_team')
                                     ->with('home_team')
                                     ->with('away_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
                                     ->first();

        return view('sports.basketball-girls.edit-score', compact('away_team_ties', 'away_losses', 'away_wins', 'home_losses', 'home_team_ties', 'home_wins', 'game', 'match', 'scores', 'teams','times','years'));
    }

    public function gameUpdate(Request $request, $id)
    {
        $user_id = Auth::user()->id;

        $match = BasketballGirls::where('id', $id)->get();

        $game = BasketballGirls::findOrFail($id);
        $game->game_minute = request('game_minute');
        $game->game_second = request('game_second');
        $game->game_status = request('game_status');
        $game->away_team_final_score = request('away_team_final_score');
        $game->home_team_final_score = request('home_team_final_score');
        $game->winning_team = request('winning_team');
        $game->losing_team = request('losing_team');
        $game->modified_by   = $user_id;

        $game->update();

        Session::flash('success', 'Girls Basketball Game Has Been Updated');

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
        $game = BasketballGirls::find($id);
        $game->delete();
        return redirect('/girls-basketball');
    }



    public function teamSchedule($team)
    {

        $id = Team::where('school_name', $team)->pluck('id');

        $selectedTeam = Team::where('school_name', $team)->first();

        $year = Year::pluck('id')->first();

        $wins = BasketballGirls::where('winning_team', $id)->where('team_level', 1)->count();

        $losses = BasketballGirls::where('losing_team', $id)->where('team_level', 1)->count();

        $matchTies = BasketballGirls::where('game_status', '=', 1)->whereRaw('away_team_final_score = home_team_final_score')->count();

        // $districWins = BasketballGirls::with('away_team')->('home_team'

        $teams = Team::orderBy('school_name')->get();

        $varsity = BasketballGirls::with('away_team')
                               ->with('home_team')
                               ->with('away_team_district')
                               ->with('home_team_district')
                               // ->with(array('home_team_district'=>function($query){
                               //  $query->where('team_id', '=', 1)->where('year_id', 1)->first();
                               // }))
                               // ->with(array('away_team_district'=>function($query){
                               //  $query->where('team_id', '=', 75)->where('year_id', 1)->first();
                               // }))
                               // ->with(['away_team_district' => function ($query) use ($id, $year) {
                               //      $query->where('team_id', '=', $id)->where('year_id', $year)->first();
                               //  }])
                               // ->with(['home_team_district' => function ($query)  use ($id, $year) {
                               //      $query->where('team_id', '=', $id)->where('year_id', $year)->first();
                               //  }])
                               ->where(function ($query) use ($id) {
                                    $query->where('away_team_id', '=' , $id)
                                    ->orWhere('home_team_id', '=', $id);
                               })
                               ->where('team_level', 1)
                               // ->where('team_level', 1)
                               ->orderBy('date')
                               ->get();

        // foreach ($varsity as $var) {
        //     echo $var->home_team_district->soccer_district; // this is lazy loaded
        // }

        $juniorvarsity = BasketballGirls::with('away_team')
                               ->with('home_team')
                               ->where(function ($query) use ($id) {
                                    $query->where('away_team_id', '=' , $id)
                                    ->orWhere('home_team_id', '=', $id);
                                })
                               ->where('team_level', 2)
                               ->orderBy('date')
                               ->get();

        $freshman = BasketballGirls::with('away_team')
                               ->with('home_team')
                               ->where(function ($query) use ($id) {
                                    $query->where('away_team_id', '=' , $id)
                                    ->orWhere('home_team_id', '=', $id);
                                })
                               ->where('team_level', 3)
                               ->orderBy('date')
                               ->get();

        return view('sports.basketball-girls.teamschedule', compact('id', 'selectedTeam', 'team', 'teams', 'varsity', 'juniorvarsity', 'freshman', 'wins', 'losses', 'matchTies'));

    }


    public function scoreCreate($id)
    {

        $user_id = Auth::user()->id;

        BasketballGirlsScores::create([
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

        $half = BasketballGirlsScores::findOrFail($id);
        $half->away_team_score  = request('away_team_score');
        $half->home_team_score  = request('home_team_score');
        $half->modified_by = $user_id;

        $half->update();

        Session::flash('success', 'Score Has Been Updated');

        return back();

    }

    public function scoreDelete($id)
    {
        BasketballGirlsScores::find($id)->delete();

        Session::flash('success', 'Quarter Has Been Deleted');

        return back();
    }



    public function apiGameId($id)
    {

        $game = BasketballGirls::where('id', $id)->with('away_team')
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

        $game = BasketballGirls::with('away_team')
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

        $game = BasketballGirls::with('away_team')
                                     ->with('home_team')
                                     ->with('away_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
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

        $game = BasketballGirls::with('away_team')
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

        // return $year;
        $selectedyear = Year::where('year', $year)->pluck('year');
        $selectedyearid = Year::where('year', $year)->pluck('id');

        $selectedteam = Team::where('school_name', $team)->get();

        $selectedteamid =   Team::where('school_name', $team)->pluck('id');
        // $selectedDistrict = Team::where('school_name', $team)->pluck('district_soccer');

        // return $selectedteam;

        $the_standings = \DB::select('SELECT school_name as Team, Sum(W) AS Wins, Sum(L) AS Losses, SUM(F) as F, SUM(A) AS A
                        FROM(

                            SELECT
                                home_team_id Team,
                                IF(home_team_final_score > away_team_final_score,1,0) W,
                                IF(home_team_final_score < away_team_final_score,1,0) L,
                                home_team_final_score F,
                                away_team_final_score A
                                
                            FROM basketball_girls
                            WHERE team_level = 1 AND year_id = ?
                            
                            UNION ALL
                              SELECT
                                away_team_id,
                                IF(home_team_final_score < away_team_final_score,1,0),
                                IF(home_team_final_score > away_team_final_score,1,0),
                                away_team_final_score,
                                home_team_final_score
                               
                            FROM basketball_girls
                            WHERE team_level = 1 AND year_id = ?
                              
                        )
                        as tot
                        JOIN teams t ON tot.Team = t.id
                        WHERE school_name = ?
                        GROUP BY Team, school_name', array($selectedyearid[0], $selectedyearid[0], $selectedteam[0]['school_name']));

        return $the_standings;

    }
}
