@extends('layouts.app')

@section('title', 'Create milestone')

@section('content')

<div class="padded content">
	<h1>Create milestone</h1>

	<form method="POST" action="" accept-charset="UTF-8" enctype="multipart/form-data">
		{{ method_field('PATCH') }}
		@csrf

		<!-- Milestone name -->
		<div class="field">
			<label for="milestoneName">Name</label>
			<input type="text" name="milestoneName" id="milestoneName" required>
		</div>

		<!-- Previous milestone -->
		<div class="field">
			<label for="prevMilestone">Previous milestone</label>
			<select class="ui fluid search dropdown" name="prevMilestone" id="prevMilestone" required>
				@foreach ($milestones as $prevMilestone)
					<option value={{ $prevMilestone->id }}> {{ $prevMilestone->name }} </option>
				@endforeach
			</select>
		</div>

		<!-- Estimated date -->
		<div class="field">
			<label for="estimatedDate">Estimated date</label>
			<input type="date" name="estimatedDate" id="estimatedDate" required>
		</div>

		<!-- Status -->
		<div class="field">
			<label for="status">Status</label>
			<select class="ui fluid search dropdown" name="status" id="status" required>
				<option value="done">Done</option>
				<option value="current">Current</option>
				<option value="coming-up">Coming up</option>
		</div>

		<input class="ui button primary" type="submit" value="Create">
		<a class="ui button outline primary" href="" title="Back">Back</a>
	</form>
</div>
@endsection
