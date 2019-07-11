<?php

namespace App\Http\Controllers;

use App\Team;

use Response;
use App\Track;
use App\Baseball;
use App\Football;
use App\Softball;
use App\Swimming;
use App\Wrestling;
use Carbon\Carbon;
use App\SoccerBoys;
use App\TennisBoys;
use App\BowlingBoys;
use App\SoccerGirls;
use App\TennisGirls;
use App\BowlingGirls;
use App\BasketballBoys;

use App\BasketballGirls;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $basketball_boys = BasketballBoys::where('date', Carbon::today('America/New_York'))->orderBy('team_level')->get();

        // $basketball_girls = BasketballGirls::where('date', Carbon::today('America/New_York'))->orderBy('team_level')->get();

        // $bowling_boys = BowlingBoys::where('date', Carbon::today('America/New_York'))->orderBy('team_level')->get();

        // $bowling_girls = BowlingGirls::where('date', Carbon::today('America/New_York'))->orderBy('team_level')->get();

        // // $bowling_girls = BowlingBoys::where('id', 5)->get();

        // $soccer_boys = SoccerBoys::where('date', Carbon::today('America/New_York'))->orderBy('team_level')->get();

        return view('home'/*, compact('basketball_boys', 'basketball_girls', 'bowling_boys', 'bowling_girls', 'soccer_boys') */);
    }

    public function events()
    {
        $basketball_boys = BasketballBoys::where('team_level', 1)
                                     ->where('date', Carbon::today('America/New_York'))
                                     ->orderBy('time_id', 'desc')
                                     ->get();

        $basketball_girls = BasketballGirls::where('team_level', 1)
                                     ->where('date', Carbon::today('America/New_York'))
                                     ->orderBy('time_id', 'desc')
                                     ->get();

        $baseball = Baseball::where('team_level', 1)
                                     ->where('date', Carbon::today('America/New_York'))
                                     ->orderBy('time_id', 'desc')
                                     ->get();

        $bowling_boys = BowlingBoys::where('team_level', 1)
                                     ->where('date', Carbon::today('America/New_York'))
                                     ->orderBy('time_id', 'desc')
                                     ->get();

        $bowling_girls = BowlingGirls::where('team_level', 1)
                                     ->where('date', Carbon::today('America/New_York'))
                                     ->orderBy('time_id', 'desc')
                                     ->get();

        $football = Football::where('team_level', 1)
                                     ->where('date', Carbon::today('America/New_York'))
                                     ->orderBy('time_id', 'desc')
                                     ->get();

        $soccer_boys = SoccerBoys::where('team_level', 1)
                                     ->where('date', Carbon::today('America/New_York'))
                                     ->orderBy('time_id', 'desc')
                                     ->get();

        $soccer_girls = SoccerGirls::where('team_level', 1)
                                     ->where('date', Carbon::today('America/New_York'))
                                     ->orderBy('time_id', 'desc')
                                     ->get();

        $softball = Softball::where('team_level', 1)
                                     ->where('date', Carbon::today('America/New_York'))
                                     ->orderBy('time_id', 'desc')
                                     ->get();

        $swimming = Swimming::with('the_team')
                                ->with('the_year')
                                ->with('host_team')
                                ->with('game_time')
                                ->where('team_level', 1)
                                ->where('date', Carbon::today('America/New_York'))
                                ->get();

        $tennis_boys = TennisBoys::where('team_level', 1)
                                     ->where('date', Carbon::today('America/New_York'))
                                     ->orderBy('time_id', 'desc')
                                     ->get();

        $tennis_girls = TennisGirls::where('team_level', 1)
                                     ->where('date', Carbon::today('America/New_York'))
                                     ->orderBy('time_id', 'desc')
                                     ->get();

        $track = Track::where('team_level', 1)
                                     ->where('date', Carbon::today('America/New_York'))
                                     ->orderBy('time_id', 'desc')
                                     ->get();

        $wrestling = Wrestling::where('team_level', 1)
                                     ->where('date', Carbon::today('America/New_York'))
                                     ->orderBy('time_id', 'desc')
                                     ->get();

        $array = array_merge($baseball->toArray(),
                             $basketball_girls->toArray(),
                             $basketball_boys->toArray(),
                             $bowling_boys->toArray(),
                             $bowling_girls->toArray(),
                             $football->toArray(),
                             $soccer_boys->toArray(),
                             $soccer_girls->toArray(),
                             $softball->toArray(),
                             $swimming->toArray(),
                             $tennis_boys->toArray(),
                             $tennis_girls->toArray(),
                             $track->toArray(),
                             $wrestling->toArray()
                        );

        //$result = $basketball_boys->toBase()->merge($basketball_girls->toBase(), $baseball->toBase());

        return Response::json($array);
    }

    public function eventsNow($team)
    {
        $theteam = Team::where('school_name', '=', $team)->pluck('id');

        $basketball_boys = BasketballBoys::with('away_team')
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

        $basketball_girls = BasketballGirls::with('away_team')
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

        $baseball = Baseball::with('away_team')
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

        $bowling_boys = BowlingBoys::with('away_team')
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

        $bowling_girls = BowlingGirls::with('away_team')
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

        $football = Football::with('away_team')
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

        $soccer_boys = SoccerBoys::with('away_team')
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

        $soccer_girls = SoccerGirls::with('away_team')
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

        $softball = Softball::with('away_team')
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

        $swimming = Swimming::with('the_team')
                                ->with('the_year')
                                ->with('host_team')
                                ->with('game_time')
                                ->where('team_id', $theteam)
                                ->where('team_level', 1)
                                ->where('date', Carbon::today('America/New_York'))
                                ->get();

        $tennis_boys = TennisBoys::with('away_team')
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

        $tennis_girls = TennisGirls::with('away_team')
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

        $track = Track::with('the_team')
                                ->with('the_year')
                                ->with('host_team')
                                ->with('game_time')
                                ->where('team_id', $theteam)
                                ->where('team_level', 1)
                                ->where('date', Carbon::today('America/New_York'))
                                ->get();

        $wrestling = Wrestling::with('the_team')
                                ->with('the_year')
                               ->with('host_team')
                               ->with('game_time')
                               ->where('team_id', $theteam)
                               ->where('team_level', 1)
                               ->where('date', Carbon::today('America/New_York'))
                               ->get();

        $array = array_merge($baseball->toArray(),
                             $basketball_girls->toArray(),
                             $basketball_boys->toArray(),
                             $bowling_boys->toArray(),
                             $bowling_girls->toArray(),
                             $football->toArray(),
                             $soccer_boys->toArray(),
                             $soccer_girls->toArray(),
                             $softball->toArray(),
                             $swimming->toArray(),
                             $tennis_boys->toArray(),
                             $tennis_girls->toArray(),
                             $track->toArray(),
                             $wrestling->toArray()
                        );

        //$result = $basketball_boys->toBase()->merge($basketball_girls->toBase(), $baseball->toBase());

        return Response::json($array);
    }
}
