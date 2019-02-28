<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
	protected $guarded = [];

	public function teachers() {
		return $this->belongsToMany('App\User')->wherePivot('role', 1);
	}

	public function students() {
		return $this->belongsToMany('App\User')->wherePivot('role', 2);
	}
}
