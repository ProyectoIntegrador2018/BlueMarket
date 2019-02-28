<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

	public function authenticate(Request $request) {
		dd('hello');
		// TODO: change this to an ENV var? maybe a config var?
		$user = User::where("name", $nameToTestAgainst)->first();

		$client = new Google_Client(['client_id' => "723110696630-74quqp3hlmjoc30f9tc4ji4v3qgvec40.apps.googleusercontent.com"]);
		$token = $request->only('id_token');
		$payload = $client->verifyIdToken($token);
		if($payload) {
			dd($payload);
			// $userid = $payload['sub'];
		}
		else {
			dd('Invalid token');
		}
	}

}
