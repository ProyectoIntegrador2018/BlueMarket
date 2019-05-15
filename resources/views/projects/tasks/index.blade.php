<div class="ui equal width stackable grid">
	<div id="to-do-tasks" class="column task-list">
		<h2>To-do</h2>
		@foreach($project->todoTasks() as $task)
			@include('projects.tasks.task-list-item', ['task' => $task])
		@endforeach
	</div>
	<div id="in-progress-tasks" class="column task-list">
		<h2>In progress</h2>
		@foreach($project->inProgressTasks() as $task)
			@include('projects.tasks.task-list-item', ['task' => $task])
		@endforeach
	</div>
	<div id="closed-tasks" class="column task-list">
		<h2>Closed</h2>
		@foreach($project->closedTasks() as $task)
			@include('projects.tasks.task-list-item', ['task' => $task])
		@endforeach
	</div>
</div>
