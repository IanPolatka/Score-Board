<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

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

        $soccer_boys = SoccerBoys::where('date', Carbon::today('America/New_York'))->get();

        return view('home', compact('soccer_boys'));
        
    }
}
