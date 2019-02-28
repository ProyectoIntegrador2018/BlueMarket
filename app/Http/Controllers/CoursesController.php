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
			'name' => 'required|string',
			'course_type' => ['required', 'integer', Rule::in([1, 2])],
			'student_cap' => 'nullable|integer|min:1',
			'team_size' => 'nullable|integer|min:1',
			'teachers' => 'required',
			'teachers.*.id' => ['integer', Rule::in(User::where('user_type', 2)->get()->pluck('id'))],
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
