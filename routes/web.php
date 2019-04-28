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

/* home */
Route::get('/', function () {
	return view('home');
});

/* login/logout */
Route::get('/logout', 'LoginController@logout')->name('logout');
Route::get('/login', 'LoginController@show')->name('login');
Route::post('/login', 'LoginController@authenticate');
Route::view('/login/welcome', 'auth.success');

/* projects */
Route::resource('projects', 'ProjectController')->only([
	'index', 'show', 'create', 'store', 'update'
]);

/* users */
Route::resource('users', 'UserController')->only(['index', 'update', 'show']);
Route::get('/user/profile', 'UserController@show');
Route::get('/user/profile/edit', 'UserController@edit');

/* courses */
Route::resource('courses', 'CourseController');
Route::get('/user/courses/associate/details', 'UserController@getCourseDetails');
Route::post('/user/courses/associate', 'UserController@associate');
Route::post('/contact', 'ContactMessageController@post');

/* teams */
Route::resource('teams', 'TeamController');

/* notification center */
//Route::get('/notifications', 'NotificationController@index');


/* Admin routes
--------------------------------------------- */
Route::namespace('Admin')->prefix('admin')->group(function() {
	Route::redirect('/', '/admin/users', 301);
	Route::resource('users', 'UserController');
	Route::get('/users/sia/{id}', 'UserController@signInAs')->name('signinas');
});

/* Temp routes */
// TODO: remove all temp routes once the correct controller has been set up.
Route::get('/projects/tasks/create', function () {
	return view('projects.tasks.create');
});
