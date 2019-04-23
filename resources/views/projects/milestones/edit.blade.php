@extends('layouts.app')

@section('title', 'Edit milestone')

@section('content')

<div class="padded content">
	<h1>Edit milestone</h1>

	<form class="ui form {{ $errors->any() ? 'error': '' }}" method="post" enctype="multipart/form-data" action="">
		@csrf

		<!-- Milestone name -->
		<div class="field">
			<label for="milestoneName">Name</label>
			<!-- Missing: value="{ $milestone->name }}"-->
			<input type="text" name="milestoneName" id="milestoneName">
		</div>

		<!-- Previous milestone -->
		<div class="field">
			<label for="prevMilestone">Previous milestone</label>
			<!-- Missing: value="{ $milestone->previous_milestone }}"-->
			<select class="ui fluid search dropdown" name="prevMilestone" id="prevMilestone">
				{{-- @foreach ($milestones as $prevMilestone)
					<option value={{ $prevMilestone->id }}> {{ $prevMilestone->name }} </option>
				@endforeach --}}
			</select>
		</div>

		<!-- Estimated date -->
		<div class="field">
			<label for="estimatedDate">Estimated date</label>
			<!-- Missing: value="{ $milestone->estimated_date }}"-->
			<input type="date" name="estimatedDate" id="estimatedDate">
		</div>

		<!-- Status -->
		<div class="field">
			<label for="status">Status</label>
			<!-- Missing: value="{ $milestone->status }}"-->
			<select class="ui fluid search dropdown" name="status" id="status">
				<option value="done">Done</option>
				<option value="current">Current</option>
				<option value="coming-up">Coming up</option>
			</select>
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

		<!-- Update button -->
		<button type="submit" class="ui button submit primary">Update</button>
		<a href="" title="Back" class="ui button">Back</a>
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
