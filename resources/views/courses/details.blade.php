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
		<p><strong>Associated courses:</strong></p>
		@if (count($course->suppliers) > 0 || count($course->clients) > 0)
			<div class="courses table">
				<table id="currentCourses" class="ui selectable striped table">
					<thead class="bluemarket-thead">
						<tr>
							<th>Course</th>
							<th>Professor</th>
							<th>Schedule</th>
						</tr>
					</thead>
					<tbody>
							@foreach($course->suppliers as $supplier)
								<tr class="selectable">
									<td>
										<a href="{{ url('courses', $supplier->id) }}">
											{{ $supplier->name }}
										</a>
									</td>
									<td>
										<a href="{{ url('courses', $supplier->id) }}">
											@foreach($supplier->teachers as $teacher)
												{{ $loop->first ? '' : ', ' }}
												{{ $teacher->name }}
											@endforeach
										</a>
									</td>
									<td>
										<a href="{{ url('courses', $supplier->id) }}">
											{{ $supplier->schedule }}
										</a>
									</td>
								</tr>
							@endforeach
							@foreach($course->clients as $client)
								<tr class="selectable">
									<td>
										<a href="{{ url('courses', $client->id) }}">
											{{ $client->name }}
										</a>
									</td>
									<td>
										<a href="{{ url('courses', $client->id) }}">
											@foreach($client->teachers as $teacher)
												{{ $loop->first ? '' : ', ' }}
												{{ $teacher->name }}
											@endforeach
										</a>
									</td>
									<td>
										<a href="{{ url('courses', $client->id) }}">
											{{ $client->schedule }}
										</a>
									</td>
								</tr>
							@endforeach
					</tbody>
				</table>
			</div>
		@else
			<div class="ui message">
				<div class="header">
					No associated courses
				</div>
				<p>This course is not currently associated to other courses in Bluemarket</p>
			</div>
		@endif
		<a href="{{ url('courses') }}" title="Go to my courses" class="ui button primary">Go back to my courses</a>
	</div>
</div>
@endsection
@section('scripts')
@endsection
