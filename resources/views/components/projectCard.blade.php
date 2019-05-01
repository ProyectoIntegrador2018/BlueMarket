<a class="project-card ProjectCard-container column" href="{{ action('ProjectController@show', ['id'=>$project->id]) }}">
	<div class="ui stackable centered card projectcard fluid eq-card">
		<div class="image">
			<img src="{{ isset($project->photo) ? $project->photo : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}">
		</div>
		<div class="content">
			<div class="header">{{ $project->name }}</div>
			<div class="description">
				{{ $project->short_description }}
			</div>
		</div>
		@if(isset($project->skills))
			<div class="extra content">
				<p class="ui sub header">Required skills</p>
				@foreach($project->skills as $skill)
					<div class="ui bluemarket-skill label">{{ $skill->name }}</div>
				@endforeach
			</div>
		@endif
		@if(isset($project->labels))
			<div class="extra content">
				<p class="ui sub header">Labels</p>
				@foreach($project->labels as $label)
					<div class="ui bluemarket-skill label">{{ $label->name }}</div>
				@endforeach
			</div>
		@endif
		<div class="extra content milestone">
			<p>Shipping</p>
		</div>
	</div>
</a>
