<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Project extends Model {

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
			->wherePivot('accepted', config(self::INVITES)['accepted'])
			->where('role', config('enum.user_roles')['student']);
	}

	public function pending_suppliers() {
		return $this->belongsToMany('App\User', 'project_user', 'project_id', 'user_id')
			->withPivot('accepted')
			->withTimestamps()
			->wherePivot('accepted', config(self::INVITES)['pending'])
			->where('role', config('enum.user_roles')['student'])
			->orderBy('pivot_created_at', 'desc');
	}

	// Get the project collaborators
	public function collaborators() {
		$members = $this->team()->first()->members()->get();
		$sups = $this->suppliers()->get();
		return $members->merge($sups);
	}

	// Check if user is a project collaborator
	public function isCollaborator($id) {
		// TODO: check if this actually returns suppliers as well
		// TODO: check if supplier_project relationshi exists
		return $this->collaborators()->where('id', $id)->first() != null;
	}

	// Check if a user is a project stakeholder (as defined in #gh-169)
	public function isStakeholder($id) {
		// Check if this is a teacher associated with the course
		$is_teacher = $this->course()->first()->teachers()->where('user_id', $id)->exists();
		$supplier_teachers = $this->course->supplierTeachers();

		$is_supplier_teacher = false;

		if($supplier_teachers !== null) {
			foreach ($supplier_teachers as $teacher) {
				if($teacher->id == $id) {
					$is_supplier_teacher = true;
					break;
				}
			}
		}

		return $this->isCollaborator($id) || $is_teacher || $is_supplier_teacher;
	// Get all the tasks of a project
	public function tasks() {
		return $this->hasMany('App\Task');
	}
}
