
@extends('layouts.app')

@section('title', 'Register a course')

@section('content')
<div class="padded content">
	<h1>Register a course</h1>
	<form class="ui error form" method="POST" action="/courses">
		@csrf
		<!-- Course name -->
		<div class="field">
			<label for="courseName">Course name</label>
			<input type="text" name="courseName" id="courseName" required>
		</div>
		<!-- Teacher(s) -->
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
		<!-- Student team size -->
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

@section('scripts')

<script>

	$(document).ready(function(){
		$('.ui.fluid.search.dropdown').dropdown();

		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

		$("#send").click(function(e){
			e.preventDefault();

			if(validateForm()){
				// Input validation was successful
				console.log("Successful form.");
				$("form").submit();
			} else {
				// There are input errors
				console.log("Unsuccessful form.");
				$(".ui.message").removeClass("hidden");
			}
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
		console.log("Select " + id + " " + $("select#" + id).val().length);
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

@endsection
