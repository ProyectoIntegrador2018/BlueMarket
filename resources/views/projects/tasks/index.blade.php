<div class="ui equal width stackable grid">
	<div id="to-do-tasks" class="column task-list">
		<h2>To-do</h2>
		@foreach($project->todoTasks() as $task)
			<div class="task" data-taskid="{{ $task->id }}">
				<div class="ui grid">
					<div class="column">
						<span title="Open task"><i class="small circle green icon"></i></span>
					</div>
					<div class="fourteen wide column">
						<p class="task-title">{{ $task->title }}</p>
						<p>Opened <span class="needs-datetimeago" data-datetime="{{ $task->created_at }}">{{ $task->created_at }}</span> by <a href="{{ action('UserController@show', ['id' => $task->creator->id]) }}">{{ $task->creator->name }}</a></p>
						<p class="task-due {{ $task->isOverdue() ? 'overdue' : '' }}">Due <span class="needs-localdatetime" data-datetimeutc="{{ $task->deadline }}">{{ $task->deadline }}</span></p>
					</div>
				</div>
			</div>
		@endforeach
	</div>
	<div class="column task-list">
		<h2>In progress</h2>
		@foreach($project->inProgressTasks() as $task)
			<div class="task" data-taskid="{{ $task->id }}">
				<div class="ui grid">
					<div class="column">
						<span title="In progress task"><i class="small circle yellow icon"></i></span>
					</div>
					<div class="fourteen wide column">
						<p class="task-title">{{ $task->title }}</p>
						<p>Opened <span class="needs-datetimeago" data-datetime="{{ $task->created_at }}">{{ $task->created_at }}</span> by <a href="{{ action('UserController@show', ['id' => $task->creator->id]) }}">{{ $task->creator->name }}</a></p>
						<p class="task-due {{ $task->isOverdue() ? 'overdue' : '' }}">Due <span class="needs-localdatetime" data-datetimeutc="{{ $task->deadline }}">{{ $task->deadline }}</span></p>
					</div>
				</div>
			</div>
		@endforeach
	</div>
	<div class="column task-list">
		<h2>Closed</h2>
		@foreach($project->closedTasks() as $task)
			<div class="task" data-taskid="{{ $task->id }}">
				<div class="ui grid">
					<div class="column">
						<span title="Closed task"><i class="small circle blue icon"></i></span>
					</div>
					<div class="fourteen wide column">
						<p class="task-title">{{ $task->title }}</p>
						<p>Opened <span class="needs-datetimeago" data-datetime="{{ $task->created_at }}">{{ $task->created_at }}</span> by <a href="{{ action('UserController@show', ['id' => $task->creator->id]) }}">{{ $task->creator->name }}</a></p>
						<p class="task-due">Due <span class="needs-localdatetime" data-datetimeutc="{{ $task->deadline }}">{{ $task->deadline }}</span></p>
					</div>
				</div>
			</div>
		@endforeach
	</div>
</div>
