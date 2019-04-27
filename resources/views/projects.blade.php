
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
					<option value="{{ $tag->name }}">{{ $tag->name }}</option>
				@endforeach
			</select>
		</div>
		<button id="searchButton" type="button" class="ui primary submit button">Search</button>
	</form>
	<!-- Message -->
	<div hidden class="ui message noProjectsMessage">
		<p class="header">No projects found</p>
		<p>No projects meet search criteria.</p>
	</div>
	<!-- Project Cards -->
	<div id="projects-grid" class="ui four column stackable grid">
		@foreach ($projects as $project)
			@projectCard([
				'id'=> $project->id,
				'projectImage' => $project->photo,
				'projectName' => $project->name,
				'projectShortDescription' => $project->short_description,
				'skillset' => $project->skills,
				'labels' => $project->labels,
				'publicMilestone' => 'shipping'
			])
			@endprojectCard
		@endforeach
	</div>
</div>
@endsection

@section('scripts')
<script>
	function adjustProjectsGrid(maxWidth) {
		if (maxWidth.matches) {
			$("#projects-grid").removeClass("four column stackable grid").addClass("two column stackable grid");
		}
		else {
			$("#projects-grid").removeClass("two column stackable grid").addClass("four column stackable grid");
		}
	}

	let maxWidth = window.matchMedia("(max-width: 1100px)");
	adjustProjectsGrid(maxWidth); // Call listener function at run time
	maxWidth.addListener(adjustProjectsGrid); // Attach listener function on state changes

	$('.ui.dropdown').dropdown();
	let projects = {!! $projects !!};
</script>

<script src="{{ mix('js/searchFunction.js')}}"></script>
<script>
	const fzs = new FuzzySearch('#searchName', '#searchTags', '.ProjectCard-container', projects, 'tags');
</script>
@endsection
