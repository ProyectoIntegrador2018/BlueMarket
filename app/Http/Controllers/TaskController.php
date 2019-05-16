<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use App\Project;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
	const TASK_STATUS = 'enum.task_status';

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$attributes = request()->validate([
			'title' => 'required',
			'description' => 'required',
			'dueDate' => 'required', // TODO: check for datetime format
			'project' => 'required|integer',
			'assignee_id' => 'nullable|integer'
		]);

		// Validate the existance of the Project
		if(!$this->validateProject($attributes['project'])) {
			return redirect()->back()->withErrors([
				'project' => 'Invalid Project.'
			])->withInput();
		}

		// Validate the existance of the Assignee
		if(isset($attributes['assignee_id']) && !$this->validateAssignee($attributes['assignee_id'], $attributes['project'])) {
			return redirect()->back()->withErrors([
				'assignee_id' => 'Invalid Assignee.'
			])->withInput();
		}

		$task = $this->createTask($attributes);

		return $task->refresh();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Task  $task
	 * @return \Illuminate\Http\Response
	 */
	public function show(Task $task) {
		return Task::with(['creator', 'assignee', 'closed_by'])->where('id', $task->id)->first();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Task  $task
	 * @return \Illuminate\Http\Response
	 */
	public function edit(int $id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Task  $task
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, int $id) {

		$attributes = request()->validate([
			'title' => 'present',
			'description' => 'present',
			'dueDate' => 'present', // TODO: check for datetime format
			'task_status' => 'present|integer|min:1|max:3',
			'assignee_id' => 'nullable|integer',
		]);

		$task = Task::findOrFail($id);

		// Update the title of the task
		if (isset($request->title)) {
			$task->title = $attributes['title'];
		}

		// Update the description of the task
		if (isset($request->description)) {
			$task->description = $attributes['description'];
		}

		// Update the deadline of the task
		if (isset($request->dueDate)) {
			$task->deadline = $this->formatDate($attributes['dueDate']);
		}

		// Update the status of the task
		if (isset($request->task_status)) {
			$new_status = $attributes['task_status'];

			if ($new_status == 3) { // Closed
				// Update the date and responsible for closure
				$task->completed_date = Carbon::now();
				$task->closed_by = Auth::user()->id;
			} else { // Open (todo or in-progress)
				// Reset the date and responsible for closure
				$task->completed_date = null;
				$task->closed_by = null;
			}

			$task->task_status = $new_status;
		}

		// Validate the existance of the Assignee
		if(isset($attributes['assignee_id']) && !$this->validateAssignee($attributes['assignee_id'], $task->project->id)) {
			return redirect()->back()->withErrors([
				'assignee_id' => 'Invalid Assignee.'
			])->withInput();
		}

		// Update the assignee of the task (when null, then assignee null)
		$task->assignee_id = $attributes['assignee_id'];

		$task->save();

		return $task->refresh();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Task  $task
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Task $task) {
		//
	}

	private function validateProject($project_id) {
		$project = \App\Project::find($project_id);
		// Check that the project exists
		if(!$project->exists()) {
			return false;
		}

		// Check that user creating the task collaborates in the project where task is created
		return $project->isCollaborator(Auth::user()->id);
	}

	private function validateAssignee($assignee_id, $project_id) {
		$assignee = \App\User::find($assignee_id);
		// Check that the assignee exists
		if(!$assignee->exists()) {
			return false;
		}

		// Check that user assigned to the task collaborates in the project where task is created
		$project = \App\Project::find($project_id);
		return $project->isCollaborator($assignee->id);
	}

	/**
	 * Create a task with the provided validated attributes
	 *
	 * @param array $attributes
	 * @return \App\Task
	 */
	private function createTask(array $attributes) {
		$task = Task::create([
			'title' => $attributes['title'],
			'description' => $attributes['description'],
			'deadline' => $this->formatDate($attributes['dueDate']),
			'task_status' => config(self::TASK_STATUS)['todo'],
			'project_id' => $attributes['project'],
			'created_by' => Auth::user()->id,
			'assignee_id' => $attributes['assignee_id']
		]);

		if (!$task->exists) {
			abort(500);
		}

		return $task;
	}

	private function formatDate(string $isostr) {
		// parse date to be in mysql datetime format
		return (new DateTime($isostr))->format("Y-m-d H:i:s");
	}

}
