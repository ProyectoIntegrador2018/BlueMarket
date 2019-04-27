@extends('layouts.app')

@section('title', 'Edit milestone')

@section('content')

<div class="padded content">
	<h1>Edit milestone</h1>

	<form class="ui form {{ $errors->any() ? 'error': '' }}" method="post" enctype="multipart/form-data" action="">
		@csrf

		@include('projects.milestones.form')

		<!-- Update button -->
		<button type="submit" class="ui button submit primary">Update</button>
		<a href="{{ url('/projects/milestones/index') }}" title="Back" class="ui button">Back</a>
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
