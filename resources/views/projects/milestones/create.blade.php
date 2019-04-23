@extends('layouts.app')

@section('title', 'Create milestone')

@section('content')

<div class="padded content">
	<h1>Create milestone</h1>

	<form class="ui error form" method="POST" action="/courses">
		@csrf

		<!-- Milestone name -->
		<div class="field">
			<label for="milestoneName">Name</label>
			<input type="text" name="milestoneName" id="milestoneName">
		</div>

		<!-- Previous milestone -->
		<div class="field">
			<label for="prevMilestone">Previous milestone</label>
			<select class="ui fluid search dropdown" name="prevMilestone" id="prevMilestone">
				{{-- @foreach ($milestones as $prevMilestone)
					<option value={{ $prevMilestone->id }}> {{ $prevMilestone->name }} </option>
				@endforeach --}}
			</select>
		</div>

		<!-- Estimated date -->
		<div class="field">
			<label for="estimatedDate">Estimated date</label>
			<input type="date" name="estimatedDate" id="estimatedDate">
		</div>

		<!-- Status -->
		<div class="field">
			<label for="status">Status</label>
			<select class="ui fluid search dropdown" name="status" id="status">
				<option value="done">Done</option>
				<option value="current">Current</option>
				<option value="coming-up">Coming up</option>
		</div>

		<!-- Error message -->
		<div class="ui error message">
			<div class="header">Whoops! Something went wrong.</div>
			@if($errors->any())
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			@endif
		</div>

		<!-- Submit button -->
		<input class="ui button primary" type="submit" value="Create">
		<a class="ui button outline primary" href="" title="Back">Back</a>
	</form>
</div>
@endsection

@section('scripts')
<script>
	$(document).ready(function(){
		$(".ui.fluid.search.dropdown").dropdown();
	})

	$(".ui.form").form({
		fields: {
			milestoneName: ["empty", "maxLength[30]"],
			prevMilestone: ["empty"],
			estimatedDate: ["empty"],
			status: ["empty"]
		},
		onFailure: function() {
			return false;
		}
	});
</script>
@endsection
