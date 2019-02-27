<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    public function courses() {
		return $this->belongsToMany(Course::class, 'professor_course', 'professor_id', 'course_id')->withTimestamps();
	}
}
