<button type="button" class="ui button primary" onclick="showMilestoneModal('new')">New milestone</button>

<table class="ui celled table">
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Status</th>
			<th>Done date</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($project->milestones as $milestone)
		<tr>
			<td>{{ $loop->iteration }}</td>
			<td>{{ $milestone->name }}</td>
			<td>
				@switch($milestone->status)
					@case(Config::get('enum.milestone_status')['done'])
						<span class="ui green label">Done</span>
						@break

					@case(Config::get('enum.milestone_status')['current'])
						<span class="ui blue label">Current</span>
						@break

					@default
						<span class="ui grey label">Coming up</span>
				@endswitch
			</td>
			<td>{{ isset($milestone->done_date) ?  $milestone->done_date : '-' }}</td>
			<td>
				<button data-id="{{ $milestone->id }}" class="ui button primary milestoneEditBtn">Edit</button>
				<button class="ui button red" onclick="showMilestoneModal('delete', this)">Delete</button>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

<!-- Modals -->
@include('projects.milestones.form', ['name' => 'new'])
@include('projects.milestones.form', ['name' => 'edit'])

<!-- TO DO: missing error validation for edit and delete -->
<div id="delete-milestone-modal" class="ui tiny modal delete-milestone-modal">
	<div class="header">Are you sure you want to delete this milestone?</div>
	<div class="content">
		<form class="ui form milestones delete {{ $errors->any() ? 'error': '' }}">
			@csrf
			<p>Confirming this modal will erase all info about this milestone.</p>
		</form>
	</div>
	<div class="actions">
		<button type="button" class="ui cancel button" onclick="hideMilestoneModal('delete')">No</button>
		<button type="submit" class="ui ok button primary">Yes</button>
	</div>
</div>

@push('js')
<script>

	const milestoneData = {!! $project->milestones !!};

	/* Milestones
	--------------------------------------------------------------------------------------- */

	$("#new-milestone-modal").modal({ transition: "fade up" });

	// Info taken from config/enum.php
	const statusMap = {
		1: 'done',
		2: 'current'
	};

	$('.milestoneEditBtn').click(function(e) {
		const id = $(this).data('id');
		const $form = $('.ui.form.milestones.edit');
		$form.find('input[name=_milestoneID]').val(id);
		const milestone = (milestoneData.filter(m => m.id == id))[0];
		$form.find('.milestoneName').val(milestone.name);
		$form.find('.status').dropdown('set selected', statusMap[milestone.status]);
		$form.find('.ui.calendar').calendar('set date', milestone.done_date);
		$form.find('.prevMilestone').dropdown('set selected', milestone.previous_milestone_id);
		$('#edit-milestone-modal').modal('show');
	});

	function showMilestoneModal(action, btn) {
		$(`#${action}-milestone-modal`).modal('show');
	}

	function hideMilestoneModal(action) {
		$(`#${action}-milestone-modal`).modal('hide');
	}

	function submitForm(modalName) {
		console.log('logged', modalName);
		console.log($(`ui.form.milestones.${modalName}`));
		$(`.ui.form.milestones.${modalName}`).trigger('submit');
	}

	// Form validation
	// $('.ui.form.milestones.new').on('submit', () => {
	// 	console.log('Submitted!');
	// });
	const milestoneFields = {
		milestoneName: ["empty", "maxLength[30]"],
		prevMilestone: ["empty"],
		estimatedDate: ["empty"],
		status: ["empty"]
	};
	$(".ui.form.milestones.new").form({
		fields: milestoneFields,
		onSuccess: function(e) {
			e.preventDefault();
			const endpoint = "{{ action('MilestoneController@store') }}";
			sendMilestone.call(this, endpoint, false);
		},
		onFailure: function() {
			console.error('Form failed validation');
			return false;
		}
	});
	$(".ui.form.milestones.edit").form({
		fields: milestoneFields,
		onSuccess: function(e) {
			e.preventDefault();
			const id  = $(this).find("input[name=_milestoneID]").val();
			let endpoint = "{{ action('MilestoneController@update', ['id' => 1]) }}";
			endpoint = endpoint.substring(0, endpoint.length-1) + id;
			sendMilestone.call(this, endpoint, true);
		},
		onFailure: function() {
			console.error('Form failed validation');
			return false;
		}
	});

	function sendMilestone(endpoint, isEdit) {
		e.preventDefault();
		let modalName = 'new';

		let values = $(this).form('get values');
		values['name'] = values['milestoneName'];
		values['project_id'] = {{ $project->id }};

		if(isEdit) {
			values['_method'] = 'PUT';
			modalName = 'edit';
		}

		$.ajax({
			type: "POST",
			url: endpoint,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: values,
			dataType: 'json',
			success: function (data) {
				console.log(data);
				// TODO: insert the milestone into the list
				alert('Your milestone has been created!');
			},
			error: function (xhr, status) {
				console.error(status);
				console.error(xhr);
				// TODO: Let's be more specific about this
				alert('Uh oh! Something went wrong and we couldn\'t create your milestone. Please try again later.');
			},
			complete: function(xhr, status) {
				$(`#${modalName}-milestone-modal`).modal("hide");
			}
		});
	}

	// Edit modal

	/* Pending delete ajax call */
	/* $(".ui.form.milestones.delete").form({
		fields: {
		},
		onSuccess: function() {
			alert('success');
			event.preventDefault();
			$.ajax({
				type: "post",
				url: "/milestones",
				data: {
					milestoneId: milestoneToDel
				},
				dataType: 'json',
				success: function (data) {
					console.log(data);
					alert('Your milestone has been created!');
				},
				error: function (data) {
					console.log(data);
					alert('Uh oh! Something went wrong and we couldn\'t create your milestone.');
				}
			});
			$("#new-milestone-modal").modal("hide");
		},
		onFailure: function() {
			alert('failure');
			return false;
		}
	}); */
</script>
@endpush
