
@extends('layouts.app')

@section('title', 'Register a course')

@section('content')
@section('header', 'Register a course')
<div class="ui form">
	<!-- Course name -->
	<div id="courseName">
		<label for="courseName">Course name</label>
		<input type="text" name="courseName" required>
	</div>
	<!-- Professor name: value should be replaced with professor's name -->
	<div id="professorName">
		<label for="professorName">Professor name</label>
		<input type="text" name="professorName" value="" required>
	</div>
	<!-- Course type -->
	<div id="courseType">
		<label for="courseType">Course type</label>
		<select name="courseType" required>
			<option value="client">Client</option>
			<option value="supplier">Supplier</option>
		</select>
	</div>
	<!-- Course schedule -->
	<div id="courseSchedule">
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
	<div id="courseHours">
		<label for="courseHours">Hours</label>
		<input type="time" name="hoursBeg" min="7:00" max="18:00" required>
		<input type="time" name="hoursEnd" min="7:00" max="18:00" required>
	</div>
	<!-- Number of students -->
	<div id="numberStudents">
		<label for="numberStudents">Number of students</label>
		<input type="number" name="numberStudents" min="1" required>
	</div>
	<!-- Teams of -->
	<div id="teamsOf">
		<label for="teamsOf">
			<input type="number" name="minStudents" min="1" required>
			<input type="number" name="maxStudents" required>
		</label>
	</div>
	<!-- Affiliated courses -->
	<div id="affiliatedCourses">
		<label for="affiliatedCourses">Affiliated courses</label>
		<input type="number" name="affiliatedCourses" required>
	</div>
	<!-- Error message -->
	<div id="errorMessage" class="ui error message">
		<div class="header">Whoops! Something went wrong.</div>
		<p>Please make sure to properly fill out all required fields.</p>
	</div>
	<!-- Register button -->
	<button id="registerCourse" class="ui button primary">Register</button>

</div>

@endsection
