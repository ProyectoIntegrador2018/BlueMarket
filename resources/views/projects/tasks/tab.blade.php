<div class="ui stackable grid">
	@if($project->isCollaborator(Auth::id()))
		<div class="right aligned sixteen wide column">
			<button type="button" class="ui button primary" onclick="showNewTaskModal()">New task</button>
		</div>
	@endif
	<div class="sixteen wide column">
		@include('projects.tasks.index')
	</div>
</div>
@if($project->isCollaborator(Auth::id()))
	<div id="task-form-modal" class="ui tiny modal task-form-modal">
		<div class="content">
			@include('projects.tasks.form')
		</div>
		<div class="actions">
			<button type="button" class="ui black deny button">Close</button>
			<button type="submit" class="ui primary button" onclick="createNewTask()">Save</button>
		</div>
	</div>
	<div id="task-form-error-modal" class="ui modal">
		<div class="header">Something went wrong</div>
		<div class="content">
			<i class="times huge red circle icon"></i>
			<p>We were unable to add or edit this task.</p>
		</div>
		<div class="actions">
			<button type="button" class="ui black deny button">Done</button>
		</div>
	</div>
@endif
<div id="task-details-modal" class="ui modal task-details-modal">
	<div class="scrolling content">
		@include('projects.tasks.details')
	</div>
	<div class="actions">
		<button class="ui black deny button">Close</button>
	</div>
</div>
<script>
	@if($project->isStakeholder(Auth::id()))
		function fillTaskDetailsModal(task) {
			// title
			$("#task-details #task-title").text(task.title);

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

		$(".task-title").click((e) => {
			const taskId = $(e.target).closest(".task").data("taskid");
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
		});

		/* format datetimes */
		renderDateTimeAgoOnce();
		utcToLocal();
	@endif

	@if($project->isCollaborator(Auth::id()))
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

		/* New task modal */
		function showNewTaskModal() {
			$("#task-form-modal").modal("show");
		}

		function createNewTask() {
			$("#new-task-form").submit();
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

			const taskComponent = 	`<div class="task" data-taskid="${id}">
										<div class="ui grid">
											<div class="column">
												<span title="Open task"><i class="small circle green icon"></i></span>
											</div>
											<div class="fourteen wide column">
												<p class="task-title">${title}</p>
												<p>Opened <span class="needs-datetimeago" data-datetime="${createdAt}">${createdAt}</span> by <a href="/users/${creatorId}">${creatorName}</a></p>
												<p class="task-due ${ isOverdue ? 'overdue' : '' }">Due <span class="needs-localdatetime" data-datetimeutc="${deadline}">${deadline}</span></p>
											</div>
										</div>
									</div>`;

			return taskComponent;
		}

		function clearTaskForm() {
			$("#new-task-form [name='title']").val("");
			$("#new-task-form [name='dueDate']").val("");
			$("#new-task-form [name='description']").val("");
		}

		/* Semantic UI form validation */
		$("#new-task-form").form({
			fields: {
				title: ["empty", "maxLength[255]"],
				description: ["empty", "maxLength[2000]"],
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

						$("#task-form-modal").modal("hide");
					},
					error: function () {
						$("#task-form-modal").modal("hide");
						$("#task-form-error-modal").modal("show");
					}
				});
			},
			onFailure: function() {
				return false;
			}
		});
	@endif
</script>
