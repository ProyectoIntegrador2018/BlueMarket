<?php

namespace App\Http\Controllers;

use App\Course;
use App\User;
use Illuminate\Http\Request;

class CoursesController extends Controller
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
		// 1 client 2 supplier

        $attributes = request()->validate([
			'courseName' => 'required|string',
			'courseType' => ['required', 'integer', Rule::in([1, 2])],
			'teamsOf' => 'required|integer|min:1',
			'professors' => 'required',
			'professors.*.id' => ['integer', Rule::in(User::where('role', 1)->get()->pluck('id'))],
			'courseSemester' => 'required|string',
			'courseSchedule' => 'required',
			'courseHours' => 'required',
		]);

		/*$course = Course::create($attributes);

		foreach ($request->teachers as $teacher) {
			$result = $this->addTeacher($course, $teacher->id);

			if (!$result) {
				// return error here
			}
		}
		*/
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
	 * Associate a course with a teacher
	 *
	 * @param \App\Course $course
	 * @param integer $teacher_id
	 * @return boolean
	 */
	private function addTeacher(Course $course, integer $teacher_id) {
		if ($course == null || $teacher_id == null) {
			return false;
		}

		$result = $course->teachers->attach($teacher_id);

		if ($result) {
			return true;
		} else {
			return false;
		}

	}
}
