<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\BasketballBoys;
use App\BasketballGirls;
use App\BowlingBoys;
use App\BowlingGirls;

use App\SoccerBoys;

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

        $basketball_boys = BasketballBoys::where('date', Carbon::today('America/New_York'))->orderBy('team_level')->get();

        $basketball_girls = BasketballGirls::where('date', Carbon::today('America/New_York'))->orderBy('team_level')->get();

        $bowling_boys = BowlingBoys::where('date', Carbon::today('America/New_York'))->orderBy('team_level')->get();  

        $bowling_girls = BowlingGirls::where('date', Carbon::today('America/New_York'))->orderBy('team_level')->get(); 

        // $bowling_girls = BowlingBoys::where('id', 5)->get();       

        $soccer_boys = SoccerBoys::where('date', Carbon::today('America/New_York'))->orderBy('team_level')->get();

        return view('home', compact('basketball_boys', 'basketball_girls', 'bowling_boys', 'bowling_girls', 'soccer_boys'));
        
    }
}
