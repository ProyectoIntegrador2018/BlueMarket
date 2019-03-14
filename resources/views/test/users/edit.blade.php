
@extends('layouts.app')

@section('title', 'Edit user')

@section('content')
	<div class="padded content">
		{{-- @include('admin.sidebar') --}}

		<h1>Edit user</h1>
		<br />

		@if ($errors->any())
		<ul class="alert alert-danger">
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
		@endif

		<form method="POST" action="{{ url('/users/' . $user->id) }}" accept-charset="UTF-8" class="ui form form-horizontal" enctype="multipart/form-data">
			{{ method_field('PATCH') }}
			{{ csrf_field() }}

			<!-- Fields are loaded from form file -->
			@include ('test.users.form')
			<input class="ui primary button" type="submit" value="Update">
		</form>

		<a href="{{ url('/users') }}" title="Back">
			<button class="ui button">Back</button>
		</a>
	</div>
@endsection
