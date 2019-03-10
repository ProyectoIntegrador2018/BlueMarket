<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	/**
	 * The attributes that cannot be mass assigned.
	 *
	 * @var array
	 */
	protected $guarded = [];

	public function tags() {
		return $this->belongsToMany('App\Tag');
	}
}
