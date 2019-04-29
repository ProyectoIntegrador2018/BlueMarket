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
}
