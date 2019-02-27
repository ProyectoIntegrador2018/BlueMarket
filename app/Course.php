<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function professors() {
		return $this->belongsToMany(Professor::class, 'professor_course', 'professor_id', 'course_id')->withTimestamps();
	}

    public function students() {
		return $this->belongsToMany(Student::class, 'student_course', 'student_id', 'course_id')->withTimestamps();
	}
}
