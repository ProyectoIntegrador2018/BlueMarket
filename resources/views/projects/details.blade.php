@extends('layouts.app')

@section('content')

<div class="padded content">
	<div>
		<!-- Project name -->
		<h1 class="ui left aligned detail-container">{{ $project->name }}</h1>
		<!-- Pitch video -->
		<div class="ui embed detail-container">
			<iframe src="{{ $project->video }}" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>
		<!-- Project Image -->
		@if(isset($project->photo))
			<div class="ui left aligned detail-container image-container">
				<div class="preview-container">
					<img id="preview" src="<?php echo asset($project->photo) ?>" alt="Project Image" class="ui small image preview"/>
				</div>
			</div>
		@endif
		<!-- Short description -->
		<div class="ui left aligned detail-container">
			<p><strong>Description</strong></p>
			<p>{{ $project->short_description }}</p>
		</div>
		<!-- Long description -->
		<div class="ui left aligned detail-container">
			<p><strong>Details</strong></p>
			<p>{{ $project->long_description }}</p>
		</div>
		<!-- Category -->
		<div class="ui left aligned detail-container">
			<p><strong>Labels</strong></p>
			@foreach($project->labels as $label)
				<div class="ui label pill">{{ $label->name }}</div>
			@endforeach
		</div>
		<!-- Skillset -->
		<div class="ui left aligned detail-container">
			<p><strong>Required skillset</strong></p>
			@foreach($project->skills as $skill)
				<div class="ui label pill">{{ $skill->name }}</div>
			@endforeach
		</div>
		<!-- Associated course -->
		<div class="ui left aligned detail-container">
			<p><strong>Associated course</strong></p>
			<p>{{ $project->course->name }}</p>
		</div>
		<!-- Associated team -->
		<div class="ui left aligned detail-container">
			<p><strong>Associated team</strong></p>
			<p>e.g. Best Team Ever</p>
		</div>
	</div>
</div>
@endsection
