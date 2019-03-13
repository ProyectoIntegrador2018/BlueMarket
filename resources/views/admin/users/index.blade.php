@extends('layouts.admin')
@section('title', 'Users')
@section('content')
	<h1>Users</h1>
	<div class="card">
		<div class="card-body">
			<table class="table table-hover">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">ID</th>
						<th scope="col">Name</th>
						<th scope="col">E-mail</th>
						<th scope="col">Role</th>
						<th scope="col">Last logon</th>
						<th scope="col">Created</th>
						<th scope="col">Modified</th>
					</tr>
				</thead>
				<tbody>
					@foreach($users->all() as $key => $user)
						<tr>
							<th scope="row">{{ $key+1 }}</th>
							<td>{{ $user->id }}</td>
							<td>{{ $user->name }}</td>
							<td>{{ $user->email }}</td>
							<td>{{ $user->role }}</td>
							<td>{{ $user->last_logon }}</td>
							<td>{{ $user->created_at->format('Y-m-d\TH:i:s') }}</td>
							<td>{{ $user->updated_at->format('Y-m-d\TH:i:s') }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection
