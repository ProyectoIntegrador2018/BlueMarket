@extends('layouts.app')

@section("meta")
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

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
	<div class="ui stackable grid">
		<div class="row">
			<h1>Project notifications</h1>
		</div>
		<div class="row">
			<table class="ui tablet stackable table">
				<tbody>
					@foreach($projectInvites as $projectInvite)
						<tr data-invite-type="{{ Config::get('enum.invite_type')['project'] }}" data-id="{{ $projectInvite->id }}">
							<td>
								<div class="ui stackable grid notifications-grid">
									<div class="twelve wide column">
										<div class="ui stackable grid">
											<div class="wide column notification-column user-avatar-column">
												<img src="{{ isset($projectInvite->team->leader->picture_url) ? $projectInvite->team->leader->picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" alt="Sender image" class="ui tiny image squared-image"/>
											</div>
											<div class="ten wide column notification-column">
												<p>
													<a href={{ action('UserController@show', ['id' => $projectInvite->team->leader->id]) }}>
														{{ $projectInvite->team->leader->name }}
													</a>
													invited you to join their project
													<a href={{ action('ProjectController@show', ['id' => $projectInvite->id]) }}>
														{{ $projectInvite->name }}
													</a>
													.
												</p>
											</div>
											<div class="four wide column notification-column">
												<div class="four wide column notification-column">
													<p class="date needs-datetimeago" data-datetime="{{ $projectInvite->pivot->created_at }}">{{ $projectInvite->pivot->created_at }}</p>
												</div>
											</div>
										</div>
									</div>
									<div class="four wide column">
										<div class="ui padded grid">
											<div class="eight wide column notification-column">
												<p class="notification-option-icon accept-invite"><i class="link big check circle outline icon green"></i></p>
											</div>
											<div class="eight wide column notification-column">
												<p class="notification-option-icon decline-invite"><i class="link big times circle outline icon red"></i></p>
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
					@foreach($teamInvites as $teamInvite)
						<tr data-invite-type="{{ Config::get('enum.invite_type')['team'] }}" data-id="{{ $teamInvite->id }}">
							<td>
								<div class="ui stackable grid notifications-grid">
									<div class="twelve wide column">
										<div class="ui stackable grid">
											<div class="wide column notification-column user-avatar-column">
												<img src="{{ isset($teamInvite->leader->picture_url) ? $teamInvite->leader->picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" alt="Sender image" class="ui tiny image squared-image"/>
											</div>
											<div class="ten wide column notification-column">
												<p>
													<a href={{ action('UserController@show', ['id' => $teamInvite->leader->id]) }}>
														{{ $teamInvite->leader->name }}
													</a>
													invited you to join their team
													<a href={{ action('TeamController@show', ['id' => $teamInvite->id]) }}>
														{{ $teamInvite->name }}
													</a>
													.
												</p>
											</div>
											<div class="four wide column notification-column">
												<p class="date needs-datetimeago" data-datetime="{{ $teamInvite->pivot->created_at }}">{{ $teamInvite->pivot->created_at }}</p>
											</div>
										</div>
									</div>
									<div class="four wide column">
										<div class="ui padded grid">
											<div class="eight wide column notification-column">
												<p class="notification-option-icon accept-invite"><i class="link big check circle outline icon green"></i></p>
											</div>
											<div class="eight wide column notification-column">
												<p class="notification-option-icon decline-invite"><i class="link big times circle outline icon red"></i></p>
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
	<div id="success-modal" class="ui modal">
		<div class="header">Success</div>
		<div class="content">
			<i class="check huge green circle icon"></i>
			<p>The invite has been accepted!</p>
		</div>
		<div class="actions">
			<button type="button" class="ui ok primary button">Done</button>
		</div>
	</div>
	<div id="success-modal-rejected-invite" class="ui modal">
		<div class="header">Success</div>
		<div class="content">
			<i class="check huge green circle icon"></i>
			<p>The invite has been rejected!</p>
		</div>
		<div class="actions">
			<button type="button" class="ui ok primary button">Done</button>
		</div>
	</div>
	<div id="error-modal" class="ui modal">
		<div class="header">Something went wrong</div>
		<div class="content">
			<i class="times huge red circle icon"></i>
			<p>We were unable to accept this invite.</p>
		</div>
		<div class="actions">
			<button type="button" class="ui ok primary button">Done</button type="button">
		</div>
	</div>
</div>
@section('scripts')
<script src="{{ mix('js/utilities.js')}}"></script>
<script>
	/* render sent datetime for all invites*/
	renderDateTimeAgoOnce();

	/* Handler for accept invite */
	$(".accept-invite").on('click', function () {
		let parenttr = $(this).closest("tr");
		const inviteType = parenttr.data("invite-type");
		const id = parenttr.data("id");
		$.ajax({
			url: '/notifications/accept',
			method: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				'id': id,
				'invite_type' : inviteType
			},
			dataType: 'json',
			success: function(data) {
				$("#success-modal").modal("show");
				parenttr.remove();
			},
			error: function() {
				$("#error-modal").modal("show");
			}
		});

		renderDateTimeAgoOnce(); // refresh sent datetimes
	});

	/* Handler to decline invite */
	$(".decline-invite").on('click', function () {
		let parenttr = $(this).closest("tr");
		const inviteType = parenttr.data("invite-type");
		const id = parenttr.data("id");
		$.ajax({
			url: '/notifications/decline',
			method: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				'id': id,
				'invite_type' : inviteType
			},
			dataType: 'json',
			success: function(data) {
				$("#success-modal-rejected-invite").modal("show");
				parenttr.remove();
			},
			error: function() {
				$("#error-modal").modal("show");
			}
		});

		renderDateTimeAgoOnce(); // refresh sent datetimes
	});
</script>
@endsection
@endsection
