<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="google-signin-client_id" content="723110696630-74quqp3hlmjoc30f9tc4ji4v3qgvec40.apps.googleusercontent.com">

	<title>Auth Google Test</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
</head>
<body>
	<div class="ui container" style="margin-top: 4%">
		<h1>Google auth</h1>
		{{-- <div class="g-signin2" data-theme="light" data-onsuccess="onSignIn" data-longtitle="true"></div> --}}
		<div id="my-signin2"></div>
		<a href="#" class="ui primary button" style="margin-top: 40px;" onclick="signOut();">Sign out</a>
		<form action="/googleauth" method="POST" id="gform">
			@csrf
			<p>Your token goes here</p>
			<input type="hidden" name="id_token" id="tokenInput">
			<button type="submit">Submit</button>
		</form>
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
				loadBtn();
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
			console.log('Image URL: ' + profile.getImageUrl());
			console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
			let token = googleUser.getAuthResponse().id_token;
			document.getElementById('tokenInput').value = token;
			document.getElementById('gform').querySelector('p').innerHTML = 'Token ready';
		}

		function signOut() {
			var auth2 = gapi.auth2.getAuthInstance();
			auth2.signOut().then(function () {
				console.log('User signed out.');
			});
		}
	</script>
</body>
</html>
