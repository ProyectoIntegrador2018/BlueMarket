<a class="column project-card" href="{{ url('teams', $team->id) }}">
	<div class="ui stackable centered card projectcard">
		<div class="ui image">
			<img src="{{ $team->img_url }}">
		</div>
		<div class="content">
			<div class="header">{{ $team->name }}</div>
			<div class="description">
				<?php $max = min(count($team->members), 5) ?>
				<?php $members = $team->members ?>
				@for($i = 0; $i < $max; $i++)
					<span class="team-member-avatar-container">
						<img class="ui mini circular image" src="{{ $members[$i]->picture_url }}">
					</span>
				@endfor
			</div>
		</div>
		<div class="extra content">
			<span class="right floated">
				<i class="user icon"></i>
					{{ count($team->members) }} Members
			</span>
			<span>
				<i class="columns icon"></i>
					<!-- TODO: set count of projects -->
					0 projects
			</span>
		</div>
	</div>
</a>
