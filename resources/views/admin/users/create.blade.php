@extends('layouts.admin')
@section('title', 'Create user')
@section('content')
<h1>Create a new user</h1>
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

			<form method="POST" action="{{ url('/users') }}" accept-charset="UTF-8" class="ui error form form-horizontal" enctype="multipart/form-data">
				@csrf

				@include('admin.users.form')
				<div class="mt-3">
					<input class="btn btn-primary" type="submit" value="Create">
					<a href="{{ url('/admin/users') }}" title="Back" class="btn btn-outline-primary">Back</a>
				</div>
			</form>

		</div>
	</div>
</div>
@endsection
