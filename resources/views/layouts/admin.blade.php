<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	@yield('meta')

	<title>Admin &raquo; @yield('title')</title>

	<!-- Styles -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap-grid.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700" rel="stylesheet">
	<link href="{{ mix('css/admin.css') }}" rel="stylesheet">

</head>
<body>
	<div class="my-container">
		<aside class="sidebar">
			<a href="#" class="logo">
				<img src="img/logo.svg" alt="Bluemarket Admin Dashboard">
			</a>
			<hr>
			<a href="#">Dashboard</a>
			<hr>
			<ul>
				<li><a href="#">Dashboard</a></li>
				<li><a href="#">Components</a></li>
				<li><a href="#">Utilities</a></li>
			</ul>
			<hr>
		</aside>
		<main class="content-pane">
			<nav class="main-nav navbar navbar-light" style="background-color: #fff">
				<form class="form-inline">
					<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
					<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
				</form>
				<div class="navbar-brand">
					<a href="#" class="user-avatar">
						{{ Auth::user()->name }}
						<img class="user-avatar-img" src="{{ asset('img/avatar.jpg') }}" alt="{{ Auth::user()->name }}">
					</a>
				</div>
			</nav>
			<div class="container-fluid">
				@yield('content')
			</div>
		</main>
	</div>
</body>
</html>
