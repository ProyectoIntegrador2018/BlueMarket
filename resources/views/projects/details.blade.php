@extends('layouts.app')

@section('content')

<div class="padded content">
	<form class="ui form">
		<!-- Project Name -->
		<p><strong>{{$project->name}}</strong></p>
		<!-- Project Image -->
		<div class="projectImage field">
			{{-- <label for="projectImage">Project Image</label> --}}
			<img src="https://lorempixel.com/400/400" alt="Project Image" class="ui medium image" id="projectImagePreview"/>
		</div>
		<!-- Category -->
		<div class="ui left aligned container">
			<p><strong>Tags: </strong>{{$project->tags()->pluck('name')}}</p>
		</div>
		<!-- Skillset -->
		<div class="ui left aligned container">
			<p><strong>Required Skillset: </strong></p>
		</div>
		<!-- Associated Course -->
		<div class="ui left aligned container">
			<p><strong>Associated Course: </strong> </p>
		</div>
		<!-- Associated Team -->
		<div class="ui left aligned container">
			<p><strong>Associated Team: </strong></p>
		</div>
		<!-- Short Description -->
		<div class="ui left aligned container">
			<p><strong>Brief Description: </strong>{{$project->short_description}}</p>
		</div>
		<!-- Long Description -->
		<div class="ui left aligned container">
			<p><strong>Detailed Description: </strong>{{$project->long_description}}</p>
		</div>
		<!-- Video Pitch -->
		<div class="ui left aligned container">
			<p><strong>Video Pitch: </strong></p>
			<iframe width="560" height="315" src="{{$project->video}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>
	</form>
</div>

@endsection
