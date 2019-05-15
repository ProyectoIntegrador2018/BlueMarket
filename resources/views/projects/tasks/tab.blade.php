<div class="ui stackable grid">
	@if($project->isCollaborator(Auth::id()))
		<div class="right aligned sixteen wide column">
			<button type="button" class="ui button primary" onclick="showTaskModal('new')">New task</button>
		</div>
	@endif
	<div class="sixteen wide column">
		@include('projects.tasks.index')
	</div>
</div>
@if($project->isCollaborator(Auth::id()))
	@include('projects.tasks.form', ['name' => 'new'])
	@include('projects.tasks.form', ['name' => 'edit'])
@endif
@include('projects.tasks.details')

@push('js')
<script>
	@if($project->isStakeholder(Auth::id()))
		function fillTaskDetailsModal(task) {
			// title
			$("#task-details #task-title").text(task.title);
			$("#task-details #task-edit-btn").data('id', task.id);

			// status
			switch(task.task_status) {
				case 1: //todo
					$("#task-details #task-status p").text("To-do");
					$("#task-details #task-status i").removeClass().addClass("small circle green icon");
					break;
				case 2: // in-progress
					$("#task-details #task-status p").text("In progress");
					$("#task-details #task-status i").removeClass().addClass("small circle yellow icon");
					break;
				case 3: // closed
					$("#task-details #task-status p").text("Closed");
					$("#task-details #task-status i").removeClass().addClass("small circle blue icon");
					break;
			}

			// description
			$("#task-details #task-description").text(task.description);

			// due date
			const deadline = task.deadline;
			const currentDatetimeUTC = Date.now();
			const deadlineDateUTC = new Date(deadline + "Z");
			const isOverdue = deadlineDateUTC < currentDatetimeUTC;
			$("#task-details #task-due-date").text(task.deadline).data("datetimeutc", task.deadline);
			// style due date
			if(isOverdue) {
				$("#task-details #task-due-date").addClass("overdue");
			}
			else {
				$("#task-details #task-due-date").addClass("overdue");
			}

			// task opened details
			$("#task-details #task-opened-date").text(task.created_at).data("datetimeutc", task.created_at);
			$("#task-details #task-opened-by").text(task.creator.name);

			// task closed details
			if(task.task_status == 3) { // task is closed
				$("#task-details #task-closed-date").text(task.completed_date).data("datetimeutc", task.completed_date);
				$("#task-details #task-closed-by").text(task.closed_by.name);
				$("#task-details #task-closed-details").show();
			}
			else {
				$("#task-details #task-closed-details").hide();
			}

			// format all datetimes to local
			utcToLocal();
		}

		function showTaskDetailsModal(taskId) {
			$.ajax({
				type: "GET",
				url: `/tasks/${taskId}`,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				dataType: 'json',
				success: function (task) {
					fillTaskDetailsModal(task);
					$("#task-details-modal").modal("show");
				}
			});
		}

		$(".task-list").click((e) => {
			if(!$(e.target).hasClass("task-title")) return;
			const taskId = $(e.target).closest(".task").data("taskid");
			showTaskDetailsModal(taskId);
		});

		/* format datetimes */
		renderDateTimeAgoOnce();
		utcToLocal();
	@endif
	@if($project->isCollaborator(Auth::id()))
		function showTaskModal(action) {
			$(`#${action}-task-form-modal`).modal("show");
		}

		function submitTaskForm(action) {
			$(`#${action}-task-form`).submit();
		}

		function getTaskComponent(task) {
			const id = task.id;
			const title = task.title;
			const createdAt = task.created_at;
			const creatorId = task.created_by;
			const creatorName = task.creator.name;
			const deadline = task.deadline;

			// determine if the task is overdue
			const currentDatetimeUTC = Date.now();
			const deadlineDateUTC = new Date(deadline + "Z");
			const isOverdue = deadlineDateUTC < currentDatetimeUTC;

			let endpoint = "{{ action('UserController@show', ['id' => 1]) }}";
			endpoint = endpoint.substring(0, endpoint.length-1) + creatorId;

			const taskComponent = 	`<div class="task new-task" data-taskid="${id}">
										<div class="ui grid">
											<div class="column">
												<span title="Open task"><i class="small circle green icon"></i></span>
											</div>
											<div class="fourteen wide column">
												<p class="task-title">${title}</p>
												<p>Opened <span class="needs-datetimeago" data-datetime="${createdAt}">${createdAt}</span> by <a href="${endpoint}">${creatorName}</a></p>
												<p class="task-due ${ isOverdue ? 'overdue' : '' }">Due <span class="needs-localdatetime" data-datetimeutc="${deadline}">${deadline}</span></p>
											</div>
										</div>
									</div>`;

			return taskComponent;
		}

		function clearTaskForm() {
			$(".task-form-modal [name='title']").val("");
			$(".task-form-modal [name='dueDate']").val("");
			$(".task-form-modal [name='description']").val("");
		}

		/* Semantic UI form validation */
		$("#new-task-form").form({
			fields: {
				title: ["empty", "maxLength[255]"],
				description: ["empty"],
				dueDate: ["empty"]
			},
			onSuccess: function(event) {
				event.preventDefault();
				let dueDate = $("#new-task-form #dueDate").val();
				let isoDueDate = new Date(dueDate).toISOString();

				$.ajax({
					type: "POST",
					url: "/tasks",
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: {
						'title': $("#new-task-form #title").val(),
						'dueDate': isoDueDate,
						'description': $("#new-task-form #description").val(),
						'project': $("#new-task-form #project").val()
					},
					dataType: 'json',
					success: function (task) {
						taskToAdd = getTaskComponent(task);

						// add task to list
						$("#to-do-tasks > .task").first().before(taskToAdd);

						clearTaskForm(); // empty input in form

						// format datetimes
						renderDateTimeAgoOnce();
						utcToLocal();

						$(".task-form-modal").modal("hide");
					},
					error: function () {
						$(".task-form-modal").modal("hide");
						$("#new-task-form-error-modal").modal("show");
					}
				});
			},
			onFailure: function() {
				return false;
			}
		});

		/* Populate edit form with task data */
		$("#task-edit-btn").click((e) => {
			const $btn = $(e.target);
			const id = $btn.data('id');
			const title = $("#task-details #task-title").text();
			const description = $("#task-details #task-description").text();
			const dueDate = $("#task-details #task-due-date").text();
			const $form = $("#edit-task-form");
			$form.find("input[name=title]").val(title);
			$form.find("input[name=dueDate]").val(dueDate);
			$form.find("textarea[name=description]").val(description);

			showTaskModal('edit');
		});
	@endif
</script>
@endpush
