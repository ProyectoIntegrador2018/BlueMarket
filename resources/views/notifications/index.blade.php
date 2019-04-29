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
		<div class="four wide column">
			<div id="notifications-menu" class="ui vertical fluid menu">
				<a class="active teal item" data-item="projects">
					Project invites
					<div class="ui {{ count($projectInvites) > 0 ? 'teal' : '' }} label">{{ count($projectInvites) }}</div>
				</a>
				<a class="item" data-item="teams">
					Team invites
					<div class="ui {{ count($teamInvites) > 0 ? 'teal' : '' }} label">{{ count($teamInvites) }}</div>
				</a>
			</div>
		</div>
		<div class="eleven wide column notifications-list active" data-item="projects">
			<table class="ui stackable table notifications-table">
				<tbody>
					@foreach($projectInvites as $projectInvite)
						<tr data-invite-type="{{ Config::get('enum.invite_type')['project'] }}" data-id="{{ $projectInvite->id }}">
							<td class="notification-column">
								<div class="ui two column stackable grid">
										<div class="column">
											<div class="ui two column grid">
												<div class="two wide column user-avatar-column">
													<img src="{{ isset($projectInvite->team->leader->picture_url) ? $projectInvite->team->leader->picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" alt="Sender image" class="ui tiny image squared-image"/>
												</div>
												<div class="fourteen wide column">
													<span>
														<a href={{ action('UserController@show', ['id' => $projectInvite->team->leader->id]) }}>
															{{ $projectInvite->team->leader->name }}
														</a>
														invited you to join their project
														<a href={{ action('ProjectController@show', ['id' => $projectInvite->id]) }}>
															{{ $projectInvite->name }}
														</a>
														.
													</span>
												</div>
											</div>
										</div>
										<div class="column">
											<div class="ui three column grid">
												<div class="ten wide column">
													<span class="date needs-datetimeago" data-datetime="{{ $projectInvite->pivot->created_at }}">{{ $projectInvite->pivot->created_at }}</span>
												</div>
												<div class="three wide right aligned column ">
												<span class="notification-option-icon accept-invite"><i class="link big check circle icon green"></i></span>
											</div>
											<div class="three wide right aligned column">
												<span class="notification-option-icon decline-invite"><i class="link big times circle icon red"></i></span>
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="ui message {{ count($projectInvites) > 0 ? 'hidden' : ''}}">
				<p class="header">No pending project invites</p>
				<p>Looks like you don't have any pending notifications here!</p>
			</div>
		</div>
		<div class="eleven wide column notifications-list" data-item="teams">
			<table class="ui stackable table notifications-table">
				<tbody>
					@foreach($teamInvites as $teamInvite)
						<tr data-invite-type="{{ Config::get('enum.invite_type')['team'] }}" data-id="{{ $teamInvite->id }}">
							<td class="notification-column">
								<div class="ui two column stackable grid">
										<div class="column">
											<div class="ui two column grid">
												<div class="two wide column user-avatar-column">
													<img src="{{ isset($teamInvite->leader->picture_url) ? $teamInvite->leader->picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" alt="Sender image" class="ui tiny image squared-image"/>
												</div>
												<div class="fourteen wide column">
													<span>
														<a href={{ action('UserController@show', ['id' => $teamInvite->leader->id]) }}>
															{{ $teamInvite->leader->name }}
														</a>
														invited you to join their team
														<a href={{ action('TeamController@show', ['id' => $teamInvite->id]) }}>
															{{ $teamInvite->name }}
														</a>
														.
													</span>
												</div>
											</div>
										</div>
										<div class="column">
											<div class="ui three column grid">
												<div class="ten wide column">
													<span class="date needs-datetimeago" data-datetime="{{ $teamInvite->pivot->created_at }}">{{ $teamInvite->pivot->created_at }}</span>
												</div>
												<div class="three wide right aligned column ">
												<span class="notification-option-icon accept-invite"><i class="link big check circle icon green"></i></span>
											</div>
											<div class="three wide right aligned column">
												<span class="notification-option-icon decline-invite"><i class="link big times circle icon red"></i></span>
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="ui message {{ count($teamInvites) > 0 ? 'hidden' : ''}}">
				<p class="header">No pending team invites</p>
				<p>Looks like you don't have any pending notifications here!</p>
			</div>
		</div>
	</div>
	<div id="success-modal" class="ui mini modal">
		<div class="header">Success</div>
		<div class="content">
			<i class="check huge green circle icon"></i>
			<p>The invite has been accepted!</p>
		</div>
		<div class="actions">
			<button type="button" class="ui ok primary button">Done</button>
		</div>
	</div>
	<div id="success-modal-rejected-invite" class="ui mini modal">
		<div class="header">Success</div>
		<div class="content">
			<i class="check huge green circle icon"></i>
			<p>The invite has been rejected!</p>
		</div>
		<div class="actions">
			<button type="button" class="ui ok primary button">Done</button>
		</div>
	</div>
	<div id="error-modal" class="ui mini modal">
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
	/* menu */
	$("#notifications-menu .item").on("click", function() {
		$(".active.teal.item").removeClass("active teal");
		let selectedItem = $(this).data("item");
		$(this).addClass("active teal");
		$(".notifications-list").removeClass("active").hide();
		$(`.notifications-list[data-item='${selectedItem}']`).addClass("active");
		$(`.notifications-list[data-item='${selectedItem}']`).show();
	});

	/* render sent datetime for all invites*/
	renderDateTimeAgoOnce();

	/* Update menu on accept/decline invite */
	function updateMenuContent(listType) {
		// update menu label
		let menuItemLabel = $(`.item[data-item='${listType}'] > .label`).text();
		let itemNotificationCount = parseInt(menuItemLabel, 10) - 1;
		$(`.item[data-item='${listType}'] > .label`).text(itemNotificationCount.toString());

		if(itemNotificationCount <= 0) {
			$(`.item[data-item='${listType}'] > .label`).removeClass("teal");

			// update list associated with menu item
			$(`.notifications-list[data-item='${listType}'] .ui.message`).show();
		}
	}

	/* Handler for accept invite */
	$(".accept-invite").on("click", function () {
		const parenttr = $(this).closest("tr");
		const listType = $(this).closest(".notifications-list").data("item");
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
				updateMenuContent(listType);
			},
			error: function() {
				$("#error-modal").modal("show");
			}
		});

		renderDateTimeAgoOnce(); // refresh sent datetimes
	});

	/* Handler to decline invite */
	$(".decline-invite").on('click', function () {
		const parenttr = $(this).closest("tr");
		const listType = $(this).closest(".notifications-list").data("item");
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
				updateMenuContent(listType);
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
