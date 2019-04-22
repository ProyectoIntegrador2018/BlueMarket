@extends('layouts.app')

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
				@if(isset($team->projects) && count($team->projects) > 0)
					<div class="ui three column stackable grid">
						@foreach ($team->projects as $project)
							@projectCard(['id'=> $project->id,'projectImage' => $project->photo, 'projectName' => $project->name, 'projectShortDescription' => $project->short_description, 'labels' => $project->labels, 'publicMilestone' => 'shipping'])
							@endprojectCard
						@endforeach
					</div>
				@else
					<div id="no-projects-msg" class="ui message">
						<div class="header">
							No projects found!
						</div>
						<p>Looks like this team does not own any projects... yet!</p>
					</div>
				@endif
			</div>
			<div class="ui bottom attached tab segment" data-tab="members">
				<div class="{{ count($team->members) <= 0 ? 'hidden' : '' }}">
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
						<div id="new-member-dropdown" class="ui fluid search selection dropdown">
							<input type="hidden" name="newMember">
							<div class="default text">Select new member</div>
							<div class="menu">
								@foreach($team->members as $member)
									<div class="item" data-value={{ $member->id }}>
										<img class="ui mini circular image" src="{{ isset($member->picture_url) ? $member->picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" style="display: inline; margin-right: 10px;"/>
										{{ $member->name }}
									</div>
								@endforeach
							</div>
						</div>
						<button type="button" class="ui primary button" onclick="validateNewMember()">Add team member</button>
					</div>
					<div id="pendingInvites" class="{{ count($team->members) <= 5 ? 'hidden' : '' }}">
						<h2>Pending invites</h2>
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
					<div id="member-to-add-modal" class="ui modal">
						<div class="header">Add member</div>
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
<script>
	/* Semantic UI tabs */
	$(".menu .item").tab();

	@if(Auth::id() === $team->leader->id)
		/* Semantic UI dropdown */
		$("#new-member-dropdown").dropdown({
			onChange: function() {
				$("#new-member-dropdown").removeClass("error");
			}
		});

		/* Validate invitation to join the team */
		function validateNewMember() {
			// get the info of the user that will receive the invitation
			const newMemberName = $("#new-member-dropdown").dropdown("get text");
			const newMemberId = $("#new-member-dropdown").dropdown("get value");

			if(newMemberId === $("#new-member-dropdown").dropdown("get default value")) {
				$("#new-member-dropdown").addClass("error");
				return false;
			}

			$("#newMemberName").text(newMemberName);
			$("#member-to-add-modal").modal({
				transition: "fade up"
			}).modal("show");
		}

		/* Generate a table row with the info of the user to inveite */
		function generateNewMemberRow(user) {
			const id = user.id;
			const name = user.name;
			const picture_url = user.picture_url ? user.picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B';

			let row = `<tr class="selectable">
							<td>
								<a href="/users/${id}">
									<img class="ui mini circular image" src="${picture_url}" style="display: inline; margin-right: 10px;"/>
									${name}
								</a>
							</td>
						</tr>`;

			return row;
		}

		/* Send invitation via ajax to join the team */
		function inviteMember() {
			// get the id of the user that will receive the invitation
			const userToInvite = $("#new-member-dropdown").dropdown("get value");

			$.ajax({
				// TODO: update url
				url: '/teams/edit/{!! $team->id !!}',
				method: 'patch',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {
					'id_new_member': userToInvite
				},
				dataType: 'json',
				success: function(data) {
					// add new member to pending invites list
					let rowToAdd = generateNewMemberRow(data.user);
					$("#pendingInvites tbody").append(rowToAdd);
					$("#pendingInvites").show();
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
