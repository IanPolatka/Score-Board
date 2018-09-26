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

        $soccer_boys = SoccerBoys::where('date', Carbon::today())->get();

        //return $soccer_boys;

        return view('home', compact('soccer_boys'));
    }
}
