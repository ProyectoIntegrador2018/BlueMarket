@extends('layouts.app')

@section('meta')
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('title', 'Welcome')

@section('content')
	<section class="home-hero-section">
		<div class="hero-container">
			<img class="hero-img" alt="Homepage hero image" src="../img/unsplash-stock01-min.jpg"/>
			<div class="hero-text-container">
				<h1 class="huge ui header bm-h1">Blue Market</h1>
			</div>
		</div>
	</section>
	<section class="home-details-section">
		<div class="home-details">
		</div>
	</section>

	<div style="display:none;" class="contact ui grid">
		<div class="home info contact">
			<h1 class="bluemarket-text">Contact us</h1>
			<a name="contact"></a>
			<div class="ui form error">
				<!-- Name -->
				<div id="nameInput" class="field input">
					<label for="name">Name</label>
					<input type="text" id="name" name="name" placeholder="e.g. John Doe">
				</div>

				<!-- Email -->
				<div id="emailInput" class="field input">
					<label for="email">Email</label>
					<input type="text" id="email" name="email" placeholder="e.g. john@example.com">
				</div>

				<!-- Message -->
				<div id="messageInput" class="field input">
					<label for="message">Message</label>
					<textarea id="message" name="message"></textarea>
				</div>

				<!-- Success message -->
				<div id="success" class="ui positive message">
					<div class="header">
						Thank you for your message.
					</div>
					<p>We'll get back to you as soon as possible.</p>
				</div>
				<!-- Error message -->
				<div id="errorMessage" class="ui error message">
					<div class="header">Whoops! Something went wrong.</div>
				</div>

				<button type="submit" class="ui button submit send" id="send">Send</button>
			</div>
		</div>
	</div>
@section('scripts')
	<script>
		function sendEmail() {
			$( ".ui.form" ).removeClass( "error" );
			$( ".field.input" ).removeClass( "error" );
			$( "#success" ).addClass( "hidden" );
			/* semantic modifies error messages by default
				we need to change it back for error handling */
			$( "#errorMessage" ).html( "<div class=\"header\">Whoops! Something went wrong.</div>" );

			let CSRF_TOKEN = $( 'meta[name="csrf-token"]' ).attr( "content" );

			$.ajax({
				url: "/contact",
				type: "POST",
				data: {
					_token: CSRF_TOKEN,
					name: $( "#name" ).val(),
					email: $( "#email" ).val(),
					message: $( "#message" ).val()
				},
				dataType: 'JSON',
				success: function (data) {
					$( ".ui.form" ).removeClass( "error" );
					$( ".field.input" ).removeClass( "error" );
					$( "#success" ).removeClass( "hidden" );
				},
				error: function (data) {
					$( ".ui.form" ).addClass( "error" );
					$( "#success" ).addClass( "hidden" );
				}
			});
		}

		// semantic form validation
		$( ".ui.form" ).form({
			fields: {
				name: "empty",
				email: "email",
				message: "empty"
			},
			onFailure: function() {
				// onFailure needs to exist to prevent form from sending request
				console.log('failed submission');
			},
			onSuccess: function() {
				sendEmail();
			}
		});

		$( "#send" ).on("click", function(){
			$( ".ui.form" ).removeClass( "error" );
			$( ".field.input" ).removeClass( "error" );
			$( "#success" ).addClass( "hidden" );
			// call semantic form validation
			$( ".ui.form" ).form("validate form");
		});

		$(document).ready(function(){
			// initial class set up
			$( ".ui.form" ).removeClass( "error" );
			$( ".field.input" ).removeClass( "error" );
			$( "#success" ).addClass( "hidden" );
		});
	</script>
@endsection
@endsection
