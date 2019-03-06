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
	const ASSOCIATED = 'associatedCourses';
	const REQUIRED = 'required';
	const ROLES = 'enum.user_roles';
	const TEACHERS = 'teachers';
	const TEACHER = 'teacher';
	const STUDENT = 'student';
	const COURSES = 'courses';
	const COURSE = 'course';
	const COURSE_KEY = 'course_key';

	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$this->checkIfAccessAllowed([config(self::ROLES)[self::STUDENT], config(self::ROLES)[self::TEACHER]]);

		$user = Auth::user();
		switch ($user->role) {
			case config(self::ROLES)[self::STUDENT]:
				return view('user.studentProfile', [self::COURSES => $user->EnrolledIn]);
			case config(self::ROLES)[self::TEACHER]:
				$courses = $user->teaches;
				return view('courses.list', compact(self::COURSES));
			default:
				abort(404);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$this->checkIfAccessAllowed([config(self::ROLES)[self::TEACHER]]);

		$teachers = User::where('role', config(self::ROLES)[self::TEACHER])->select('id', 'name')->get();
		$courses = Course::where('course_type', 2)->get();
		return view('courses.create', compact(self::TEACHERS, self::COURSES));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$attributes = request()->validate([
			'courseName' => self::REQUIRED,
			'courseType' => 'required|integer|min:1|max:2',
			'teamSize' => 'required|integer|min:1',
			self::TEACHERS => 'required|array|min:1',
			'teachers.*' => [
				'integer',
				Rule::in(User::where('role', config(self::ROLES)[self::TEACHER])->get()->pluck('id')),
			],
			'courseSemester' => self::REQUIRED,
			'courseSchedule' => 'required|array|min:1',
			'courseHours' => self::REQUIRED,
			self::ASSOCIATED => 'nullable|array|min:1',
		]);

		$course = $this->createCourse($attributes);

		$course->teachers()->attach($attributes[self::TEACHERS]);
		if (isset($attributes[self::ASSOCIATED])) {
			$course->suppliers()->attach($attributes[self::ASSOCIATED]);
		}

		$teachers = $course->teachers->map(function ($user) {
			return $user->only(['id', 'name', 'email']);
		});
		return view('course.details', compact(self::COURSE, self::TEACHERS));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Course  $course
	 * @return \Illuminate\Http\Response
	 */
	public function show(Course $course)
	{
		$teachers = $course->teachers->map(function ($user) {
			return $user->only(['id', 'name', 'email']);
		});
		return view('course.details', compact(self::COURSE, self::TEACHERS));
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
		$course = Course::where(self::COURSE_KEY, $courseKey)->first();

		if ($course == null) {
			abort(404);
		}

		// Check if course is already associated
		$associatedCourse = $user->enrolledIn()->where('course_id', $course->id)->first();

		if (!$associatedCourse) {
			return [self::COURSE => $course, self::TEACHERS => $course->teachers];
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
	public function associate(Request $request) {
		$user = Auth::user();
		$courseKey = $request->courseKey;
		$course = Course::where(self::COURSE_KEY, $courseKey)->first();

		if ($course == null || $user == null) {
			abort(400);
		}

		if ($user->role != 2) {
			abort(401);
		}

		$result = $user->EnrolledIn()->attach($course);

		return [self::COURSE => $course, self::TEACHERS => $course->teachers];
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

		return $schedule . " {$courseHours}, {$courseSemester}";
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
		} while (Course::where(self::COURSE_KEY, $course_key)->first() != null);

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
			self::COURSE_KEY => $courseKey,
		]);

		if (!isset($course)) {
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
