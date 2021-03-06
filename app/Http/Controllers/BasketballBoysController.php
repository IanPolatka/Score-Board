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
use App\CurrentYear;

use App\BasketballBoys;

use Illuminate\Http\Request;

use App\BasketballBoysScores;

class BasketballBoysController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'edit', 'editScore', 'delete']]);
    }

    public function index()
    {
        $teams = Team::orderBy('school_name')->get();

        $todaysGames = BasketballBoys::where('date', Carbon::today('America/New_York'))->orderBy('team_level')->with('scores')->get();

        $yesterdaysGames = BasketballBoys::where('date', Carbon::yesterday('America/New_York'))->get();

        $tomorrowsGames = BasketballBoys::where('date', Carbon::tomorrow('America/New_York'))->get();

        $games = BasketballBoys::all();

        $currentYearId = CurrentYear::pluck('year_id');

        $theCurrentYear = Year::where('id', $currentYearId)->get();

        return view('sports.basketball-boys.index', compact('games', 'teams', 'theCurrentYear', 'todaysGames', 'tomorrowsGames', 'yesterdaysGames'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currentYearId = CurrentYear::pluck('year_id');

        $teams = Team::orderBy('school_name')->get();

        $times = Time::all();

        $years = Year::orderBy('year')->get();

        return view('sports.basketball-boys.create', compact('teams', 'currentYearId', 'times', 'years'));
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
            'time_id.required'          =>  'Please select a game time.',
        ]);

        BasketballBoys::create([
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

        Session::flash('success', 'BasketballBoys Game Has Been Created');

        return redirect('/boys-basketball');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = BasketballBoys::where('id', $id)->with('away_team')
                                     ->with('home_team')
                                     ->with('home_team_district')
                                     ->with('away_team')
                                     ->with('away_team_district')
                                     ->with('game_time')
                                     ->with('the_year')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
                                     ->first();

        return view('sports.basketball-boys.show', compact('game'));
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

        $years = Year::orderBy('year')->get();

        $match = BasketballBoys::where('id', $id)->with('away_team')
                                     ->with('home_team')
                                     ->with('away_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
                                     ->first();

        return view('sports.basketball-boys.edit', compact('match', 'teams', 'times', 'years'));
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
            'time_id.required'          =>  'Please select a game time.',
        ]);

        $game = BasketballBoys::findOrFail($id);
        $game->year_id = request('year_id');
        $game->team_level = request('team_level');
        $game->date = request('date');
        $game->scrimmage = request('scrimmage');
        $game->tournament_name = request('tournament_name');
        $game->away_team_id = request('away_team_id');
        $game->home_team_id = request('home_team_id');
        $game->time_id = request('time_id');
        $game->district_game = request('district_game');
        $game->location = request('location');
        $game->modified_by = $user_id;

        $game->update();

        Session::flash('success', 'BasketballBoys Game Has Been Updated');

        return redirect('/boys-basketball/'.$id);
    }

    public function editScore($id)
    {
        $teams = Team::orderBy('school_name')->get();

        $times = Time::all();

        $years = Year::all();

        //  Get Away Team Wins And Losses
        $away_team_id = BasketballBoys::where('id', $id)->pluck('away_team_id');

        $year_id = BasketballBoys::where('id', $id)->pluck('year_id');

        $away_team_losses_loop = BasketballBoys::where('losing_team', '=', $away_team_id)
                                ->where('team_level', '=', 1)
                                ->where('year_id', $year_id)
                                ->get();
        $away_losses = $away_team_losses_loop->count();

        $away_team_wins_loop = BasketballBoys::where('winning_team', '=', $away_team_id)
                                ->where('team_level', '=', 1)
                                ->where('year_id', $year_id)
                                ->get();
        $away_wins = $away_team_wins_loop->count();

        //  Get Home Team Wins And Losses
        $home_team_id = BasketballBoys::where('id', $id)->pluck('home_team_id');

        $home_team_losses_loop = BasketballBoys::where('losing_team', '=', $home_team_id)
                                ->where('team_level', '=', 1)
                                ->where('year_id', $year_id)
                                ->get();
        $home_losses = $home_team_losses_loop->count();

        $home_team_wins_loop = BasketballBoys::where('winning_team', '=', $home_team_id)
                                ->where('team_level', '=', 1)
                                ->where('year_id', $year_id)
                                ->get();
        $home_wins = $home_team_wins_loop->count();

        //  Get Scores from each half
        $scores = BasketballBoysScores::where('game_id', $id)->get();

        $match = BasketballBoys::where('id', $id)->with('away_team')
                                     ->with('home_team')
                                     ->with('away_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
                                     ->first();

        return view('sports.basketball-boys.edit-score', compact('away_losses', 'away_wins', 'home_losses', 'home_wins', 'match', 'scores', 'teams', 'times', 'years'));
    }

    public function gameUpdate(Request $request, $id)
    {
        $user_id = Auth::user()->id;

        $match = BasketballBoys::where('id', $id)->get();

        $game = BasketballBoys::findOrFail($id);
        $game->game_minute = request('game_minute');
        $game->game_second = request('game_second');
        $game->game_status = request('game_status');
        $game->away_team_final_score = request('away_team_final_score');
        $game->home_team_final_score = request('home_team_final_score');
        $game->winning_team = request('winning_team');
        $game->losing_team = request('losing_team');
        $game->modified_by = $user_id;

        $game->update();

        Session::flash('success', 'Boys Basketball Game Has Been Updated');

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
        $game = BasketballBoys::find($id);
        $game->delete();

        return redirect('/boys-basketball');
    }

    public function teamSchedule($year, $team)
    {

        // return $year;
        $selectedyear = Year::where('year', $year)->pluck('year');

        $selectedyearid = Year::where('year', $year)->pluck('id');

        $id = Team::where('school_name', $team)->pluck('id');

        $selectedTeam = Team::where('school_name', $team)->first();

        $year = Year::pluck('id')->first();

        $years = Year::orderBy('year')->get();

        $wins = BasketballBoys::where('winning_team', $id)->where('team_level', 1)->where('year_id', $selectedyearid)->count();

        $losses = BasketballBoys::where('losing_team', $id)->where('team_level', 1)->where('year_id', $selectedyearid)->count();

        $districtWins = BasketballBoys::where('winning_team', $id)->where('team_level', 1)->where('year_id', $selectedyearid)->where('district_game', 1)->count();

        $districtLosses = BasketballBoys::where('losing_team', $id)->where('team_level', 1)->where('year_id', $selectedyearid)->where('district_game', 1)->count();

        $teams = Team::orderBy('school_name')->get();

        $varsity = BasketballBoys::with('away_team')
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

        $juniorvarsity = BasketballBoys::with('away_team')
                               ->with('home_team')
                               ->where(function ($query) use ($id) {
                                   $query->where('away_team_id', '=', $id)
                                    ->orWhere('home_team_id', '=', $id);
                               })
                               ->where('team_level', 2)
                               ->where('year_id', $selectedyearid)
                               ->orderBy('date')
                               ->get();

        $freshman = BasketballBoys::with('away_team')
                               ->with('home_team')
                               ->where(function ($query) use ($id) {
                                   $query->where('away_team_id', '=', $id)
                                    ->orWhere('home_team_id', '=', $id);
                               })
                               ->where('team_level', 3)
                               ->where('year_id', $selectedyearid)
                               ->orderBy('date')
                               ->get();

        return view('sports.basketball-boys.teamschedule', compact('id', 'districtWins', 'districtLosses', 'selectedTeam', 'selectedyear', 'selectedyearid', 'team', 'teams', 'varsity', 'juniorvarsity', 'freshman', 'wins', 'losses', 'years'));
    }

    public function scoreCreate($id)
    {
        $user_id = Auth::user()->id;

        BasketballBoysScores::create([
            'game_id'          =>  $id,
            'away_team_score'   =>  0,
            'home_team_score'   =>  0,
            'created_by'        =>  $user_id,
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

        $half = BasketballBoysScores::findOrFail($id);
        $half->away_team_score = request('away_team_score');
        $half->home_team_score = request('home_team_score');
        $half->modified_by = $user_id;

        $half->update();

        Session::flash('success', 'Score Has Been Updated');

        return back();
    }

    public function scoreDelete($id)
    {
        BasketballBoysScores::find($id)->delete();

        Session::flash('success', 'Quarter Has Been Deleted');

        return back();
    }

    public function apiGameId($id)
    {
        $game = BasketballBoys::where('id', $id)->with('away_team')
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

        $game = BasketballBoys::with('away_team')
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

        return $game;
    }

    public function todaysEvents($team)
    {
        $theteam = Team::where('school_name', '=', $team)->pluck('id');

        $game = BasketballBoys::with('away_team')
                                     ->with('home_team')
                                     ->with('away_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
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

    public function singleMatch($id)
    {
        $game = BasketballBoys::with('away_team')
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

        $selectedteamid = Team::where('school_name', $team)->pluck('id');
        // $selectedDistrict = Team::where('school_name', $team)->pluck('district_soccer');

        // return $selectedteam;

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
                                
                            FROM basketball_boys
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
                               
                            FROM basketball_boys
                            WHERE team_level = 1 AND year_id = ?
                              
                        )
                        as tot
                        JOIN teams t ON tot.Team = t.id
                        WHERE school_name = ?
                        GROUP BY Team, school_name', [$selectedyearid[0], $selectedyearid[0], $selectedteam[0]['school_name']]);

        return $the_standings;
    }
}
