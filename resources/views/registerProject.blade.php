<!--
	*** NO BORRAR COMENTARIOS HASTA QUE QUEDE LISTO LO QUE FALTA EN ESTE VIEW ***

	Falta:
		1. Validar que imagen no pase de 1MB (ya está el código pero estoy teniendo problema para que funcione.)
		2. Que se puedan seleccionar más de un associated course.
		3. Textarea semantic validation (short & long descriptions)
		4. Image semantic validation
		5. Image upload is not working now
		6. Register Project button is not inside form
-->

@extends('layouts.app')

@section('title', 'Add Project')

@section('content')

@section('header', 'Register a new project')

<div class="ui container" style="margin: 4% auto 8%">
	<div class="ui grid centered">
		<div class="ten wide column">
			<form class="ui form error segment" method="POST" action="/projects">
				@csrf
				{{--
				<div id="errorMessage" class="ui error message hidden">
					<div class="header">Register Error</div>
					<p>All fields are required for registering a new project.</p>
				</div> --}}
				<!-- Project Image input -->
				<div class="projectImg">
					<label for="projectImg">Project Image</label>
					<div id="errorMessage" class="ui error message hidden">
						<div class="header">Image Error</div>
						{{-- <p>The image should not exceed 1 MB.</p> --}}
					</div>
					<img src="https://lorempixel.com/400/400" alt="Project Image" class="ui medium image"  id="userImagePreview" />
					<a href="#" class="imgUploader">
						<button id="uploadImage" class="ui left floated button primary">Upload Image</button>
					</a>
					<input name="projectImg" type="file" id="imgInput" style="display:none" multiple accept='image/*'>
				</div>
				<!-- Project Name input -->
				<div id ="projectName" class="field">
					<label for="proyectName">Project Name</label>
					<input type="text" name="projectName" placeholder="Enter your project's name...">
				</div>
				<!-- Team Name input-->
				<div id="teamName" class="field">
					<label for="teamName">Team Name</label>
					<input type="text" name="teamName" placeholder="Enter your team's name...">
				</div>
				<!-- Associated Courses dropdown-->
				<div id ="courses" class="field">
					<label for="courses">Associated Courses</label>
					<select name="courses" multiple="" class="ui search dropdown" placeholder="Select associated courses to this project...">
						<option value="">Select associated courses to this project...</option>
						@if(isset($courses))
							@foreach($courses->all() as $course)
								<option value={{ $course['id'] }}>
								{{ $course['name'] }} </option>
							@endforeach
						@endif
					</select>
				</div>
				<!-- Category dropdown-->
				<div id ="category" class="field">
					<label for="category">Category</label>
					<select name="category" class="ui search dropdown" placeholder="Select your project's category...">
						<option value="">Select your project's category...</option>
						@if(isset($categories))
							@foreach($categories->all() as $category)
								<option value={{ $category['id'] }}>
								{{ $category['name'] }} </option>
							@endforeach
						@endif
					</select>
				</div>
				<!-- Skillset search-->
				<div id="skillsets" class="field">
				    <label for="skillsets">Skillsets</label>
				    <select name="skillsets" multiple="" class="ui fluid dropdown">
					    <option value="">Search and add skillsets...</option>
					    @if(isset($skillsets))
					    	@foreach($skillsets->all() as $skillset)
					    		<option value={{ $skillset['id'] }}>
					    		{{ $skillset['name'] }} </option>
					    	@endforeach
					    @endif
				    </select>
				  </div>
				{{-- <div id="skillsets" class="field">
					<label for="skillsets">Required Skillsets</label>
					<div class="ui search">
						<div class="ui icon input">
							<input name="skillsets" class="prompt" type="text" placeholder="Search and add skillsets...">
							<i class="search icon"></i>
						</div>
						<div class="results">
						</div>
					</div>
				</div> --}}
				<!-- Milestones input-->
				<div id="milestones" class="field">
					<label for="milestones">Public Milestones</label>
					<input type="text" name="milestones" placeholder="Example: Shipping">
				</div>
				<!-- Short Description textarea-->
				<div id="shortDescription" class="field">
					<label>Brief Description</label>
					<textarea rows="2"></textarea>
				</div>
				<!-- Long Description textarea-->
				<div id="longDescription" class="field">
					<label>Detailed Description</label>
					<textarea></textarea>
				</div>
				<!-- Video Pitch input-->
				<div id="videoPitch" class="field">
					<label for="videoPitch">Pitch Video</label>
					<input type="text" name="videoPitch" placeholder="Example: https://youtube.com/watch?v=238028302">
				</div>
				<!-- Register Button -->
				{{-- <button type="submit" id="registerProject" class="ui left floated button primary">Register project</button> --}}
				<button id="registerButton" type="submit" class="ui left floated primary submit button">Register Project</button>
				<!-- Error Message -->
				<div class="ui error message"></div>
			</form>
		</div>
	</div>
</div>

@section('jquery')
<script>
	// /* Search for skillsets */
	// var skillsets = [
	// 	{ title: 'Skillset 1' },
	// 	{ title: 'Skillset 2' },
	// 	{ title: 'Skillset 3' },
	// 	{ title: 'Skillset 4' },
	// 	{ title: 'Skillset 5' },
	// ];
	// $('.ui.search').search({source: skillsets});
	// $('.ui.search.category.dropdown').dropdown({useLabels: false});
	// $('.imgUploader').click(function(event) {
	// 	event.preventDefault();
	// 	$('#imgInput').click();
	// });

	/* Upload new image */
	function readURL(input){
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#userImagePreview').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imgInput").change(function(){
	    readURL(this);
	});

	/* Register button click */
	// $('#registerButton').on('click', function(event){
	// 	event.preventDefault();
		$('.ui.form')
		  	.form({
		    	fields: {
		    		//project image
		     		projectName: {
		        		identifier: 'projectName',
		        		rules: [
		          			{
		            			type   : 'empty',
		            			prompt : 'Please enter a project name'
		          			}
		        		]
		      		},
		      		teamName: {
		        		identifier: 'teamName',
		        		rules: [
		          			{
					            type   : 'empty',
					            prompt : 'Please enter a team name'
		          			}
		        		]
		      		},
		      		courses: {
			      		identifier: 'courses',
			      		rules: [
		      		    	{
			      		    	type   : 'minCount[1]',
			      		      	prompt : 'Please select at least one associated course'
		      		    	}
		      		  	]
		      		},
		      		category: {
			      		identifier: 'category',
			      		rules: [
		      		    	{
			      		    	type   : 'empty',
			      		      	prompt : 'Please select a category'
		      		    	}
		      		  	]
		      		},
		      		skillsets: {
		      			identifier: 'skillsets',
		        		rules: [
		        			{
					            type   : 'minCount[1]',
					            prompt : 'Please select at least one skillset required'
		          			}
		        		]
		      		},
		      		milestones: {
				        identifier: 'milestones',
				        rules: [
		          			{
					        	type   : 'empty',
					            prompt : 'Please enter current milestone'
		          			}
		        		]
		      		},
				    //short description semantic validation
				    //long description semantic validation
				    videoPitch: {
				        identifier: 'videoPitch',
				        rules: [
		          			{
					            type   : 'empty',
					            prompt : 'Please enter link to pitch video'
		          			}
		        		]
		      		},
		    	}
		  	})
		;
		// //Alert Message
		// let $errorMessage = $('#errorMessage');
		// // Image
		// /*let $fileSize = $('#imgInput')[0].files[0].size;
		// if($fileSize > 300){//1000000){
		// 	$errorMessage.removeClass('hidden');
		// 	//return false;
		// }*/
		// // Project Name
		// let $projectName = $('#projectName');
		// let $projectName2 = $('#projectName2');
		// if($projectName2.val() == ""){
		// 	$projectName.addClass('field error');
		// 	$errorMessage.removeClass('hidden');
		// 	$("html, body").animate({scrollTop: 0}, "slow");
		// }
		// // Team Name
		// let $teamName = $('#teamName');
		// let $teamName2 = $('#teamName2');
		// if($teamName2.val() == ""){
		// 	$teamName.addClass('field error');
		// 	$errorMessage.removeClass('hidden');
		// 	$("html, body").animate({scrollTop: 0}, "slow");
		// }
		// // Associated Courses
		// let $courses = $("#courses");
		// let $courses2 = $('#courses2');
		// if($courses2.val() == '0'){
		// 	$courses.addClass('field error');
		// 	$errorMessage.removeClass('hidden');
		// 	$("html, body").animate({scrollTop: 0}, "slow");
		// }
		// // Category Dropdown
		// let $category = $("#category");
		// let $category2 = $('#category2');
		// if($category2.val() == '0'){
		// 	$category.addClass('field error');
		// 	$errorMessage.removeClass('hidden');
		// 	$("html, body").animate({scrollTop: 0}, "slow");
		// }
		// // Skillsets
		// let $skillsets = $('#skillsets');
		// let $skillsets2 = $('#skillsets2');
		// if($skillsets2.val() == ""){
		// 	$skillsets.addClass('field error');
		// 	$errorMessage.removeClass('hidden');
		// 	$("html, body").animate({scrollTop: 0}, "slow");
		// }
		// // Public Milestones
		// let $milestones = $('#milestones');
		// let $milestones2 = $('#milestones2');
		// if($milestones2.val() == ""){
		// 	$milestones.addClass('field error');
		// 	$errorMessage.removeClass('hidden');
		// 	$("html, body").animate({scrollTop: 0}, "slow");
		// }
		// // Short Description
		// let $shortDescription = $('#shortDescription');
		// let $shortDescription2 = $('#shortDescription2');
		// if($shortDescription2.val() == ""){
		// 	$shortDescription.addClass('field error');
		// 	$errorMessage.removeClass('hidden');
		// 	$("html, body").animate({scrollTop: 0}, "slow");
		// }
		// // Long Description
		// let $longDescription = $('#longDescription');
		// let $longDescription2 = $('#longDescription2');
		// if($longDescription2.val() == ""){
		// 	$longDescription.addClass('field error');
		// 	$errorMessage.removeClass('hidden');
		// 	$("html, body").animate({scrollTop: 0}, "slow");
		// }
		// // Pitch Video
		// let $videoPitch = $('#videoPitch');
		// let $videoPitch2 = $('#videoPitch2');
		// if($videoPitch2.val() == ""){
		// 	$videoPitch.addClass('field error');
		// 	$errorMessage.removeClass('hidden');
		// 	$("html, body").animate({scrollTop: 0}, "slow");
		// }
	//});
</script>
@endsection
@endsection
