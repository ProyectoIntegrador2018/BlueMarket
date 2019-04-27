<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class TeamController extends Controller
{
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
		if (!$team->exists) {
			abort(500);
		}

		$team->members()->attach($team->leader_id, ['has_accepted' => config('enum.invite_status')['accepted']]);

		// redirect to teams/{id} // NOSONAR
		return redirect()->route('teams.show', [$team]);
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

		// Check courses associated with teams' existing projects, and filter users accordingly
		$courses = array_unique($team->projects()->with('course:id')->get()->pluck('course.id')->toArray());
		$teamUsers = array_merge($team->members()->get()->pluck('id')->toArray(), $team->pending_members()->get()->pluck('id')->toArray());

		if (empty($courses)) {
			// get all students except team members
			$students = User::students()->whereNotIn('users.id', $teamUsers)->get();
		} else {
			// get all students except team members and people in courses
			$students = User::students()->whereNotIn('users.id', $teamUsers)
				->whereHas('enrolledIn', function ($q) use($courses) {
					$q->whereIn('courses.id', $courses);
				})->get();
		}

		return view('teams.details', compact('team', 'users'));
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
		if (!empty($request['newMember'])) {
			$team->members()->attach($request['newMember']);
		}
		return redirect()->route('teams.show', [$team]);
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
