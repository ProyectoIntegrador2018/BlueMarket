@extends('layouts.app')

@section('content')

<div class="padded content">
	<div>
		<!-- Project name -->
		<h1 class="ui left aligned container">{{ $project->name }}</h1>
		<!-- Pitch video -->
		<div class="ui embed container">
			<iframe src="{{ $project->video }}" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>
		<!-- Short description -->
		<div class="ui left aligned container">
			<p><strong>Description</strong></p>
			<p>{{ $project->short_description }}</p>
		</div>
		<!-- Long description -->
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
			<p><strong>Required skillset</strong></p>
			@foreach($project->skills as $skill)
				<div class="ui label pill">{{ $skill->name }}</div>
			@endforeach
		</div>
		<!-- Associated course -->
		<div class="ui left aligned container">
			<p><strong>Associated course</strong></p>
			<p>e.g. Computer Graphics</p>
		</div>
		<!-- Associated team -->
		<div class="ui left aligned container">
			<p><strong>Associated team</strong></p>
			<p>e.g. Best Team Ever</p>
		</div>
	</div>
</div>
<style>
	.container {
		margin-bottom: 25px;
	}
</style>
@endsection
