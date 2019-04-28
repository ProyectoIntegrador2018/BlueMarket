<div class="header">New milestone</div>
<div class="content">
	<form class="ui form milestones create {{ $errors->any() ? 'error': '' }}">
		@csrf
		@include('projects.milestones.form')
		<button type="button" class="ui cancel button" onclick="hideMilestoneModal('create')">Cancel</button>
		<button type="submit" class="ui ok button primary">Create</button>
	</form>
</div>
