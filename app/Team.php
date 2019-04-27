<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
	const INVITES = 'enum.invite_status';

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
		return $this->belongsToMany('App\User', 'team_user', 'team_id', 'user_id')
			->withPivot('has_accepted')
			->withTimestamps()
			->wherePivot('has_accepted', config(self::INVITES)['accepted']);
	}

	public function pending_members() {
		return $this->belongsToMany('App\User', 'team_user', 'team_id', 'user_id')
			->withPivot('has_accepted')
			->withTimestamps()
			->wherePivot('has_accepted', config(self::INVITES)['pending'])
			->orderBy('pivot_created_at', 'desc');
	}
	public function projects() {
		return $this->hasMany('App\Project');
	}
}
