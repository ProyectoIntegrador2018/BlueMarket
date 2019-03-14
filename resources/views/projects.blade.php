
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
			<input id="searchName" type="text" name="searchName" placeholder="e.g. A cool project">
		</div>
		<!-- Search by Tag -->
		<div class="field">
			<label for="tags">Tags</label>
{{-- 			@foreach($project->tags as $tag)
				<div class="ui bluemarket-skill label">{{$tag->name}}</div>
			@endforeach --}}
			<select name="tags" class="ui fluid search dropdown searchTags" multiple="">
				<option value="">e.g. web-dev, fun, teamwork</option>
				<option value="1">tag1</option>
				<option value="2">tag2</option>
				<option value="3">tag3</option>
			</select>
		</div>
		<button id="searchButton" type="button" class="ui primary submit button" onclick="filterProjects()">Search</button>
	</form>
	<!-- Project Cards -->
	<div class="ui four stackable cards">
		@foreach ($projects as $project)
			@projectCard(['projectImage' => $project['photo'], 'projectName' => $project['name'], 'projectShortDescription' => $project['short_description'], 'skillset' => ['Skill 0', 'Skill 1', 'Skill 2'], 'labels' => ['Label 0', 'Label 1', 'Label 2'], 'publicMilestone' => 'shipping'])
			@endprojectCard
		@endforeach
	</div>
</div>
@endsection
@section('scripts')
<script>
	$('.ui.dropdown').dropdown();
	let projects = {!! $projects !!};
	function filterProjects(){
		let searchBar = $("#searchName").val();
		let regexName = new RegExp(searchBar, 'i');
		// let searchTags = ["webDev", "anotherOne"]; //need to get from database
		// let searchTagsSorted = searchTags.sort();
		// let regexTags = new RegExp(searchTagsSorted.join(","), 'i');

		let result = $.grep(projects, function(project){
			console.log(project.name);
			if(regexName.test(project.name)){
				// let tags = project.tags.map(function(tag){
				// 	return tag.name;
				// });
				// let projectTags = tags.sort();
				// let stringFromProjectTags = projectTags.join(",");
				// if(regexTags.test(stringFromProjectTags)){
				// 	return project;
				// }
				return project;
			}
		});
		console.log(result);
		let projectCardList = "";
		for (index in result) {
			let project = result[index];
			// console.log(result[project]);
			let projectCardContent = `<div class="card bluemarket-projectcard">
										<div class="image">
										   <img src=${project.photo}>
										</div>
									   <div class="content">
									   		<div class="header">${project.name}</div>
									   		<div class="description">${project.short_description}</div>
									   </div>
									   <div class="extra content">
									   		<p class="ui sub header">Required skills</p>
									   		<div class="ui label pill">Skill1</div>
									   		<div class="ui label pill">Skill2</div>
									   		<div class="ui label pill">Skill3</div>
									   </div>
									   <div class="extra content">
									   		<p class="ui sub header">Labels</p>
									   		<div class="ui label pill">Tag1</div>
									   		<div class="ui label pill">Tag2</div>
									   		<div class="ui label pill">Tag3</div>
									   </div>
									   <div class="ui bottom attached label content">SHIPPING</div>
									   </div>`;
			projectCardList = projectCardList.concat(projectCardContent);
		}
		$(".ui.four.stackable.cards").html(projectCardList);
	}
</script>
@endsection
