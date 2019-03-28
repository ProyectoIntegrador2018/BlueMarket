
@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div class="padded content">
	<h1>Projects</h1>
	<!-- Filters -->
	<form class="ui form">
		<!-- Search by name -->
		<div class="field">
			<label for="searchName">Name</label>
			<input id="searchName" type="text" name="searchName" placeholder="e.g. A cool project">
		</div>
		<!-- Search by tag -->
		<div class="field">
			<label for="tags">Tags</label>
			<select id="searchTags" name="tags" class="ui fluid search dropdown searchTags" multiple>
				@foreach ($tags as $tag)
					<option value={{ $tag->id }}>{{ $tag->name }}</option>
				@endforeach
			</select>
		</div>
		<button id="searchButton" type="button" class="ui primary submit button">Search</button>
	</form>
	<!-- Project Cards -->
	<div class="ui four stackable cards">
		@foreach ($projects as $project)
			@projectCard(['id'=> $project->id,'projectImage' => $project->photo, 'projectName' => $project->name, 'projectShortDescription' => $project->short_description, 'skillset' => $project->skills, 'labels' => $project->labels, 'publicMilestone' => 'shipping'])
			@endprojectCard
		@endforeach
	</div>
</div>
@endsection
@section('scripts')
<script>
	$('.ui.dropdown').dropdown();
	let projects = {!! $projects !!};
</script>
<script src="{{ mix('js/searchProjects.js')}}"></script>
@endsection
