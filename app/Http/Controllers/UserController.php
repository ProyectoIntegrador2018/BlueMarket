<?php

namespace App\Http\Controllers;

use App\User;
use App\Tag;
use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller {

	const ROLES = 'enum.user_roles';

	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Display the specified user.
	 *
	 * @param  int  $id
	 * @return \Illuminate\View
	 */
	public function show(int $id) {
		$user = User::find($id);
		return view('user.details', compact('user'));
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

	/**
	 * Get a course details.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \App\Course
	 */
	public function getCourseDetails(Request $request) {
		$user = Auth::user();
		$courseKey = $request->courseKey;
		$course = Course::with('teachers')->where('course_key', $courseKey)->first();

		abort_if($course === null, 404);

		// Check if course is already associated
		$associatedCourse = $user->enrolledIn()->where('course_id', $course->id)->first();

		abort_if($associatedCourse, 400);
		return ['course' => $course];
	}

	/**
	 * Associate a student with a course.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return Bool
	 */
	public function associate(Request $request) {
		$user = Auth::user();
		$courseKey = $request->courseKey;
		$course = Course::where('course_key', $courseKey)->first();

		abort_if($course == null || $user == null, 400);
		abort_if($user->role != config(self::ROLES)['student'], 401);

		$result = $user->enrolledIn()->attach($course);

		return ['course' => $course, 'teachers' => $course->teachers];
	}

	private function updateImg($image) {
		$path = isset($image) ? Storage::putFile('public', $image) : Auth::user()->picture_url;
		$user = Auth::user();
		$user->picture_url = Storage::url($path);
		$user->save();
	}
}
