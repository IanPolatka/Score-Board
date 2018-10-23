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



///////////////////////////////////////////////////////////////////////
//  Basketball Boys
///////////////////////////////////////////////////////////////////////
Route::get('/basketball-boys/{id}', 'BasketballBoysController@apiGameId');
Route::get('/basketball-boys/schedule/{year}/{team}/{teamlevel}', 'BasketballBoysController@apiteamschedule');
Route::get('/basketball-boys/todays-events/{team}', 'BasketballBoysController@todaysEvents');
Route::get('/basketball-boys/year-summary/{year}/{team}', 'BasketballBoysController@yearSummary');



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
//  Football Soccer
///////////////////////////////////////////////////////////////////////
Route::get('/football/{id}', 'FootballController@apiGameId');
Route::get('/football/schedule/{year}/{team}/{teamlevel}', 'FootballController@apiteamschedule');
Route::get('/football/todays-events/{team}', 'FootballController@todaysEvents');
Route::get('/football/year-summary/{year}/{team}', 'FootballController@yearSummary');