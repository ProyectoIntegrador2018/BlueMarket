@extends('layouts.admin')
@section('title', 'Edit user')
@section('content')
<h1>Edit user</h1>
<div class="card">
	<div class="card-body">
		<div class="padded content">

			@if ($errors->any())
			<ul class="alert alert-danger">
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
			@endif

			<form method="POST" action="{{ url('/admin/users/' . $user->id) }}" accept-charset="UTF-8" class="ui form form-horizontal" enctype="multipart/form-data">
				{{ method_field('PATCH') }}
				{{ csrf_field() }}

				<!-- Fields are loaded from form file -->
				@include ('admin.users.form')
				<input class="btn btn-primary" type="submit" value="Update">
				<a class="btn btn-outline-primary" href="{{ url('/admin/users') }}" title="Back">Back </a>
			</form>

		</div>
	</div>
</div>
@endsection
