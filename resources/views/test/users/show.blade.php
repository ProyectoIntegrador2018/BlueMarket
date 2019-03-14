
@extends('layouts.app')

@section('title', 'View user')

@section('content')
	<div class="padded content">
		{{-- @include('admin.sidebar') --}}

		<div class="userInfo">
			<img class="ui avatar image" src="<?= $user->picture_url ?>" alt="User profile picture">
			<h1> {{ $user->name }} </h1>
			<div>
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
					<span class="tag admin">Administator</span>
				@endswitch
			</div>

			<br>

			<table class="ui single line table userInfo">
				<tbody>
					<tr>
						<th>User ID</th>
						<td> {{ $user->id }} </td>
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

			<button class="ui primary button" title="Edit" onclick="location.href='{{ url('/users/' . $user->id . '/edit') }}'">Edit</button>

			<button class="ui white button" title="Back" onclick="location.href='{{ url('/users') }}'">Back</button>
		</div>
	</div>
	</div>
@endsection
