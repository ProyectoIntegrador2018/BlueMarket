
@extends('layouts.admin')

@section('title', 'View user')

@section('content')
<div class="card">
	<div class="card-body">
		<div class="padded content">

			<div class="userInfo">
				<div class="item">
					<div class="d-flex mt-2 mb-3">
						<img class="rounded-circle" src="{{ isset($user->picture_url) ? $user->picture_url : 'http://colegioclassea.com.br/wp-content/themes/PageLand/assets/img/avatar/avatar.jpgb' }}" alt="User profile picture">
						<h1 class="align-self-center pl-4"> {{ $user->name }} </h1>
						<div class="align-self-center pl-4">
							@switch($user->role)
							@case(Config::get('enum.user_roles')['admin'])
							<span class="badge badge-pill admin">Administrator</span>
							@break

							@case(Config::get('enum.user_roles')['teacher'])
							<span class="badge badge-pill teacher">Teacher</span>
							@break

							@case(Config::get('enum.user_roles')['student'])
							<span class="badge badge-pill student">Student</span>
							@break

							@default
							<span class="badge badge-pill admin">Administrator</span>
							@endswitch
						</div>
					</div>
				</div>

				<table class="table">
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

				<a class="btn btn-primary" title="Edit" href="{{ url('/admin/users/' . $user->id . '/edit') }}">Edit</a>
				<a class="btn btn-outline-primary" title="Back" href="{{ url('/admin/users') }}">Back</a>
			</div>
		</div>
	</div>
</div>
@endsection
