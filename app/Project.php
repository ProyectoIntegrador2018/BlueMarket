<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	const INVITES = 'enum.invite_status';

	/**
	 * The attributes that cannot be mass assigned.
	 *
	 * @var array
	 */
	protected $guarded = [];

	// Get all the tags of a project (skills + labels)
	public function tags() {
		return $this->belongsToMany('App\Tag', 'tag_project', 'project_id', 'tag_id');
	}

	// Get the skills a project is looking for (required skills)
	public function skills() {
		return $this->belongsToMany('App\Tag', 'tag_project', 'project_id', 'tag_id')->where('tags.type', 1);
	}

	// Get the labels a project has
	public function labels() {
		return $this->belongsToMany('App\Tag', 'tag_project', 'project_id', 'tag_id')->where('tags.type', 2);
	}

	// Get the course the project belongs to
	public function course() {
		return $this->belongsTo('App\Course');
	}

	// Get the team the project belongs to
	public function team() {
		return $this->belongsTo('App\Team');
	}

	// Get the milestones of the project
	public function milestones() {
		return $this->hasMany('App\Milestone');
	}

	public function suppliers() {
		return $this->belongsToMany('App\User', 'project_user', 'project_id', 'user_id')
			->withPivot('accepted')
			->withTimestamps()
			->wherePivot('accepted', config(self::INVITES)['accepted']);
	}

	public function pending_suppliers() {
		return $this->belongsToMany('App\User', 'project_user', 'project_id', 'user_id')
			->withPivot('accepted')
			->withTimestamps()
			->wherePivot('accepted', config(self::INVITES)['pending'])
			->orderBy('pivot_created_at', 'desc');
	}
}
