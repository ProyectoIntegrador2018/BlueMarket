@extends('layouts.app')

@section('meta')
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('title', 'Welcome')

@section('content')
	<section class="home-hero-section">
		<div class="hero-container">
			<div class="hero-text-container">
				<h1 class="bm-hero-text header">Blue Market</h1>
				<h2 class="bm-hero-text subheader">A place for collaboration.</h2>
				<span style="display: none;" class="bm-word-list bm-hero-text">
					<span class="bm-hero-text">
						is
						<span id="hero-words" class="bm-hero-text bm-hero-word-list"></span>
						<span class="bm-hero-text">.</span>
					</span>
				</span>
			</div>
		</div>
	</section>
	<section class="home-details-section">
		<div class="home-details-container">
			<div class="home-details">
				<div class="ui stackable three column grid details-list">
					<div class="row">
						<div class="column">
						@if(Auth::user())
							<a href="#">
						@else
							<a href="{{ action('LoginController@show') }}">
						@endif
								<span class="detail-icon"><i class="clipboard icon"></i></span>
								<h2 class="home-details-text">Sign up</h2>
							</a>
						</div>
						<div class="column">
							<a href="{{ action('ProjectController@index') }}">
								<span class="detail-icon"><i class="rocket icon"></i></span>
								<h2 class="home-details-text">Find projects</h2>
							</a>
						</div>
						<div class="column">
							<a href="{{ action('UserController@index') }}">
								<span class="detail-icon"><i class="user icon"></i></span>
								<h2 class="home-details-text">Find people</h2>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="home-contact-section">
		<div class="ui stackable grid contact-us-container">
			<div class="five wide column">
				<h2 class="home-contact-text header">Let's talk</h2>
				<p class="home-contact-text">Questions? Comments?</p>
				<p class="home-contact-text">We're here for you!</p>
			</div>
			<div class="one wide column">
			</div>
			<div class="ten wide column">
				<form class="ui form error">
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
					<button type="submit" class="ui primary button" id="send">Send</button>
				</form>
			</div>

		</div>
	</section>


@section('scripts')
	<script>
		let hero_words_colors = [ ["innovation","#8e44ad"], ["collaboration", "#f1c40f"], ["teamwork","#16a085"], ["productivity", "#e67e22"]];
		let current = 0;

		function changeWordInList() {
			$('#hero-words').text(hero_words_colors[current][0]).css('color', hero_words_colors[current][1]);
			current = (current + 1) % hero_words_colors.length;
		}

		let animateWordsTimer = setInterval(changeWordInList, 1000);

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
