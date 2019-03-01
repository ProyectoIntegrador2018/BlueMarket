
@extends('layouts.app')

@section('title', 'Course registered')

@section('content')
<div class="padded content">
	<h1>Success! Your course was registered.</h1>
	<div>
		<h2>Overview:</h2>
		<p><strong>Course name:</strong> Cool course name</p>
		<p><strong>Teacher(s):</strong></p>
		<ul>
			<li>Mr. Monday</li>
		</ul>
		<p><strong>Course semester:</strong> Fall 2018</p>
		<p><strong>Course type:</strong> Client</p>
		<p><strong>Course schedule:</strong> Monday, Thursday</p>
		<p><strong>Starting time:</strong> 10:30 AM</p>
		<p><strong>Max. team size:</strong> 4</p>
		<p><strong>Associated courses:</strong></p>
		<ul>
		</ul>
		<p>Your course key is <strong>ABCDEF</strong>.</p>
	</div>
</div>


	{{-- <!-- Esto es lo que iría con la respuesta del backend -->
	<div>
		<h2>Overview:</h2>
		<p>Course name: {{ $courseName }}</p>
		<p><strong>Teacher(s):</strong></p>
		<ul>
		@foreach (teachers as teacher)
			<li>{{ $teacher }}</li>
		@endforeach
		</ul>
		<p><strong>Course semester:</strong> {{ $courseSemester }}</p>
		<p><strong>Course type:</strong> {{ $courseType }}</p>
		<p><strong>Course schedule:</strong> {{ $courseSchedule }}</p>
		<p><strong>Starting time:</strong> {{ $courseHours }}</p>
		<p><strong>Teams of:</strong> {{ $teamsOf }}</p>
		<p><strong>Affiliated courses:</strong></p>
		<ul>
		@foreach (affiliatedCourses as course)
			<li>{{ $course }}</li>
		@endforeach
		</ul>
		<p>Your course key is <strong>{{ $courseKey }}</strong>.</p>
	</div> --}}

@endsection

