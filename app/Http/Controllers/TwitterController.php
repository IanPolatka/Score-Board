<?php

namespace App\Http\Controllers;

use Twitter;

use Illuminate\Http\Request;

class TwitterController extends Controller
{
    public function tweet(Request $request)
    {

    	$this->validate(request(), [
            'tweet'	=> 'required',
        ]);

    	$newTweet = ['status' => $request->tweet];

		$twitter = Twitter::postTweet($newTweet);

    	return redirect('/');
    }
}
