@extends('layouts.app')

@section('content')

<div class="padded content">
	<div>
		<!-- Project Name -->
		<h1 class="ui left aligned container">{{ $project->name }}</h1>
		<!-- Video Pitch -->
		<div class="ui embed container" data-source="youtube" data-id="O6Xo21L0ybE">
			<iframe src="{{ $project->video }}" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>
		<!-- Short Description -->
		<div class="ui left aligned container">
			<p><strong>Pitch</strong></p>
			<p>{{ $project->short_description }}</p>
		</div>
		<!-- Long Description -->
		<div class="ui left aligned container">
			<p><strong>Details</strong></p>
			<p>{{ $project->long_description }}</p>
		</div>
		<!-- Category -->
		<div class="ui left aligned container">
			<p><strong>Labels</strong></p>
			@foreach($project->labels as $label)
				<div class="ui label pill">{{ $label->name }}</div>
			@endforeach
		</div>
		<!-- Skillset -->
		<div class="ui left aligned container">
			<p><strong>Required Skillset</strong></p>
			@foreach($project->skills as $skill)
				<div class="ui label pill">{{ $skill->name }}</div>
			@endforeach
		</div>
		<!-- Associated Course -->
		<div class="ui left aligned container">
			<p><strong>Associated Course</strong></p>
			<p>Computer Graphics</p>
		</div>
		<!-- Associated Team -->
		<div class="ui left aligned container">
			<p><strong>Associated Team</strong></p>
			<p>Best Team Ever</p>
		</div>
	</div>
</div>
<style>
	.container {
		margin-bottom: 25px;
	}
</style>
@endsection
