<div class="ui stackable grid">
	<div class="eight wide column task-list">
		<h2>Open tasks</h2>
		<div class="task">
			<div class="ui stackable grid">
				<div class="two wide right aligned column task-status">
					<span title="Overdue task"><i class="small circle red icon"></i></span>
					<span title="Open task"><i class="small circle green icon"></i></span>
				</div>
				<div class="fourteen wide column">
					<!-- TODO: task controller show action -->
					<p class="task-title">Upload wireframes to remote workspace</p>
					<p>Opened <span>10 days ago</span> by <a href="{{ action('UserController@show', ['id' => $project->team->leader->id]) }}">{{ $project->team->leader->name }}</a></p>
					<p class="task-due">Due <span>01/03/2019 11:59PM</span></p>
				</div>
			</div>
		</div>
		<div class="task">
			<div class="ui stackable grid">
				<div class="two wide right aligned column task-status">
					<span title="Open task"><i class="small circle green icon"></i></span>
				</div>
				<div class="fourteen wide column">
					<!-- TODO: task controller show action -->
					<p class="task-title">Upload wireframes to remote workspace</p>
					<p>Opened <span>10 days ago</span> by <a href="{{ action('UserController@show', ['id' => $project->team->leader->id]) }}">{{ $project->team->leader->name }}</a></p>
					<p class="task-due">Due <span>01/03/2019 11:59PM</span></p>
				</div>
			</div>
		</div>
		<div class="task">
			<div class="ui stackable grid">
				<div class="two wide right aligned column task-status">
					<span title="Open task"><i class="small circle green icon"></i></span>
				</div>
				<div class="fourteen wide column">
					<!-- TODO: task controller show action -->
					<p class="task-title">Upload wireframes to remote workspace</p>
					<p>Opened <span>10 days ago</span> by <a href="{{ action('UserController@show', ['id' => $project->team->leader->id]) }}">{{ $project->team->leader->name }}</a></p>
					<p class="task-due">Due <span>01/03/2019 11:59PM</span></p>
				</div>
			</div>
		</div>
		<div class="task">
			<div class="ui stackable grid">
				<div class="two wide right aligned column task-status">
					<span title="Overdue task"><i class="small circle red icon"></i></span>
					<span title="Open task"><i class="small circle green icon"></i></span>
				</div>
				<div class="fourteen wide column">
					<!-- TODO: task controller show action -->
					<p class="task-title">Upload wireframes to remote workspace</p>
					<p>Opened <span>10 days ago</span> by <a href="{{ action('UserController@show', ['id' => $project->team->leader->id]) }}">{{ $project->team->leader->name }}</a></p>
					<p class="task-due">Due <span>01/03/2019 11:59PM</span></p>
				</div>
			</div>
		</div>
	</div>
	<div class="eight wide column task-list">
		<h2>Closed tasks</h2>
		<div class="task">
			<div class="ui stackable grid">
				<div class="two wide right aligned column task-status">
					<span title="Closed task"><i class="small circle blue icon"></i></span>
				</div>
				<div class="fourteen wide column">
					<!-- TODO: task controller show action -->
					<p class="task-title">Upload wireframes to remote workspace</p>
					<p>Opened <span>10 days ago</span> by <a href="{{ action('UserController@show', ['id' => $project->team->leader->id]) }}">{{ $project->team->leader->name }}</a></p>
					<p class="task-due">Due <span>01/03/2019 11:59PM</span></p>
				</div>
			</div>
		</div>
		<div class="task">
			<div class="ui stackable grid">
				<div class="two wide right aligned column task-status">
					<span title="Closed task"><i class="small circle blue icon"></i></span>
				</div>
				<div class="fourteen wide column">
					<!-- TODO: task controller show action -->
					<p class="task-title">Upload wireframes to remote workspace</p>
					<p>Opened <span>10 days ago</span> by <a href="{{ action('UserController@show', ['id' => $project->team->leader->id]) }}">{{ $project->team->leader->name }}</a></p>
					<p class="task-due">Due <span>01/03/2019 11:59PM</span></p>
				</div>
			</div>
		</div>
		<div class="task">
			<div class="ui stackable grid">
				<div class="two wide right aligned column task-status">
					<span title="Closed task"><i class="small circle blue icon"></i></span>
				</div>
				<div class="fourteen wide column">
					<!-- TODO: task controller show action -->
					<p class="task-title">Upload wireframes to remote workspace</p>
					<p>Opened <span>10 days ago</span> by <a href="{{ action('UserController@show', ['id' => $project->team->leader->id]) }}">{{ $project->team->leader->name }}</a></p>
					<p class="task-due">Due <span>01/03/2019 11:59PM</span></p>
				</div>
			</div>
		</div>
		<div class="task">
			<div class="ui stackable grid">
				<div class="two wide right aligned column task-status">
					<span title="Closed task"><i class="small circle blue icon"></i></span>
				</div>
				<div class="fourteen wide column">
					<!-- TODO: task controller show action -->
					<p class="task-title">Upload wireframes to remote workspace</p>
					<p>Opened <span>10 days ago</span> by <a href="{{ action('UserController@show', ['id' => $project->team->leader->id]) }}">{{ $project->team->leader->name }}</a></p>
					<p class="task-due">Due <span>01/03/2019 11:59PM</span></p>
				</div>
			</div>
		</div>
	</div>
</div>
