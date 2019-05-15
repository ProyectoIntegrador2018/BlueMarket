<div class="task" data-taskid="{{ $task->id }}">
	<div class="ui grid">
		<div class="column">
			@switch($task->task_status)
				@case(Config::get('enum.task_status')['todo'])
				<span title="To-do task"><i class="small circle green icon"></i></span>
				@break

				@case(Config::get('enum.task_status')['in-progress'])
				<span title="In progress task"><i class="small circle yellow icon"></i></span>
				@break

				@case(Config::get('enum.task_status')['closed'])
				<span title="Closed task"><i class="small circle blue icon"></i></span>
				@break
			@endswitch
		</div>
		<div class="fourteen wide column">
			<p class="task-title">{{ $task->title }}</p>
			<p>Opened <span class="needs-datetimeago" data-datetime="{{ $task->created_at }}">{{ $task->created_at }}</span> by <a href="{{ action('UserController@show', ['id' => $task->creator->id]) }}">{{ $task->creator->name }}</a></p>
			<p class="task-due {{ $task->isOverdue() ? 'overdue' : '' }}">Due <span class="needs-localdatetime" data-datetimeutc="{{ $task->deadline }}">{{ $task->deadline }}</span></p>
		</div>
	</div>
</div>
