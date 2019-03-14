
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
			<input id="searchName" type="text" name="searchName" placeholder="e.g. A cool project" onkeyup="filterProjects()">
		</div>
		<!-- Search by Tag -->
		<div class="field">
			<label for="tags">Tags</label>
			<select id="searchTags" name="tags" class="ui fluid search dropdown searchTags" multiple onchange="filterProjects()">
				@foreach ($tags as $tag)
					<option value={{$tag->id}}>{{$tag->name}}</option>
				@endforeach
			</select>
		</div>
		<button id="searchButton" type="button" class="ui primary submit button" onclick="filterProjects()">Search</button>
	</form>
	<!-- Project Cards -->
	<div class="ui four stackable cards">
		@foreach ($projects as $project)
			@projectCard(['projectImage' => $project['photo'], 'projectName' => $project['name'], 'projectShortDescription' => $project['short_description'], 'skillset' => $project->skills, 'labels' => $project->labels, 'publicMilestone' => 'shipping'])
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
		let searchTags = [];
		$('#searchTags > option:selected').each(function() {
			searchTags.push($(this).text());
		});
		let searchTagsSorted = searchTags.sort();
		let searchTagsString = '.*' + searchTagsSorted.join(",.*");
		let regexTags = new RegExp(searchTagsString, 'i');
		console.log(regexTags);

		let result = $.grep(projects, function(project){
			if(regexName.test(project.name)){
				let projectTags = project.labels.concat(project.skills);
				let tags = projectTags.map(function(tag){
					return tag.name;
				});
				let projectTagsSorted = tags.sort();
				let stringFromProjectTags = projectTagsSorted.join(",");
				console.log(stringFromProjectTags);
				if(regexTags.test(stringFromProjectTags)){
					return project;
				}
			}
		});

		let projectCardList = "";

		for (index in result) {
			let project = result[index];
			console.log(project);

			let projectSkills = "";
			for(skillIndex in project.skills) {
				let skill = project.skills[skillIndex];
				projectSkills =	projectSkills.concat(`<div class="ui label pill">${skill.name}</div>`);
			}

			let projectLabels = "";
			for(labelIndex in project.labels) {
				let label = project.labels[labelIndex];
				projectLabels =	projectLabels.concat(`<div class="ui label pill">${label.name}</div>`);
			}

			let projectCardContent =	`<div class="card bluemarket-projectcard">
											<div class="image">
											<img src=${project.photo}>
											</div>
											<div class="content">
											<div class="header">${project.name}</div>
												<div class="description">${project.short_description}</div>
											</div>
											<div class="extra content">
												<p class="ui sub header">Required skills</p>
												${projectSkills}
											</div>
											<div class="extra content">
												<p class="ui sub header">Labels</p>
												${projectLabels}
											</div>
											<div class="ui bottom attached label content">SHIPPING</div>
										</div>`;
			projectCardList = projectCardList.concat(projectCardContent);
		}
		$(".ui.four.stackable.cards").html(projectCardList);
	}
</script>
@endsection
