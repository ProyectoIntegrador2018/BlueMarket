
@extends('layouts.app')

@section('title', 'Course registered')

@section('content')
<div class="padded content">
	<h1>Success! Your course was registered.</h1>
	<div>
		<h2>Overview:</h2>
		<p>Course name: Cool course name</p>
		<p>Teacher(s):</p>
		<ul>
			<li>Mr. Monday</li>
			<li>Mr. Monday</li>
			<li>Mr. Monday</li>
			<li>Mr. Monday</li>
		</ul>
		<p>Course semester: Fall 2018</p>
		<p>Course type: Client</p>
		<p>Course schedule: Monday, Thursday</p>
		<p>Starting time: 10:30 AM</p>
		<p>Teams of: 4</p>
		<p>Affiliated courses:</p>
		<ul>
			<li>Random</li>
			<li>Random</li>
			<li>Random</li>
			<li>Random</li>
		</ul>
		<p>Your course key is ABCDEF.</p>
	</div>
</div>


	{{-- <!-- Esto es lo que iría con la respuesta del backend -->
	<div>
		<h2>Overview:</h2>
		<p>Course name: {{ $courseName }}</p>
		<p>Teacher(s):</p>
		<ul>
		@foreach (teachers as teacher)
			<li>{{ $teacher }}</li>
		@endforeach
		</ul>
		<p>Course semester: {{ $courseSemester }}</p>
		<p>Course type: {{ $courseType }}</p>
		<p>Course schedule: {{ $courseSchedule }}</p>
		<p>Starting time: {{ $courseHours }}</p>
		<p>Teams of: {{ $teamsOf }}</p>
		<p>Affiliated courses:</p>
		<ul>
		@foreach (affiliatedCourses as course)
			<li>{{ $course }}</li>
		@endforeach
		</ul>
		<p>Your course key is {{ $courseKey }}.</p>
	</div> --}}

@endsection

@section('scripts')
@endsection
