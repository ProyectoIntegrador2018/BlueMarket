<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
		$students = User::students()->where('id', '!=', Auth::user()->id);

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
			'name' => 'required',
			'photo' => 'nullable',
		]);

		$attributes['leader_id'] = Auth::user()->id;

		$team = Team::create($attributes);
		if (!$team->exists) {
			abort(500);
		}

		$team->members()->attach($team->leader_id);

		return view('teams.details', compact('team'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Team  $team
	 * @return \Illuminate\Http\Response
	 */
	public function show(Team $team) {
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
}
