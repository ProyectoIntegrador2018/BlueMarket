<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
	protected $guarded = [];

	public function teachers() {
		return $this->belongsToMany('App\User')->wherePivot('user_type', 2);
	}

	public function students() {
		return $this->belongsToMany('App\User')->wherePivot('user_type', 1);
	}
}
