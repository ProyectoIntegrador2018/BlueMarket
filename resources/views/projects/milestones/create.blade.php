<div class="header">New milestone</div>
<div class="content">
	<form class="ui form milestones create {{ $errors->any() ? 'error': '' }}">
		@csrf
		@include('projects.milestones.form')
	</form>
</div>
<div class="ui error message">
	<h2 class="header">Whoops! Something went wrong.</h2>
	@if($errors->any())
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	@endif
</div>
<div class="actions">
	<button type="button" class="ui cancel button" onclick="hideMilestoneModal('create')">Cancel</button>
	<button type="submit" class="ui ok button primary">Create</button>
</div>
