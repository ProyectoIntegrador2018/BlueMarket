
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
	<div id="projects-grid" class="ui doubling four column stackable grid">
		@foreach ($projects as $project)
			@projectCard(['project' => $project])
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

<script src="{{ mix('js/searchFunction.js')}}"></script>
<script>
	const fzs = new FuzzySearch('#searchName', '#searchTags', '.ProjectCard-container', projects, 'tags');
</script>
@endsection
