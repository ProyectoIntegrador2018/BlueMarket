@extends('layouts.app')

@section("meta")
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section("title", $project->name)

@section('content')

<div class="padded content">
	<!-- Project name -->
	<h1>{{ $project->name }}</h1>
	<div class="ui top attached tabular menu">
		<a class="item" data-tab="overview">Overview</a>
		<a class="item" data-tab="collaborators">Collaborators</a>
		<!-- TODO:check if($project->IsProjectCollaborator(Auth::id())) -->
		<a class="item" data-tab="tasks">Tasks</a>
		<!-- TODO:check if($project->IsProjectCollaborator(Auth::id())) -->
		<a class="item" data-tab="milestones">Milestones</a>
	</div>

	<div class="ui bottom attached active tab segment" data-tab="overview">
		<div class="ui stackable two column grid">
			<div class="four wide column">
				<!-- Project Image -->
				@if(isset($project->photo))
					<img src="{{ isset($project->photo) ? $project->photo : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" alt="Project Image" class="ui medium image squared-image"/>
				@endif
			</div>
			<div class="twelve wide column">
				<!-- Pitch video -->
				<div class="ui embed">
					<iframe src="{{ $project->video }}" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			</div>
			<div class="eleven wide column">
				<!-- Short description -->
				<div class="ui detail-container">
					<p><strong>Description</strong></p>
					<p>{{ $project->short_description }}</p>
				</div>
				<!-- Long description -->
				<div class="ui detail-container">
					<p><strong>Details</strong></p>
					<p>{{ $project->long_description }}</p>
				</div>
				<div class="ui stackable two column grid">
					<div class="four wide column" style="padding-left: 0;">
						<!-- Associated team -->
						<div class="ui detail-container">
							<p><strong>Owner team</strong></p>
							<!-- Team Image -->
							<a href="{{ url('teams', $project->team->id) }}" title="{{  $project->team->name }}">
								<div class="ui image-container">
									<div class="squared-image-container" >
										<img src="{{ isset($project->team->img_url) ? $project->team->img_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" alt="Owner team: {{ isset($project->team->name) ? $project->team->name : '' }}" class="ui small image squared-image"/>
									</div>
								</div>
							</a>
						</div>
					</div>
					<div class="twelve wide column">
						<!-- Associated course -->
						<div class="ui detail-container">
							<p><strong>Associated course</strong></p>
							@if(isset($project->course))
								<a href="{{ url('courses', $project->course->id) }}">
								<p>{{ $project->course->name }}</p>
								<p>
									@foreach($project->course->teachers as $teacher)
										{{ $loop->first ? '' : ', ' }}
										{{ $teacher->name }}
									@endforeach
								</p>
								<p>{{ $project->course->schedule }}</p>
								</a>
							@endif
						</div>
					</div>
				</div>
			</div>
			<div class="five wide column">
				<!-- Labels -->
				<div class="ui detail-container">
					<p><strong>Labels</strong></p>
					@foreach($project->labels as $label)
						<div class="ui label pill">{{ $label->name }}</div>
					@endforeach
				</div>
				<!-- Skillset -->
				<div class="ui detail-container">
					<p><strong>Required skillset</strong></p>
					@foreach($project->skills as $skill)
						<div class="ui label pill">{{ $skill->name }}</div>
					@endforeach
				</div>
			</div>
			<!-- Progress section -->
			<div class="sixteen wide column">
				<h3>Progress</h3>
				<div id="progress" class="ui blue progress" data-percent="{{ $project->progress * 100 }}">
					<div class="bar">
						<div class="progress">{{ $project->progress * 100 }}%</div>
					</div>
					@if(count($project->milestones) > 0)
						@php
							$currentMilestone = $project->milestones->where('status', Config::get('enum.milestone_status')['current'])->first();
						@endphp
						@if($currentMilestone != null)
							<div class="label">Currently on: {{ $currentMilestone->name }}</div>
						@endif
					@endif
				</div>
				@if(count($project->milestones) > 0)
					<div class="ui list milestone-section">
					@foreach ($project->milestones as $milestone)

						@switch($milestone->status)
						@case(Config::get('enum.milestone_status')['done'])
						<div class="item done">
							<i class="large circle green icon"></i>
							<div class="content">
								<p class="header">{{ $milestone->name }}</p>
								<div class="description">Done on {{ $milestone->done_date}}</div>
							</div>
						</div>
						@break

						@case(Config::get('enum.milestone_status')['current'])
						<div class="item current">
							<i class="large circle blue icon"></i>
							<div class="content">
								<p class="header">{{ $milestone->name }}</p>
								<div class="description"></div>
							</div>
						</div>
						@break

						@default
						<div class="item coming-up">
							<i class="large circle grey icon"></i>
							<div class="content">
								<p class="header">{{ $milestone->name }}</p>
								<div class="description"></div>
							</div>
						</div>
						@endswitch
					@endforeach
					</div>
				@endif
			</div>
		</div>
	</div>

	<div class="ui bottom attached tab segment" data-tab="collaborators">
		<div class="ui stackable grid">
			@if(isset($project->team->members) && count($project->team->members) > 0)
				<div class="eight wide column">
					<h2>Owners</h2>
					<table class="ui striped table">
						<tbody>
							@foreach($project->team->members as $member)
								<tr class="selectable">
									<td>
										<a href="{{ url('users', $member->id) }}">
											<img class="ui mini circular image" src="{{ isset($member->picture_url) ? $member->picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" alt="{{ $member->name }}" style="display: inline; margin-right: 10px;"/>
											{{ $member->name }}
										</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
			@if(isset($project->suppliers) && count($project->suppliers) > 0)
				<div class="eight wide column">
					<h2>Suppliers</h2>
					<table class="ui striped table">
						<tbody>
							@foreach($project->suppliers as $supplier)
								<tr class="selectable">
									<td>
										<a href="{{ url('users', $supplier->id) }}">
											<img class="ui mini circular image" src="{{ isset($supplier->picture_url) ? $supplier->picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" alt="{{ $supplier->name }}" style="display: inline; margin-right: 10px;"/>
											{{ $supplier->name }}
										</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
			@if($project->team->leader->id == Auth::id())
				<div class="sixteen wide column">
					<div class="ui fluid action input" style="margin:20px 0;">
						<div id="new-supplier-dropdown" class="ui fluid search selection dropdown user-search">
							<input class="user-search-input" type="hidden" name="newSupplier">
							<div class="default text">Select new supplier</div>
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
						<button type="button" class="ui primary button" onclick="validateNewSupplier()">Add supplier</button>
					</div>
					@if(isset($project->pending_suppliers))
						<div id="pendingInvites" class="{{ count($project->pending_suppliers) <= 0 ? 'hidden' : '' }}">
							<h2>Pending invites</h2>
							<table class="ui striped table">
								<tbody>
									@foreach($project->pending_suppliers as $pending_supplier)
										<tr class="selectable">
											<td>
												<a href="{{ url('users', $pending_supplier->id) }}">
													<img class="ui mini circular image" src="{{ isset($pending_supplier->picture_url) ? $pending_supplier->picture_url : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" style="display: inline; margin-right: 10px;"/>
													{{ $pending_supplier->name }}
												</a>
											</td>
											<td>
												sent <p class="needs-datetimeago invite-sent-datetime" data-datetime="{{ $pending_supplier->pivot->created_at }}">{{ $pending_supplier->pivot->created_at }}</p>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					@endif
				</div>
				<div id="supplier-to-add-modal" class="ui modal">
					<p class="header">Add supplier</p>
					<div class="content">
						<p>Invite</p>
						<p><strong id="newSupplierName"></strong></p>
						<p>to join <strong>{{ $project->name }}.</strong></p>
					</div>
					<div class="actions">
						<button type="button" class="ui cancel button">Cancel</button>
						<button type="button" class="ui ok primary button" onclick="inviteSupplier()">Confirm</button>
					</div>
				</div>
				<div id="supplier-to-add-error-modal" class="ui modal">
					<div class="header">Something went wrong</div>
					<div class="content">
						<i class="times huge red circle icon"></i>
						<p>We were unable to send an invite to this user.</p>
					</div>
					<div class="actions">
						<button type="button" class="ui ok primary button">Done</button type="button">
					</div>
				</div>
			@endif
		</div>
	</div>
	<div class="ui bottom attached active tab segment" data-tab="tasks">
		<button type="button" class="ui button primary" onclick="showTaskModal()">New task</button>
		@include('projects.tasks.index')
	</div>
	<div id="new-task-modal" class="ui tiny modal new-task-modal">
		<div class="content">
			@include('projects.tasks.create')
		</div>
		<div class="actions">
			<button class="ui black deny button">Close</button>
		</div>
	</div>

	<!-- Milestones -->
	<div id="Milestones" class="ui bottom attached tab segment" data-tab="milestones">
		@include('projects.milestones.index')
	</div>
</div>

@endsection


@section('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui-calendar/0.0.8/calendar.min.js"></script>
<script src="{{ mix('js/utilities.js')}}"></script>
<script>
	/* Semantic UI setup */
	$(".menu .item").tab();
	$("#new-task-modal").modal({ transition: "fade up" });
	$("#supplier-to-add-modal").modal({ transition: "fade up" });
	$("#supplier-to-add-error-modal").modal({ transition: "fade up" });



	$(document).ready(function() {
		$(".ui.fluid.search.dropdown").dropdown();
		$('#progress').progress();
		/* Due date datetime picker */
		$(".ui.calendar").calendar({
			monthFirst: false,
			formatter: {
				date: function (date, settings) {
					if (!date) return '';
					var day = date.getDate();
					var month = date.getMonth() + 1;
					var year = date.getFullYear();
					return month + '/' + day + '/' + year;
				}
			}
		});
	});


	/* Tasks
	--------------------------------------------------------------------------------------- */
	function hideTaskModal() {
		$("#new-task-modal").modal("hide");
	}

	function showTaskModal() {
		$("#new-task-modal").modal("show");
	}
	/* Semantic UI form validation */
	$(".ui.form.tasks.create").form({
		fields: {
			title: ["empty", "maxLength[30]"],
			description: ["empty", "maxLength[2000]"],
			dueDate: ["empty"]
		},
		onFailure: function() {
			return false;
		}
	});


	/* Supplier invitations
	--------------------------------------------------------------------------------------- */
	@if(Auth::id() === $project->team->leader->id)
		/* Semantic UI dropdown */
		$("#new-supplier-dropdown").dropdown({
			onChange: function() {
				$("#new-supplier-dropdown").removeClass("error");
			}
		});

		/* render sent datetime for all invites*/
		renderDateTimeAgoOnce();

		/* Validate invitation to join the team */
		function validateNewSupplier() {
			// get the info of the user that will receive the invitation
			const defaultValue = $("#new-supplier-dropdown").dropdown("get default value");
			const newSupplierName = $("#new-supplier-dropdown").dropdown("get text");
			const newSupplierId = $("#new-supplier-dropdown").dropdown("get value");

			if(newSupplierId === defaultValue) {
				$("#new-supplier-dropdown").addClass("error");
				return false;
			}

			$("#newSupplierName").text(newSupplierName);
			$("#supplier-to-add-modal").modal("show");
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
								sent <p class="needs-datetimeago invite-sent-datetime" data-datetime="${sent_datetime}">${sent_datetime}</p>
							</td>
						</tr>`;

			return row;
		}

		/* Send invitation via ajax to join the project */
		function inviteSupplier() {
			const userToInvite = $("#new-supplier-dropdown").dropdown("get value");
			$.ajax({
				// TODO: update url if needed
				url: '/projects/{!! $project->id !!}',
				method: 'PATCH',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {
					'id_new_supplier': userToInvite
				},
				dataType: 'json',
				success: function(data) {
					let rowToAdd = generatePendingInviteRow(data);
					$("#pendingInvites tbody").prepend(rowToAdd);
					$("#pendingInvites").show();
					$("div[data-value='" + userToInvite + "']").remove();
					renderDateTimeAgoOnce(); // refresh sent datetimes
				},
				error: function() {
					$("#supplier-to-add-error-modal").modal("show");
				}
			});
			$("#new-supplier-dropdown").dropdown("restore defaults");
		}
	@endif
</script>

@stack('js')

@endsection
