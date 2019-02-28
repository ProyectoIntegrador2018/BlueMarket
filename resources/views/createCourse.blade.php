
@extends('layouts.app')

@section('title', 'Register a course')

@section('content')
@section('header', 'Register a course')
<div class="padded content">
	<div class="ui form error">
		<!-- Course name -->
		<div id="courseName" class="field">
			<label for="courseName">Course name</label>
			<input type="text" name="courseName" required>
		</div>
		<!-- Professor -->
		<div id="professors" class="field">
			<label for="professors">Professor(s)</label>
			<select class="ui fluid search dropdown" name="professors" multiple="">
				<option value="1">Mr. Monday</option>
				<option value="2">Mrs. Tuesday</option>
				<option value="3">Ms. Wednesday</option>
				<option value="4">Mr. Thursday</option>
				<option value="5">Mrs. Friday</option>
			</select>
		</div>
		<!-- Course semester -->
		<div id="courseSemester" class="field">
			<label for="courseSemester">Course semester</label>
			<input type="text" name="courseSemester" placeholder="Spring/Fall/Summer/Winter and year Ex. Fall 2018" required>
		</div>
		<!-- Course type -->
		<!-- 1-client, 2-supplier-->
		<div id="courseType" class="field">
			<label for="courseType">Course type</label>
			<select name="courseType" required>
				<option value="1">Client</option>
				<option value="2">Supplier</option>
			</select>
		</div>
		<!-- Course schedule -->
		<div id="courseSchedule" class="field">
			<label for="couseSchedule">Course schedule</label>
			<select name="courseType" multiple required>
				<option value="monday">Monday</option>
				<option value="tuesday">Tuesday</option>
				<option value="wednesday">Wednesday</option>
				<option value="thusday">Thursday</option>
				<option value="friday">Friday</option>
				<option value="saturday">Saturday</option>
			</select>
		</div>
		<!-- Course hours -->
		<div id="courseHours" class="field">
			<label for="courseHours">Starting time</label>
			<input type="time" name="hoursBeg" min="7:00" max="18:00" required>
		</div>
		<!-- Teams of -->
		<div id="teamsOf" class="field">
			<label for="teamsOf">Teams of</label>
			<input type="number" name="teamsOf" min="1" required>
		</div>
		<!-- Affiliated courses -->
		<div id="affiliatedCourses" class="field">
			<label for="affiliatedCourses">Affiliated courses</label>
			<select class="ui fluid search dropdown" multiple="">
				<option value="1">Random</option>
				<option value="2">Courses</option>
				<option value="3">To Affiliate</option>
				<option value="4">With</option>
			</select>
		</div>
		<!-- Error message -->
		<div id="errorMessage" class="ui error hidden message">
			<div class="header">Whoops! Something went wrong.</div>
			<p>Please make sure to properly fill out all required fields.</p>
		</div>
		<!-- Register button -->
		<button id="registerCourse" class="ui button primary">Register</button>
	</div>
</div>

@endsection

@section('scripts')
<script>
	$('.ui.fluid.search.dropdown')
		  .dropdown();


</script>
@endsection
