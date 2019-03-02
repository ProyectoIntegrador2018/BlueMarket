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

Route::get('/', function () {
	return view('home');
});

Route::get('/logout', 'LoginController@logout')->name('logout');
Route::get('/login', 'LoginController@show')->name('login');
Route::post('/login', 'LoginController@authenticate');

Route::resource('projects', 'ProjectController')->only([
	'index', 'show', 'create', 'store'
]);

Route::resource('courses', 'CourseController');
Route::get('/create', function() {
	return view('courses.create');
});

Route::get('/details', function() {
	return view('courses.details');
});
