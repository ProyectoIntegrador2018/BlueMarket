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
		$this->checkIfAccessAllowed([config(self::ROLES)['student'], config(self::ROLES)['teacher']]);

		$user = Auth::user();
		switch ($user->role) {
			case config(self::ROLES)['student']:
				return view('user.studentProfile', ['courses' => $user->EnrolledIn]);

			case config(self::ROLES)['teacher']:
				$courses = $user->teaches;
				return view('courses.list', compact('courses'));

			default:
				abort(404);
				break;
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$this->checkIfAccessAllowed([config(self::ROLES)['teacher']]);

		$teachers = User::where('role', config(self::ROLES)['teacher'])->select('id', 'name')->get();
		$courses = Course::where('course_type', 2)->get();
		return view('courses.create', compact('teachers', 'courses'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$attributes = request()->validate([
			'courseName' => 'required',
			'courseType' => 'required|integer|min:1|max:2',
			'teamSize' => 'required|integer|min:1',
			'teachers' => 'required|array|min:1',
			'teachers.*' => [
				'integer',
				// Validate ids belong to teacher users
				Rule::in(User::where('role', config(self::ROLES)['teacher'])->get()->pluck('id')),
			],
			'courseSemester' => 'required',
			'courseSchedule' => 'required|array|min:1',
			'courseHours' => 'required',
			'associatedCourses' => 'nullable|array|min:1',
		]);

		$course = $this->createCourse($attributes);

		$course->teachers()->attach($attributes['teachers']);
		if (isset($attributes['associatedCourses'])) {
			$course->suppliers()->attach($attributes['associatedCourses']);
		}

		return view('courses.details', compact('course'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Course  $course
	 * @return \Illuminate\Http\Response
	 */
	public function show(Course $course) {
		return view('courses.details', compact('course'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Course  $course
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Course $course) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Course  $course
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Course $course) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Course  $course
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Course $course) {
		//
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
		$course = Course::where('course_key', $courseKey)->first();

		abort_if($course === null, 404);

		// Check if course is already associated
		$associatedCourse = $user->enrolledIn()->where('course_id', $course->id)->first();

		abort_if(!$associatedCourse, 400);
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
		abort_if($user->role != 2, 401);

		$result = $user->EnrolledIn()->attach($course);

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

		return $schedule." {$courseHours}, {$courseSemester}";
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

	/**
	 * Create a course with the provided validated attributes
	 *
	 * @param array $attributes
	 * @return \App\Course
	 */
	private function createCourse(array $attributes) {
		$schedule = $this->joinSchedule(
			$attributes['courseSchedule'],
			$attributes['courseHours'],
			$attributes['courseSemester']
		);
		$courseKey = $this->getCourseKey();

		$course = Course::create([
			'name' => $attributes['courseName'],
			'course_type' => $attributes['courseType'],
			'schedule' => $schedule,
			'max_team_size' => $attributes['teamSize'],
			'course_key' => $courseKey,
		]);

		if (!$course->exists) {
			abort(500);
		}
		return $course;
	}

	/**
	 * Check if user is authenticated and has one of the indicated roles
	 *
	 * @param array $roles
	 * @return null
	 */
	private function checkIfAccessAllowed(array $roles) {
		$user = Auth::user();

		foreach ($roles as $role) {
			if ($user->role == $role) {
				return null;
			}
		}

		abort(404);
	}
}
