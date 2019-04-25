@extends('layouts.app')

@section("title", $project->name)

@section('content')

<div class="padded content">
	<!-- Project name -->
	<h1>{{ $project->name }}</h1>
	<div class="ui top attached tabular menu">
		<a class="active item" data-tab="overview">Overview</a>
		<a class="item" data-tab="collaborators">Collaborators</a>
		<!-- TODO:check if($project->IsProjectCollaborator(Auth::id())) -->
		<a class="item" data-tab="tasks">Tasks</a>
	</div>
	<div class="ui bottom attached active tab segment" data-tab="overview">
		<div class="ui stackable two column grid">
			<div class="four wide column">
				<!-- Project Image -->
				@if(isset($project->photo))
					<div class="ui image-container">
						<div class="squared-image-container">
							<img src="{{ isset($project->photo) ? $project->photo : 'https://dummyimage.com/400x400/3498db/ffffff.png&text=B' }}" alt="Project Image" class="ui small image squared-image"/>
						</div>
					</div>
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
		</div>
	</div>
	<div class="ui bottom attached tab segment" data-tab="tasks">
		<button type="button" class="ui button primary" onclick="showTaskModal()">New task</button>
		<div id="new-task-modal" class="ui tiny modal new-task-modal">
			@include('projects.tasks.create')
		</div>
	</div>
</div>

@section('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui-calendar/0.0.8/calendar.min.js"></script>
<script>
	/* Semantic UI setup */
	$(".menu .item").tab();

	function hideTaskModal() {
		$("#new-task-modal").modal({
			transition: "fade up"
		}).modal("hide");
	}

	function showTaskModal() {
		$("#new-task-modal").modal({
			transition: "fade up"
		}).modal("show");
	}

	/* Due date datetime picker */
	$(".ui.calendar").calendar({
		monthFirst: false,
		formatter: {
			date: function (date, settings) {
				if (!date) return '';
				var day = date.getDate();
				var month = date.getMonth() + 1;
				var year = date.getFullYear();
				return day + '/' + month + '/' + year;
			}
		}
	});

	/* Semantic UI form validation */
	$(".ui.form").form({
		fields: {
			title: ["empty", "maxLength[30]"],
			description: ["empty", "maxLength[2000]"],
			dueDate: ["empty"]
		},
		onFailure: function() {
			return false;
		}
	});
</script>
@endsection
@endsection
