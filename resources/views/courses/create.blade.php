
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
		<div class="field" title="Are you giving this course with another teacher?">
			<label for="teachers">Teacher(s)</label>
			<select class="ui fluid search dropdown" name="teachers[]" id="teachers" multiple required>
				@foreach ($teachers as $teacher)
					<option value={{ $teacher['id'] }}> {{ $teacher['name'] }} </option>
				@endforeach
			</select>
		</div>
		<!-- Course semester -->
		<div class="field">
			<label for="courseSemester">Course semester</label>
			<input type="text" name="courseSemester" id="courseSemester" placeholder="Spring/Summer/Fall/Winter and year.  Ex. Fall 2018" title="When is this course taking place?"required>
		</div>
		<!-- Course type -->
		<div class="field" title="A client course is looking to outsource specific tasks. A supplier course is looking for projects to team up with.">
			<label for="courseType">Course type</label>
			<select class="ui fluid search dropdown" name="courseType" id="courseType"  required  onchange="updateAssociatedCourses()">
				<option value=""></option>
				<option value="1">Client</option>
				<option value="2">Supplier</option>
			</select>
		</div>
		<!-- Course schedule -->
		<div class="ui stackable two column grid">
			<div class="column wide field">
				<label for="courseSchedule">Course schedule</label>
				<select class="ui fluid search dropdown" name="courseSchedule[]" id="courseSchedule" multiple required>
					<option value="monday">Monday</option>
					<option value="tuesday">Tuesday</option>
					<option value="wednesday">Wednesday</option>
					<option value="thusday">Thursday</option>
					<option value="friday">Friday</option>
					<option value="saturday">Saturday</option>
				</select>
			</div>
			<!-- Course hours -->
			<div class="column wide field">
				<label for="courseHours">Starting time</label>
				<select class="ui fluid search dropdown" name="courseHours" id="courseHours" required>
					<option value=""></option>
					<option value="7:00">7:00</option>
					<option value="7:30">7:30</option>
					<option value="8:00">8:00</option>
					<option value="8:30">8:30</option>
					<option value="9:00">9:00</option>
					<option value="9:30">9:30</option>
					<option value="10:00">10:00</option>
					<option value="10:30">10:30</option>
					<option value="11:00">11:00</option>
					<option value="11:30">11:30</option>
					<option value="12:00">12:00</option>
					<option value="12:30">12:30</option>
					<option value="13:00">13:00</option>
					<option value="13:30">13:30</option>
					<option value="14:00">14:00</option>
					<option value="14:30">14:30</option>
					<option value="15:00">15:00</option>
					<option value="15:30">15:30</option>
					<option value="16:00">16:00</option>
					<option value="16:30">16:30</option>
					<option value="17:00">17:00</option>
					<option value="17:30">17:30</option>
					<option value="18:00">18:00</option>
				</select>
			</div>
		</div>
		<!-- Student team size -->
		<div class="field">
			<label for="teamSize">Max. team size</label>
			<input type="text" name="teamSize" id="teamSize" title="What is the maximum size of your students' teams?" required>
		</div>
		<!-- Associated courses -->
		<div id="associatedCoursesField" class="field" title="Are you collaborating with other courses?">
			<label for="associatedCourses">Associated courses</label>
			<select class="ui fluid search dropdown" name="associatedCourses[]" id="associatedCourses" multiple>
				@if(isset($courses))
					@foreach($courses->all() as $course)
						<option value={{ $course['id'] }}>
						{{ $course['name'] }} /
						@foreach($course['teachers'] as $teacher)
							{{ $loop->first ? '' : ', ' }}
							{{ $teacher['name'] }}
						@endforeach /
						{{ $course['schedule'] }} </option>
					@endforeach
				@endif
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
		$(".ui.fluid.search.dropdown").dropdown();

		$("#associatedCoursesField").css("display", "none");

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
		return isAlphanumeric("courseName") &&
		hasSelection("teachers") &&
		isAlphanumeric("courseSemester") &&
		hasSelection("courseType") &&
		hasSelection("courseType") &&
		hasSelection("courseSchedule") &&
		hasSelection("courseHours") &&
		isInteger("teamSize");
	}

	function updateAssociatedCourses(){
		console.log('changes course type');
		// if course is not of type client
		if($("#courseType option:selected").val() != 1){
			$("#associatedCoursesField").css("display", "none");
			return false;
		}
		$("#associatedCoursesField").css("display", "block");
	}

</script>

@endsection
