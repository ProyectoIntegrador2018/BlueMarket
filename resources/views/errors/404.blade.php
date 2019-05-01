@extends('layouts.app')

@section('title', '404')

@section('content')
<style>
	.bluemarket-header {
		position: absolute;
		width: 100%;
		z-index: 10;
	}

	/* based off: codepen.io/chiaren/pen/ALwnI */
	section {
		width: 100%;
	}

	.four {
		margin: 0 5px;
	}

	.page-not-found {
		font-size: 3rem;
		margin: 0 5px;
	}

	.go-home {
		text-transform: uppercase;
		font-size: 1.8rem;
		margin: 0 5%;
		color: #fff;
		background-color: #000;
		width: fit-content;
		border-style: solid;
		border-radius: 15px;
		border-color: #000;
		padding: 10px;
	}

	.go-home:hover {
		color: #fff;
		padding: 11px;
		font-size: 1.9rem;
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	}

	.circles {
		text-align: center;
		position: relative;
	}

	.circles div {
		font-size: 6rem;
		padding-top: 160px;
		position: relative;
		z-index: 9;
		line-height: 100%;
	}

	.circles div small {
		font-size: 5rem;
		line-height: 100%;
		vertical-align: center;
	}

	.circles .circle {
		background: linear-gradient(90deg, #1CB5E0 0%, #000851 100%);
		position: absolute;
		z-index: 1;
	}

	.circles .circle.small {
		width: 150px;
		height: 150px;
		border-radius: 50%;
		animation: 7s small-animation infinite;
		-webkit-animation: 7s small-animation infinite;
		animation-delay: 0s;
		-webkit-animation-delay: 0s;
	}

	.circles .circle.med {
		width: 200px;
		height: 200px;
		border-radius: 50%;
		animation: 7s medium-animation infinite;
		-webkit-animation: 7s medium-animation infinite;
		animation-delay: 0s;
		-webkit-animation-delay: 0s;
	}

	.circles .circle.big {
		width: 250px;
		height: 250px;
		border-radius: 50%;
		animation: 8s big-animation infinite;
		-webkit-animation: 8s big-animation infinite;
		animation-delay: 0s;
		-webkit-animation-delay: 0s;
	}

	@-webkit-keyframes big-animation {
		0% { top: 0px; right: 20%; opacity: 0.5; }
		25% { top: 240px; right: 80%; opacity:0.8; }
		50% { top: 300px; right: 45%; opacity:0.6; }
		75% { top: 100px; right: 55%;  opacity:0.7; }
		100% { top: 0px; right: 20%; opacity: 0.5; }
	}

	@keyframes big-animation {
		0% { top: 0px; right: 20%; opacity: 0.5; }
		25% { top: 240px; right: 80%; opacity:0.8; }
		50% { top: 300px; right: 45%; opacity:0.6; }
		75% { top: 100px; right: 55%;  opacity:0.7; }
		100% { top: 0px; right: 20%; opacity: 0.5; }
	}

	@-webkit-keyframes medium-animation {
		0% { top: 0px; left: 20%; opacity: 1; }
		25% { top: 300px; left: 80%; opacity:0.7; }
		50% { top: 100px; left: 40%;  opacity:0.6; }
		75% { top: 240px; left: 55%; opacity:0.8; }
		100% { top: 0px; left: 20%; opacity: 1; }
	}

	@keyframes medium-animation {
		0% { top: 0px; left: 20%; opacity: 1; }
		25% { top: 300px; left: 80%; opacity:0.7; }
		50% { top: 100px; left: 40%;  opacity:0.6; }
		75% { top: 240px; left: 55%; opacity:0.8; }
		100% { top: 0px; left: 20%; opacity: 1; }
	}

	@-webkit-keyframes small-animation {
		0% { top: 10px; left: 45%; opacity: 1; }
		25% { top: 300px; left: 40%; opacity:0.7; }
		50% { top: 240px; left: 55%; opacity:0.6; }
		75% { top: 100px; left: 40%;  opacity:0.8; }
		100% { top: 10px; left: 45%; opacity: 1; }
	}

	@keyframes small-animation {
		0% { top: 10px; left: 45%; opacity: 1; }
		25% { top: 300px; left: 40%; opacity:0.7; }
		50% { top: 240px; left: 55%; opacity:0.6; }
		75% { top: 100px; left: 40%;  opacity:0.8; }
		100% { top: 10px; left: 45%; opacity: 1; }
	}
</style>
<section id="not-found">
	<div class="circles">
		<div>
			<p class="four">404</p>
			<p class="page-not-found">We couldn't find this page. Are you lost?</p>
			<a class="go-home" href={{ url("/") }}>Let's go <i class="home icon" title="Home"></i></a>
		</div>
		<span class="circle big"></span>
		<span class="circle med"></span>
		<span class="circle small"></span>
	</div>
</section>
@endsection
