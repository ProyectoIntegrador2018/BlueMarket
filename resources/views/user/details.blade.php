@extends("layouts.app")

@section("meta")
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section("title", $user->name)

@section("content")
	<div class="padded content student profile">
		<div class="ui stackable grid">
			<div class="four wide column user-basic-info">
				<!-- User avatar -->
				<img class="ui small circular image user-avatar" src="<?php echo asset($user->picture_url) ?>"/>
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
					<a class="active item" data-tab="projects">Projects</a>
					<a class="item" data-tab="second">Second</a>
					<a class="item" data-tab="courses">Courses</a>
				</div>
				<div class="ui bottom attached active tab segment" data-tab="projects">
					@if(isset($user->projects) && count($user->projects) > 0)
						<div class="ui two column stackable grid">
							@foreach ($user->projects as $project)
								@projectCard(['id'=> $project->id,'projectImage' => $project->photo, 'projectName' => $project->name, 'projectShortDescription' => $project->short_description, 'labels' => $project->labels, 'publicMilestone' => 'shipping'])
								@endprojectCard
							@endforeach
						</div>
					@else
						<div id="no-projects-msg" class="ui message">
							<div class="header">
								No projects found!
							</div>
							<p>Looks like this user is not participating in any projects... yet!</p>
						</div>
					@endif
				</div>
				<div class="ui bottom attached tab segment" data-tab="second">
					Second
				</div>
				<div class="ui bottom attached tab segment" data-tab="courses">
					<div class="courses">
						@if($user->id == Auth::user()->id)
							<div id="courseKeyInputContainer" class="ui fluid action input add-course">
								<input id="courseKey" type="text" placeholder="Course key" onkeypress="handleKeyPress(event)">
								<button type="button" id="addCourse" class="ui primary button" onclick="addNewCourse()">Add course</button>
							</div>
						@endif
						<div id="current-courses" class="courses table">
							<table class="ui striped table">
								<thead class="bluemarket-thead">
									<tr>
										<th>Course</th>
										<th>Professor</th>
										<th>Schedule</th>
									</tr>
								</thead>
								<tbody>
									@foreach($user->enrolledIn as $course)
										<tr class="selectable">
											<td>
												<a href="{{ url('courses', $course->id) }}">
													{{ $course->name }}
												</a>
											</td>
											<td>
												<a href="{{ url('courses', $course->id) }}">
													@foreach($course->teachers as $teacher)
														{{ $loop->first ? '' : ', ' }}
														{{ $teacher->name }}
													@endforeach
												</a>
											</td>
											<td>
												<a href="{{ url('courses', $course->id) }}">
													{{ $course->schedule }}
												</a>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div id="no-courses-msg" class="ui message">
							<div class="header">
								No courses found!
							</div>
							<p>This user is not enrolled in any courses yet.</p>
						</div>
						<div id="courseFound" class="ui coupled first modal">
							<div class="header">Add course</div>
							<div class="content">
								<p id="courseName"></p>
								<p id="courseTeacher"></p>
								<p id="courseSchedule"></p>
							</div>
							<div class="actions">
								<button type="button" class="ui cancel button">Cancel</button>
								<button type="button" id="confirmAddCourse" class="ui primary button" onclick="associateCourse()">Confirm</button>
							</div>
						</div>
						<div id="courseAddedSuccessfully" class="ui coupled second modal">
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
						<div id="courseAdditionError" class="ui modal">
							<div class="header">Something went wrong</div>
							<div class="content">
								<i class="times huge red circle icon"></i>
								<p>We were unable to associate you with this course.</p>
							</div>
							<div class="actions">
								<button type="button" class="ui ok primary button">Done</button type="button">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@section("scripts")
<script>
	/* Semantic UI setup */
	$('.menu .item')
		.tab()
	;

	$(".coupled.modal").modal({
			allowMultiple: false
	});

	/* send cstf token on every ajax request */
	$.ajaxSetup({
		beforeSend: function(xhr) {
			xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr("content"));
		}
	});

	/* courses */
	let hasCourses = {!! $user->enrolledIn !!}.length > 0;

	function showCourses() {
		if(hasCourses) {
			$('#current-courses').show();
			$('#no-courses-msg').hide();

		}
		else {
			$('#current-courses').hide();
			$('#no-courses-msg').show();
		}
	}

	showCourses(); // execute on load

	@if($user->id == Auth::user()->id)
		/* course association workflow */
		function validateCourseKey(courseKey) {
			$("#courseKeyInputContainer").removeClass("error");
			$("#courseKey").removeClass("error");

			if(courseKey == "") {
				$("#courseKeyInputContainer").addClass("error");
				$("#courseKey").addClass("error");
				return false;
			}
			return true;
		}

		function displayCandidateCourseDetails(courseKey) {
			$.ajax({
				url: '/user/courses/associate/details',
				type: 'GET',
				data: {
					courseKey: courseKey
				},
				dataType: 'JSON',
				success: function (data) {
					let course = data.course;
					$("#courseName").text(course.name);
					let courseTeachers = course.teachers.map(function(val) {
						return val.name;
					}).join(', ');
					$("#courseTeacher").text(courseTeachers);
					$("#courseSchedule").text(course.schedule);
					$(".first.modal").modal({
						transition: "fade up"
					}).modal("show");
				},
				error: function(data) {
					// course not found
					if(data.status == 404) {
						$("#courseNotFound").modal({
							transition: "fade up"
						}).modal("show");
					}
					// student is already associated with course
					if(data.status == 400) {
						$("#courseDuplicated").modal({
							transition: "fade up"
						}).modal("show");
					}
				}
			});
		}

		function generateCourseDetailsRow(course, teachers) {
			let courseId = course.id;
			let courseName = course.name;
			let courseTeachers = teachers.map(function(val) {
				return val.name;
			}).join(', ');
			let courseSchedule = course.schedule;
			// modify confirmation modal
			$("#courseAddedName").text(courseName);
			// add row to table
			let row = `<tr class="selectable">
							<td>
								<a href="/courses/${courseId}">
									${courseName}
								</a>
							</td>
							<td>
								<a href="/courses/${courseId}">
									${courseTeachers}
								</a>
							</td>
							<td>
								<a href="/courses/${courseId}">
									${courseSchedule}
								</a>
							</td>
						</tr>`;
			return row;
		}

		function addNewCourse() {
			let courseKey = $("#courseKey").val().trim();

			if(validateCourseKey(courseKey)) {
				courseKey = courseKey.toUpperCase();
				displayCandidateCourseDetails(courseKey);
			}
		}

		function handleKeyPress(e){
			if(e.keyCode === 13) { // press Enter
				addNewCourse();
			}
		}

		function associateCourse() {
			let courseKey = $("#courseKey").val().trim();

			$.ajax({
				url: '/user/courses/associate',
				type: 'POST',
				data: {
					courseKey: courseKey
				},
				dataType: 'JSON',
				success: function (data) {
					let course = data;
					let courseName = course.name;
					// confirmation modal
					$("#courseAddedName").text(courseName);
					$("#courseAddedSuccessfully").modal({
						transition: "fade up"
					}).modal("show");
					// add row to table
					let rowToAdd = generateCourseDetailsRow(course, course.teachers);
					$("#courseKey").val("");

					// update courses tab
					$("#current-courses tbody").append(rowToAdd);
					hasCourses = true;
					showCourses();
				},
				error: function (data) {
					$("#courseAdditionError").modal({
						transition: "fade up"
					}).modal("show");
				}
			});
		}
	@endif
</script>
@endsection
@endsection
