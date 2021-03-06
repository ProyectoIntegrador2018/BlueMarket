@extends('layouts.admin')
@section('title', 'Users')
@section('content')
<div class="row justify-content-between">
	<div class="col">
		<h1>Users</h1>
	</div>
	<div class="col-3 d-flex justify-content-end">
		<div class="flex-wrapper">
			<a class="btn btn-primary" title="Add New User" href="{{ url('/admin/users/create') }}">New</a>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<div class="padded content">

			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>ID</th>
						<th>Name</th>
						<th>Role</th>
						<th>Email</th>
						<th>Last logon</th>
						<th>Created</th>
						<th>Modified</th>
						<th>Sign in as</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $user)
					<tr>
						<td>
							<a href="{{ url('/admin/users/' . $user->id) }}" title="View User">
								{{ $loop->iteration }}
							</a>
						</td>

						<td>{{ $user->id }}</td>

						<td>
							<a href="{{ url('/admin/users/' . $user->id) }}" title="View User">
								{{ $user->name }}
							</a>
						</td>

						<td>
							<a href="{{ url('/admin/users/' . $user->id) }}" title="View User">
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
							</a>
						</td>

						<td>
							<a href="{{ url('/admin/users/' . $user->id) }}" title="View User">
								{{ $user->email }}
							</a>
						</td>

						<td>{{ $user->last_logon }}</td>
						<td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
						<td>{{ $user->updated_at->format('Y-m-d H:i:s') }}</td>

						<td style="min-width: 140px">
							<a class="btn btn-sm btn-outline-warning" href="{{ route('signinas', ['id' => $user->id]) }}"><small>Sign in as this user</small></a>
						</td>
						<td>
							<a class="btn btn-outline-primary btn-sm" href="{{ url('/admin/users/' . $user->id) }}">View</a>
							<a class="btn btn-outline-primary btn-sm" href="{{ url('/admin/users/' . $user->id . '/edit') }}">Edit</a>
						</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<!-- Ver cómo generarlo según el número de usuarios que me manda backend-->
					<tr>
						<th colspan="10">
							<nav aria-label="Page navigation example">
								<ul class="pagination">
									<li class="page-item">
										<a class="page-link" href="#" aria-label="Previous">
											<span aria-hidden="true">&laquo;</span>
										</a>
									</li>
									<li class="page-item"><a class="page-link" href="#">1</a></li>
									<li class="page-item"><a class="page-link" href="#">2</a></li>
									<li class="page-item"><a class="page-link" href="#">3</a></li>
									<li class="page-item">
										<a class="page-link" href="#" aria-label="Next">
											<span aria-hidden="true">&raquo;</span>
										</a>
									</li>
								</ul>
							</nav>
						</th>
					</tr>
				</tfoot>
			</table>
			<div class="pagination-wrapper"> {!! $users->appends(['search' => Request::get('search')])->render() !!} </div>

		</div>
	</div>
</div>
@endsection
