@extends('layouts.app')

@section('content')

<div class="padded content">
	<form class="ui form">
		<!-- Project Name -->
		<p><strong>Cool Project{{-- {{$project->name}} --}}</strong></p>
		<!-- Project Image -->
		<div class="projectImage field">
			{{-- <label for="projectImage">Project Image</label> --}}
			<img src="https://lorempixel.com/400/400" alt="Project Image" class="ui medium image" id="projectImagePreview"/>
		</div>
		<!-- Category -->
		<div class="ui left aligned container">
			<p><strong>Tags</strong></p> {{-- {{$project->tags()->pluck('name')}}</p> --}}
			<div class="ui label">Tag1</div>{{-- {{ $skill }}</div> --}}
 			<div class="ui label">Tag2</div>
 			<div class="ui label">Tag3</div>
 			<div class="ui label">Tag4</div>
		</div>
		<!-- Skillset -->
		<div class="ui left aligned container">
			<p><strong>Required Skillset</strong></p>
{{-- 			@foreach($skillset as $skill)
 --}}				<div class="ui label">Skill1</div>{{-- {{ $skill }}</div> --}}
 					<div class="ui label">Skill2</div>
 					<div class="ui label">Skill3</div>
 					<div class="ui label">Skill4</div>
{{-- 			@endforeach
 --}}		</div>
		<!-- Associated Course -->
		<div class="ui left aligned container">
			<p><strong>Associated Course</strong> </p>
			<p>Computer Graphics</p>
		</div>
		<!-- Associated Team -->
		<div class="ui left aligned container">
			<p><strong>Associated Team</strong></p>
			<p>Best Team Ever</p>
		</div>
		<!-- Short Description -->
		<div class="ui left aligned container">
			<p><strong>Brief Description</strong></p>{{-- {{$project->short_description}}</p> --}}
			<p>This project...</p>
		</div>
		<!-- Long Description -->
		<div class="ui left aligned container">
			<p><strong>Detailed Description</strong></p>{{-- {{$project->long_description}}</p> --}}
			<p>This project...It includes...</p>
		</div>
		<!-- Video Pitch -->
		<div class="ui left aligned container">
			<p><strong>Video Pitch</strong></p>
			<iframe width="560" height="315" src="https://www.youtube.com/embed/Cz979ejKB_U" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			{{-- src="{{$project->video}}" --}}
		</div>
	</form>
</div>
<style>
	.container {
	  margin-bottom: 25px;
	}
</style>
@endsection
