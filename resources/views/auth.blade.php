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
		<div class="g-signin2" data-theme="light" data-onsuccess="onSignIn" data-longtitle="true"></div>
		<a href="#" class="ui primary button" style="margin-top: 40px;" onclick="signOut();">Sign out</a>

	</div>
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<script>
		function onSignIn(googleUser) {
			var profile = googleUser.getBasicProfile();
			console.log(profile);
			console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
			console.log('Name: ' + profile.getName());
			console.log('Image URL: ' + profile.getImageUrl());
			console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
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
