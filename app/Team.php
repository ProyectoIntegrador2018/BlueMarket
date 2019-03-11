<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
	/**
	 * The attributes that cannot be mass assigned.
	 *
	 * @var array
	 */
	protected $guarded = [];

	public function leader() {
		return $this->belongsTo('App\User', 'leader_id');
	}

	public function members() {
		return $this->belongsToMany('App\User', 'team_user', 'team_id', 'user_id');
	}
}
