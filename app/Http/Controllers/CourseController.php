<?php

namespace App\Http\Controllers;

use App\Course;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public static function index()
	{
		$user = Auth::user();

		//If user is not signed in, redirect to login.
		if($user == null){
			return redirect('/login');
		}

		$courses = $user->courses;

		return view('user.studentProfile', compact('courses'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Course  $course
	 * @return \Illuminate\Http\Response
	 */
	public function show(Course $course)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Course  $course
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Course $course)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Course  $course
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Course $course)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Course  $course
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Course $course)
	{
		//
	}

	/**
	 * Get a course details.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \App\Course
	 */
	public function getCourseDetails(Request $request)
	{
		$user = Auth::user();
		$courseKey = $request->courseKey;
		$course = Course::where('course_key', $courseKey)->first();

		if ($course == null) {
			abort(404);
		}

		// Check if course is already associated
		$associatedCourse = $user->courses()->where('course_id', $course->id)->first();

		if (!$associatedCourse) {
			return ['course' => $course, 'teachers' => $course->teachers];
		} else {
			abort(400);
		}
	}

	/**
	 * Associate a student with a course.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return Bool
	 */
	public function associate(Request $request)
	{
		$user = Auth::user();
		$courseKey = $request->courseKey;
		$course = Course::where('course_key', $courseKey)->first();

		if ($course == null || $student == null) {
			abort(400);
		}

		if ($user->role != 2) {
			abort(401);
		}

		$result = $student->courses()->attach($course);

		return ['course' => $course, 'teachers' => $course->teachers];
	}

	/**
	 * Generate a descriptive schedule string for a course
	 *
	 * @param array $courseSchedule
	 * @param string $courseHours
	 * @param string $courseSemester
	 * @return string
	 */
	private function joinSchedule(array $courseSchedule, string $courseHours, string $courseSemester) {
		$schedule = "";
		foreach ($courseSchedule as $day) {
			switch ($day) {
				case "monday":
					$schedule .= "Mo";
					break;
				case "tuesday":
					$schedule .= "Tue";
					break;
				case "wednesday":
					$schedule .= "Wed";
					break;
				case "thursday":
					$schedule .= "Thu";
					break;
				case "friday":
					$schedule .= "Fri";
					break;
				case "saturday":
					$schedule .= "Sat";
					break;
				default:
					break;
			}
		}

		$schedule .= " {$courseHours}, {$courseSemester}";
		return $schedule;
	}

	/**
	 * Generate a course key for a new course
	 *
	 * @return string
	 */
	private function getCourseKey() {
		$course_key = "";
		do {
			$course_key = substr(md5(date(DATE_RFC2822)),-6);
			$course_key = strtoupper($course_key);
		} while (Course::where('course_key', $course_key)->first() != null);

		return $course_key;
	}
}
