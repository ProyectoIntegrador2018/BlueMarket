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
}
