@extends('layouts.app')

@section('title', 'Login')

@section('meta')
    <meta name="google-signin-client_id" content="723110696630-74quqp3hlmjoc30f9tc4ji4v3qgvec40.apps.googleusercontent.com">
@endsection

@section('content')
	<div class="ui container bluemarket centered-container" id="signin">
        <h1>Sign in</h1>
        <p>Sign in to unlock more features</p>
		<div class="g-signin2" data-theme="light" data-onsuccess="onSignIn" data-longtitle="true"></div>
	</div>
	<script src="https://apis.google.com/js/platform.js" async defer></script>
@endsection