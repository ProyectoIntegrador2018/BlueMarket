<?php

namespace App\Http\Controllers;

use App\User;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function show($id) {
		$user = User::findOrFail($id);
		return view('user.details', ['user' => $user, 'courses' => $user->enrolledIn]);
	}

	/**
	 * Show the form for editing the current user
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit() {
		return view('user.edit', [
			'skills' => Tag::where('type', 1)->get(),
			'user' => Auth::user()
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request) {
		$attributes = request()->validate([
			'name' => ['present']
		]);

		$user = Auth::user();
		$user->name = $attributes['name'];
		$user->save();

		// Update the picture of the user
		if (isset($request->avatar)) {
			$this->updateImg($request->file('avatar'));
		}

		// Update skillset of the user
		$user->skillset()->detach();
		if (isset($request->skills)) {
			$user->skillset()->attach($request->skills);
		}

		return redirect()->back()->with([
			'skills' => Tag::where('type', 1)->get(),
			'user' => Auth::user()
		]);
	}

	private function updateImg($image) {
		$path = isset($image) ? Storage::putFile('public', $image) : Auth::user()->picture_url;
		$user = Auth::user();
		$user->picture_url = Storage::url($path);
		$user->save();
	}
}
