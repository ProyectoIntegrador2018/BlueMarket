<a class="column project-card" href="{{ url('teams', $team->id) }}">
	<div class="ui stackable centered card projectcard">
		<div class="ui fluid image">
			<img src="{{ isset($team->img_url) ? $team->img_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}">
		</div>
		<div class="content">
			<div class="header">{{ $team->name }}</div>
			<div class="description">
				<?php $loop_boundary = min(count($team->members), 5) ?>
				<?php $members = $team->members ?>
				@for($i = 0; $i < $loop_boundary; $i++)
					<span class="team-member-avatar-container">
						<img class="ui mini circular image" src="{{ isset($members[$i]->picture_url) ? $members[$i]->picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}">
					</span>
				@endfor
			</div>
		</div>
		<div class="extra content">
			<span class="right floated">
				<i class="user icon"></i>
					{{ isset($team->members) ? count($team->members) : '0' }} Members
			</span>
			<span>
				<i class="columns icon"></i>
					<!-- TODO: set count of projects -->
					{{ isset($team->projects) ? count($team->projects) : '0' }} Projects
			</span>
		</div>
	</div>
</a>
