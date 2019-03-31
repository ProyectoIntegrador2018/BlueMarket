@extends('layouts.app')
@section('title', 'My courses')
@section('content')
<div class="padded content">
	<h1>My courses</h1>
	<a class="ui button primary" title="Add New Course" href="{{ url('/courses/create') }}">New</a>
	@if(count($courses) > 0)
		<div class="courses table">
			<table id="currentCourses" class="ui selectable striped table">
				<thead class="bluemarket-thead">
					<tr>
						<th>Course</th>
						<th>Key</th>
						<th>Course type</th>
						<th>Schedule</th>
						<th>Created at</th>
						<th>Updated at</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($courses as $course)
						<tr>
							<td class="selectable">
								<a href="{{ url('courses', $course->id) }}">
									{{ $course->name }}
								</a>
							</td>
							<td class="selectable">
								<a href="{{ url('courses', $course->id) }}">
									{{ $course->course_key }}
								</a>
							</td>
							<td class="selectable">
								<a href="{{ url('courses', $course->id) }}">
									@switch($course->course_type)
										@case(Config::get('enum.course_types')['client'])
											Client
											@break
										@case(Config::get('enum.course_types')['supplier'])
											Supplier
											@break
										@default
											Client
									@endswitch
								</a>
							</td>
							<td class="selectable">
								<a href="{{ url('courses', $course->id) }}">
									{{ $course->schedule }}
								</a>
							</td>
							<td class="selectable">
								<a href="{{ url('courses', $course->id) }}">
									{{ $course->created_at }}
								</a>
							</td>
							<td class="selectable">
								<a href="{{ url('courses', $course->id) }}">
									{{ $course->updated_at }}
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
		<p>You have no courses... yet!</p>
	</div>
	@endif
</div>

@endsection
