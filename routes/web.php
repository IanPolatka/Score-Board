<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::redirect('home', '/');







///////////////////////////////////////////////////////////////////////
//  Boys Soccer
///////////////////////////////////////////////////////////////////////

Route::get('/boys-soccer', 'SoccerBoysController@index')->name('boyssoccer.index');
Route::get('/boys-soccer/create', 'SoccerBoysController@create')->name('boyssoccer.create')->middleware('role:superadministrator|administrator|editor');
Route::post('/boys-soccer/create', 'SoccerBoysController@store')->name('boys-soccer-create-match')->middleware('role:superadministrator|administrator|editor');
Route::delete('/boys-soccer/delete/{id}', 'SoccerBoysController@destroy');
Route::get('/boys-soccer/{id}', 'SoccerBoysController@show')->name('boys-soccer-show');
Route::get('/boys-soccer/{id}/edit', 'SoccerBoysController@edit')->name('boys-soccer-edit')->middleware('role:superadministrator|administrator|editor');
Route::put('/boys-soccer/{id}/update', 'SoccerBoysController@update')->name('boys-soccer-edit-match')->middleware('role:superadministrator|administrator|editor');
Route::get('/boys-soccer/{id}/edit-score', 'SoccerBoysController@editScore')->name('boys-soccer-score-edit')->middleware('role:superadministrator|administrator|editor');

Route::patch('/boys-soccer/{id}/match-update', 'SoccerBoysController@gameUpdate')->name('boys.soccer.match.update')->middleware('role:superadministrator|administrator|editor');

Route::get('/boys-soccer/2018-2019/{team}', 'SoccerBoysController@teamSchedule')->name('boyssoccer.teamSchedule');

Route::post('/boys-soccer-score-create/{id}', 'SoccerBoysController@scoreCreate')->name('boys-soccer-score-create');
Route::delete('/boys-soccer-score-delete/{id}', 'SoccerBoysController@scoreDelete')->name('boys-soccer-score-delete');

Route::patch('/boys-soccer-half-update/{id}', 'SoccerBoysController@storeGameHalf');





///////////////////////////////////////////////////////////////////////
//  Girls Soccer
///////////////////////////////////////////////////////////////////////

Route::get('/girls-soccer', 'SoccerGirlsController@index')->name('girlssoccer.index');
Route::get('/girls-soccer/create', 'SoccerGirlsController@create')->name('girlssoccer.create')->middleware('role:superadministrator|administrator|editor');
Route::post('/girls-soccer/create', 'SoccerGirlsController@store')->name('girls-soccer-create-match')->middleware('role:superadministrator|administrator|editor');
Route::delete('/girls-soccer/delete/{id}', 'SoccerGirlsController@destroy');
Route::get('/girls-soccer/{id}', 'SoccerGirlsController@show')->name('girls-soccer-show');
Route::get('/girls-soccer/{id}/edit', 'SoccerGirlsController@edit')->name('girls-soccer-edit')->middleware('role:superadministrator|administrator|editor');
Route::put('/girls-soccer/{id}/update', 'SoccerGirlsController@update')->name('girls-soccer-edit-match')->middleware('role:superadministrator|administrator|editor');
Route::get('/girls-soccer/{id}/edit-score', 'SoccerGirlsController@editScore')->name('girls-soccer-score-edit')->middleware('role:superadministrator|administrator|editor');

Route::patch('/girls-soccer/{id}/match-update', 'SoccerGirlsController@gameUpdate')->name('girls.soccer.match.update')->middleware('role:superadministrator|administrator|editor');

Route::get('/girls-soccer/2018-2019/{team}', 'SoccerGirlsController@teamSchedule')->name('girlssoccer.teamSchedule');

Route::post('/girls-soccer-score-create/{id}', 'SoccerGirlsController@scoreCreate')->name('girls-soccer-score-create');
Route::delete('/girls-soccer-score-delete/{id}', 'SoccerGirlsController@scoreDelete')->name('girls-soccer-score-delete');

Route::patch('/girls-soccer-half-update/{id}', 'SoccerGirlsController@storeGameHalf');







///////////////////////////////////////////////////////////////////////
//  Teams
///////////////////////////////////////////////////////////////////////

Route::middleware('role:superadministrator')->group(function() {
	//Route::resource('/teams', 'TeamController');
	Route::get('/teams', 'TeamController@index')->name('teams.index');
	Route::get('/teams/{id}/edit', 'TeamController@edit')->name('team.edit');
	Route::post('/teams/create', 'TeamController@create')->name('team.create');
	Route::patch('/teams/{id}/update', 'TeamController@update')->name('team.update');
	Route::get('/teams/{id}/{year}', 'TeamController@show')->name('team.show');
	Route::get('/teams/{id}/{year}/edit-meta', 'TeamController@editMeta')->name('team.edit.meta');
	Route::post('/teams/{id}/{year}/create-meta', 'TeamController@createMeta')->name('team.create.meta');
	Route::patch('/teams/{id}/{year}/edit-meta', 'TeamController@patchMeta')->name('team.update.meta');
	Route::post('/teams/{id}/image-upload', 'TeamController@imageUpload');
});

//Route::post('/team/meta-create', 'TeamController@createYearMeta');



///////////////////////////////////////////////////////////////////////
//  Users
///////////////////////////////////////////////////////////////////////

Route::prefix('manage')->middleware('role:superadministrator')->group(function() {
	Route::get('/', 'ManageController@index');
	Route::get('/dashboard', 'ManageController@dashboard')->name('manage.dashboard');
	Route::resource('/users', 'UserController');
});



Route::get('/profile', 'ProfileController@index')->name('profile.index');
Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');
Route::patch('/profile/edit', 'ProfileController@update')->name('profile.update');
Route::post('/profile/edit-password', 'ProfileController@changePassword')->name('profile.edit.password');


