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
			'email' => ['required'],
			'avatar' => ['required'],
			'skills' => 'required|array|min:1',
			// verify each elm in skills[] to exist as a skill tag record
			'skills.*' => [
				'integer',
				Rule::in(Tag::where('type', 1)->pluck('id')),
			]
		]);

		$user = Auth::user();
		$user->name = $attributes['name'];
		$user->email = $attributes['email'];
		$user->picture_url = $attributes['avatar']; // TO-DO: how are we storing img files
		$user->save();

		// Update skillset of the user
		$user->skillset()->detach();
		$user->skillset()->attach($attributes['skills']);

		// Session::flash('message', 'Successfully updated user!');
		return view('welcome'); // TO-DO: where should we redirect to?
	}
}
