<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CurrentYear;
use App\Team;
use App\TeamMeta;
use App\Year;

use Session;

class TeamController extends Controller
{

    public function __construct() 
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::orderBy('school_name')->get();

        $currentYear = CurrentYear::first();

        return view('teams.index', compact('currentYear', 'teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'school_name'  =>  'required|max:255',
            'city' =>  'required',
            'state' => 'required',
            'abbreviated_name'  => 'required',
            'mascot' => 'required'
        ]);

        $team = new Team();
        $team->school_name = $request->school_name;
        $team->city = $request->city;
        $team->state = $request->state;
        $team->abbreviated_name = $request->abbreviated_name;
        $team->mascot = $request->mascot;
        $team->logo = $request->logo;
        if ($team->save()){
            Session::flash('success', 'Team created.');
            return redirect()->route('teams.index');
        } else {
            Session::flash('danger', 'Sorry a problem occured while createing the team.');
            return redirect()->route('teams.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $year)
    {

        $team = Team::find($id);

        $selectedyear = Year::where('year', $year)->pluck('year');
        $selectedyearid = Year::where('year', $year)->pluck('id')->first();

        $currentYear = CurrentYear::first();

        $years = Year::all();

        $teamMeta = TeamMeta::where('team_id', $id)->where('year_id', $selectedyearid)->get();

        return view('teams.show', compact('currentYear', 'selectedyear', 'selectedyearid', 'team', 'teamMeta', 'year', 'years'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = Team::find($id);

        $currentYear = CurrentYear::first();

        return view('teams.edit', compact('currentYear', 'team'));
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
        $this->validate($request, [
            'school_name'  =>  'required|max:255',
            'city' =>  'required',
            'state' => 'required',
            'abbreviated_name'  => 'required',
            'mascot' => 'required'
        ]);

        $team = Team::findOrFail($id);
        $team->school_name = $request->school_name;
        $team->city = $request->city;
        $team->state = $request->state;
        $team->abbreviated_name = $request->abbreviated_name;
        $team->mascot = $request->mascot;
        $team->logo = $request->logo;

        $team->update();

        Session::flash('success', 'Team Has Been Updated');

        return redirect()->route('teams.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function createMeta($id, $year)
    {

        $added_year = Year::where('id', $year)->pluck('year')->first();

        $teamMeta = new TeamMeta();
        $teamMeta->team_id = $id;
        $teamMeta->year_id = $year;
        $teamMeta->save();

        Session::flash('success', 'Team alignment created.');
        return redirect('/teams/'.$id.'/'.$added_year);
        
    }

}
