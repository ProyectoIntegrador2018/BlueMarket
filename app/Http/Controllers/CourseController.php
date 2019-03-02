<?php

namespace App\Http\Controllers;

use App\Course;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
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
        $teachers = User::where('role', config('enum.user_roles')['teacher'])->select('id', 'name')->get();
		return view('createCourse', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$attributes = request()->validate([
			'courseName' => 'required',
			'courseType' => 'required|integer|min:1|max:2',
			'teamSize' => 'required|integer|min:1',
			'teachers' => 'required|array|min:1',
			'teachers.*' => [
				'integer',
				Rule::in(User::where('role', config('enum.user_roles')['teacher'])->get()->pluck('id')),
			],
			'courseSemester' => 'required',
			'courseSchedule' => 'required|array|min:1',
			'courseHours' => 'required',
		]);

		$schedule = $this->joinSchedule($attributes['courseSchedule'], $attributes['courseHours'], $attributes['courseSemester']);

		$course = Course::create([
			'name' => $attributes['courseName'],
			'course_type' => $attributes['courseType'],
			'schedule' => $schedule,
			'team_size' => $attributes['teamSize'],
		]);

		if (!isset($course)) {
			abort(500);
		}

		$course->teachers->attach($attributes['teachers']);

		$course_key = $this->getCourseKey();
		$course->course_key = $course_key;
		$course->save();

		return view('success', compact('course_key'));
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
     * @param  String $courseKey
     * @return \App\Course
     */
    public function getCourseDetails(String $courseKey)
    {
		$user = Auth::user();
		$course = Course::where('course_key', $courseKey)->first();

		if ($course == null) {
			abort(404);
		}

		$exists = $user->courses()->contains($course->id);

		if ($exists == false) {
			return $course;
		} else {
			abort(400);
		}
	}

    /**
     * Associate a student with a course.
     *
     * @param  \App\Course  $course
     * @return Bool
     */
    public function associate(Course $course)
    {
		$user = Auth::user();
		$course = Course::find($course->id);

		if ($course == null || $student == null) {
			abort(400);
		}

		if ($user->role != 2) {
			abort(401);
		}

		$result = $student->courses()->attach($course);

		if ($result == null) {
			abort(400);
		}

		return back();
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
