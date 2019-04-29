<button type="button" class="ui button primary" onclick="showMilestoneModal('new')">New milestone</button>

<table class="ui celled table">
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Status</th>
			<th>Done date</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($project->milestones as $milestone)
		<tr>
			<td>{{ $loop->iteration }}</td>
			<td>{{ $milestone->name }}</td>
			<td>
				@switch($milestone->status)
					@case(Config::get('enum.milestone_status')['done'])
						<span class="ui green label">Done</span>
						@break

					@case(Config::get('enum.milestone_status')['current'])
						<span class="ui blue label">Current</span>
						@break

					@default
						<span class="ui grey label">Coming up</span>
				@endswitch
			</td>
			<td>{{ isset($milestone->done_date) ?  $milestone->done_date : '-' }}</td>
			<td>
				<button class="ui button primary" onclick="showMilestoneModal('edit')">Edit</button>
				<button class="ui button red" onclick="showMilestoneModal('delete')">Delete</button>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

<!-- Modals -->
@include('projects.milestones.form', ['name' => 'new'])
@include('projects.milestones.form', ['name' => 'edit'])

<!-- TO DO: missing error validation for edit and delete -->
<div id="delete-milestone-modal" class="ui tiny modal delete-milestone-modal">
	<div class="header">Are you sure you want to delete this milestone?</div>
	<div class="content">
		<form class="ui form milestones delete {{ $errors->any() ? 'error': '' }}">
			@csrf
			<p>Confirming this modal will erase all info about this milestone.</p>
		</form>
	</div>
	<div class="actions">
		<button type="button" class="ui cancel button" onclick="hideMilestoneModal('delete')">No</button>
		<button type="submit" class="ui ok button primary">Yes</button>
	</div>
</div>
