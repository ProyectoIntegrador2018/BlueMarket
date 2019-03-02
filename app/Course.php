<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
	protected $guarded = [];

	public function teachers() {
		return $this->belongsToMany('App\User')->join('users as usrs', 'course_user.user_id', '=', 'usrs.id')->where('users.role', config('enum.user_roles')['teacher']);
	}

	public function students() {
		return $this->belongsToMany('App\User')->join('users as usrs', 'course_user.user_id', '=', 'usrs.id')->where('users.role', config('enum.user_roles')['student']);
	}
}
