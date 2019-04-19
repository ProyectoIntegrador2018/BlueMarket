@extends('layouts.app')

@section("title", $project->name)

@section('content')

<div class="padded content">
	<!-- Project name -->
	<h1>{{ $project->name }}</h1>
	<div class="ui top attached tabular menu">
		<a class="active item" data-tab="overview">Overview</a>
		<a class="item" data-tab="tasks">Tasks</a>
	</div>
	<div class="ui bottom attached active tab segment" data-tab="overview">
		<div class="ui stackable two column grid">
			<div class="four wide column">
				<!-- Project Image -->
				@if(isset($project->photo))
					<div class="ui image-container">
						<div class="squared-image-container">
							<img src="{{ isset($project->photo) ? $project->photo : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" alt="Project Image" class="ui small image squared-image"/>
						</div>
					</div>
				@endif
			</div>
			<div class="twelve wide column">
				<!-- Pitch video -->
				<div class="ui embed">
					<iframe src="{{ $project->video }}" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			</div>
			<div class="eleven wide column">
				<!-- Short description -->
				<div class="ui detail-container">
					<p><strong>Description</strong></p>
					<p>{{ $project->short_description }}</p>
				</div>
				<!-- Long description -->
				<div class="ui detail-container">
					<p><strong>Details</strong></p>
					<p>{{ $project->long_description }}</p>
				</div>
				<div class="ui stackable two column grid">
					<div class="four wide column" style="padding-left: 0;">
						<!-- Associated team -->
						<div class="ui detail-container">
							<p><strong>Owner team</strong></p>
							<!-- Team Image -->
							<!-- TODO: add 'href' and 'title' with project name to <a> tag. Blocked by #110 -->
							<a href="#">
								<div class="ui image-container">
									<div class="squared-image-container" >
										<img src="{{ isset($project->team->img_url) ? $project->team->img_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" alt="Owner team: {{ isset($project->team->name) ? $project->team->name : '' }}" class="ui small image squared-image"/>
									</div>
								</div>
							</a>
						</div>
					</div>
					<div class="twelve wide column">
						<!-- Associated course -->
						<div class="ui detail-container">
							<p><strong>Associated course</strong></p>
							<a href="#">
								<p>Computer Graphics</p>
								<p>
									Dr. Zoom, Captain Marvel
								</p>
								<p>Fall 2019, MoThu 13:00</p>
							</a>
							@if(isset($project->course))
								<a href="{{ url('courses', $project->course->id) }}">
									<p>$project->course->name</p>
									<p>
										@foreach($project->course->teachers as $teacher)
											{{ $loop->first ? '' : ', ' }}
											{{ $teacher->name }}
										@endforeach
									</p>
									<p>$project->course->schedule</p>
								</a>
							@endif
						</div>
					</div>
				</div>
			</div>
			<div class="five wide column">
				<!-- Labels -->
				<div class="ui detail-container">
					<p><strong>Labels</strong></p>
					@foreach($project->labels as $label)
						<div class="ui label pill">{{ $label->name }}</div>
					@endforeach
				</div>
				<!-- Skillset -->
				<div class="ui detail-container">
					<p><strong>Required skillset</strong></p>
					@foreach($project->skills as $skill)
						<div class="ui label pill">{{ $skill->name }}</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
