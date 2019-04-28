@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<style>
	.notification-option-icon {
		text-align: center;
	}

	.tablet.stackable.table {
		font-weight: initial;
	}
</style>
<div class="padded content">
	<!-- TODO: call teamInvites -->
	<div class="ui stackable grid">
		<div class="row">
			<h1>Project notifications</h1>
		</div>
		<div class="row">
			<table class="ui tablet stackable table">
			<tbody>
				@foreach($projects as $project)
					<tr>
						<td>
							<div class="ui stackable grid notifications-grid">
								<div class="twelve wide column">
									<div class="ui stackable grid">
										<div class="wide column notification-column user-avatar-column">
											<img src="{{ isset($user->picture_url) ? $user->picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" alt="Sender image" class="ui tiny image squared-image"/>
										</div>
										<div class="ten wide column notification-column">
											<p>
												<a href={{ action('UserController@show', ['id' => $user->id]) }}>
													{{ $user->name }}
												</a>
												invited you to join their project
												<a href={{ action('ProjectController@show', ['id' => $project->id]) }}>
													{{ $project->name }}
												</a>
												.
											</p>
										</div>
										<div class="four wide column notification-column">
											<!-- TODO: add datetime rendering classes. Blocked by #188 -->
											<p class="date">2 minutes ago</p>
										</div>
									</div>
								</div>
								<div class="four wide column">
									<div class="ui padded grid">
										<div class="eight wide column notification-column">
											<p class="notification-option-icon"><i class="link big check circle outline icon green"></i></p>
										</div>
										<div class="eight wide column notification-column">
											<p class="notification-option-icon"><i class="link big times circle outline icon red"></i></p>
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
			</table>
		</div>
		<div class="row">
			<h1>Team notifications</h1>
		</div>
		<div class="row">
			<table class="ui tablet stackable table">
			<tbody>
				@foreach($user->teams as $team)
					<tr>
						<td>
							<div class="ui stackable grid notifications-grid">
								<div class="twelve wide column">
									<div class="ui stackable grid">
										<div class="wide column notification-column user-avatar-column">
											<img src="{{ isset($user->picture_url) ? $user->picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" alt="Sender image" class="ui tiny image squared-image"/>
										</div>
										<div class="ten wide column notification-column">
											<p>
												<a href={{ action('UserController@show', ['id' => $user->id]) }}>
													{{ $user->name }}
												</a>
												invited you to join their team
												<a href={{ action('TeamController@show', ['id' => $team->id]) }}>
													{{ $team->name }}
												</a>
												.
											</p>
										</div>
										<div class="four wide column notification-column">
											<!-- TODO: add datetime rendering classes. Blocked by #188 -->
											<p class="date">2 minutes ago</p>
										</div>
									</div>
								</div>
								<div class="four wide column">
									<div class="ui padded grid">
										<div class="eight wide column notification-column">
											<p class="notification-option-icon"><i class="link big check circle outline icon green"></i></p>
										</div>
										<div class="eight wide column notification-column">
											<p class="notification-option-icon"><i class="link big times circle outline icon red"></i></p>
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
			</table>
		</div>
	</div>
</div>
@section('scripts')
<script>
	// TODO: uncomment next 2 lines. Blocked by #188
	/* render sent datetime for all invites*/
	// renderDateTimeAgoOnce();
</script>
@endsection
@endsection
