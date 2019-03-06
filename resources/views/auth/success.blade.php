@extends('layouts.app')

@section('title', 'Welcome')

@section('head')
	<meta name="google-signin-client_id" content="723110696630-74quqp3hlmjoc30f9tc4ji4v3qgvec40.apps.googleusercontent.com">
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
	<div class="ui container bluemarket centered-container">
		@if(Auth::user())
			<div id="profileInformation">
				<div class="profile-name">
					<h2>Welcome <span class="name">{{ Auth::user()->name }}</span>!</h2>
					<p>Would you like to set up your profile now? Don't worry. You can always update it later.</p>
					<a href="{{ url('/user/edit') }}" class="ui button primary">Set up profile</a>
					<a href="{{ url('/') }}" class="ui button primary">Skip for now</a>
				</div>
			</div>
		@endif
	</div>
@endsection
