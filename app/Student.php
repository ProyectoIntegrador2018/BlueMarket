<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function courses() {
		return $this->belongsToMany(Course::class, 'student_course', 'student_id', 'course_id');
	}
}
