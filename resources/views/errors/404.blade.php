@extends('layouts.app')

@section('title', '404')

@section('content')
<style>
	.bluemarketheader {
		position: absolute;
		width: 100%;
		z-index: 10;
	}

	/* based off: codepen.io/chiaren/pen/ALwnI */
	section {
		background: #fff;
		width: 100%;
	}

	.circles:after {
		background: #1c587f;
		position: absolute;
		width: 100%;
		height: 600px;
		z-index: 1;
		top: -90px;
		content: '';
		display: block;
		opacity: 0.4;
		transform: skewY(-10deg);
		-webkit-transform: skewY(-10deg);
	}

	.circles {
		background: #fff;
		text-align: center;
		position: relative;
	}

	.circles div {
		font-size: 6rem;
		color: #fff;
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

	.circles .go-home{
		padding-top: 0;
	}

	.circles .circle {
		background: #2980b9;
		position: absolute;
		z-index: 1;
	}

	.circles .circle.small {
		width: 140px;
		height: 140px;
		border-radius: 50%;
		animation: 7s small-animation infinite;
		-webkit-animation: 7s small-animation infinite;
		animation-delay: 1.2s;
		-webkit-animation-delay: 1.2s;
	}

	.circles .circle.med {
		width: 200px;
		height: 200px;
		border-radius: 50%;
		animation: 7s medium-animation infinite;
		-webkit-animation: 7s medium-animation infinite;
		animation-delay: 0.4s;
		-webkit-animation-delay: 0.4s;
	}

	.circles .circle.big {
		width: 320px;
		height: 320px;
		border-radius: 50%;
		animation: 8s big-animation infinite;
		-webkit-animation: 8s big-animation infinite;
		animation-delay: 3s;
		-webkit-animation-delay: 3s;
	}

	@-webkit-keyframes small-animation {
		0% { top: 10px; left: 45%; opacity: 1; }
		25% { top: 300px; left: 40%; opacity:0.7; }
		50% { top: 240px; left: 55%; opacity:0.4; }
		75% { top: 100px; left: 40%;  opacity:0.6; }
		100% { top: 10px; left: 45%; opacity: 1; }
	}

	@keyframes small-animation {
		0% { top: 10px; left: 45%; opacity: 1; }
		25% { top: 300px; left: 40%; opacity:0.7; }
		50% { top: 240px; left: 55%; opacity:0.4; }
		75% { top: 100px; left: 40%;  opacity:0.6; }
		100% { top: 10px; left: 45%; opacity: 1; }
	}

	@-webkit-keyframes medium-animation {
		0% { top: 0px; left: 20%; opacity: 1; }
		25% { top: 300px; left: 80%; opacity:0.7; }
		50% { top: 240px; left: 55%; opacity:0.4; }
		75% { top: 100px; left: 40%;  opacity:0.6; }
		100% { top: 0px; left: 20%; opacity: 1; }
	}

	@keyframes medium-animation {
		0% { top: 0px; left: 20%; opacity: 1; }
		25% { top: 300px; left: 80%; opacity:0.7; }
		50% { top: 240px; left: 55%; opacity:0.4; }
		75% { top: 100px; left: 40%;  opacity:0.6; }
		100% { top: 0px; left: 20%; opacity: 1; }
	}

	@-webkit-keyframes big-animation {
		0% { top: 0px; right: 35%; opacity: 0.5; }
		25% { top: 300px; right: 45%; opacity:0.4; }
		50% { top: 240px; right: 55%; opacity:0.8; }
		75% { top: 100px; right: 35%;  opacity:0.6; }
		100% { top: 0px; right: 35%; opacity: 0.5; }
	}

	@keyframes big-animation {
		0% { top: 0px; right: 35%; opacity: 0.5; }
		25% { top: 300px; right: 45%; opacity:0.4; }
		50% { top: 240px; right: 55%; opacity:0.8; }
		75% { top: 100px; right: 35%;  opacity:0.6; }
		100% { top: 0px; right: 35%; opacity: 0.5; }
	}
</style>
<section id="not-found">
	<div class="circles">
		<div>
			404
			<br>
			<small>Are you lost?</small>
			<div class="go-home">
				<a class="ui primary submit button" href="{{ url('/') }}">
					Let's go home!
				</a>
			</div>
		</div>
		<span class="circle big"></span>
		<span class="circle med"></span>
		<span class="circle small"></span>
	</div>
</section>
@endsection
