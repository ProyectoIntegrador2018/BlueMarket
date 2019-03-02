
@extends('layouts.app')

@section('title', 'Course details')

@section('content')
<div class="padded content">
	<h1>{{ "HERE GOES THE COURSE NAME" }}</h1>
	<div>
		<p id="courseKey">Your course key is <br> <code>{{ isset($courseKey) ? $courseKey : "HELLO" }}</code></p>
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
	</div>
</div>
@endsection

@section('scripts')
@endsection
