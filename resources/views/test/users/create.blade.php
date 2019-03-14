
@extends('layouts.app')

@section('title', 'Create user')

@section('content')
	<div class="padded content">
		{{-- @include('admin.sidebar') --}}

		<h1>Create a new user</h1>
		<br />

		@if ($errors->any())
		<ul class="alert alert-danger">
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
		@endif

		<form method="POST" action="{{ url('/users') }}" accept-charset="UTF-8" class=" ui form form-horizontal" enctype="multipart/form-data">
			{{ csrf_field() }}

			@include ('test.users.form')
			<input class="ui primary button" type="submit" value="Create">
		</form>

		<a href="{{ url('/users') }}" title="Back">
			<button class="ui button">Back</button>
		</a>
	</div>
@endsection
