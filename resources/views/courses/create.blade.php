
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
			<input type="text" name="courseName" id="courseName">
		</div>
		<!-- Teacher(s) -->
		<div class="field">
			<label for="teachers">Teacher(s)</label>
			<select class="ui fluid search dropdown" name="teachers[]" id="teachers" multiple>
				@foreach ($teachers as $teacher)
					<option value={{ $teacher->id }} {{ ($teacher->id == Auth::id()) ? "selected" : '' }}> {{ $teacher->name }} </option>
				@endforeach
			</select>
			<p>Are you giving this course with another teacher?</p>
		</div>
		<!-- Course semester -->
		<div class="field">
			<label for="courseSemester">Course semester</label>
			<input type="text" name="courseSemester" id="courseSemester">
			<p>When is this course taking place? Spring/Summer/Fall/Winter and year. e.g. Fall 2018</p>
		</div>
		<!-- Course type -->
		<div class="field">
			<label for="courseType">Course type</label>
			<select class="ui fluid search dropdown" name="courseType" id="courseType" onchange="updateAssociatedCourses()">
				<option value=""></option>
				<option value="1">Client</option>
				<option value="2">Supplier</option>
			</select>
			<p>A client course is looking to outsource specific tasks. A supplier course is looking for projects to team up with.</p>
		</div>
		<!-- Course schedule -->
		<div class="two fields">
			<div class="field">
				<label for="courseSchedule">Course schedule</label>
				<select class="ui fluid search dropdown" name="courseSchedule[]" id="courseSchedule" multiple>
					<option value="monday">Monday</option>
					<option value="tuesday">Tuesday</option>
					<option value="wednesday">Wednesday</option>
					<option value="thursday">Thursday</option>
					<option value="friday">Friday</option>
					<option value="saturday">Saturday</option>
				</select>
			</div>

			<!-- Course hours -->
			<div class="field">
				<label for="courseHours">Starting time</label>
				<select class="ui fluid search dropdown" name="courseHours" id="courseHours">
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
		<!-- Associated courses -->
		<div id="associatedCoursesField" class="field">
			<label for="associatedCourses">Associated courses</label>
			<select class="ui fluid search dropdown" name="associatedCourses[]" id="associatedCourses" multiple>
				@if(isset($courses))
					@foreach($courses->all() as $course)
						<option value="{{ $course->id }}">
						{{ $course->name }} /
						@foreach($course->teachers as $teacher)
							{{ $loop->first ? '' : ', ' }}
							{{ $teacher->name }}
						@endforeach /
						{{ $course->schedule }} </option>
					@endforeach
				@endif
			</select>
			<p>Are you collaborating with other courses?</p>
		</div>
		<!-- Error message -->
		<div class="ui error message hidden">
			<div class="header">Whoops! Something went wrong.</div>
			@if($errors->any())
				<ul class="list">
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			@endif
		</div>
		<!-- Register button -->
		<button id="send" type="submit" class="ui button primary">Register</button>
		<a href="{{ url('courses') }}" title="Back" class="ui button">Back</a>
	</form>
</div>

@endsection

@section('scripts')
<script>
	$(document).ready(function(){
		$(".ui.fluid.search.dropdown").dropdown();

		$("#associatedCoursesField").css("display", "none");
	})

	function updateAssociatedCourses(){
		console.log('changes course type');
		// if course is not of type client
		if($("#courseType option:selected").val() != 1){
			$("#associatedCoursesField").css("display", "none");
			return false;
		}
		$("#associatedCoursesField").css("display", "block");
	}

	$('.ui.form').form({
		fields: {
			courseName: {
				identifier: 'courseName',
				rules: [{
					type: 'empty',
				}]
			},
			teachers: {
				identifier: 'teachers[]',
				rules: [{
					type: 'minCount[1]',
				}]
			},
			courseSemester: {
				identifier: 'courseSemester',
				rules: [{
					type: 'regExp',
					value: '/^[a-zA-Z0-9][a-zA-Z0-9\\s]+$/',
					prompt: 'Course semester must have a valid value'
				}]
			},
			courseType: {
				identifier: 'courseType',
				rules: [{
					type: 'exactCount[1]',
				}]
			},
			courseSchedule: {
				identifier: 'courseSchedule',
				rules: [{
					type: 'minCount[1]',
				}]
			},
			courseHours: {
				identifier: 'courseHours',
				rules: [{
					type: 'exactCount[1]',
				}]
			},
		},
		onFailure:function() {
			$('.ui.error.message').removeClass('hidden');
			return false;
		},
		onSuccess:function() {
		}
	});

</script>

@endsection
