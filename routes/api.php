<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/todays-events', 'HomeController@events');

Route::get('/todays-events/{team}', 'HomeController@eventsNow');

///////////////////////////////////////////////////////////////////////
//  Baseball
///////////////////////////////////////////////////////////////////////
Route::get('/baseball/{id}', 'BaseballController@apiGameId');
Route::get('/baseball/schedule/{year}/{team}/{teamlevel}', 'BaseballController@apiteamschedule');
Route::get('/baseball/todays-events/{team}', 'BaseballController@todaysEvents');
Route::get('/baseball/year-summary/{year}/{team}', 'BaseballController@yearSummary');

///////////////////////////////////////////////////////////////////////
//  Basketball Boys
///////////////////////////////////////////////////////////////////////
Route::get('/basketball-boys/{id}', 'BasketballBoysController@apiGameId');
Route::get('/basketball-boys/schedule/{year}/{team}/{teamlevel}', 'BasketballBoysController@apiteamschedule');
Route::get('/basketball-boys/todays-events/{team}', 'BasketballBoysController@todaysEvents');
Route::get('/basketball-boys/year-summary/{year}/{team}', 'BasketballBoysController@yearSummary');

///////////////////////////////////////////////////////////////////////
//  Basketball Girls
///////////////////////////////////////////////////////////////////////
Route::get('/basketball-girls/{id}', 'BasketballGirlsController@apiGameId');
Route::get('/basketball-girls/schedule/{year}/{team}/{teamlevel}', 'BasketballGirlsController@apiteamschedule');
Route::get('/basketball-girls/todays-events/{team}', 'BasketballGirlsController@todaysEvents');
Route::get('/basketball-girls/year-summary/{year}/{team}', 'BasketballGirlsController@yearSummary');

///////////////////////////////////////////////////////////////////////
// 	Bowling Boys
///////////////////////////////////////////////////////////////////////
Route::get('/bowling-boys/schedule/{year}/{team}/{teamlevel}', 'BowlingBoysController@apiteamschedule');
Route::get('/bowling-boys/todays-events/{team}', 'BowlingBoysController@todaysEvents');

///////////////////////////////////////////////////////////////////////
// 	Bowling Girls
///////////////////////////////////////////////////////////////////////
Route::get('/bowling-girls/schedule/{year}/{team}/{teamlevel}', 'BowlingGirlsController@apiteamschedule');
Route::get('/bowling-girls/todays-events/{team}', 'BowlingGirlsController@todaysEvents');

///////////////////////////////////////////////////////////////////////
//  Boys Soccer
///////////////////////////////////////////////////////////////////////
Route::get('/soccer-boys/{id}', 'SoccerBoysController@apiGameId');
Route::get('/soccer-boys/schedule/{year}/{team}/{teamlevel}', 'SoccerBoysController@apiteamschedule');
Route::get('/soccer-boys/todays-events/{team}', 'SoccerBoysController@todaysEvents');
Route::get('/soccer-boys/match/{id}', 'SoccerBoysController@singleMatch');
Route::get('/soccer-boys/year-summary/{year}/{team}', 'SoccerBoysController@yearSummary');

///////////////////////////////////////////////////////////////////////
//  Girls Soccer
///////////////////////////////////////////////////////////////////////
Route::get('/soccer-girls/{id}', 'SoccerGirlsController@apiGameId');
Route::get('/soccer-girls/schedule/{year}/{team}/{teamlevel}', 'SoccerGirlsController@apiteamschedule');
Route::get('/soccer-girls/todays-events/{team}', 'SoccerGirlsController@todaysEvents');
Route::get('/soccer-girls/match/{id}', 'SoccerGirlsController@singleMatch');
Route::get('/soccer-girls/year-summary/{year}/{team}', 'SoccerGirlsController@yearSummary');

///////////////////////////////////////////////////////////////////////
//  Football
///////////////////////////////////////////////////////////////////////
Route::get('/football/{id}', 'FootballController@apiGameId');
Route::get('/football/schedule/{year}/{team}/{teamlevel}', 'FootballController@apiteamschedule');
Route::get('/football/todays-events/{team}', 'FootballController@todaysEvents');
Route::get('/football/year-summary/{year}/{team}', 'FootballController@yearSummary');

///////////////////////////////////////////////////////////////////////
//  Softball
///////////////////////////////////////////////////////////////////////
Route::get('/softball/{id}', 'SoftballController@apiGameId');
Route::get('/softball/schedule/{year}/{team}/{teamlevel}', 'SoftballController@apiteamschedule');
Route::get('/softball/todays-events/{team}', 'SoftballController@todaysEvents');
Route::get('/softball/year-summary/{year}/{team}', 'SoftballController@yearSummary');

///////////////////////////////////////////////////////////////////////
//  Swimming
///////////////////////////////////////////////////////////////////////
Route::get('/swimming/schedule/{year}/{team}/{teamlevel}', 'SwimmingController@apiteamschedule');
Route::get('/swimming/todays-events/{team}', 'SwimmingController@todaysEvents');

///////////////////////////////////////////////////////////////////////
// 	Tennis Boys
///////////////////////////////////////////////////////////////////////
Route::get('/tennis-boys/schedule/{year}/{team}/{teamlevel}', 'TennisBoysController@apiteamschedule');
Route::get('/tennis-boys/todays-events/{team}', 'TennisBoysController@todaysEvents');

///////////////////////////////////////////////////////////////////////
// 	Tennis Girls
///////////////////////////////////////////////////////////////////////
Route::get('/tennis-girls/schedule/{year}/{team}/{teamlevel}', 'TennisGirlsController@apiteamschedule');
Route::get('/tennis-girls/todays-events/{team}', 'TennisGirlsController@todaysEvents');

///////////////////////////////////////////////////////////////////////
//  Track
///////////////////////////////////////////////////////////////////////
Route::get('/track-and-field/schedule/{year}/{team}/{teamlevel}', 'TrackController@apiteamschedule');
Route::get('/track-and-field/todays-events/{team}', 'TrackController@todaysEvents');

///////////////////////////////////////////////////////////////////////
//  Wrestling
///////////////////////////////////////////////////////////////////////
Route::get('/wrestling/schedule/{year}/{team}/{teamlevel}', 'WrestlingController@apiteamschedule');
Route::get('/wrestling/todays-events/{team}', 'WrestlingController@todaysEvents');
