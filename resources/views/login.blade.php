@extends('layouts.app')

@section('title', 'Login')

@section('meta')
	<meta name="google-signin-client_id" content="723110696630-74quqp3hlmjoc30f9tc4ji4v3qgvec40.apps.googleusercontent.com">
@endsection

@section('content')
	<style>
		.hidden {
			display: none;
		}
	</style>
	<div class="ui container bluemarket centered-container">
		<div class="signInInfo">
			<h1>Sign in</h1>
			<p>Sign in to unlock more features</p>
			<div id="my-signin2"></div>
		</div>
		<div id="profileInformation" class="hidden">
			<div class="profile-name">
				<h2>Welcome <span class="name"></span>!</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad reiciendis delectus quibusdam, animi illo aliquid velit asperiores perspiciatis voluptas. Quas optio deleniti odio rem unde odit voluptate, earum aliquam fugiat!</p>
				<a href="#" class="ui button primary" style="margin-top: 20px">Fill your profile now</a>
			</div>
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
			let auth2;
			gapi.load('auth2', function() {
				auth2 = gapi.auth2.init({
					hosted_domain: 'itesm.mx',
					prompt: 'select_account'
				});
				// let options = new gapi.auth2.SigninOptionsBuilder();
				// options.setPrompt('select_account');
				setTimeout(loadBtn, 1200);
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
			console.log(profile);
			console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
			console.log('Name: ' + profile.getName());
			const name = profile.getName();
			$('#profileInformation span.name').html(name);
			console.log('Image URL: ' + profile.getImageUrl());
			console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
			let token = googleUser.getAuthResponse().id_token;
			$('.signInInfo').fadeOut(function() {
				$('#profileInformation').fadeIn();
			})
			$('#logoutBtn').html('Logout').click(signOut);
			// document.getElementById('tokenInput').value = token;
			// document.getElementById('gform').querySelector('p').innerHTML = 'Token ready';
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
