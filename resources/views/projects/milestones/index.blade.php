@extends('layouts.app')

@section('title', 'View milestones')

@section('content')

<div class="padded content">
	<h1>View milestones</h1>

	<table class="ui celled table">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Status</th>
				<th>Estimated date</th>
				<th>Done date</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			{{-- @foreach($milestones as $milestone)
			<tr>
				<td>{{ $loop->iteration }}</td>

				<td>{{ $milestone->name }}</td>

				<td>
					@switch($milestone->status)
					@case(Config::get('enum.milestone_status')['done'])
					<span class="">Done</span>
					@break

					@case(Config::get('enum.milestone_status')['current'])
					<span class="">Current</span>
					@break

					@case(Config::get('enum.milestone_status')['coming-up'])
					<span class="">Coming up</span>
					@break

					@default
					<span class="">Coming up</span>
					@endswitch
				</td>

				<td>{{ $milestone->estimated_date }}</td>

				<td>{{ isset($milestone->done_date) ?  $milestone->done_date : '-' }}</td>

				<td>
					<a class="" href="{{ url('/projects/' . $project->id . '/milestones/' . $milestone->id . '/edit') }}">Edit</a>
				</td>
			</tr>
			@endforeach --}}
			<tr>
				<td>1</td>
				<td>Ideation</td>
				<td>
					<span>Done</span>
				</td>
				<td>4/19</td>
				<td>4/20</td>
				<td>
					<a class="" href="">Edit</a>
				</td>
			</tr>

			<tr>
				<td>2</td>
				<td>Design</td>
				<td>
					<span class="">Current</span>
				</td>
				<td>4/25</td>
				<td>-</td>
				<td>
					<a class="" href="">Edit</a>
				</td>
			</tr>

			<tr>
				<td>3</td>
				<td>Planning</td>
				<td>
					<span class="">Coming up</span>
				</td>
				<td>4/30</td>
				<td>-</td>
				<td>
					<a class="" href="">Edit</a>
				</td>
			</tr>

			<tr>
				<td>4</td>
				<td>Execution</td>
				<td>
					<span class="">Coming up</span>
				</td>
				<td>6/10</td>
				<td>-</td>
				<td>
					<a class="" href="">Edit</a>
				</td>
			</tr>

			<tr>
				<td>5</td>
				<td>Test</td>
				<td>
					<span class="-up">Coming up</span>
				</td>
				<td>6/30</td>
				<td>-</td>
				<td>
					<a class="" href="">Edit</a>
				</td>
			</tr>
		</tbody>
	</table>

</div>

@endsection

@section('scripts')
@endsection
