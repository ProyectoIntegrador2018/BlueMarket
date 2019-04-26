@extends('layouts.app')

@section('title', 'Create milestone')

@section('content')

<div class="padded content">
	<h1>Create milestone</h1>

	<form class="ui form {{ $errors->any() ? 'error': '' }}" method="post" enctype="multipart/form-data" action="">
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
					<option value="{{ $prevMilestone->id }}"> {{ $prevMilestone->name }} </option>
					@endforeach --}}
				</select>
			</div>

			<!-- Estimated date -->
			<div class="field">
				<label for="estimatedDate">Estimated date</label>
				<div class="ui calendar">
					<div class="ui input left icon">
						<i class="calendar icon"></i>
						<input id="estimatedDate" name="estimatedDate" type="text" placeholder="e.g. 30/4/2019" value="">
					</div>
				</div>
			</div>

			<!-- Status -->
			<div class="field">
				<label for="status">Status</label>
				<select class="ui fluid search dropdown" name="status" id="status">
					<option value="done">Done</option>
					<option value="current">Current</option>
					<option value="coming-up">Coming up</option>
				</select>
			</div>

			<!-- Error message -->
			<div class="ui error message">
				<p class="header">Whoops! Something went wrong.</p>
				@if($errors->any())
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
				@endif
			</div>

			<!-- Submit button -->
			<button type="submit" class="ui button submit primary">Create</button>
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
