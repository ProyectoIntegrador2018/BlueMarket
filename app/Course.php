<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
	protected $guarded = [];

	public function teachers() {
		return $this->belongsToMany('App\User')->wherePivot('role', config('enum.user_roles')['teacher']);
	}

	public function students() {
		return $this->belongsToMany('App\User')->wherePivot('role', config('enum.user_roles')['student']);
	}
}
