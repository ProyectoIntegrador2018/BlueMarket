<a class="ProjectCard-container column" href="{{ url('projects', $id) }}">
	<div class="ui stackable centered card projectcard">
		<div class="image">
			<img src={{ $projectImage }}>
		</div>
		<div class="content">
			<div class="header">{{ $projectName }}</div>
			<div class="description">
				{{ $projectShortDescription }}
			</div>
		</div>
		@if(isset($skillset))
			<div class="extra content">
				<p class="ui sub header">Required skills</p>
				@foreach($skillset as $skill)
					<div class="ui bluemarket-skill label">{{ $skill->name }}</div>
				@endforeach
			</div>
		@endif
		<div class="extra content">
			<p class="ui sub header">Labels</p>
			@foreach($labels as $label)
				<div class="ui bluemarket-skill label">{{ $label->name }}</div>
			@endforeach
		</div>
		<div class="ui bottom attached label content">{{ $publicMilestone }}</div>
	</div>
</a>
