@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
	<div class="ui container bluemarket centered-container">
		@if(Auth::user())
			<div id="profileInformation">
				<div class="profile-name">
					<h2>Welcome <span class="name">{{ Auth::user()->name }}</span>!</h2>
					<p>Would you like to set up your profile now? Don't worry. You can always update it later.</p>
					<a href="{{ action('UserController@edit') }}" class="ui button primary">Set up profile</a>
					<a href="{{ url('/') }}" class="ui button primary">Skip for now</a>
				</div>
			</div>
		@endif
	</div>
@endsection
