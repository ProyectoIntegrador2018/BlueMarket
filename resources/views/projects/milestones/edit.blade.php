<div class="header">Edit milestone</div>
<div class="content">
	<form class="ui form milestones create {{ $errors->any() ? 'error': '' }}">
		@csrf
		@include('projects.milestones.form')
	</form>
</div>
<div class="actions">
	<button type="button" class="ui cancel button" onclick="hideMilestoneModal('edit')">Cancel</button>
	<button type="submit" class="ui ok button primary">Update</button>
</div>
