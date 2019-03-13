<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller {
	/**
	 * Show the form for editing the current user
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit() {
		return view('user.edit', ['skills' => Tag::where('type', 1)->get());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, User $user) {
		$attributes = request()->validate([
			'name' => ['required'],
			'skills' => 'required|array|min:1',
			// verify each elm in skills[] to exist as a skill tag record
			'skills.*' => [
				'integer',
				Rule::in(Tag::where('type', 1)->pluck('id')),
			]
		]);

		$user = Auth::user();
		$user->name = $attributes['name'];
		$user->save();

		$this->updateImg($request->file('teamImage'));

		// Update skillset of the user
		$user->skillset()->detach();
		$user->skillset()->attach($attributes['skills']);

		// Session::flash('message', 'Successfully updated user!');
		return view('welcome'); // TO-DO: where should we redirect to?
	}

	private function updateImg($image) {
		$path = isset($image) ? Storage::putFile('user/avatars', $image) : null;
		$user = Auth::user();
		$user->picture_url => $path;
		$user->save();
	}
}
