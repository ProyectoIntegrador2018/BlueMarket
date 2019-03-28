@extends('layouts.app')

@section('title', $team->name)

@section('content')
<div class="padded content">
	<h1>{{ $team->name }}</h1>
	<div class="team-info">
		<div class="image-container">
			<div class="image-uploader preview-container">
				<img id="preview" src="<?= $team->img_url ?>" alt="Team image" class="ui small image preview"/>
			</div>
		</div>
		<div class="team-people">
			<p><strong>People</strong></p>
			<div class="team-members">
				@if(isset($team->members))
					@foreach($team->members as $member)
						<!-- TODO: add route to user profile -->
						<a href="#">
							<img class="ui avatar image" src="<?= $member->picture_url ?>"/>
						</a>
					@endforeach
				@endif
			</div>
		</div>
	</div>
	<div class="team-projects">
		<p><strong>Projects</strong></p>
		<!-- TODO: add project cards -->
		<div class="ui message">
		<div class="header">
			No projects available
		</div>
		<p>Looks like this team has no projects at the moment.</p>
		</div>
	</div>
</div>
@endsection
