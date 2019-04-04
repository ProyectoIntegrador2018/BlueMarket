@extends( "layouts.app" )

@section( "meta" )
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section( "title", "Welcome" )

@section( "content" )
	<div class="padded content student profile">
		<div class="ui grid">
			<div class="four wide column">
				<!-- User avatar -->
				<img class="ui medium circular image" src={{ $user->picture_url }}>
				<!-- User name -->
				<h2 class="center" style="text-align: center;">{{ $user->name }}</h2>
				<!-- Contact button -->
				<a class="fluid ui primary button buttonSpace" href="mailto:{{ $user->email }}" style="margin-bottom: 10px;"><i class="icon envelope"></i>Contact</a>
				<!-- Edit button -->
				@if ($user->id == Auth::user()->id)
					<a class="fluid ui grey button buttonSpace" href="#" style="margin-bottom: 10px;">Edit</a> <!--TODO: Falta cambiar el href-->
				@endif
				<!-- Skillset pills -->
				@if (count($user->skillset) > 0)
					<div class="ui left aligned detail-container">
						<p><strong>Skillset</strong></p>
						@foreach($user->skillset as $skill)
							<div class="ui label pill">{{ $skill->name }}</div>
						@endforeach
					</div>
				@endif
			</div>
			<div class="twelve wide column">
				<div class="ui top attached tabular menu">
					<a class="active item" data-tab="first">First</a>
					<a class="item" data-tab="second">Second</a>
					<a class="item" data-tab="third">Third</a>
				</div>
				<div class="ui bottom attached active tab segment" data-tab="first">
					First
				</div>
				<div class="ui bottom attached tab segment" data-tab="second">
					Second
				</div>
				<div class="ui bottom attached tab segment" data-tab="third">
					Third
				</div>
			</div>
		</div>
		<div class="courses">
			<h2>My courses</h2>
			<div id="courseKeyInputContainer" class="ui action input">
				<input id="courseKey" type="text" placeholder="Course key">
				<button type="button" id="addCourse" class="ui primary button">Add course</button>
			</div>
			<div class="courses table">
				<table id="currentCourses" class="ui striped table">
					<thead class="bluemarket-thead">
						<tr>
							<th>Course</th>
							<th>Professor</th>
							<th>Schedule</th>
						</tr>
					</thead>
					<tbody>
						@if(isset($courses))
							@foreach($courses->all() as $course)
							<tr>
								<td>{{ $course->name }}</td>
								<td>
									@foreach($course->teachers as $teacher)
										{{ $loop->first ? '' : ', ' }}
										{{ $teacher->name }}
									@endforeach
								</td>
								<td>{{ $course->schedule }}</td>
							</tr>
							@endforeach
						@endif
					</tbody>
					</table>
			</div>
			<div id="courseFound" class="ui coupled first modal">
				<div class="header">Add course</div>
				<div class="content">
					<p id="courseName">Advanced Databases</p>
					<p id="courseTeacher">Hello World</p>
					<p id="courseSchedule">MoFri 13:00, Spring 2019</p>
				</div>
				<div class="actions">
					<button type="button" class="ui cancel button">Cancel</button>
					<button type="button" id="confirmAddCourse" class="ui primary button">Confirm</button>
				</div>
			</div>
			<div class="ui coupled second modal">
				<div class="header">Course successfully added</div>
				<div class="content">
					<i class="check huge green circle icon"></i>
					<p>You have been added to</p>
					<p id="courseAddedName"></p>
				</div>
				<div class="actions">
					<button type="button" class="ui ok primary button">Done</button>
				</div>
			</div>
			<div id="courseNotFound" class="ui modal">
				<div class="header">Course not found</div>
				<div class="content">
					<i class="times huge red circle icon"></i>
					<p>The course key you entered was not found.</p>
				</div>
				<div class="actions">
					<button type="button" class="ui ok primary button">Done</button>
				</div>
			</div>
			<div id="courseDuplicated" class="ui modal">
				<div class="header">Duplicated course</div>
				<div class="content">
					<i class="times huge red circle icon"></i>
					<p>You are already associated with this course.</p>
				</div>
				<div class="actions">
					<button type="button" class="ui ok primary button">Done</button type="button">
				</div>
			</div>
		</div>
	</div>
@section( "scripts" )
<script>
	$('.menu .item')
		.tab()
	;

	$.ajaxSetup({
		beforeSend: function(xhr) {
			xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr( "content" ));
		}
	});

	function displayCandidateCourseDetails(courseKey) {
		$.ajax({
			url: '/user/courses/associate/details',
			type: 'GET',
			data: {
				courseKey: courseKey
			},
			dataType: 'JSON',
			success: function (data) {
				$( "#courseName" ).text(data.course.name);
				let courseTeachers = data.teachers.map(function(val) {
					return val.name;
				}).join(',');
				$( "#courseTeacher" ).text(courseTeachers);
				$( "#courseSchedule" ).text(data.course.schedule);
				$( ".first.modal" ).modal({
					transition: "fade up"
				}).modal( "show" );
			},
			error: function(data) {
				// course not found
				console.log(data);
				if(data.status == 404) {
					$( "#courseNotFound" ).modal({
						transition: "fade up"
					}).modal( "show" );
				}
				// student is already associated with course
				if(data.status == 400) {
					$( "#courseDuplicated" ).modal({
						transition: "fade up"
					}).modal( "show" );
				}
			}
		});
	}

	function associateWithCourse(courseKey) {
		console.log("sending ajax" + courseKey);
		$.ajax({
			url: '/user/courses/associate',
			type: 'POST',
			data: {
				courseKey: courseKey
			},
			dataType: 'JSON',
			success: function (data) {
				console.log(data);
				console.log("success ajax");
				let courseName = data.course.name;
				let courseTeachers = data.teachers.map(function(val) {
					return val.name;
				}).join(',');
				let courseSchedule = data.course.schedule;
				// modify confirmation modal
				$( "#courseAddedName" ).text(courseName);
				// add row to table
				let rowToAdd = `<tr><td>${courseName}</td><td>${courseTeachers}</td><td>${courseSchedule}</td></tr>`;
				$( "#currentCourses tbody" ).append(rowToAdd);
				$( "#courseKey" ).val("");
			},
			error: function(data) {
				console.log(data);
				console.log("error ajax");
			}
		});
	}
	$(document).ready(function() {
		$( "#courseKeyInputContainer" ).removeClass( "error" );
		$( "#courseKey" ).removeClass( "error" );
		$( ".coupled.modal" ).modal({
			allowMultiple: false
		});
		$( ".second.modal" ).modal( "attach events", ".first.modal .button" );
		$( "#addCourse" ).click(function() {
			$( "#courseKeyInputContainer" ).removeClass( "error" );
			$( "#courseKey" ).removeClass( "error" );
			let courseKey = $( "#courseKey" ).val();
			if(courseKey == "" ) {
				$( "#courseKeyInputContainer" ).addClass( "error" );
				$( "#courseKey" ).addClass( "error" );
				return false;
			}
			courseKey = courseKey.toUpperCase();
			displayCandidateCourseDetails(courseKey);
		});
		$( "#confirmAddCourse" ).click(function() {
			let courseKey = $( "#courseKey" ).val();
			associateWithCourse(courseKey);
		});
	});
</script>
@endsection
@endsection
