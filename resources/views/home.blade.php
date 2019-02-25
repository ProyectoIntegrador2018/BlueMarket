@extends('layouts.app')

@section('head')
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('title', 'Welcome')

@section('content')
	<div>
		<div id="main" class="home view-projects">
			<div class="overlay">
				<div class="contents">
					<h1 class="ui header">Welcome to Bluemarket</h1>
					<a class="ui primary button" href="/projects"><div class="bluemarket-button">View projects</div></a>
				</div>
			</div>
		</div>
	</div>
	<div class="padded content">
		<div class="home info">
			<div class="ui divider"></div>
				<div class="ui two column padded grid">
					<div class="column">
						<h1 class="bluemarket-text">What is Bluemarket?</h1>
						<p class="bluemarket-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
					</div>
					<div class="column image-container">
						<img class="ui small circular image" src="https://images.unsplash.com/photo-1531496681078-27dc2277e898?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&h=200&fit=crop&ixid=eyJhcHBfaWQiOjF9">
					</div>
				</div>
			</div>
		</div>
		<div class="content ui padded grid">
			<div class="home info steps">
				<h1 class="bluemarket-text">Getting started</h1>
				<ul class="progress">
					<li class="progress-item">
						<p class="progress-title bluemarket-text">Step 1</p>
						<p class="progress-info bluemarket-text">Register in the platform</p>
					</li>
					<li class="progress-item">
						<p class="progress-title bluemarket-text">Step 2</p>
						<p class="progress-info bluemarket-text">Find and submit projects</p>
					</li>
					<li class="progress-item">
						<p class="progress-title bluemarket-text">Step 3</p>
						<p class="progress-info bluemarket-text">Find and collaborate with people</p>
					</li>
				</ul>
			</div>
		</div>
		<div class="padded content contact ui grid">
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
					<p>We'll get back at you as soon as possible.</p>
					</div>

					<!-- Error message -->
					<div id="errorMessage" class="ui error message">
						<div class="header">Whoops! Something went wrong.</div>
					</div>

					<button type="submit" class="ui button submit send" id="send">Send</button>
				</div>
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
			name     : "empty",
			email    : "email",
			message	 : "empty"
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

