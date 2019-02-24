<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		@yield('meta')

		<title>Bluemarket - @yield('title')</title>

		<!-- Semantic UI -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">

		<!-- Styles -->
		<link href="{{ mix('css/app.css') }}" rel="stylesheet">

	</head>
	<body>
		<div class="ui secondary pointing menu bluemarketheader" id="bluemarketheader">
			<div class="right menu">
				<a class="item {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">
					Home
				</a>
				<a class="item {{ Request::is('projects') ? 'active' : '' }}" href="{{ url('projects') }}">
					Projects
				</a>
				<a class="item {{ Request::is('login') ? 'active' : '' }}" id="loginBtn" href="{{ url('login') }}">
					Login
				</a>
			</div>
		</div>
		<div class="container">
			@yield('content')
		</div>
	</body>
</html>
