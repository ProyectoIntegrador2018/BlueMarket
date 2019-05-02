<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model {
	/**
	 * The attributes that cannot be mass assigned.
	 *
	 * @var array
	 */
	protected $guarded = [];

	public function project() {
		return $this->belongsTo('App\Project');
	}

	public function nextMilestone() {
		return $this->hasOne('App\Milestone', 'previous_milestone_id');
	}

	public function previousMilestone() {
		return $this->belongsTo('App\Milestone', 'previous_milestone_id');
	}
}
