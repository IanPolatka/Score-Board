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
Route::get('/soccer-girls/{id}', 'SoccerBoysController@apiGameId');
Route::get('/soccer-girls/schedule/{year}/{team}/{teamlevel}', 'SoccerBoysController@apiteamschedule');
Route::get('/soccer-girls/todays-events/{team}', 'SoccerBoysController@todaysEvents');
Route::get('/soccer-girls/match/{id}', 'SoccerBoysController@singleMatch');
Route::get('/soccer-girls/year-summary/{year}/{team}', 'SoccerBoysController@yearSummary');