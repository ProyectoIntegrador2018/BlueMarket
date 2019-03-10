<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Google_Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller {
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
	protected $redirectTo = '/';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('guest')->except('logout');
	}

	public function show() {
		return view('auth.login');
	}

	public function logout() {
		Auth::logout();
		return redirect('/');
	}

	private function createUserInDB($payload) {
		$user = new User();
		$user->email = $payload['email'];
		$user->picture_url = $payload['picture'];
		$user->name = $payload['name'];
		$user->google_id = $payload['sub'];
		$user->save();

		return $user;
	}

	public function authenticate(Request $request) {
		// TODO: change this to an ENV var? maybe a config var?
		$client = new Google_Client(['client_id' => "723110696630-74quqp3hlmjoc30f9tc4ji4v3qgvec40.apps.googleusercontent.com"]);
		$token = $request->id_token;

		if(empty($token)) {
			abort(400, 'No token');
		}

		$new = false;
		$payload = $client->verifyIdToken($token);
		if($payload) {
			if($payload['hd'] !== 'itesm.mx') { // Take this out into an conf var
				abort(500, 'Not an itesm.mx user');
				// TODO: ERROR fix
			}

			$user = User::where("email", $payload['email'])->first();

			if(empty($user)) {
				// Create the user in the db
				$new = true;
				$user = $this->createUserInDB($payload);
			}

			Auth::login($user);
			// return redirect()->intended('/'); // NOSONAR

			return ["success" => "OK", "new" => $new];
		}

		abort(403, 'Invalid ID token');
	}
}
