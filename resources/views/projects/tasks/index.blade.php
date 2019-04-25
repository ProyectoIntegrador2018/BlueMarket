<div>
	<h2>Open</h2>
	<table class="ui selectable very padded stackable yellow table">
		<tbody>
			<tr class="task-row warning">
				<td>
					<p>Upload wireframes to remote workspace</p>
					<p>Opened <span>2 days ago</span> by {{ $project->team->leader->name }}</p>
				</td>
				<td>
					<p>Due <span>01/03/2019 11:59PM</span></p>
					<p><i class="attention icon"></i>Overdue</p>
				</td>
			</tr>
			<tr class="task-row warning">
				<td>
					<p>Upload wireframes to remote workspace</p>
					<p>Opened <span>2 days ago</span> by {{ $project->team->leader->name }}</p>
				</td>
				<td>
					<p>Due <span>01/03/2019 11:59PM</span></p>
					<p><i class="attention icon"></i>Overdue</p>
				</td>
			</tr>
			<tr class="task-row">
				<td>
					<p>Upload wireframes to remote workspace</p>
					<p>Opened <span>2 days ago</span> by {{ $project->team->leader->name }}</p>
				</td>
				<td>
					<p>Due <span>01/03/2019 11:59PM</span></p>
				</td>
			</tr>
			<tr class="task-row">
				<td>
					<p>Upload wireframes to remote workspace</p>
					<p>Opened <span>2 days ago</span> by {{ $project->team->leader->name }}</p>
				</td>
				<td>
					<p>Due <span>01/03/2019 11:59PM</span></p>
				</td>
			</tr>
			<tr class="task-row">
				<td>
					<p>Upload wireframes to remote workspace</p>
					<p>Opened <span>2 days ago</span> by {{ $project->team->leader->name }}</p>
				</td>
				<td>
					<p>Due <span>01/03/2019 11:59PM</span></p>
				</td>
			</tr>
		</tbody>
	</table>

	<h2>Closed</h2>
	<table class="ui selectable very padded stackable grey table">
		<thead>
		<tbody>
			<tr class="task-row">
				<td>
					<p>Upload wireframes to remote workspace</p>
					<p>Closed <span>2 days ago</span> by {{ $project->team->leader->name }}</p>
				</td>
				<td>
					<p>Due <span>01/03/2019 11:59PM</span></p>
				</td>
			</tr>
			<tr class="task-row">
				<td>
					<p>Upload wireframes to remote workspace</p>
					<p>Closed <span>2 days ago</span> by {{ $project->team->leader->name }}</p>
				</td>
				<td>
					<p>Due <span>01/03/2019 11:59PM</span></p>
				</td>
			</tr>
		</tbody>
	</table>
	<div id="task-details-modal" class="ui fullscreen modal task-details-modal">
		<div class="scrolling content">
			@include('projects.tasks.details')
		</div>
		<div class="actions">
			<button class="ui black deny button">Close</button>
		</div>
	</div>
</div>
