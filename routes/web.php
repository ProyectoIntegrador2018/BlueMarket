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

Route::get('/login', function () {
	return view('login');
});
Route::resource('projects', 'ProjectController')->only([
	'index', 'show', 'create', 'store'
]);
Route::get('/projects', function () {
	return view('projects');
});
Route::get('/auth', function() {
	return view('auth');
});

Route::post('/googleauth', function() {
	$client = new Google_Client(['client_id' => "723110696630-74quqp3hlmjoc30f9tc4ji4v3qgvec40.apps.googleusercontent.com"]);
	$token = request('id_token');
	$payload = $client->verifyIdToken($token);
	if($payload) {
		dd($payload);
		// $userid = $payload['sub'];
	}
	else {
		dd('Invalid token');
	}
});

