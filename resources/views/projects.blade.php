
@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div class="padded content">
	<h1>Projects</h1>
	<!-- Filters -->
	<form class="ui form">
		<!-- Search by Name -->
		<div class="field">
			<label for="searchName">Name</label>
			<input id="searchName" type="text" name="searchName" placeholder="A cool project">
		</div>
		<!-- Search by Tag -->
		<div class="field">
			<label for="tags">Tags</label>
{{-- 			@foreach($project->tags as $tag)
				<div class="ui bluemarket-skill label">{{$tag->name}}</div>
			@endforeach --}}
			<select name="tags" class="ui fluid search dropdown searchTags" multiple="">
				<option value="">web-dev, fun, teamwork</option>
				<option value="1">tag1</option>
				<option value="2">tag2</option>
				<option value="3">tag3</option>
			</select>
		</div>
		<button id="searchButton" type="submit" class="ui primary submit button" onclick="filter()">Search</button>
	</form>
	<!-- Project Cards -->
	<div class="ui four stackable cards">
		@for ($i = 0; $i < 10; $i++)
			@projectCard(['projectImage' => 'https://source.unsplash.com/400x300/?project', 'projectName' => 'A cool project', 'category' => 'Videogames', 'projectShortDescription' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'skillset' => ['Skill 0', 'Skill 1', 'Skill 2'], 'publicMilestone' => 'shipping'])
			@endprojectCard
		@endfor
	</div>
</div>
@endsection
@section('scripts')
<script>
	$('.ui.dropdown').dropdown();
	let projects = {!! $projects !!}; //need to get from database
	function filter(){
		let name = "ProjectName"; //need to get from database
		let regexName = new RegExp(name, 'i');
		let searchTags = ["webDev", "anotherOne"]; //need to get from database

		let searchTagsSorted = searchTags.sort();
		let regexTags = new RegExp(searchTagsSorted.join(","), 'i');

		let result = $.grep(project, function(project){
			if(regexName.test(project.name)){
				let tags = project.tags.msp(function(tag){
					return tag.name;
				});
				let projectTags = tags.sort();
				let stringFromProjectTags = projectTags.join(",");
				if(regexTags.test(stringFromProjectTags)){
					return project;
				}
			}
		});
	}
</script>
@endsection
