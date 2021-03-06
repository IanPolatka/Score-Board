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

use App\SoccerGirls;

use App\SoccerGirlsScore;

use App\CurrentYear;

use Illuminate\Http\Request;

class SoccerGirlsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'edit', 'editScore', 'delete']]);
    }

    public function index()
    {
        $teams = Team::orderBy('school_name')->get();

        $todaysGames = SoccerGirls::where('date', Carbon::today('America/New_York'))->get();

        $yesterdaysGames = SoccerGirls::where('date', Carbon::yesterday('America/New_York'))->get();

        $tomorrowsGames = SoccerGirls::where('date', Carbon::tomorrow('America/New_York'))->get();

        $currentYearId = CurrentYear::pluck('year_id');

        $theCurrentYear = Year::where('id', $currentYearId)->get();

        $games = SoccerGirls::all();

        return view('sports.soccer-girls.index', compact('games', 'teams', 'theCurrentYear', 'todaysGames', 'tomorrowsGames', 'yesterdaysGames'));
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

        $years = Year::orderBy('year', 'desc')->get();

        return view('sports.soccer-girls.create', compact('teams', 'times', 'years'));
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

        SoccerGirls::create([
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

        Session::flash('success', 'Girls Soccer Match Has Been Created');

        return redirect('/girls-soccer');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = SoccerGirls::where('id', $id)->with('away_team')
                                     ->with('home_team')
                                     ->with('home_team_district')
                                     ->with('away_team')
                                     ->with('away_team_district')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
                                     ->first();

        return view('sports.soccer-girls.show', compact('game'));
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

        $match = SoccerGirls::where('id', $id)->with('away_team')
                                     ->with('home_team')
                                     ->with('away_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
                                     ->first();

        return view('sports.soccer-girls.edit', compact('match', 'teams', 'times', 'years'));
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

        $game = SoccerGirls::findOrFail($id);
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

        Session::flash('success', 'Girls Soccer Match Has Been Updated');

        return redirect('/girls-soccer/'.$id);
    }

    public function editScore($id)
    {
        $teams = Team::orderBy('school_name')->get();

        $times = Time::all();

        $years = Year::all();

        $selectedYear = SoccerGirls::where('id', $id)->pluck('year_id');

        //  Get Away Team Wins And Losses
        $away_team_id = SoccerGirls::where('id', $id)->pluck('away_team_id');

        $away_team_losses_loop = SoccerGirls::where('losing_team', '=', $away_team_id)
                                ->where('team_level', '=', 1)
                                ->where('year_id', $selectedYear)
                                ->get();
        $away_losses = $away_team_losses_loop->count();

        $away_team_wins_loop = SoccerGirls::where('winning_team', '=', $away_team_id)
                                ->where('team_level', '=', 1)
                                ->where('year_id', $selectedYear)
                                ->get();
        $away_wins = $away_team_wins_loop->count();

        $away_team_ties = SoccerGirls::where(function ($query) use ($away_team_id) {
            $query->where('away_team_id', '=', $away_team_id)
                            ->orWhere('home_team_id', '=', $away_team_id);
        })
                        ->where('game_status', '=', 1)
                        ->where('year_id', $selectedYear)
                        ->whereRaw('away_team_final_score = home_team_final_score')
                        ->count();

        //  Get Home Team Wins And Losses
        $home_team_id = SoccerGirls::where('id', $id)->pluck('home_team_id');

        $home_team_losses_loop = SoccerGirls::where('losing_team', '=', $home_team_id)
                                ->where('team_level', '=', 1)
                                ->where('year_id', $selectedYear)
                                ->get();
        $home_losses = $home_team_losses_loop->count();

        $home_team_wins_loop = SoccerGirls::where('winning_team', '=', $home_team_id)
                                ->where('team_level', '=', 1)
                                ->where('year_id', $selectedYear)
                                ->get();
        $home_wins = $home_team_wins_loop->count();

        $home_team_ties = SoccerGirls::where(function ($query) use ($home_team_id) {
            $query->where('away_team_id', '=', $home_team_id)
                            ->orWhere('home_team_id', '=', $home_team_id);
        })
                        ->where('game_status', '=', 1)
                        ->where('year_id', $selectedYear)
                        ->whereRaw('away_team_final_score = home_team_final_score')
                        ->count();

        //  Get Scores from each half
        $scores = SoccerGirlsScore::where('match_id', $id)->get();

        $match = SoccerGirls::where('id', $id)->with('away_team')
                                     ->with('home_team')
                                     ->with('away_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('scores')
                                     ->first();

        return view('sports.soccer-girls.edit-score', compact('away_team_ties', 'away_losses', 'away_wins', 'home_losses', 'home_team_ties', 'home_wins', 'match', 'scores', 'teams', 'times', 'years'));
    }

    public function gameUpdate(Request $request, $id)
    {
        $user_id = Auth::user()->id;

        $match = SoccerGirls::where('id', $id)->get();

        $game = SoccerGirls::findOrFail($id);
        $game->game_minute = request('game_minute');
        $game->game_status = request('game_status');
        $game->away_team_final_score = request('away_team_final_score');
        $game->home_team_final_score = request('home_team_final_score');
        $game->winning_team = request('winning_team');
        $game->losing_team = request('losing_team');
        $game->end_in_pks = request('end_in_pks');
        $game->modified_by = $user_id;

        $game->update();

        Session::flash('success', 'Girls Soccer Match Has Been Updated');

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
        $game = SoccerGirls::find($id);
        $game->delete();

        return redirect('/girls-soccer');
    }

    public function teamSchedule($year, $team)
    {
        $id = Team::where('school_name', $team)->pluck('id');

        $selectedyear = Year::where('year', $year)->pluck('year');

        $selectedyearid = Year::where('year', $year)->pluck('id');

        $selectedTeam = Team::where('school_name', $team)->first();

        $year = Year::pluck('id')->first();

        $years = Year::orderBy('year')->get();

        $wins = SoccerGirls::where('winning_team', $id)->where('team_level', 1)->where('year_id', $selectedyearid)->count();

        $losses = SoccerGirls::where('losing_team', $id)->where('team_level', 1)->where('year_id', $selectedyearid)->count();

        $matchTies = SoccerGirls::where('game_status', '=', 1)->where('team_level', 1)->where('year_id', $selectedyearid)->whereRaw('away_team_final_score = home_team_final_score')->count();

        $districtWins = SoccerGirls::where('winning_team', $id)->where('team_level', 1)->where('year_id', $selectedyearid)->where('district_game', 1)->count();

        $districtLosses = SoccerGirls::where('losing_team', $id)->where('team_level', 1)->where('year_id', $selectedyearid)->where('district_game', 1)->count();

        $teams = Team::orderBy('school_name')->get();

        $varsity = SoccerGirls::with('away_team')
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

        $juniorvarsity = SoccerGirls::with('away_team')
                               ->with('home_team')
                               ->where(function ($query) use ($id) {
                                   $query->where('away_team_id', '=', $id)
                                    ->orWhere('home_team_id', '=', $id);
                               })
                               ->where('team_level', 2)
                               ->where('year_id', $selectedyearid)
                               ->orderBy('date')
                               ->get();

        $freshman = SoccerGirls::with('away_team')
                               ->with('home_team')
                               ->where(function ($query) use ($id) {
                                   $query->where('away_team_id', '=', $id)
                                    ->orWhere('home_team_id', '=', $id);
                               })
                               ->where('team_level', 3)
                               ->where('year_id', $selectedyearid)
                               ->orderBy('date')
                               ->get();

        return view('sports.soccer-girls.teamschedule', compact('id', 'districtWins', 'districtLosses', 'selectedTeam', 'team', 'teams', 'varsity', 'juniorvarsity', 'freshman', 'wins', 'losses', 'matchTies', 'years', 'selectedyear', 'selectedyearid'));
    }

    public function scoreCreate($id)
    {
        $user_id = Auth::user()->id;

        SoccerGirlsScore::create([
            'match_id'          =>  $id,
            'away_team_score'   =>  0,
            'home_team_score'   =>  0,
            'created_by'        =>  $user_id,
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

        $half = SoccerGirlsScore::findOrFail($id);
        $half->away_team_score = request('away_team_score');
        $half->home_team_score = request('home_team_score');
        $half->modified_by = $user_id;

        $half->update();

        Session::flash('success', 'Score Has Been Updated');

        return back();
    }

    public function scoreDelete($id)
    {
        SoccerGirlsScore::find($id)->delete();

        Session::flash('success', 'Half Has Been Deleted');

        return back();
    }

    public function apiGameId($id)
    {
        $game = SoccerGirls::where('id', $id)->with('away_team')
                                     ->with('home_team')
                                     ->with('away_team')
                                     ->with('game_time')
                                     ->with('user_created')
                                     ->with('user_modified')
                                     ->with('the_year')
                                     ->with('scores')
                                     ->first();

        return $game;
    }

    public function apiTeamSchedule($year, $team, $teamlevel)
    {
        $theteam = Team::where('school_name', '=', $team)->pluck('id');
        $theYear = Year::where('year', $year)->pluck('id')->first();

        $game = SoccerGirls::with('away_team')
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

        $game = SoccerGirls::with('away_team')
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
        $game = SoccerGirls::with('away_team')
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

        $the_standings = \DB::select('SELECT school_name as Team, Sum(W) AS Wins, Sum(T) AS Ties, Sum(L) AS Losses, SUM(F) as F, SUM(A) AS A, SUM(DW) AS DistrictWins, SUM(DL) AS DistrictLoses
                        FROM(

                            SELECT
                                home_team_id Team,
                                IF(home_team_final_score > away_team_final_score,1,0) W,
                                IF(home_team_final_score < away_team_final_score,1,0) L,
                                IF(home_team_final_score = away_team_final_score,1,0) T,
                                home_team_final_score F,
                                away_team_final_score A,
                                IF(district_game = 1 && home_team_final_score > away_team_final_score,1,0) DW,
                                IF(district_game = 1 && home_team_final_score < away_team_final_score,1,0) DL
                                
                            FROM soccer_girls
                            WHERE team_level = 1 AND year_id = ?
                            
                            UNION ALL
                              SELECT
                                away_team_id,
                                IF(home_team_final_score < away_team_final_score,1,0),
                                IF(home_team_final_score > away_team_final_score,1,0),
                                IF(home_team_final_score = away_team_final_score,1,0),
                                away_team_final_score,
                                home_team_final_score,
                                IF(district_game = 1 && home_team_final_score < away_team_final_score,1,0),
                                IF(district_game = 1 && home_team_final_score > away_team_final_score,1,0)
                               
                            FROM soccer_girls
                            WHERE team_level = 1 AND year_id = ?
                              
                        )
                        as tot
                        JOIN teams t ON tot.Team = t.id
                        WHERE school_name = ?
                        GROUP BY Team, school_name', [$selectedyearid[0], $selectedyearid[0], $selectedteam[0]['school_name']]);

        return $the_standings;
    }
}
