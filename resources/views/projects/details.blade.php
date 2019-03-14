@extends('layouts.app')

@section('content')

<div class="padded content">
	<div>
		<!-- Project Name -->
		<p><strong>Cool Project{{-- {{$project->name}} --}}</strong></p>
		<!-- Video Pitch -->
		<div class="ui left aligned container">
			<iframe width="560" height="315" src="https://www.youtube.com/embed/Cz979ejKB_U" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			{{-- src="{{$project->video}}" --}}
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
		<!-- Category -->
		<div class="ui left aligned container">
			<p><strong>Tags</strong></p> {{-- {{$project->tags()->pluck('name')}}</p> --}}
			{{-- @foreach($skillset as $skill) --}}
			<div class="ui label pill">Tag1</div>{{-- {{ $skill }}</div> --}}
			<div class="ui label pill">Tag2</div>
			<div class="ui label pill">Tag3</div>
			<div class="ui label pill">Tag4</div>
			{{-- @endforeach --}}
		</div>
		<!-- Skillset -->
		<div class="ui left aligned container">
			<p><strong>Required Skillset</strong></p>
			{{-- @foreach($skillset as $skill) --}}
				<div class="ui label pill">Skill1</div>{{-- {{ $skill }}</div> --}}
					<div class="ui label pill">Skill2</div>
					<div class="ui label pill">Skill3</div>
					<div class="ui label pill">Skill4</div>
			{{-- @endforeach --}}
		</div>
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
	</div>
</div>
<style>
	.container {
	  margin-bottom: 25px;
	}
</style>
@endsection
