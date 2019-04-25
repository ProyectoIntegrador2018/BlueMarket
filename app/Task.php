<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model {
	/**
	 * The attributes that cannot be mass assigned.
	 *
	 * @var array
	 */
	protected $guarded = [];

	// Get the project the task belongs to
	public function project() {
		return $this->belongsTo('App\Project');
	}

	// Get the user who created (opened for the first time) the task
	public function creator() {
		return $this->belongsTo('App\User', 'created_by');
	}

	// Get the user who completed (closed) the task
	public function closed_by() {
		return $this->belongsTo('App\User', 'closed_by');
	}

}
