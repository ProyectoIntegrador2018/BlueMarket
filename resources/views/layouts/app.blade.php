<!DOCTYPE html>
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
	<div class="ui secondary pointing menu bluemarket-header" id="bluemarket-header">
		<div class="menu">
			<a class="item {{ Request::is('/') ? 'active' : '' }}" href="/">Home</a>
			<a class="item {{ Request::is('projects') ? 'active' : '' }}" href="{{ action('ProjectController@index') }}">
				Projects
			</a>
		</div>
		<div class="right menu">
			@if(Auth::user())
				@if(Auth::user()->role ==Config::get('enum.user_roles')['student'])
					<div class="ui menu bluemarket-header">
						<a id="add-menu-item" class="browse item">
							<i class="plus icon"></i>
							<i class="dropdown icon"></i>
						</a>
						<a id="user-menu-item" class="browse item">
							<img class="ui mini circular image user-avatar" src="{{ isset(Auth::user()->picture_url) ? Auth::user()->picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}"/>
							<i class="dropdown icon"></i>
						</a>
					</div>
					<div id="add-menu" class="ui vertical popup transition hidden">
						<a class="item user-dropdown-menu" href="{{ url('projects/create') }}">New project</a>
						<a class="item user-dropdown-menu" href="{{ url('teams/create') }}">New team</a>
					</div>
					<div id="user-menu" class="ui vertical popup transition hidden">
						<a class="item user-dropdown-menu" href="{{ url('users', Auth::id()) }}">My profile</a>
						<a class="item user-dropdown-menu" href="{{ route('logout') }}">Logout</a>
					</div>
				@elseif(Auth::user()->role ==Config::get('enum.user_roles')['teacher'])
					<div class="ui menu bluemarket-header">
						<a id="add-menu-item" class="browse item">
							<i class="plus icon"></i>
							<i class="dropdown icon"></i>
						</a>
						<a id="user-menu-item" class="browse item">
							<img class="ui mini circular image user-avatar" src="{{ isset(Auth::user()->picture_url) ? Auth::user()->picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}"/>
							<i class="dropdown icon"></i>
						</a>
					</div>
					<div id="add-menu" class="ui vertical popup transition hidden">
						<a class="item user-dropdown-menu" href="{{ url('courses/create') }}">New course</a>
					</div>
					<div id="user-menu" class="ui vertical popup transition hidden">
						<a class="item user-dropdown-menu" href="{{ url('courses') }}">My courses</a>
						<a class="item user-dropdown-menu" href="{{ route('logout') }}">Logout</a>
					</div>
				@endif
			@else
				<a class="item {{ Request::is('login') ? 'active' : '' }}" id="loginBtn" href="{{ route('login') }}">
					Login
				</a>
			@endif
		</div>
	</div>
	<div class="container">
		@yield('content')
	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
	<script src="{{ mix('js/inputValidation.js') }}"></script>
	<script>
		$('#user-menu-item').popup({
			popup: $('#user-menu'),
			on: 'click'
		});

		$('#add-menu-item').popup({
			popup: $('#add-menu'),
			on: 'click'
		});
	</script>
	@yield('scripts')
</body>
</html>
