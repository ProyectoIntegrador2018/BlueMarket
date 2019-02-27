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
    public function index()
    {
        //
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
		$courseKey = $request->$courseKey;
		return Course::where('course_key', $courseKey)->first();
	}

    /**
     * Associate a student with a course.
     *
     * @param  \App\Course  $course
     * @return Bool
     */
    public function associate(Course $course, Student $student)
    {
		$course = Course::find($course->id);
		$student = Student::find($student->id);

		if ($course == null || $student == null) {
			return false;
		}

		$result = $student->courses()->attach($course->id);

		if ($result == null) {
			return false;
		} else {
			return true;
		}
	}
}
