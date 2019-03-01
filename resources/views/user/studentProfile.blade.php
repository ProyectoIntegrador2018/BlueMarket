@extends( "layouts.app" )

<!--
@section( "head" )
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
-->

@section( "title", "Welcome" )

@section( "content" )
	<div class="padded content student profile">
		<h1>Student profile</h1>
		<div class="courses">
			<h2>My courses</h2>
			<div id="courseKeyInputContainer" class="ui action input">
				<input id="courseKey" type="text" placeholder="Course key">
				<button id="addCourse" class="ui primary button">Add course</button>
			</div>
			<div class="courses table">
				<table id="currentCourses" class="ui striped table bluemarket-table">
					<thead class="bluemarket-thead">
						<tr>
						<th>Course</th>
						<th>Professor</th>
						<th>Schedule</th>
						</tr>
					</thead>
					<tbody>
						<tr>
						<td>Computer Graphics</td>
						<td>Doctor Strange</td>
						<td>Wed 12:00, Spring 2019</td>
						</tr>
						<tr>
						<td>Web Development</td>
						<td>Doctor Doom</td>
						<td>MoThu 14:30, Spring 2019</td>
						</tr>
						<td>Software Engineering</td>
						<td>Captain America</td>
						<td>TuFri 11:30, Spring 2019</td>
						</tr>
					</tbody>
					</table>
			</div>
			<div id="courseFound" class="ui coupled first modal">
				<div class="header">Add course</div>
				<div class="content">
					<p class="newCourseInfo" id="courseName">Advanced Databases</p>
					<p class="newCourseInfo" id="courseTeacher">Doctor Octopus</p>
					<p class="newCourseInfo" id="courseSchedule">MoFri 13:00, Spring 2019</p>
				</div>
				<div class="actions">
					<div class="ui cancel button">Cancel</div>
					<div id="confirmAddCourse" class="ui primary button">Confirm</div>
				</div>
				</div>
				<div class="ui coupled second modal">
				<div class="header">Course successfully added</div>
				<div class="content">
					<i class="check huge green circle icon"></i>
					<p class="newCourseInfo" id="courseAddedName">You have been added to</p>
					<p class="newCourseInfo" id="courseAddedName">Advanced Databases</p>
				</div>
				<div class="actions">
					<div class="ui ok primary button">Done</div>
				</div>
			</div>
			<div id="courseNotFound" class="ui modal">
				<div class="header">Course not found</div>
				<div class="content">
					<i class="times huge red circle icon"></i>
					<p class="newCourseInfo" id="courseAddedName">The course key you entered was not found.</p>
				</div>
				<div class="actions">
					<div class="ui ok primary button">Done</div>
				</div>
			</div>
			<div id="courseDuplicated" class="ui modal">
				<div class="header">Duplicated course</div>
				<div class="content">
					<i class="times huge red circle icon"></i>
					<p class="newCourseInfo" id="courseAddedName">You are already associated with this course.</p>
				</div>
				<div class="actions">
					<div class="ui ok primary button">Done</div>
				</div>
			</div>
		</div>
	</div>
@section( "scripts" )
<script>
	$(document).ready(function() {
		// TODO: ajax to load student's current courses
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
			}
			else {
				courseKey = courseKey.toUpperCase();
				// TODO: ajax to check if course key exists
				if(courseKey == "HELLO" || courseKey == "DOUBLE") {
					// TODO: ajax to check course is not duplicated
					if(courseKey == "HELLO") {
						$( ".first.modal" ).modal({
							transition: "fade up"
						}).modal( "show" );
					}
					if(courseKey == "DOUBLE") {
						$( "#courseDuplicated" ).modal({
							transition: "fade up"
						}).modal( "show" );
					}
				}
				else {
					$( "#courseNotFound" ).modal({
						transition: "fade up"
					}).modal( "show" );
				}
			}
		});

		$( "#confirmAddCourse" ).click(function() {
			let courseKey = $( "#courseKey" ).val();

			// TODO: ajax to associate student with course

			let courseName = "Advanced Databases";
			let courseProfessor = "Doctor Octopus";
			let courseSchedule = "MoFri 13:00, Spring 2019";

			let rowToAdd = "<tr>" + "<td>" + courseName + "</td>" + "<td>" + courseProfessor + "</td>" + "<td>" + courseSchedule + "</td>" + "</tr>";

			$( "#currentCourses tbody tr:first" ).before(rowToAdd);
			$( "#courseKey" ).val("");
        });
    });
</script>
@endsection
@endsection
