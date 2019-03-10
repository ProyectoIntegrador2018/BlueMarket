
@extends('layouts.app')

@section('title', 'Users')

@section('content')
	<div class="padded content">
		<div class="container">
			<div class="row">
				{{-- @include('admin.sidebar') --}}

				<div class="col-md-9">
					<div class="card">
						<div class="card-header">user {{ $user->id }}</div>
						<div class="card-body">

							<a href="{{ url('/users') }}" title="Back">
								<button class="btn btn-warning btn-sm">
									<i class="fa fa-arrow-left" aria-hidden="true"></i>Back
								</button>
							</a>

							<a href="{{ url('/users/' . $user->id . '/edit') }}" title="Edit user">
								<button class="btn btn-primary btn-sm">
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit
								</button>
							</a>
							<br/>
							<br/>

							<div class="userInfo">
								<img src="{{ $user->picture_url }}" alt="User profile picture">
								<p> {{ $user->name }} </p>
								<p> {{ $user->role }} </p>

								<div class="table-responsive">
										<table class="table">
											<tbody>
												<tr>
													<th>ID</th>
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
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
