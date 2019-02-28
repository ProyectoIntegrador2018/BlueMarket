<?php

namespace App\Http\Controllers;

use App\Course;
use App\Student;
use Illuminate\Http\Request;

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
		$courses = $user->courses;
        return view('user.studentProfile', $courses);
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
}
