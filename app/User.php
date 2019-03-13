<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;

	const ROLES = 'enum.user_roles';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
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
		return self::where('role', config(self::ROLES)['student'])->get();
	}

	public static function teachers() {
		return self::where('role', config(self::ROLES)['teacher'])->get();
	}

	public function teaches() {
		return $this->belongsToMany('App\Course')->join('users as usrs', 'course_user.user_id', '=', 'usrs.id')->where('users.role', config(self::ROLES)['teacher']);
	}

	public function enrolledIn() {
		return $this->belongsToMany('App\Course')->join('users as usrs', 'course_user.user_id', '=', 'usrs.id')->where('usrs.role', config(self::ROLES)['student']);
	}

	public function teamsLed() {
		return $this->hasMany('App\Team', 'leader_id');
	}

	public function teams() {
		return $this->belongsToMany('App\Team', 'team_user', 'user_id', 'team_id');
	}

	public function skillset() {
		return $this->belongsToMany('App\Tag', 'skill_user', 'user_id', 'tag_id');
	}
}
