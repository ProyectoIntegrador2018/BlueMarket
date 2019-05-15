<div id="{{ $name }}-task-form-modal" class="ui tiny modal task-form-modal">
	<div class="header">{{ $name == "new" ? "New" : "Edit" }} task</div>
	<div class="content">
		<div class="ui stackable grid">
			<form id="{{ $name }}-task-form" class="ui form {{ $errors->any() ? 'error': '' }}" style="width: 100%;">
				<div class="ui stackable grid">
					<div class="sixteen wide column">
						<!-- Project id -->
						<input type="hidden" id="project" name="project" value="{{ $project->id }}">
						<!-- Title -->
						<div class="field {{ $errors->has('title') ? 'error': '' }}">
							<label for="title">Title</label>
							<input type="text" id="title" name="title" placeholder="e.g. Design UI layout" value="{{ old('title') }}">
						</div>
						<!-- Due date -->
						<div class="field {{ $errors->has('dueDate') ? 'error': '' }}">
							<label for="dueDate">Due date</label>
							<div class="ui calendar">
								<div class="ui input left icon">
									<i class="calendar icon"></i>
									<input id="dueDate" name="dueDate" type="text" placeholder="e.g. 30/4/2019 5:30 PM" value="{{ old('dueDate') }}">
								</div>
							</div>
						</div>
						<!-- Description -->
						<div class="field {{ $errors->has('description') ? 'error': '' }}">
							<label for="description">Description</label>
							<textarea id="description" name="description" placeholder="e.g. Design the layout for the application in all devices...">{{ old('description') }}</textarea>
						</div>
					</div>
					<div class="sixteen wide column">
						<!-- Error message -->
						<div class="ui error message">
							<h2 class="header">Whoops! Something went wrong.</h2>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="actions">
		<button type="button" class="ui black deny button">Close</button>
		<button type="submit" class="ui primary button" onclick="submitTaskForm('{{ $name }}')">{{ $name == "new" ? "Create" : "Update" }}</button>
	</div>
</div>
<div id="{{ $name }}-task-form-error-modal" class="ui modal">
	<div class="header">Something went wrong</div>
	<div class="content">
		<i class="times huge red circle icon"></i>
		<p>We were unable to {{ $name == "new" ? "add" : "edit" }} this task.</p>
	</div>
	<div class="actions">
		<button type="button" class="ui black deny button">Done</button>
	</div>
</div>
