<?php

namespace App\Http\Controllers;

use App\Year;
use App\CurrentYear;

use Session;

use Auth;

use Illuminate\Http\Request;

class YearsController extends Controller
{
    
	public function __construct() 
    {
      $this->middleware('auth');
    }



    public function index() 
    {

    	$currentYear = CurrentYear::find(1);

    	$years = Year::orderBy('year')->get();

    	return view('years.index', compact('currentYear', 'years'));
    
    }



    public function show($id)
    {

    	$year = Year::where('id', $id)->first();

    	return view('years.show', compact('year'));

    }



    public function create()
    {

        return view('years.create');
    
    }



    public function store(Request $request)
    {

        $user_id = Auth::user()->id;

        $this->validate(request(), [
            'year'           => 'required',
        ]);

        Year::create([
            'year'       => request('year'),
            'created_by'    => $user_id
        ]);

        Session::flash('success', 'Year Has Been Created');

        return redirect('/years');

    }



    public function edit($id)
    {

        $year = Year::where('id', $id)->first();

        return view('years.edit', compact('year'));

    }



    public function update(Request $request, $id)
    {

        $user_id = Auth::user()->id;

        $this->validate(request(), [
            'year' => 'required',
        ]);

        $year = Year::findOrFail($id);
        $year->year = request('year');
        $year->modified_by   = $user_id;

        $year->update();

        Session::flash('success', 'Year Has Been Updated');

        return redirect('/years/'.$id);

    }



    public function currentYear(Request $request)
    {

        $user_id = Auth::user()->id;

        $currentYear = CurrentYear::findOrFail(1);
        $currentYear->year_id = request('year_id');
       	$currentYear->modified_by   = $user_id;

        $currentYear->update();

        Session::flash('success', 'Current School Year Has Been Updated.');

        return redirect('/years');

    }



    public function destroy($id)
    {
        
        $year = Year::find($id);
        $year->delete();

        Session::flash('success', 'Year Has Been Deleted');

        return redirect('/years');
    
    }

}
