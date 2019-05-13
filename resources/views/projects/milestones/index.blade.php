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
	<tbody id="milestoneList">
		@for($i = 1; $i <= count($project->milestones); $i++)
		<tr data-index="{{ $i }}">
			<td>{{ $i }}</td>
			@php
				$milestone = $i > 1 ?  $project->next_milestone($milestone->id) : $project->first_milestone();
			@endphp
			@if(isset($milestone))
			<td class="name">{{ $milestone->name }}</td>
			<td class="status">
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
			<td class="donedate">{{ isset($milestone->done_date) ?  $milestone->done_date : '-' }}</td>
			<td class="buttons">
				<button data-id="{{ $milestone->id }}" class="ui button primary milestoneEditBtn">Edit</button>
			</td>
			@endif
		</tr>
		@endfor
	</tbody>
</table>

<template id="milestoneTpl">
	<tr>
		<td class="index"></td>
		<td class="name"></td>
		<td class="status"> <span class="ui label"></span> </td>
		<td class="donedate"></td>
		<td class="buttons">
			<button data-id="" class="ui button primary milestoneEditBtn">Edit</button>
		</td>
	</tr>
</template>


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
	const milestoneTpl = $('#milestoneTpl')[0];

	/* Milestones
	--------------------------------------------------------------------------------------- */

	$("#new-milestone-modal").modal({ transition: "fade up" });

	$('.milestoneEditBtn').click(function(e) {
		const id = $(this).data('id');
		const $form = $('.ui.form.milestones.edit');
		$form.find('input[name=_milestoneID]').val(id);
		const milestone = (milestoneData.filter(m => m.id == id))[0];
		$form.find('.milestoneName').val(milestone.name);
		let status = milestone.status === null ? 0 : milestone.status;
		$form.find('.status').dropdown('set selected', status);
		$form.find('.ui.calendar').calendar('set date', milestone.done_date);
		$form.find('.prevMilestone').dropdown('set selected', milestone.previous_milestone_id);
		$('#edit-milestone-modal').modal('show');
		const rowIndex = $(this).parent().parent().data('index');
		$('#edit-milestone-modal').find('.submitBtn').data('index', rowIndex);
	});

	function showMilestoneModal(action, btn) {
		$(`#${action}-milestone-modal`).modal('show');
	}

	function hideMilestoneModal(action) {
		$(`#${action}-milestone-modal`).modal('hide');
	}

	function submitForm(modalName) {
		$(`.ui.form.milestones.${modalName}`).trigger('submit');
	}

	// Form validation
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
		let modalName = 'new';

		let values = $(this).form('get values');
		values['name'] = values['milestoneName'];
		values['done_date'] = values['doneDate'] != '' && new Date(values['doneDate']).toISOString();
		values['previous_milestone_id'] = values['prevMilestone'];
		values['project_id'] = {{ $project->id }};

		delete values['milestoneName'];
		delete values['_milestoneID'];
		delete values['doneDate'];
		delete values['prevMilestone'];
		if(values['status'] == 0) {
			// Changing status to null if 'coming up' was selected.
			values['status'] = null;
		}
		if(!values['done_date']) {
			values['done_date'] = null;
		}

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
				if(isEdit) {
					alert('Saved!');
					const rowIndex = $(`#${modalName}-milestone-modal`).find('.submitBtn').data('index');
					updateTableEntry(data, rowIndex);
				}
				else {
					alert('Your milestone has been created!');
					addMilestone(data);
				}
			},
			error: function (data) {
				console.log(data);
				// TODO: Let's be more specific about this
				alert(`Uh oh! Something went wrong and we couldn't ${isEdit ? "save": "create"} your milestone. Please try again later.`);
			},
			complete: function(xhr, status) {
				$(`#${modalName}-milestone-modal`).modal("hide");
				// Clean the modal
				$(`#${modalName}-milestone-modal`).find('form').form('reset');
			}
		});
	}

	function updateTableEntry(milestone, index) {
		milestoneData[index-1] = milestone;
		const $row = $(`#milestoneList tr[data-index="${index}"]`);
		$row.find('.name').html(milestone.name);
		$label = $row.find('.status .ui.label');
		$label.removeClass('green').removeClass('blue').removeClass('grey');
		if(typeof(milestone.status) == 'string') {
			milestone.status = parseInt(milestone.status, 10);
		}
		$label.addClass(classMap(milestone.status)).html(labelMap(milestone.status));
		if(milestone.done_date) {
			let ddate = milestone.done_date;
			ddate = ddate.split(' ')[0];
			$row.find('.donedate').html(ddate);
		}
	}

	function classMap(status) {
		if(status == null) return 'grey';
		let map = {
			1: 'green',
			2: 'blue'
		};
		return map[status];
	}
	function labelMap(status) {
		if(status == null) return 'Coming up';
		let map = {
			1: 'Done',
			2: 'Current'
		};
		return map[status];
	}

	function addMilestone(milestone) {
		const clone = document.importNode(milestoneTpl.content, true);
		const $clone = $(clone);
		$clone.find('.index').html(milestoneData.length+1);
		$clone.find('tr').data('index', milestoneData.length+1);
		$clone.find('.name').html(milestone.name);
		$clone.find('.status .ui.label').addClass(classMap(milestone.status)).html(labelMap(milestone.status));
		if(milestone.done_date) {
			let ddate = milestone.done_date;
			ddate = ddate.split(' ')[0];
			$clone.find('.donedate').html(ddate);
		}
		$clone.find('.milestoneEditBtn').data('id', milestone.id);
		$('#milestoneList').append($clone);
		milestoneData.push(milestone);
	}
</script>
@endpush
