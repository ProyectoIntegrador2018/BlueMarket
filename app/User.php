<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
	use Notifiable;

	const ROLES = 'enum.user_roles';
	const INVITES = 'enum.invite_status';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'role', 'picture_url'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public static function students() {
		return self::where('role', config(self::ROLES)['student']);
	}

	public static function teachers() {
		return self::where('role', config(self::ROLES)['teacher']);
	}

	public function teaches() {
		return $this->belongsToMany('App\Course')
			->join('users', 'course_user.user_id', '=', 'users.id')
			->where('users.role', config(self::ROLES)['teacher']);
	}

	public function enrolledIn() {
		return $this->belongsToMany('App\Course')
			->join('users', 'course_user.user_id', '=', 'users.id')
			->where('users.role', config(self::ROLES)['student']);
	}

	public function teamsLed() {
		return $this->hasMany('App\Team', 'leader_id');
	}

	public function teams() {
		return $this->belongsToMany('App\Team', 'team_user', 'user_id', 'team_id')
		->withPivot('accepted')
		->withTimestamps()
		->wherePivot('accepted', config(self::INVITES)['accepted']);
	}

	public function skillset() {
		return $this->belongsToMany('App\Tag', 'skill_user', 'user_id', 'tag_id');
	}

	public function teamInvites() {
		return $this->belongsToMany('App\Team', 'team_user', 'user_id', 'team_id')
		->withPivot('accepted')
		->withTimestamps()
		->wherePivot('accepted', config(self::INVITES)['pending'])
		->orderBy('pivot_created_at', 'desc');
	}

	public function projectInvites() {
		return $this->belongsToMany('App\Project', 'project_user', 'user_id', 'project_id')
		->withPivot('accepted')
		->withTimestamps()
		->wherePivot('accepted', config(self::INVITES)['pending'])
		->orderBy('pivot_created_at', 'desc');
	}

	public function projects() {
		$teamProjects = $this->teams()->with('projects')
			->get()
			->pluck('projects')
			->flatten();
		$supplierProjects = $this->belongsToMany('App\Project', 'project_user', 'user_id', 'project_id')
			->withPivot('accepted')
			->withTimestamps()
			->wherePivot('accepted', config(self::INVITES)['accepted'])
			->get();
		return $teamProjects->merge($supplierProjects);
	}

	public function isAdmin() {
		return $this->role === config('enum.user_roles')['admin']; // Admin
	}
}
