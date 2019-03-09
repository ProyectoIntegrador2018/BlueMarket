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
Route::view('/login/welcome', 'auth.success');

Route::resource('projects', 'ProjectController')->only([
	'index', 'show', 'create', 'store'
]);

/* courses */
Route::resource('courses', 'CourseController');
Route::get('/user/profile', 'CourseController@index');
Route::get('/user/courses/associate/details', 'CourseController@getCourseDetails');
Route::post('/user/courses/associate', 'CourseController@associate');

/* dummy routes */
Route::get('/user/edit', function () {
	return view('editUserProfile');
});

Route::post('/contact', 'ContactMessageController@post');
