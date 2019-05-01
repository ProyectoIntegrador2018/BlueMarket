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
			->withPivot('accepted')
			->withTimestamps()
			->wherePivot('accepted', config(self::INVITES)['accepted'])
			->where('role', config('enum.user_roles')['student']);
	}

	public function pending_members() {
		return $this->belongsToMany('App\User', 'team_user', 'team_id', 'user_id')
			->withPivot('accepted')
			->withTimestamps()
			->wherePivot('accepted', config(self::INVITES)['pending'])
			->where('role', config('enum.user_roles')['student'])
			->orderBy('pivot_created_at', 'desc');
	}
	public function projects() {
		return $this->hasMany('App\Project');
	}
}
