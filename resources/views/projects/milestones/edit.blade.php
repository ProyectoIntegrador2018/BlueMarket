@extends('layouts.app')

@section('title', 'Edit milestone')

@section('content')

<div class="padded content">
	<h1>Edit milestone</h1>

	<form method="POST" action="" accept-charset="UTF-8" enctype="multipart/form-data">
		{{ method_field('PATCH') }}
		@csrf

		<!-- Milestone name -->
		<div class="field">
			<label for="milestoneName">Name</label>
			<input type="text" name="milestoneName" id="milestoneName" value="{{ $milestone->name }}" required>
		</div>

		<!-- Previous milestone -->
		<div class="field">
			<label for="prevMilestone">Previous milestone</label>
			<select class="ui fluid search dropdown" name="prevMilestone" id="prevMilestone" value="{{ $milestone->previous_milestone }}" required>
				@foreach ($milestones as $prevMilestone)
					<option value={{ $prevMilestone->id }}> {{ $prevMilestone->name }} </option>
				@endforeach
			</select>
		</div>

		<!-- Estimated date -->
		<div class="field">
			<label for="estimatedDate">Estimated date</label>
			<input type="date" name="estimatedDate" id="estimatedDate" value="{{ $milestone->estimated_date }}" required>
		</div>

		<input class="ui button primary" type="submit" value="Update">
		<a class="ui button outline primary" href="" title="Back">Back</a>
	</form>
</div>
@endsection
