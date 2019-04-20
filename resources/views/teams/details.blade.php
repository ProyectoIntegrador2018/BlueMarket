@extends('layouts.app')

@section('title', $team->name)

@section('content')
<div class="padded content">
	<div class="ui stackable grid">
		<div class="four wide column">
			<h1 style="text-align: center;">{{ $team->name }}</h1>
			<img src="{{ isset($team->img_url) ? $team->img_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" alt="Team image" class="ui small image preview" style="margin: 0 auto; margin-bottom: 20px; border-radius: 15px;"/>
			<div class="ui stackable grid">
				<div class="eight wide column">
					<p><i class="user outline icon"></i><strong>{{ count($team->members) }} Members</strong></p>
				</div>
				<div class="eight wide column">
					<p><i class="file alternate outline icon"></i><strong>{{ count($team->projects) }} Projects</strong></p>
				</div>
			</div>
			<!-- Contact button -->
			<a class="fluid ui primary button buttonSpace" href="mailto:{{ $team->leader->email }}" style="margin-top: 20px;"><i class="icon envelope"></i>Contact</a>
		</div>
		<div class="twelve wide column">
			<div class="ui top attached tabular menu">
				<a class="active item" data-tab="projects">Projects</a>
				<a class="item" data-tab="members">Members</a>
			</div>
			<div class="ui bottom attached active tab segment" data-tab="projects">
				@if(isset($team->projects) && count($team->projects) > 0)
					<div class="ui three column stackable grid">
						@foreach ($team->projects as $project)
							@projectCard(['id'=> $project->id,'projectImage' => $project->photo, 'projectName' => $project->name, 'projectShortDescription' => $project->short_description, 'labels' => $project->labels, 'publicMilestone' => 'shipping'])
							@endprojectCard
						@endforeach
					</div>
				@else
					<div id="no-projects-msg" class="ui message">
						<div class="header">
							No projects found!
						</div>
						<p>Looks like this team does not own any projects... yet!</p>
					</div>
				@endif
			</div>
			<div class="ui bottom attached tab segment" data-tab="members">
				<div class="{{ count($team->members) <= 0 ? 'hidden' : '' }}">
					<table class="ui striped table">
						<tbody>
							@foreach($team->members as $member)
								<tr class="selectable">
									<td>
										<a href="{{ url('users', $member->id) }}">
											<img class="ui mini circular image" src="{{ isset($member->picture_url) ? $member->picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" style="display: inline; margin-right: 10px;"/>
											{{ $member->name }}
										</a>
									</td>
								</tr>
							@endforeach
							@foreach($team->members as $member)
								<tr class="selectable">
									<td>
										<a href="{{ url('users', $member->id) }}">
											<img class="ui mini circular image" src="{{ isset($member->picture_url) ? $member->picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" style="display: inline; margin-right: 10px;"/>
											{{ $member->name }}
										</a>
									</td>
								</tr>
							@endforeach
							@foreach($team->members as $member)
								<tr class="selectable">
									<td>
										<a href="{{ url('users', $member->id) }}">
											<img class="ui mini circular image" src="{{ isset($member->picture_url) ? $member->picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" style="display: inline; margin-right: 10px;"/>
											{{ $member->name }}
										</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@section("scripts")
<script>
	/* Semantic UI setup */
	$('.menu .item').tab();
</script>
@endsection
@endsection
