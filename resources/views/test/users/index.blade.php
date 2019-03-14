
@extends('layouts.app')

@section('title', 'Users')

@section('content')
	<div class="padded content">
		{{-- @include('admin.sidebar') --}}

		<h1>Users</h1>

		<form method="GET" action="{{ url('/users') }}" accept-charset="UTF-8" role="search">
			<div class="ui search">
				<div class="ui icon input">
					<input class="prompt" type="text" placeholder="Search users" value="{{ request('search') }}">
					<i class="search icon"></i>
				</div>
				<div class="results"></div>
			</div>
		</form>

		<a href="{{ url('/users/create') }}">
			<button class="ui primary button" title="Add New User" onclick="location.href='{{ url('/users/create') }}">New</button>
		</a>

		<table class="ui single line selectable table">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Role</th>
					<th>Email</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			@foreach($users as $user)
				<tr>
					<td class="selectable">
						<a href="{{ url('/users/' . $user->id) }}" title="View User">
							{{ $loop->iteration }}
						</a>
					</td>

					<td class="selectable">
						<a href="{{ url('/users/' . $user->id) }}" title="View User">
							{{ $user->name }}
						</a>
					</td>

					<td class="selectable">
						<a href="{{ url('/users/' . $user->id) }}" title="View User">
							<!-- Aquí tengo que confirmar cómo me van a pasar el rol -->
							@switch($user->role)
								@case(1)
								<span class="tag teacher">Teacher</span>
								@break

								@case(2)
								<span class="tag student">Student</span>
								@break

								@case(3)
								<span class="tag admin">Administrator</span>
								@break

								@default
								<span class="tag admin">Administrator</span>
							@endswitch
						</a>
					</td>

					<td class="selectable">
						<a href="{{ url('/users/' . $user->id) }}" title="View User">
							{{ $user->email }}
						</a>
					</td>

					<td class="selectable">
						<button class="ui primary basic button" onclick="location.href='{{ url('/users/' . $user->id . '/edit') }}'">Edit</button>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<div class="pagination-wrapper"> {!! $users->appends(['search' => Request::get('search')])->render() !!} </div>

	</div>
@endsection
