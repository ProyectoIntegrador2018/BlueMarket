
@extends('layouts.app')

@section('title', 'View user')

@section('content')
	<div class="padded content">
		<div class="container">
			<div class="row">
				{{-- @include('admin.sidebar') --}}

				<div class="col-md-9">

					<div class="userInfo">
						<img class="ui avatar image" src="{{ $user->picture_url }}" alt="User profile picture">
						<h1> {{ $user->name }} </h1>
						<div>
							@switch($user->role)
								@case(1)
								<span class="tag student">Student</span>
								@break

								@case(2)
								<span class="tag teacher">Teacher</span>
								@break

								@case(3)
								<span class="tag admin">Administrator</span>
								@break

								@default
								<span class="tag student">Student</span>
							@endswitch
						</div>

						<br>

						<div>
							<table class="ui single line table userInfo">
								<tbody>
									<tr>
										<th>User ID</th>
										<td>{{ $user->id }}</td>
									</tr>
									<tr>
										<th>Email</th>
										<td> {{ $user->email }} </td>
									</tr>
									<tr>
										<th>Created</th>
										<td> {{ $user->created_at }} </td>
									</tr>
									<tr>
										<th>Last logon</th>
										<td> {{ $user->last_logon }} </td>
									</tr>
								</tbody>
							</table>
						</div>

						<a href="{{ url('/users') }}" title="Back">
							<button class="ui white button btn btn-warning btn-sm">
								<i class="fa fa-arrow-left" aria-hidden="true"></i>Back
							</button>
						</a>

						<a href="{{ url('/users/' . $user->id . '/edit') }}" title="Edit user">
							<button class="ui primary button btn btn-primary btn-sm">
								<i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit
							</button>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
