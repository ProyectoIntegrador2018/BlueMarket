@extends('layouts.app')

@section('title', 'Login')

@section('head')
	<meta name="google-signin-client_id" content="723110696630-74quqp3hlmjoc30f9tc4ji4v3qgvec40.apps.googleusercontent.com">
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="ui container bluemarket centered-container">
	<div class="signInInfo">
		<h1>Sign in</h1>
		<p>Sign in to unlock more features</p>
		<a role="button" id="my-signin2"></a>
	</div>
	<div id="signInError" class="ui error message hidden">
		<h2>Could not sign you in</h2>
		<p id="errorReason"></p>
	</div>
</div>
@section('scripts')
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script>
	const errorMessageGeneric = "Please contact us for support.";
	const errorMessageItesmAccount = "Please use your \@itesm.mx account.";

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

	function showError(errorMessage) {
		$('#errorReason').html(errorMessage);
		$('#signInError').removeClass("hidden");
	}

	function onFailure(e) {
		// Handle the error where user does not match domain
		if(e.error) {
			showError(errorMessageItesmAccount);
		}
		if(e.type && e.type === "tokenFailed") {
			showError(errorMessageGeneric);
		}
	}

	function onSignIn(googleUser) {
		var profile = googleUser.getBasicProfile();
		let token = googleUser.getAuthResponse().id_token;
		// $('#my-signin2').fadeOut();
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
				console.log(data);
				if(data && data.success) {
					if(data.new){
						window.location.href = "/login/welcome";
					}
					else{
						window.location.href = "/";
					}
				}
			},
			error: function(data) {
				showError(errorMessageGeneric);
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
@endsection
