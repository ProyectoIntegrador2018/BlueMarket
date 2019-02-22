@extends('layouts.app')

@section('title', 'Add Project')

@section('content')
<!-- Internal CSS stylesheet -->
<style>
	#uploadImage{
		margin-top: 1em;
		margin-bottom: 2em;
	}

	.hidden{
		display: none;
	}
</style>
<div class="ui container" style="margin: 4% auto 8%">
	<div class="ui grid centered">
		<div class="ten wide column">
			<div class="ui form error">
				<!-- Alert Message -->
				<div id="errorMessage" class="ui error message hidden">
					<div class="header">Incomplete Information</div>
					<p>All fields are required for registering a new project.</p>
				</div>
				<!-- Project Image -->
				<div class="projectImg">
					<img src="https://lorempixel.com/400/400" alt="Project Image" class="ui centered medium circular image"/>
					<a href="#" class="imgUploader">
						<button id="uploadImage" class="fluid ui button">Upload Image</button>
					</a>
					<input type="file" id="imgInput" style="display:none" multiple accept='image/*'>
				</div>
				<!-- Project Name -->
				<div id ="projectName" class="field">
					<label for="proyectName">Project Name</label>
					<input type="text" name="projectName" placeholder="Enter your project's name...">
				</div>
				<!-- Team Name -->
				<div id="teamName" class="field">
					<label for="teamName">Team Name</label>
					<input type="text" name="teamName" placeholder="Enter your team's name...">
				</div>
				<!-- Category -->
					<!-- <div id="category" class="field">
						<label>Category</label>
						<div class="ui fluid search selection dropdown category">
							<i class="dropdown icon"></i>
							<input id ="category" type="hidden" name="country">
							<div class="default text">Select a category of your project</div>
							<div class="menu">
								<div class="item" value="1">Category 1</div>
								<div class="item" value="2">Category 2</div>
								<div class="item" value="3">Category 3</div>
								<div class="item" value="4">Category 4</div>
							</div>
						</div>
					</div> -->
				<div id ="category" class="field">
					<label for="category">Category</label>
					<select name="category" class="ui search dropdown" placeholder="Select your project's category">
						<option style="color:grey;" value="0">Select your project's category</option>
						<option value="1">Category 1</option>
						<option value="2">Category 2</option>
						<option value="3">Category 3</option>
					</select>
				</div>
				<!-- Skillset -->
				<div id="skillsets" class="field">
					<label for="skillsets">Required Skillsets</label>
					<div class="ui search">
						<div class="ui icon input">
							<input name="skillsets" class="prompt" type="text" placeholder="Search and add skillsets...">
							<i class="search icon"></i>
						</div>
						<div class="results">
						</div>
					</div>
				</div>
				<!-- Milestones -->
				<div id="milestones" class="field">
					<label for="milestones">Public Milestones</label>
					<input type="text" name="milestones" placeholder="e.g. Shipping">
				</div>
				<!-- Short Description -->
				<div id="shortDescription" class="field">
					<label>Brief Description</label>
					<textarea rows="2"></textarea>
				</div>
				<!-- Long Description -->
				<div id="longDescription" class="field">
					<label>Detailed Description</label>
					<textarea></textarea>
				</div>
				<!-- Video Pitch -->
				<div id="videoPitch" class="field">
					<label>Video pitch</label>
					<input type="text" name="milestones" placeholder="Example: https://youtube.com/watch?v=238028302">
				</div>
				<!-- Register Button -->
				<button id="registerProject" class="ui right floated button">Register project</button>
			</div>
		</div>
	</div>
</div>

@section('jquery')
<!-- Internal jQuery -->
<script>
	/* Search for Skillsets */
	var skillsets = [
		{ title: 'Skillset 1' },
		{ title: 'Skillset 2' },
		{ title: 'Skillset 3' },
		{ title: 'Skillset 4' },
		{ title: 'Skillset 5' },
	];
	$('.ui.search').search({source: skillsets});
	$('.ui.search.category.dropdown').dropdown({useLabels: false});
	$('.imgUploader').click(function(event) {
		event.preventDefault();
		$('#imgInput').click();
	});

	/*
	 Uploading Image function:
	function readURL(input) {
		  if (input.files && input.files[0]) {
			  var reader = new FileReader();

			  reader.onload = function (e) {
				  $('#blah').attr('src', e.target.result);
			  }

			  reader.readAsDataURL(input.files[0]);
		  }
	  }
	  $("#imgInp").change(function(){
			  readURL(this);
	   });

	  HTML for funtcion above:
	  <form id="form1" runat="server">
			<input type='file' id="imgInp" />
			<img id="blah" src="#" alt="your image" />
		</form>

		HTML AHORITA:
		<div class="projectImg">
			<img src="https://lorempixel.com/400/400" alt="Project Image" class="ui centered medium circular image"/>
			<a href="#" class="imgUploader">
				<button id="uploadImage" class="fluid ui button">Upload Image</button>
			</a>
			<input type="file" id="imgInput" style="display:none" multiple accept='image/*'>
		</div>
	  */


	/* Register Button Click */
	$('#registerProject').on('click', function(event){
		//event.preventDefault();
		//Alert Message
		let $errorMessage = $('#errorMessage');

		// Project Name
		let $projectName = $('#projectName');
		if($projectName.val() == ""){
			$projectName.addClass('field error');
			$errorMessage.removeClass('hidden');
		}

		// Team Name
		let $teamName = $('#teamName');
		if($teamName.val() == ""){
			$teamName.addClass('field error');
			$errorMessage.removeClass('hidden');
		}

		// Category Dropdown
		let $category = $('category');
		if($category.val() == 0){
			$category.addClass('field error');
			$errorMessage.removeClass('hidden');
		}

		// Skillsets

		// Public Milestones
		let $milestones = $('#milestones');
		if($milestones.val() == ""){
			$milestones.addClass('field error');
			$errorMessage.removeClass('hidden');
		}

		// Short Description
		let $shortDescription = $('#shortDescription');
		if($shortDescription.val() == ""){
			$shortDescription.addClass('field error');
			$errorMessage.removeClass('hidden');
		}

		// Long Description
		let $longDescription = $('#longDescription');
		if($longDescription.val() == ""){
			$longDescription.addClass('field error');
			$errorMessage.removeClass('hidden');
		}

		// Video Pitch
		let $videoPitch = $('#videoPitch');
		if($videoPitch.val() == ""){
			$videoPitch.addClass('field error');
			$errorMessage.removeClass('hidden');
		}
	});
</script>
@endsection
@endsection
