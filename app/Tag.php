<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {
	/**
	 * The attributes that cannot be mass assigned.
	 *
	 * @var array
	 */
	protected $guarded = [];

	public function projects() {
		return $this->belongsToMany('App\Project',  'tag_project', 'project_id', 'tag_id');
	}
}
