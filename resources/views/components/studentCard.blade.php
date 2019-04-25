<a class="student-card studentCard-container column" href="{{ url('users', $user->id) }}">
	<div class="ui stackable centered card studentcard">
		<div class="content">
			<!--User avatar-->
			<div>
				<img class="ui centered small circular image user-avatar-in-card" src="{{ isset($user->picture_url) ? $user->picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}">
			</div>
			<!--User name-->
			<!-- TODO: need to make name centered-->
			<div class="ui header student-card-name">{{ $user->name }}</div>
		</div>
		<!--User skillset-->
		@if(isset($user->skillset) && count($user->skillset) > 0)
			<div class="extra content">
				<p class="ui sub header">Skills</p>
				@foreach($user->skillset as $skill)
					<div class="ui bluemarket-skill label">{{ $skill->name }}</div>
				@endforeach
			</div>
		@endif
	</div>
</a>
