<?php

namespace App\Http\Controllers;

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
		// TODO: send the project team members to view?
		return view('tasks.create');
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
			'project' => 'required|integer'
		]);

		// Validate the existance of the Project
		if(!$this->validateProject($attributes['project'])) {
			return redirect()->back()->withErrors([
				'project' => 'Invalid Project.'
			])->withInput();
		}

		$task = $this->createTask($attributes);

		// Add creator
		Auth::user()->tasksCreated()->associate($task);
		Auth::user()->save();

		return ['task' => $task]
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Task  $task
	 * @return \Illuminate\Http\Response
	 */
	public function show(Task $task) {
		return ['task' => $task]
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Task  $task
	 * @return \Illuminate\Http\Response
	 */
	public function edit(int $id) {
		return ['task' => Task::findOrFail($id)]
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Task  $task
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Task $task) {
		$task->update($request->all());
		return ['task' => $task]
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
		Project::find($project_id) == null
		// Check that all members in the team belong to the course that you're trying to create this project in
		$project = \App\Project::find($project_id);
		if(!$project->exists()) {
			return false;
		}

		return true;
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
			'deadline' => $attributes['dueDate'],
			'task_status' => config(self::TASK_STATUS)['open'],
			'project_id' => $attributes['project'],
		]);

		if (!$task->exists) {
			abort(500);
		}

		return $task;
	}
}
