@extends('layouts.app')

@section('title', $team->name)

@section('content')
<div class="padded content">
	<h1>{{ $team->name }}</h1>
	<div class="team-info">
		<div class="image-container">
			<img id="avatar" src="<?= $team->img_url ?>" alt="Team avatar" class="ui small image"/>
		</div>
		<div class="team-people">
			<h2>People</h2>
			<div class="team-members">
				@if(isset($team->members))
					@foreach($team->members as $member)
						<!-- TODO: add route to user profile -->
						<a href="https://www.google.com">
							<img class="ui avatar image" src="<?= $member->picture_url ?>"/>
						</a>
					@endforeach
				@endif
			</div>
		</div>
	</div>
	<div class="team-projects">
		<h2>Projects</h2>
		<!-- TODO: add project cards -->
	</div>
</div>
@endsection
