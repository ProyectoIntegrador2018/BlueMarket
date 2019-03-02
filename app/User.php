<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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

	public function teaches() {
		return $this->belongsToMany('App\Course')->wherePivot('role', config('enum.user_roles')['teacher']);
	}

	public function enrolledIn() {
		return $this->belongsToMany('App\Course')->wherePivot('role', config('enum.user_roles')['student']);
	}
}
