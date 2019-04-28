@extends('layouts.app')

@section("meta")
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title', $team->name)

@section('content')
<div class="padded content">
	<div class="ui stackable grid">
		<div class="four wide column">
			<h1 style="text-align: center;">{{ $team->name }}</h1>
			<img src="{{ isset($team->img_url) ? $team->img_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" alt="Team image" class="ui small image preview" style="margin: 0 auto; margin-bottom: 20px; border-radius: 15px;"/>
			<div class="ui stackable grid">
				<div class="eight wide column">
					<p><i class="user outline icon"></i><strong>{{ count($team->members) }} Members</strong></p>
				</div>
				<div class="eight wide column">
					<p><i class="file alternate outline icon"></i><strong>{{ count($team->projects) }} Projects</strong></p>
				</div>
			</div>
			<!-- Contact button -->
			<a class="fluid ui primary button buttonSpace" href="mailto:{{ $team->leader->email }}" style="margin-top: 20px;"><i class="icon envelope"></i>Contact</a>
		</div>
		<div class="twelve wide column">
			<div class="ui top attached tabular menu">
				<a class="active item" data-tab="projects">Projects</a>
				<a class="item" data-tab="members">Members</a>
			</div>
			<div class="ui bottom attached active tab segment" data-tab="projects">
				@if(isset($team->projects))
					<div class="ui three column stackable grid">
						@foreach ($team->projects as $project)
							@projectCard([
								'id'=> $project->id,
								'projectImage' => $project->photo,
								'projectName' => $project->name,
								'projectShortDescription' => $project->short_description,
								'labels' => $project->labels,
								'publicMilestone' => 'shipping'
							])
							@endprojectCard
						@endforeach
					</div>
				@else
					<div id="no-projects-msg" class="ui message">
						<p class="header">No projects found!</p>
						<p>Looks like this team does not own any projects... yet!</p>
					</div>
				@endif
			</div>
			<div class="ui bottom attached tab segment" data-tab="members">
				<div>
					<h2>Current members</h2>
					<table class="ui striped table">
						<tbody>
							@foreach($team->members as $member)
								<tr class="selectable">
									<td>
										<a href="{{ url('users', $member->id) }}">
											<img class="ui mini circular image" src="{{ isset($member->picture_url) ? $member->picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" style="display: inline; margin-right: 10px;"/>
											{{ $member->name }}
										</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				@if($team->leader->id == Auth::id())
					<div class="ui fluid action input" style="margin:20px 0;">
						<div id="new-member-dropdown" class="ui fluid search selection dropdown user-search">
							<input class="user-search-input" type="hidden" name="newMember">
							<div class="default text">Select new member</div>
							<div class="menu">
								<!-- TODO: populate select onChange and onFocus -->
								@if(isset($students))
									@foreach($students as $student)
										<div class="item" data-value={{ $student->id }}>
											<img class="ui mini circular image" src="{{ isset($student->picture_url) ? $student->picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" style="display: inline; margin-right: 10px;"/>
											{{ $student->name }}
										</div>
									@endforeach
								@endif
							</div>
						</div>
						<button type="button" class="ui primary button" onclick="validateNewMember()">Add team member</button>
					</div>
					@if(isset($team->pending_members))
						<div id="pendingInvites" class="{{ count($team->pending_members) <= 0 ? 'hidden' : '' }}">
							<h2>Pending invites</h2>
							<table class="ui striped table">
								<tbody>
									@foreach($team->pending_members as $pending_member)
										<tr class="selectable">
											<td>
												<a href="{{ url('users', $pending_member->id) }}">
													<img class="ui mini circular image" src="{{ isset($pending_member->picture_url) ? $pending_member->picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" style="display: inline; margin-right: 10px;"/>
													{{ $pending_member->name }}
												</a>
											</td>
											<td>
												sent <p class="needs-datetimeago invite-sent-datetime" datetime="{{ $pending_member->pivot->created_at }}">{{ $pending_member->pivot->created_at }}</p>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					@endif
					<div id="member-to-add-modal" class="ui modal">
						<p class="header">Add member</p>
						<div class="content">
							<p>Invite</p>
							<p><strong id="newMemberName"></strong></p>
							<p>to join <strong>{{ $team->name }}.</strong></p>
						</div>
						<div class="actions">
							<button type="button" class="ui cancel button">Cancel</button>
							<button type="button" class="ui ok primary button" onclick="inviteMember()">Confirm</button>
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
@section("scripts")
<script src="{{ mix('js/utilities.js')}}"></script>
<script>
	/* Semantic UI tabs */
	$(".menu .item").tab();
	$("#member-to-add-modal").modal({ transition: "fade up" });

	@if(Auth::id() === $team->leader->id)
		/* Semantic UI dropdown */
		$("#new-member-dropdown").dropdown({
			onChange: function() {
				$("#new-member-dropdown").removeClass("error");
			}
		});

		/* render sent datetime for all invites*/
		renderDateTimeAgoOnce();

		/* Validate invitation to join the team */
		function validateNewMember() {
			// get the info of the user that will receive the invitation
			const defaultValue = $("#new-member-dropdown").dropdown("get default value");
			const newMemberName = $("#new-member-dropdown").dropdown("get text");
			const newMemberId = $("#new-member-dropdown").dropdown("get value");

			if(newMemberId === defaultValue) {
				$("#new-member-dropdown").addClass("error");
				return false;
			}

			$("#newMemberName").text(newMemberName);
			$("#member-to-add-modal").modal("show");
		}

		/* Generate a table row with the info of the user to invite */
		function generatePendingInviteRow(invite) {
			const id = invite.id;
			const name = invite.name;
			const picture_url = invite.picture_url ? invite.picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B';
			const sent_datetime = invite.pivot.created_at;

			const row = `<tr class="selectable">
							<td>
								<a href="/users/${id}">
									<img class="ui mini circular image" src="${picture_url}" style="display: inline; margin-right: 10px;"/>
									${name}
								</a>
							</td>
							<td>
								sent <p class="needs-datetimeago invite-sent-datetime" datetime="${sent_datetime}">${sent_datetime}</p>
							</td>
						</tr>`;

			return row;
		}

		/* Send invitation via ajax to join the team */
		function inviteMember() {
			const userToInvite = $("#new-member-dropdown").dropdown("get value");
			$.ajax({
				// TODO: update url if needed
				url: '/teams/{!! $team->id !!}',
				method: 'PATCH',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {
					'id_new_member': userToInvite
				},
				dataType: 'json',
				success: function(data) {
					console.log(data);
					let rowToAdd = generatePendingInviteRow(data);
					$("#pendingInvites tbody").append(rowToAdd);
					$("#pendingInvites").show();
					renderDateTimeAgoOnce(); // refresh sent datetimes
				},
				error: function(data) {
					// TODO: error handling (need possible errors)
				}
			});
			$("#new-member-dropdown").dropdown("restore defaults");
		}
	@endif
</script>
@endsection
@endsection
