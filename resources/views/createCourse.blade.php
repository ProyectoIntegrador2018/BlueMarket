
@extends('layouts.app')

@section('title', 'Register a course')

@section('content')
<div class="padded content">
	<h1>Register a course</h1>
	<form class="ui form error" method="POST" action="/courses">
		@csrf
		<!-- Course name -->
		<div class="field">
			<label for="courseName">Course name</label>
			<input type="text" name="courseName" id="courseName" required>
		</div>
		<!-- Teachers -->
		<div class="field">
			<label for="teachers">Teacher(s)</label>
			<select class="ui fluid search dropdown" name="teachers" id="teachers" multiple required>
				<option value="1">Mr. Monday</option>
				<option value="2">Mrs. Tuesday</option>
				<option value="3">Ms. Wednesday</option>
				<option value="4">Mr. Thursday</option>
				<option value="5">Mrs. Friday</option>
			</select>
		</div>
		<!-- Course semester -->
		<div class="field">
			<label for="courseSemester">Course semester</label>
			<input type="text" name="courseSemester" id="courseSemester" placeholder="Spring/Fall/Summer/Winter and year Ex. Fall 2018" required>
		</div>
		<!-- Course type -->
		<!-- 1-client, 2-supplier-->
		<div class="field">
			<label for="courseType">Course type</label>
			<select class="ui fluid search dropdown" name="courseType" id="courseType" required>
				<option value=""></option>
				<option value="1">Client</option>
				<option value="2">Supplier</option>
			</select>
		</div>
		<!-- Course schedule -->
		<div class="field">
			<label for="couseSchedule">Course schedule</label>
			<select class="ui fluid search dropdown" name="courseType" id="courseSchedule" multiple required>
				<option value="monday">Monday</option>
				<option value="tuesday">Tuesday</option>
				<option value="wednesday">Wednesday</option>
				<option value="thusday">Thursday</option>
				<option value="friday">Friday</option>
				<option value="saturday">Saturday</option>
			</select>
		</div>
		<!-- Course hours -->
		<div class="field">
			<label for="courseHours">Starting time</label>
			<input type="time" name="courseHours" id="courseHours" required>
		</div>
		<!-- Teams of -->
		<div class="field">
			<label for="teamsOf">Teams of</label>
			<input type="text" name="teamsOf" id="teamsOf" min="1" required>
		</div>
		<!-- Affiliated courses -->
		<div class="field">
			<label for="affiliatedCourses">Affiliated courses</label>
			<select class="ui fluid search dropdown" name="affiliatedCourses" id="affiliatedCourses" multiple>
				<option value="1">Random</option>
				<option value="2">Courses</option>
				<option value="3">To Affiliate</option>
				<option value="4">With</option>
			</select>
		</div>
		<!-- Error message -->
		<div id="error" class="ui error hidden message">
			<div class="header">Whoops! Something went wrong.</div>
			<p>Please make sure to properly fill out all required fields.</p>
		</div>
		<!-- Register button -->
		<button id="send" type="submit" class="ui button primary">Register</button>
	</form>
</div>

@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
<script>

	$(document).ready(function(){
		$('.ui.fluid.search.dropdown').dropdown();
		// Initial class set up
		$(".ui.form").removeClass("error");
		$(".field.input").removeClass("error");
		$("#success").addClass("hidden");

		var CSRF_TOKEN = $( 'meta[name="csrf-token"]' ).attr("content");

		$("#send").click(function(e){
			e.preventDefault();

			if(validateForm()){
				console.log("Successful form.");
				// Validation was successful
				$("form").submit();
			} else {
				console.log("Unsuccessful form.");
				// There are input errors
				$(".ui.form").addClass("error");
				$(".field.input").addClass("error");
			}

			// Dedided that we are not going to make an ajax call here
			// $.ajax({
			// 	url: '/courses',
			// 	type: 'POST',
			// 	data: {
			// 		_token: CSRF_TOKEN,
			// 		courseName: $("input#courseName").val(),
			// 		courseType: $("input#courseType").val(),
			// 		teamsOf: $("input#teamsOf").val(),
			// 		teachers: $("input#teachers").val(),
			// 		courseSemester: $("input#courseSemester").val(),
			// 		courseSchedule: $("input#courseSchedule").val(),
			// 		courseHours: $("input#courseHours").val()
			// 	},
			// 	dataType: 'JSON',
			// 	success: function(data) {
			// 		console.log(data);
			// 		if(data.status == "success") {
			// 			$(".ui.form").removeClass("error");
			// 			$(".field.input").removeClass("error");
			// 			$("#success").removeClass("hidden");

			// 			$("span#courseKey").val(data.courseKey);
			// 		} else {
			// 			// Error
			// 			$("#error").addClass("hidden");
			// 		}
			// 	},
			// 	error: function(data) {
			// 		console.log(data);
			// 		var json = data;

			// 	}
			// })
		});
	})

	function validateForm(){
		return validateText("courseName") && validateSelector("teachers") && validateText("courseSemester") && validateSelector("courseType") && validateSelector("courseType") && validateText("courseHours") && validateNumber("teamsOf") && validateSelector("affiliatedCourses");
	}

	function validateText(id){
		if($("input#" + id).val()){
			console.log("Text " + id + " valid.");
			return true;
		} else {
			console.log("Text " + id + " invalid.");
			return false;
		}
	}

	function validateSelector(id){
		console.log($("select#" + id).val().length);
		if($("select#" + id).val().length){
			console.log("Select " + id + " valid.");
			return true;
		} else {
			console.log("Select " + id + " invalid.");
			return false;
		}
	}

	function validateNumber(id){
		if($("input#" + id).val() > 0){
			console.log("Number " + id + " valid.");
			return true;
		} else {
			console.log("Number " + id + " invalid.");
			return false;
		}
	}
</script>
