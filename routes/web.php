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
//  Baseball
///////////////////////////////////////////////////////////////////////

Route::get('/baseball', 'BaseballController@index')->name('baseball.index');
Route::get('/baseball/create', 'BaseballController@create')->name('baseball.create')->middleware('role:superadministrator|administrator|editor');
Route::post('/baseball/create', 'BaseballController@store')->name('baseball-create-game')->middleware('role:superadministrator|administrator|editor');
Route::delete('/baseball/delete/{id}', 'BaseballController@destroy');
Route::get('/baseball/{id}', 'BaseballController@show')->name('baseball-show');
Route::get('/baseball/{id}/edit', 'BaseballController@edit')->name('baseball-edit')->middleware('role:superadministrator|administrator|editor');
Route::put('/baseball/{id}/update', 'BaseballController@update')->name('baseball-edit-match')->middleware('role:superadministrator|administrator|editor');
Route::get('/baseball/{id}/edit-score', 'BaseballController@editScore')->name('baseball-score-edit')->middleware('role:superadministrator|administrator|editor');

Route::patch('/baseball/{id}/match-update', 'BaseballController@gameUpdate')->name('baseball.match.update')->middleware('role:superadministrator|administrator|editor');

Route::get('/baseball/2018-2019/{team}', 'BaseballController@teamSchedule')->name('baseball.teamSchedule');

Route::post('/baseball-score-create/{id}', 'BaseballController@scoreCreate')->name('baseball-score-create');
Route::delete('/baseball-score-delete/{id}', 'BaseballController@scoreDelete')->name('baseball-score-delete');

Route::patch('/baseball-inning-update/{id}', 'BaseballController@storeGameHalf');







///////////////////////////////////////////////////////////////////////
//  Basketball Boys
///////////////////////////////////////////////////////////////////////

Route::get('/boys-basketball', 'BasketballBoysController@index')->name('basketball-boys.index');
Route::get('/boys-basketball/create', 'BasketballBoysController@create')->name('basketball-boys.create')->middleware('role:superadministrator|administrator|editor');
Route::post('/boys-basketball/create', 'BasketballBoysController@store')->name('basketball-boys-create-game')->middleware('role:superadministrator|administrator|editor');
Route::delete('/boys-basketball/delete/{id}', 'BasketballBoysController@destroy');
Route::get('/boys-basketball/{id}', 'BasketballBoysController@show')->name('basketball-boys-show');
Route::get('/boys-basketball/{id}/edit', 'BasketballBoysController@edit')->name('basketball-boys-edit')->middleware('role:superadministrator|administrator|editor');
Route::put('/boys-basketball/{id}/update', 'BasketballBoysController@update')->name('basketball-boys-edit-match')->middleware('role:superadministrator|administrator|editor');
Route::get('/boys-basketball/{id}/edit-score', 'BasketballBoysController@editScore')->name('basketball-boys-score-edit')->middleware('role:superadministrator|administrator|editor');

Route::patch('/boys-basketball/{id}/match-update', 'BasketballBoysController@gameUpdate')->name('basketball-boys.match.update')->middleware('role:superadministrator|administrator|editor');

Route::get('/boys-basketball/{year}/{team}', 'BasketballBoysController@teamSchedule')->name('basketball-boys.teamSchedule');

Route::post('/boys-basketball-score-create/{id}', 'BasketballBoysController@scoreCreate')->name('basketball-boys-score-create');
Route::delete('/boys-basketball-score-delete/{id}', 'BasketballBoysController@scoreDelete')->name('basketball-boys-score-delete');

Route::patch('/boys-basketball-half-update/{id}', 'BasketballBoysController@storeGameHalf');







///////////////////////////////////////////////////////////////////////
//  Basketball Girls
///////////////////////////////////////////////////////////////////////

Route::get('/girls-basketball', 'BasketballGirlsController@index')->name('basketball-girls.index');
Route::get('/girls-basketball/create', 'BasketballGirlsController@create')->name('basketball-girls.create')->middleware('role:superadministrator|administrator|editor');
Route::post('/girls-basketball/create', 'BasketballGirlsController@store')->name('basketball-girls-create-game')->middleware('role:superadministrator|administrator|editor');
Route::delete('/girls-basketball/delete/{id}', 'BasketballGirlsController@destroy');
Route::get('/girls-basketball/{id}', 'BasketballGirlsController@show')->name('basketball-girls-show');
Route::get('/girls-basketball/{id}/edit', 'BasketballGirlsController@edit')->name('basketball-girls-edit')->middleware('role:superadministrator|administrator|editor');
Route::put('/girls-basketball/{id}/update', 'BasketballGirlsController@update')->name('basketball-girls-edit-match')->middleware('role:superadministrator|administrator|editor');
Route::get('/girls-basketball/{id}/edit-score', 'BasketballGirlsController@editScore')->name('basketball-girls-score-edit')->middleware('role:superadministrator|administrator|editor');

Route::patch('/girls-basketball/{id}/match-update', 'BasketballGirlsController@gameUpdate')->name('basketball-girls.match.update')->middleware('role:superadministrator|administrator|editor');

Route::get('/girls-basketball/{year}/{team}', 'BasketballGirlsController@teamSchedule')->name('basketball-girls.teamSchedule');

Route::post('/girls-basketball-score-create/{id}', 'BasketballGirlsController@scoreCreate')->name('basketball-girls-score-create');
Route::delete('/girls-basketball-score-delete/{id}', 'BasketballGirlsController@scoreDelete')->name('basketball-girls-score-delete');

Route::patch('/girls-basketball-half-update/{id}', 'BasketballGirlsController@storeGameHalf');







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
//  Bowling Boys
///////////////////////////////////////////////////////////////////////

Route::get('/boys-bowling', 'BowlingBoysController@index')->name('boys-bowling.index');
Route::get('/boys-bowling/create', 'BowlingBoysController@create')->name('boys-bowling.create')->middleware('role:superadministrator|administrator|editor');
Route::post('/boys-bowling/create', 'BowlingBoysController@store')->name('boys-bowling.create.game')->middleware('role:superadministrator|administrator|editor');
Route::delete('/boys-bowling/delete/{id}', 'BowlingBoysController@destroy');
Route::get('/boys-bowling/{id}', 'BowlingBoysController@show')->name('boys-bowling.show');
Route::get('/boys-bowling/{id}/edit', 'BowlingBoysController@edit')->name('boys-bowling.edit')->middleware('role:superadministrator|administrator|editor');
Route::put('/boys-bowling/{id}/update', 'BowlingBoysController@update')->name('boys-bowling.edit.match')->middleware('role:superadministrator|administrator|editor');
Route::get('/boys-bowling/{id}/edit-score', 'BowlingBoysController@editScore')->name('boys-bowling.score.edit')->middleware('role:superadministrator|administrator|editor');

Route::patch('/boys-bowling/{id}/match-update', 'BowlingBoysController@gameUpdate')->name('boys-bowling.match.update')->middleware('role:superadministrator|administrator|editor');

Route::get('/boys-bowling/2018-2019/{team}', 'BowlingBoysController@teamSchedule')->name('boys-bowling.teamSchedule');







///////////////////////////////////////////////////////////////////////
//  Bowling Girls
///////////////////////////////////////////////////////////////////////

Route::get('/girls-bowling', 'BowlingGirlsController@index')->name('girls-bowling.index');
Route::get('/girls-bowling/create', 'BowlingGirlsController@create')->name('girls-bowling.create')->middleware('role:superadministrator|administrator|editor');
Route::post('/girls-bowling/create', 'BowlingGirlsController@store')->name('girls-bowling.create.game')->middleware('role:superadministrator|administrator|editor');
Route::delete('/girls-bowling/delete/{id}', 'BowlingGirlsController@destroy');
Route::get('/girls-bowling/{id}', 'BowlingGirlsController@show')->name('girls-bowling.show');
Route::get('/girls-bowling/{id}/edit', 'BowlingGirlsController@edit')->name('girls-bowling.edit')->middleware('role:superadministrator|administrator|editor');
Route::put('/girls-bowling/{id}/update', 'BowlingGirlsController@update')->name('girls-bowling.edit.match')->middleware('role:superadministrator|administrator|editor');
Route::get('/girls-bowling/{id}/edit-score', 'BowlingGirlsController@editScore')->name('girls-bowling.score.edit')->middleware('role:superadministrator|administrator|editor');

Route::patch('/girls-bowling/{id}/match-update', 'BowlingGirlsController@gameUpdate')->name('girls-bowling.match.update')->middleware('role:superadministrator|administrator|editor');

Route::get('/girls-bowling/2018-2019/{team}', 'BowlingGirlsController@teamSchedule')->name('girls-bowling.teamSchedule');







///////////////////////////////////////////////////////////////////////
//  Football
///////////////////////////////////////////////////////////////////////

Route::get('/football', 'FootballController@index')->name('football.index');
Route::get('/football/create', 'FootballController@create')->name('football.create')->middleware('role:superadministrator|administrator|editor');
Route::post('/football/create', 'FootballController@store')->name('football-create-game')->middleware('role:superadministrator|administrator|editor');
Route::delete('/football/delete/{id}', 'FootballController@destroy');
Route::get('/football/{id}', 'FootballController@show')->name('football-show');
Route::get('/football/{id}/edit', 'FootballController@edit')->name('football-edit')->middleware('role:superadministrator|administrator|editor');
Route::put('/football/{id}/update', 'FootballController@update')->name('football-edit-match')->middleware('role:superadministrator|administrator|editor');
Route::get('/football/{id}/edit-score', 'FootballController@editScore')->name('football-score-edit')->middleware('role:superadministrator|administrator|editor');

Route::patch('/football/{id}/match-update', 'FootballController@gameUpdate')->name('football.match.update')->middleware('role:superadministrator|administrator|editor');

Route::get('/football/2018-2019/{team}', 'FootballController@teamSchedule')->name('football.teamSchedule');

Route::post('/football-score-create/{id}', 'FootballController@scoreCreate')->name('football-score-create');
Route::delete('/football-score-delete/{id}', 'FootballController@scoreDelete')->name('football-score-delete');

Route::patch('/football-half-update/{id}', 'FootballController@storeGameHalf');







///////////////////////////////////////////////////////////////////////
//  Softball
///////////////////////////////////////////////////////////////////////

Route::get('/softball', 'SoftballController@index')->name('softball.index');
Route::get('/softball/create', 'SoftballController@create')->name('softball.create')->middleware('role:superadministrator|administrator|editor');
Route::post('/softball/create', 'SoftballController@store')->name('softball-create-game')->middleware('role:superadministrator|administrator|editor');
Route::delete('/softball/delete/{id}', 'SoftballController@destroy');
Route::get('/softball/{id}', 'SoftballController@show')->name('softball-show');
Route::get('/softball/{id}/edit', 'SoftballController@edit')->name('softball-edit')->middleware('role:superadministrator|administrator|editor');
Route::put('/softball/{id}/update', 'SoftballController@update')->name('softball-edit-match')->middleware('role:superadministrator|administrator|editor');
Route::get('/softball/{id}/edit-score', 'SoftballController@editScore')->name('softball-score-edit')->middleware('role:superadministrator|administrator|editor');

Route::patch('/softball/{id}/match-update', 'SoftballController@gameUpdate')->name('softball.match.update')->middleware('role:superadministrator|administrator|editor');

Route::get('/softball/2018-2019/{team}', 'SoftballController@teamSchedule')->name('softball.teamSchedule');

Route::post('/softball-score-create/{id}', 'SoftballController@scoreCreate')->name('softball-score-create');
Route::delete('/softball-score-delete/{id}', 'SoftballController@scoreDelete')->name('softball-score-delete');

Route::patch('/softball-inning-update/{id}', 'SoftballController@storeGameHalf');







///////////////////////////////////////////////////////////////////////
//  Swimming
///////////////////////////////////////////////////////////////////////

Route::get('/swimming', 'SwimmingController@index')->name('swimming.index');
Route::get('/swimming/create', 'SwimmingController@create')->name('swimming.create')->middleware('role:superadministrator|administrator|editor');
Route::post('/swimming/create', 'SwimmingController@store')->name('swimming.create.match')->middleware('role:superadministrator|administrator|editor');
Route::delete('/swimming/delete/{id}', 'SwimmingController@destroy');
Route::get('/swimming/{id}', 'SwimmingController@show')->name('swimming.show');
Route::get('/swimming/{id}/edit', 'SwimmingController@edit')->name('swimming.edit')->middleware('role:superadministrator|administrator|editor');
Route::put('/swimming/{id}/update', 'SwimmingController@update')->name('swimming.edit.match')->middleware('role:superadministrator|administrator|editor');

Route::patch('/swimming/{id}/match-update', 'SwimmingController@gameUpdate')->name('swimming.soccer.match.update')->middleware('role:superadministrator|administrator|editor');

Route::get('/swimming/2018-2019/{team}', 'SwimmingController@teamSchedule')->name('swimming.teamSchedule');







///////////////////////////////////////////////////////////////////////
//  Tennis Boys
///////////////////////////////////////////////////////////////////////

Route::get('/boys-tennis', 'TennisBoysController@index')->name('boys-tennis.index');
Route::get('/boys-tennis/create', 'TennisBoysController@create')->name('boys-tennis.create')->middleware('role:superadministrator|administrator|editor');
Route::post('/boys-tennis/create', 'TennisBoysController@store')->name('boys-tennis.create.game')->middleware('role:superadministrator|administrator|editor');
Route::delete('/boys-tennis/delete/{id}', 'TennisBoysController@destroy');
Route::get('/boys-tennis/{id}', 'TennisBoysController@show')->name('boys-tennis.show');
Route::get('/boys-tennis/{id}/edit', 'TennisBoysController@edit')->name('boys-tennis.edit')->middleware('role:superadministrator|administrator|editor');
Route::put('/boys-tennis/{id}/update', 'TennisBoysController@update')->name('boys-tennis.edit.match')->middleware('role:superadministrator|administrator|editor');
Route::get('/boys-tennis/{id}/edit-score', 'TennisBoysController@editScore')->name('boys-tennis.score.edit')->middleware('role:superadministrator|administrator|editor');

Route::patch('/boys-tennis/{id}/match-update', 'TennisBoysController@gameUpdate')->name('boys-tennis.match.update')->middleware('role:superadministrator|administrator|editor');

Route::get('/boys-tennis/2018-2019/{team}', 'TennisBoysController@teamSchedule')->name('boys-tennis.teamSchedule');







///////////////////////////////////////////////////////////////////////
//  Tennis Girls
///////////////////////////////////////////////////////////////////////

Route::get('/girls-tennis', 'TennisGirlsController@index')->name('girls-tennis.index');
Route::get('/girls-tennis/create', 'TennisGirlsController@create')->name('girls-tennis.create')->middleware('role:superadministrator|administrator|editor');
Route::post('/girls-tennis/create', 'TennisGirlsController@store')->name('girls-tennis.create.game')->middleware('role:superadministrator|administrator|editor');
Route::delete('/girls-tennis/delete/{id}', 'TennisGirlsController@destroy');
Route::get('/girls-tennis/{id}', 'TennisGirlsController@show')->name('girls-tennis.show');
Route::get('/girls-tennis/{id}/edit', 'TennisGirlsController@edit')->name('girls-tennis.edit')->middleware('role:superadministrator|administrator|editor');
Route::put('/girls-tennis/{id}/update', 'TennisGirlsController@update')->name('girls-tennis.edit.match')->middleware('role:superadministrator|administrator|editor');
Route::get('/girls-tennis/{id}/edit-score', 'TennisGirlsController@editScore')->name('girls-tennis.score.edit')->middleware('role:superadministrator|administrator|editor');

Route::patch('/girls-tennis/{id}/match-update', 'TennisGirlsController@gameUpdate')->name('girls-tennis.match.update')->middleware('role:superadministrator|administrator|editor');

Route::get('/girls-tennis/2018-2019/{team}', 'TennisGirlsController@teamSchedule')->name('girls-tennis.teamSchedule');







///////////////////////////////////////////////////////////////////////
//  Track
///////////////////////////////////////////////////////////////////////

Route::get('/track', 'TrackController@index')->name('track.index');
Route::get('/track/create', 'TrackController@create')->name('track.create')->middleware('role:superadministrator|administrator|editor');
Route::post('/track/create', 'TrackController@store')->name('track.create.match')->middleware('role:superadministrator|administrator|editor');
Route::delete('/track/delete/{id}', 'TrackController@destroy');
Route::get('/track/{id}', 'TrackController@show')->name('track.show');
Route::get('/track/{id}/edit', 'TrackController@edit')->name('track.edit')->middleware('role:superadministrator|administrator|editor');
Route::put('/track/{id}/update', 'TrackController@update')->name('track.edit.match')->middleware('role:superadministrator|administrator|editor');

Route::patch('/track/{id}/match-update', 'TrackController@gameUpdate')->name('track.soccer.match.update')->middleware('role:superadministrator|administrator|editor');

Route::get('/track/2018-2019/{team}', 'TrackController@teamSchedule')->name('track.teamSchedule');







///////////////////////////////////////////////////////////////////////
//  Wrestling
///////////////////////////////////////////////////////////////////////

Route::get('/wrestling', 'WrestlingController@index')->name('wrestling.index');
Route::get('/wrestling/create', 'WrestlingController@create')->name('wrestling.create')->middleware('role:superadministrator|administrator|editor');
Route::post('/wrestling/create', 'WrestlingController@store')->name('wrestling.create.match')->middleware('role:superadministrator|administrator|editor');
Route::delete('/wrestling/delete/{id}', 'WrestlingController@destroy');
Route::get('/wrestling/{id}', 'WrestlingController@show')->name('wrestling.show');
Route::get('/wrestling/{id}/edit', 'WrestlingController@edit')->name('wrestling.edit')->middleware('role:superadministrator|administrator|editor');
Route::put('/wrestling/{id}/update', 'WrestlingController@update')->name('wrestling.edit.match')->middleware('role:superadministrator|administrator|editor');

Route::patch('/wrestling/{id}/match-update', 'WrestlingController@gameUpdate')->name('wrestling.soccer.match.update')->middleware('role:superadministrator|administrator|editor');

Route::get('/wrestling/2018-2019/{team}', 'WrestlingController@teamSchedule')->name('wrestling.teamSchedule');







///////////////////////////////////////////////////////////////////////
//  Teams
///////////////////////////////////////////////////////////////////////

Route::middleware('role:superadministrator')->group(function() {
	//Route::resource('/teams', 'TeamController');
	Route::get('/teams', 'TeamController@index')->name('teams.index');
	Route::get('/teams/{id}/edit', 'TeamController@edit')->name('team.edit');
	Route::get('/teams/create', 'TeamController@create')->name('team.create');
	Route::post('/teams/create', 'TeamController@store')->name('team.store');
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







///////////////////////////////////////////////////////////////////////
//  Years
///////////////////////////////////////////////////////////////////////

Route::prefix('years')->middleware('role:superadministrator')->group(function() {
	Route::get('/', 'YearsController@index')->name('years.index');
	Route::get('/create', 'YearsController@create')->name('year.create');
	Route::post('/create', 'YearsController@store');
	Route::get('/{id}', 'YearsController@show')->name('year.show');
	Route::get('/{id}/edit', 'YearsController@edit')->name('year.edit');
	Route::patch('/{id}/update', 'YearsController@update')->name('year.update');
	Route::delete('/delete/{id}', 'YearsController@destroy');
	Route::patch('/current-year', 'YearsController@currentYear');
});









///////////////////////////////////////////////////////////////////////
//  Twitter Routes
///////////////////////////////////////////////////////////////////////

Route::post('/tweet', 'TwitterController@tweet')->name('post.tweet');



