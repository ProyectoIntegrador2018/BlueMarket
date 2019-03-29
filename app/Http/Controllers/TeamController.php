<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;


class TeamController extends Controller
{
	const ROLES = 'enum.user_roles';

	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$students = User::students()->where('id', '!=', Auth::id());

		return view('teams.create', compact('students'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$attributes = request()->validate([
			'teamName' => 'required',
		]);

		$team = $this->createTeam($attributes, $request->file('teamImage'));

		$this->save_resized_image($request);

		if (!$team->exists) {
			abort(500);
		}

		$team->members()->attach($team->leader_id);

		// redirect to teams/{id}
		return redirect()->route('teams.show', [$team]);
	}

	private function save_resized_image($req) {
		if($req->hasFile('teamImage')) {
			$ext = $req->teamImage->extension();
			$path = $req->teamImage->store('teams/avatars');
			$nameindex = strrpos($path, ".");
			$name = substr($path, 0, $nameindex);
			$resized_name = $name."_400x400.".$ext;
			$resized_img = Image::make($req->teamImage)->fit(400);
			Storage::put($resized_name, $resized_img->encode($ext));
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Team  $team
	 * @return \Illuminate\Http\Response
	 */
	public function show(Team $team) {
		// If no set image, return temporary stock image
		if (!$team->img_url) {
			$team->img_url = 'https://avatars1.githubusercontent.com/u/42351872?s=200&v=4';
		}

		return view('teams.details', compact('team'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Team  $team
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Team $team) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Team  $team
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Team $team) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Team  $team
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Team $team) {
		//
	}

	/**
	 * Create a team with the provided validated attributes
	 *
	 * @param array $attributes
	 * @return \App\Course
	 */
	private function createTeam(array $attributes, $image) {
		$path = isset($image) ? Storage::putFile('public/teams/avatars', $image) : null;

		$team = Team::create([
			'name' => $attributes['teamName'],
			'img_url' => isset($path) ? Storage::url($path) : null,
			'leader_id' => Auth::id(),
		]);

		return $team;
	}
}
