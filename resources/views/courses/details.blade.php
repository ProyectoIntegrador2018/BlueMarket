@extends('layouts.app')

@section('title', $course->name)

@section('content')
<div class="padded content">
	<h1>{{ $course->name }}</h1>
	<div>
		<p class="coursekey">Your course key is <br> <code>{{ isset($course->course_key) ? $course->course_key : "ERROR" }}</code></p>
		<h2>Overview:</h2>
		<p><strong>Course name:</strong> {{ $course->name }}</p>
		<p><strong>Teacher(s):</strong></p>
		<ul>
			@foreach ($course->teachers as $teacher)
			<li>{{ $teacher->name }}</li>
			@endforeach
		</ul>
		<p><strong>Course schedule:</strong> {{ $course->schedule }}</p>
		@if (isset($course->suppliers))
			<p><strong>Associated courses:</strong></p>
			<ul>
				@foreach ($course->suppliers as $supplier)
					<li>{{ $supplier->name }}</li>
				@endforeach
			</ul>
		@endif
	</div>
</div>
@endsection

@section('scripts')
@endsection
