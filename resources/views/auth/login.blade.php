@extends('layouts.app')

@section('title', 'Login')

@section('meta')
	<meta name="google-signin-client_id" content="723110696630-74quqp3hlmjoc30f9tc4ji4v3qgvec40.apps.googleusercontent.com">
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
	<style>
		.hidden {
			display: none;
		}
	</style>
	<div class="ui padded content container centered-container" style="width: 60%">
		<form method="POST" action="{{ route('login') }}" class="ui form">
			@csrf
			<input type="hidden" name="id_token" id="token">
			<div class="form-group row">
				<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

				<div class="col-md-6">
					<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

					@if ($errors->has('email'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif
				</div>

			</div>

			<div class="form-group row mb-0">
				<div class="col-md-8 offset-md-4">
					<button type="submit" class="ui button primary" style="margin-top: 20px;">
						{{ __('Login') }}
					</button>
				</div>
			</div>
		</form>
	</div>
	<div class="ui container bluemarket centered-container">
		<div class="signInInfo">
			<h1>Sign in</h1>
			<p>Sign in to unlock more features</p>
			<div id="my-signin2"></div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<script>
		$(function() {

			// Test content blocking on firefox:
			let $img = $('<img/>').attr("src", "https://apps.facebook.com/favicon.ico");
			$img.on('load', function(e){
				loadPage(true);
			});
			$img.on('error', function() {
				loadPage(false);
			});
			$img.css("display", "none").appendTo(document.body);
		});
		function loadPage(isContentBlockingEnabled) {
			if(!isContentBlockingEnabled) {
				let msg = 'Please disable content blocking on this page to be able to sign in.';
				console.error(msg);
				$('#my-signin2').html(msg);
				return false;
			}
			// let auth2;
			gapi.load('auth2', function() {
				var auth2 = gapi.auth2.init({
					hosted_domain: 'itesm.mx',
					prompt: 'select_account'
				});
				auth2.then(function() {
					const hasUser = <?= Auth::user() === NULL ? 'false' : 'true' ?>;
					if(auth2.isSignedIn.get() && !hasUser) {
						auth2.signOut().then(function() {
							loadBtn();
						});
					}
					else {
						setTimeout(loadBtn, 1200);
					}
				});
			});
		}
		function loadBtn() {
			gapi.signin2.render('my-signin2', {
				'width': 240,
				'height': 50,
				'longtitle': true,
				'theme': 'light',
				'onsuccess': onSignIn,
				'onfailure': onFailure
			});
		}
		function onFailure(e) {
			// Handle the error where user does not match domain
			if(e.error) {
				console.error(e);
			}
			if(e.type && e.type === "tokenFailed") {
				alert('Could not sign you in using this account. Please use your \@itesm.mx account');
			}
		}
		function onSignIn(googleUser) {
			var profile = googleUser.getBasicProfile();
			let token = googleUser.getAuthResponse().id_token;
			$('#my-signin2').fadeOut();
			// Send the request now
			$.ajax({
				url: '/login',
				method: 'POST',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {'id_token': token},
				dataType: 'json',
				success: function(data) {
					if(data && data.success) {
						window.location.href = "/";
					}
				},
				error: function() {
					console.log('something went wrong');
				}
			});
		}

		function signOut() {
			var auth2 = gapi.auth2.getAuthInstance();
			auth2.signOut().then(function () {
				console.log('User signed out.');
				window.location.href="/";
			});
		}
	</script>
@endsection
