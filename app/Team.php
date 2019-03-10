<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
	/**
	 * The attributes that are guarded.
	 *
	 * @var array
	 */
	protected $guarded = [];

	public function leader() {
		return $this->belongsTo('App\User', 'leader_id');
	}
}
