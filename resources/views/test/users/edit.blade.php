
@extends('layouts.app')

@section('title', 'Edit user')

@section('content')
	<div class="padded content">
		<div class="container">
			<div class="row">
				{{-- @include('admin.sidebar') --}}

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

					@include ('test.users.form', ['formMode' => 'edit'])

				</form>

				<a href="{{ url('/users/' . $user->id) }}" title="Back">
					<button class="ui white button btn btn-warning btn-sm">
						<i class="fa fa-arrow-left" aria-hidden="true"></i>Back
					</button>
				</a>

			</div>
		</div>
	</div>
@endsection
