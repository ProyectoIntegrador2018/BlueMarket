@extends('layouts.app')

@section('title', 'Add Project')

@section('content')

@section('header', 'Register a new project')
<style>
	.imgUploader {
		margin-bottom: 20px;
	}
</style>
<div class="padded content">
	<h1>Create new project</h1>
	<form class="ui form {{ $errors->any() ? 'error': '' }}" method="post" enctype="multipart/form-data" action="/projects">
		@csrf
		<!-- Project image -->
		<div class="field {{ $errors->has('projectImage') ? 'error': '' }}">
			<label for="projectImage">Project image</label>
			<div class="image-container">
				<div class="imgUploader preview-container">
					<img src="https://lorempixel.com/400/400" alt="Project image" class="ui medium image preview" id="projectImagePreview"/>
				</div>
				<button class="imgUploader ui button primary" type="button">Upload image</button>
			</div>
			<input id="projectImage" name="projectImage" type="file" style="display:none" accept="image/x-png,image/jpeg,image/png" onchange="updateImage(this)">
		</div>
		<button class="ui button primary" onclick="fillDummy()" type="button">Fill with dummy data </button>
		<!-- Project name -->
		<div class="field {{ $errors->has('projectName') ? 'error': '' }}">
			<label for="projectName">Project name</label>
			<input type="text" id="projectName"" name="projectName" placeholder="e.g. Best Project" value="{{ old('projectName') }}">
		</div>
		<!-- Associated course -->
		<div class="field {{ $errors->has('courses') ? 'error': '' }}">
			<label for="course">Associated course</label>
			<select name="course" id="course" class="ui search dropdown" value="{{ old('course') }}">
				<option value="">e.g. Web development class</option>
				@if(isset($courses))
					@foreach($courses->all() as $course)
						<option value="{{ $course->id }}">{{ $course->name }}</option>
					@endforeach
				@endif
			</select>
		</div>
		<!-- Associated team -->
		<div class="ui placeholder segment">
			<div class="ui two column very relaxed stackable grid">
				<div class="column responsive-segment">
					<div class="field associatedTeam">
						<label for="existingTeam">Choose an existing team</label>
						<select id="existingTeam" name="existingTeam" class="ui search dropdown team {{ $errors->has('existingTeam') || $errors->has('bothTeams') ? 'error': '' }}" value="{{ old('existingTeam') }}" onchange="selectTeam()">
							<option value="">My teams</option>
							@if(isset($teams))
								@foreach($teams->all() as $team)
									<option value="{{ $team->id }}">{{ $team->name }}</option>
								@endforeach
							@endif
						</select>
					</div>
				</div>
				<div class="ui horizontal divider">
					Or
				</div>
				<div class="column responsive-segment">
					<div class="field associatedTeam">
						<label for="newTeam">Create a new team</label>
						<input id="newTeam" type="text" name="newTeam" placeholder="Create a new team" value="{{ old('newTeam')}}" onchange="createNewTeam()">
					</div>
				</div>
			</div>
			<div class="ui vertical divider">
				Or
			</div>
		</div>
		<!-- Labels -->
		<div class="field {{ $errors->has('label') ? 'error': '' }}">
			<label for="labels">Labels</label>
			<select name="labels[]" id="labels" multiple class="ui search dropdown">
				<option value="">e.g. Finance</option>
				@if(isset($labels))
					@foreach($labels->all() as $label)
						<option value="{{ $label->id }}">{{ $label->name }}</option>
					@endforeach
				@endif
			</select>
		</div>
		<!-- Skillset -->
		<div class="field {{ $errors->has('skillsets') ? 'error': '' }}">
			<label for="skillsets">Skillset</label>
			<select id="skillsets" name="skillsets[]" multiple class="ui search dropdown">
				<option value="">e.g. Java, HTML</option>
				@if(isset($skillsets))
					@foreach($skillsets->all() as $skillset)
						<option value="{{ $skillset->id }}">{{ $skillset->name }}</option>
					@endforeach
				@endif
			</select>
		</div>
		<!-- Milestone -->
		<div class="field {{ $errors->has('milestone') ? 'error': '' }}">
			<label for="milestone">Public milestone</label>
			<input type="text" id="milestone" value="{{ old('milestone') }}" placeholder="e.g. Design">
		</div>
		<!-- Short description -->
		<div class="field {{ $errors->has('shortDescription') ? 'error': '' }}">
			<label for="shortDescription">Brief description</label>
			<textarea id="shortDescription" name="shortDescription" rows="2" placeholder="e.g. The project is a web page for personal financial organization">{{ old('shortDescription') }}</textarea>
		</div>
		<!-- Long description -->
		<div class="field {{ $errors->has('longDescription') ? 'error': '' }}">
			<label for="longDescription">Detailed description</label>
			<textarea id="longDescription" name="longDescription" placeholder="e.g. The project consists of a single page application where users can sign up or login. It includes...">{{ old('longDescription') }}</textarea>
		</div>
		<!-- Pitch video -->
		<div class="field {{ $errors->has('videoPitch') ? 'error': '' }}">
			<label for="videoPitch">Pitch video</label>
			<input type="text" id="videoPitch" name="videoPitch"  value="{{ old('videoPitch') }}" placeholder="e.g. https://youtube.com/watch?v=238028302">
		</div>
		<!-- Register button -->
		<button id="registerButton" type="button" class="ui primary submit button">Register project</button>
		<!-- Error message -->
		<div class="ui error message">
			<div class="header">Whoops! Something went wrong.</div>
			@if($errors->any())
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			@endif
		</div>
	</form>
</div>
@section('scripts')
<script>
	/* Upload new image */
	$(".imgUploader").click(function(event) {
		event.preventDefault();
		$("#projectImage").click();
	});

	function fillDummy() {
		$('input[name=projectName]').val('Some project title');
		$("select[name=courses]").val('1');
		$('input[name=newTeam]').val('Some team name');
		let labels = $("#labels option").slice(1,4).toArray().map(t => t.value);
		$('#labels').dropdown('set selected', labels);
		let skillsets = $('#skillsets option').slice(1,5).toArray().map(t => t.value);
		$('#skillsets').dropdown('set selected', skillsets);
		$('input[name=milestone]').val('Some milestone');
		$('textarea[name=shortDescription]').val('This is the short description');
		$('textarea[name=longDescription]').val('This is the long description');
		$('input[name=videoPitch]').val('https://www.youtube.com/watch?v=QsaNaZy3SSA');
	}

	function updateImage(imageInput) {
		const reader = new FileReader();

		const file = imageInput.files[0];
		const maxImageSize = 1024 * 1024 * 1; // 1MiB

		// validate file
		if (!file || !isValidImage(file, maxImageSize)) {
			alert("Please upload a .png or .jpeg file. Maximum size: 1MiB.");
			return false;
		}

		// update preview when completed successfully
		reader.addEventListener("load", function () {
			$("#projectImagePreview").attr("src", reader.result);
		});
		reader.readAsDataURL(file);
	}

	/* Team association */
	function createNewTeam() {
		$(".associatedTeam").removeClass("error");
		$("#existingTeam").dropdown("clear");
	}

	function selectTeam() {
		$(".associatedTeam").removeClass("error");
		$("#newTeam").val("");
	}

	/* Responsiveness not handled by Semantic */
	function setResponsiveProperties(mobile) {
		$(".ui.divider").hide();
		if (mobile.matches) { // If media query matches
			$(".ui.horizontal.divider").show();
			$(".responsive-segment").addClass("row").removeClass("column");

		}
		else {
			$(".ui.vertical.divider").show();
			$(".responsive-segment").addClass("column").removeClass("row");
		}
	}

	let mobile = window.matchMedia("(max-width: 767px)");
	setResponsiveProperties(mobile);
	mobile.addListener(setResponsiveProperties);

	/* Semantic dropdown set up  */
	$('.ui.dropdown').dropdown({ clearable: true });

	/* Form validation */
	$.fn.form.settings.rules.associatedTeam = function() {
		return ($("#newTeam").val() != "" || $("#existingTeam").val() != "");
	};

	$('.ui.form').form({
		fields: {
			projectName: {
				identifier:'projectName',
				rules:[{
					type: 'empty'
				}]
			},
			existingTeam: {
				identifier: 'existingTeam',
				rules: [{
					type: 'associatedTeam',
					prompt: 'Project must be associated with a team.'
				}]
			},
			newTeam: {
				identifier: 'newTeam',
				rules: [{
					type: 'maxLength[30]',
					prompt: 'Team name cannot be longer than 30 characters.'
				},
				{
					type: 'associatedTeam',
					prompt: function(){
						// we only show team-association prompt once
						return '';
					}
				}]
			},
			courses: {
				identifier: 'courses',
				rules: [{
					type: 'minCount[1]'
				}]
			},
			label: {
				identifier: 'labels[]',
				rules: [{
					type: 'minCount[1]',
				}]
			},
			skillsets: {
				identifier: 'skillsets[]',
				rules: [{
					type: 'minCount[1]',
				}]
			},
			milestone: {
				identifier: 'milestone',
				rules: [{
					type: 'empty',
				}]
			},
			shortDescription: {
				identifier: 'shortDescription',
				rules: [{
						type: 'empty'
					},
					{
						type: 'maxLength[280]'
				}]
			},
			longDescription: {
				identifier: 'longDescription',
				rules: [{
					type: 'empty'
				}]
			},
			videoPitch: {
				identifier: 'videoPitch',
				rules:[
					{
						type: 'regExp',
						value: '/^((http(s)?:\\/\\/)?)(www\\.)?((youtube\\.com\\/)|(youtu.be\\/))[\\S]+$/',
						prompt: 'Pitch video must be a valid YouTube URL.'
					}
				]
			}
		},
		onFailure:function() {
			console.log('failed registration');
			return false;
		},
		onSuccess:function() {
		}
	});
	// TODO: Associated Team Validation
	@if(old('labels') !== null)
		let labels = '{!! json_encode(old("labels")) !!}';
		labels = JSON.parse(labels);
		$('#labels').dropdown('set selected', labels);
	@endif

	@if(old('skillsets') !== null)
		let skillsets = '{!! json_encode(old("skillsets")) !!}';
		skillsets = JSON.parse(skillsets);
		$('#skillsets').dropdown('set selected', skillsets);
	@endif
</script>
@endsection
@endsection
