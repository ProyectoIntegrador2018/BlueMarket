<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {

	/**
	 * The attributes that cannot be mass assigned.
	 *
	 * @var array
	 */
	protected $guarded = [];

	public function teachers() {
		return $this->belongsToMany('App\User')->join('users as usrs', 'course_user.user_id', '=', 'usrs.id')->where('users.role', config('enum.user_roles')['teacher']);
	}

	public function students() {
		return $this->belongsToMany('App\User')->join('users as usrs', 'course_user.user_id', '=', 'usrs.id')->where('users.role', config('enum.user_roles')['student']);
	}

	public function clients() {
		return $this->belongsToMany('App\Course', 'client_supplier_course', 'supplier_id', 'client_id');
	}

	public function supplierTeachers() {
		$suppliers = $this->suppliers()->get();
		$supplier_teachers = null;

		if(count($suppliers) > 0) {
			$supplier_teachers = $suppliers[0]->teachers()->get();

			for($i = 1; $i < count($suppliers); $i++) {
				$supplier_teachers = $supplier_teachers->merge($suppliers[$i]->teachers()->get());
			}
		}

		return $supplier_teachers;
	}

	public function suppliers() {
		return $this->belongsToMany('App\Course', 'client_supplier_course', 'client_id', 'supplier_id');
	}

	// Get all the projects of a course
	public function projects() {
		return $this->hasMany('App\Project');
	}
}
