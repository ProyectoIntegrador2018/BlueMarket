@extends('layouts.app')

@section('title', 'Add Project')

@section('content')

@section('header', 'Register a new project')
<style>
	#or {
		text-align: center;
		color: #C7C7C7;
	}

	.imgUploader {
		margin-bottom: 20px;
	}

</style>
<div class="padded content">
	<form class="ui form {{ $errors->any() ? 'error': '' }}" method="POST" action="/projects">
		@csrf
		<!-- Project Image -->
		<div class="projectImage field {{ $errors->has('projectImage') ? 'error': '' }}">
			<label for="projectImage">Project Image</label>
			<div class="projectImageUploaderContainer">
				<div class="imgUploader" class="imagePreviewContainer">
					<img src="https://lorempixel.com/400/400" alt="Project Image" class="ui medium image" id="projectImagePreview"/>
				</div>
				<button class="imgUploader upload-image-button ui button primary" type="button" href="#">Upload Image</button>
			</div>
			<input id="imgInput" name="projectImage" type="file" style="display:none" accept="image/x-png,image/jpeg,image/png" onchange="updateImage(this)">
		</div>
		<!-- Project Name -->
		<div class="field {{ $errors->has('projectName') ? 'error': '' }}">
			<label for="projectName">Project Name</label>
			<input type="text" name="projectName" placeholder="e.g. Best Project">
		</div>
		<!-- Associated Course -->
		<div class="field {{ $errors->has('courses') ? 'error': '' }}">
			<label for="courses">Associated Course</label>
			<select name="courses" class="ui search dropdown">
				<option value="">e.g. Web Development Class</option>
				@if(isset($courses))
					@foreach($courses->all() as $course)
						<option value={{ $course->id }}>{{ $course->name }}</option>
					@endforeach
				@endif
			</select>
		</div>
		<!-- Labels -->
		<div class="field {{ $errors->has('label') ? 'error': '' }}">
			<label for="label">Labels</label>
			<select name="label" multiple class="ui search dropdown">
				<option value="">e.g. Finance</option>
				@if(isset($labels))
					@foreach($labels -> all() as $label)
						<option value={{ $label->id }}>{{ $label->name }}</option>
					@endforeach
				@endif
			</select>
		</div>
		<!-- Skillset -->
		<div class="field {{ $errors->has('skillsets') ? 'error': '' }}">
			<label for="skillsets">Skillsets</label>
			<select name="skillsets" multiple class="ui fluid dropdown">
				<option value="">e.g. Java, HTML</option>
				@if(isset($skillsets))
					@foreach($skillsets->all() as $skillset)
						<option value={{ $skillset->id }}>{{ $skillset->name }}</option>
					@endforeach
				@endif
			</select>
		</div>
		<!-- Milestone -->
		<div class="field {{ $errors->has('milestone') ? 'error': '' }}">
			<label for="milestone">sPublic Milestone</label>
			<input type="text" name="milestone" placeholder="e.g. Design">
		</div>
		<!-- Short Description -->
		<div class="field {{ $errors->has('shortDescription') ? 'error': '' }}">
			<label for="shortDescription">Brief Description</label>
			<textarea name="shortDescription" rows="2" placeholder="e.g. The project is a web page for personal financial organization"></textarea>
		</div>
		<!-- Long Description -->
		<div class="field {{ $errors->has('longDescription') ? 'error': '' }}">
			<label for="longDescription">Detailed Description</label>
			<textarea name="longDescription" placeholder="e.g. The project consists of a single page application where users can sign up or login. It includes..."></textarea>
		</div>
		<!-- Video Pitch -->
		<div class="field {{ $errors->has('videoPitch') ? 'error': '' }}">
			<label for="videoPitch">Pitch Video</label>
			<input type="text" name="videoPitch" placeholder="e.g. https://youtube.com/watch?v=238028302">
		</div>
		<!-- Register Button -->
		<button id="registerButton" type="submit" class="ui primary submit button">Register Project</button>
		<!-- Error Message -->
		<div class="ui error message"></div>
	</form>
</div>
@section('scripts')
<script>
	/* Upload new image */
	$(".imgUploader").click(function(event) {
		event.preventDefault();
		$("#imgInput").click();
	});
	function validateImage(file) {
		const maxImageSize=1000000; // 1MB
		if((file.type == "image/png" || file.type == "image/jpg") && file.size <= maxImageSize) {
			return true;
		}
		else {
			return false;
		}
	}
	function updateImage(imageInput) {
		let reader = new FileReader();
		let file = imageInput.files[0];
		let preview = $("#projectImagePreview");
		reader.addEventListener("load", function() {
			if(validateImage(file)) {
				$("#projectImagePreview").attr("src", reader.result);
			}
		});
		if(file) {
			reader.readAsDataURL(file);
		}
	}
	/* Register button validation */
	$('.ui.dropdown').dropdown();
	$('.ui.form').form({
		fields: {
			projectImage: {
				identifier:'projectImage',
				rules:[{
						type:'empty',
						prompt:'Please enter a project image'
					}
				]
			},
			projectName:{
				identifier:'projectName',
				rules:[{
						type:'empty',
						prompt:'Please enter a project name'
					}
				]
			},
			// teamName:{
			// 	identifier:'teamName',
			// 	rules:[{
			// 			type:'empty',
			// 			prompt:'Please select a team name'
			// 		}
			// 	]
			// },
			courses:{
				identifier:'courses',
				rules:[{
						type:'minCount[1]',
						prompt:'Please select an associated course'
					}
				]
			},
			label:{
				identifier:'label',
				rules:[{
						type:'empty',
						prompt:'Please select a label'
					}
				]
			},
			skillsets:{
				identifier:'skillsets',
				rules:[{
						type:'minCount[1]',
						prompt:'Please select at least one skillset'
					}
				]
			},
			milestone:{
				identifier:'milestone',
				rules:[{
						type:'empty',
						prompt:'Please enter current milestone'
					}
				]
			},
			shortDescription:{
				identifier:'shortDescription',
				rules:[{
						type:'empty',
						prompt:'Please enter a brief project description'
					}
				]
			},
			longDescription:{
				identifier:'longDescription',
				rules:[{
						type:'empty',
						prompt:'Please enter a detailed project description'
					}
				]
			},
			videoPitch:{
				identifier:'videoPitch',
				rules:[{
						type:'empty',
						prompt:'Please enter a link to pitch video'
					},
					{
						type:'regExp',
						value:'/^((http(s)?:\\/\\/)?)(www\\.)?((youtube\\.com\\/)|(youtu.be\\/))[\\S]+$/',
						prompt:'Please enter a valid youtube url'
					}
				]
			}
		},
		onFailure:function() {
			return false;
		},
		onSuccess:function() {
		}
	});
	/* Associated Team Validation */


</script>
@endsection
@endsection
