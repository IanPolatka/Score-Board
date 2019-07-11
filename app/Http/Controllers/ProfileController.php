<?php

namespace App\Http\Controllers;

use Auth;

use Hash;

use Session;

use App\User;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        return view('profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();

        $id = Auth::user()->id;

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $id = Auth::user()->id;

        $this->validate(request(), [
            'name' => 'required|string|max:255',
            'email' =>  'required|email|unique:users,email,'.$id,
        ]);

        $user->update($request->all());

        Session::flash('success', 'Your profile has been updated.');

        return redirect('/profile');
    }

    public function changePassword(Request $request)
    {
        if (! (Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with('error', 'Your current password does not match with the password you provided. Please try again.');
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with('error', 'New Password cannot be same as your current password. Please choose a different password.');
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully !');
    }
}
