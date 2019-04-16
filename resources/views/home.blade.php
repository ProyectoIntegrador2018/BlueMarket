@extends('layouts.app')

@section('meta')
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('title', 'Welcome')

@section('content')
<style>
	.detail-circle {
		background-color: white;
		border-radius: 25px;
	}

	.detail-icon {
		display: block;
		width: 150px;
		height: 150px;
		line-height: 150px;
		color: white;
		font-size: 50px;
		position: relative;
		margin: 0 auto;
		border-radius: 100%;
		border-width: 3px;
		border-style: solid;
		border-color: white;
		background-color: white;
	}

	.detail-icon i {
		color:  #2c3e50;
		line-height: inherit;
		position: relative;
		margin: 0 auto;
		width: 100%;
	}

	.detail-icon:hover {
		background-color: #2c3e50;
	}

	.detail-icon:hover i {
		color: white;
	}

	.ui.stackable.grid.details-list {
		margin: -1px auto;
	}

	.ui.header.home-details-text {
		color: white;
		text-align: center;
		text-transform: uppercase;
	}

	.home-contact-section {
		position: relative;
		width: 100%;
	}

	.home-contact-text {
		text-transform: uppercase;
		vertical-align: top;
		text-align: right;
	}

	h2.home-contact-text {
		font-size: 14vmin;
	}

	.home-contact-section .contact-us-container {
		padding: 0 6.25%;
	}

	@media only screen and (max-height: 420px) {
		.home-details-section .home-details-container {
			top: auto;
		}

		.home-hero-section .hero-container .hero-text-container .bm-hero-text {
			font-size: 20vmin;
		}
	}

	@media only screen and (max-width: 800px) {
		.home-hero-section .hero-container .hero-text-container {
			margin-top: 10%;
		}

		.home-hero-section .hero-container .hero-text-container .bm-hero-text {
			font-size: 6.5vmin;
		}
	}
</style>
	<section class="home-hero-section">
		<div class="hero-container">
			<img class="hero-img" alt="Homepage hero image" src="../img/unsplash-stock01-min.jpg"/>
			<div class="hero-text-container">
				<h1 class="ui header bm-hero-text">Blue Market</h1>
				<span class="bm-word-list bm-hero-text">
					<span class="ui header bm-hero-text">
						is
						<span id="hero-words" class="ui header bm-hero-text bm-hero-word-list"></span>
						<span class="ui header bm-hero-text">.</span>
					</span>
				</span>
			</div>
		</div>
	</section>
	<section class="home-details-section">
		<div class="home-details-container">
			<div class="home-details">
				<div class="ui stackable three column grid details-list">
					<div class="column">
						<a href="{{ url('/projects') }}">
							<span class="detail-icon"><i class="address book outline icon"></i></span>
							<h2 class="ui header home-details-text">Get started</h2>
						</a>
					</div>
					<div class="column">
						<a href="{{ url('/projects') }}">
							<span class="detail-icon"><i class="address book outline icon"></i></span>
							<h2 class="ui header home-details-text">Find projects</h2>
						</a>
					</div>
					<div class="column">
						<a href="{{ url('/projects') }}">
							<span class="detail-icon"><i class="address book outline icon"></i></span>
							<h2 class="ui header home-details-text">Find people</h2>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="home-contact-section">
		<div class="ui stackable grid contact-us-container">
			<div class="five wide column">
				<h2 class="home-contact-text">Let's talk</h2>
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
