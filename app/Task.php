<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model {
	/**
	 * The attributes that cannot be mass assigned.
	 *
	 * @var array
	 */
	protected $guarded = [];

	// Get the project the task belongs to
	public function project() {
		return $this->belongsTo('App\Project');
	}

	// Get the user who created (opened for the first time) the task
	public function creator() {
		return $this->belongsTo('App\User', 'created_by');
	}

	// Get the user who is assigned for the task
	public function assignee() {
		return $this->belongsTo('App\User', 'assignee_id');
	}

	// Get the user who completed (closed) the task
	public function closed_by() {
		return $this->belongsTo('App\User', 'closed_by');
	}

	// Check if task is overdue
	public function isOverdue() {
		return !$this->isClosed() && $this->is_date_overdue();
	}

	// Check if task is open (has a todo or in-progress status)
	public function isOpen() {
		return !$this->isClosed();
	}

	// Check if task has to-do status
	public function isToDo() {
		return $this->task_status === config('enum.task_status')['todo'];
	}

	// Check if task has in-progress status
	public function isInProgress() {
		return $this->task_status === config('enum.task_status')['in-progress'];
	}

	// Check if task is closed
	public function isClosed() {
		return $this->task_status === config('enum.task_status')['closed'];
	}

	// Helper for checks
	private function is_date_overdue() {
		return $this->deadline < Carbon::now()->toDateTimeString();
	}

}
