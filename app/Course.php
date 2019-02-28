<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{

    /**
     * The users that a course has. They could be students and professors.
     *
     * @var array
     */
    public function users() {
		return $this->belongsToMany(User::class);
	}
}
