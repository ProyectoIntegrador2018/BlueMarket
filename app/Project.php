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
}
