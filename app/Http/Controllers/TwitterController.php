<?php

namespace App\Http\Controllers;

use File;
use Session;
use Twitter;

use Illuminate\Http\Request;

class TwitterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function twitterUserTimeLine()
    {
        $data = Twitter::getUserTimeline(['count' => 10, 'format' => 'array']);

        return view('twitter', compact('data'));
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function tweet(Request $request)
    {
        $this->validate($request, [
            'tweet' => 'required',
        ]);

        $newTweet = ['status' => $request->tweet];

        $twitter = Twitter::postTweet($newTweet);

        Session::flash('success', 'Tweet has been posted.');

        return back();
    }
}
