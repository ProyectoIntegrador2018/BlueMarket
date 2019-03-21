
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
		<button id="searchButton" type="button" class="ui primary submit button" onclick="filterProjects()">Search</button>
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
	// npm install --save lodash.debounce OR yarn add lodash.debounce:
	import _debounce from 'lodash.debounce';
	// Event handler (do something on type):
	$('#searchName').on('keyup', _debounce(filterProjects2, 200));
	$('#searchTags').on('change', filterProjects2);
	// Flatten out the object:
	projects.forEach((project, index) => {
		project.name = project.name.toLowerCase();
		project.domid = index;
		project.tags = project.tags.map(tag => {
			return tag.name;
		});
	});
	// DOM Elements (<projectCard>):
	const $projectCards = $('.ProjectCard-container'); // Array
	// projects[0] => $projectCards[0]
	// Search by name, labels, or skills
	// Tags => labels, skills
	function filterProjects2() {
		// Get the seabrch name query (string)
		// Get the search tags query
			// AND project.tags includes labels, skills
		const nameQuery = $('#searchName').val().trim().toLowerCase();
		const tagQuery = $('#searchTags').val(); // Returns an array for the select
		// Get all the projects where name LIKE %namequery%:
		let projectResults = projects.filter(project => {
			return project.name.indexOf(nameQuery) > -1;
		});
		// Get the projects that match search tags:
		// All the projects where projects.tags contain all of tagQuery
		const finalResults = projectResults.filter(project => {
			let matchesAllTags = true;
			for (var i = 0; i < tagQuery.length; i++) {
				if(project.tags.indexOf(tagQuery[i]) === -1) {
					matchesAllTags = false;
					break;
				}
			}
			return matchesAllTags;
		});
		$projectCards.hide();
		finalResults.forEach(project => {
			$projectCards.eq(project.domid).show();
		});
	}
</script>
@endsection
