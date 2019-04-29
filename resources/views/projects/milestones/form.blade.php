<div id="{{ $name }}-milestone-modal" class="ui tiny modal milestones {{ $name }}-milestone-modal">
	<div class="header">{{ $name == "new" ? "New" : "Edit" }} milestone</div>
	<div class="content">
		<form class="ui form milestones {{ $name }} {{ $errors->any() ? 'error': '' }}">
			<!-- Milestone name -->
			<div class="field">
				<label class="ui left" for="milestoneName">Name</label>
				<input type="text" class="milestoneName" name="milestoneName">
			</div>

			<!-- Previous milestone -->
			<div class="field">
				<label class="ui left" for="prevMilestone">Previous milestone</label>
				<select class="ui fluid search dropdown prevMilestone" name="prevMilestone">
					@foreach ($project->milestones as $milestone)
						<option value="{{ $milestone->id }}"> {{ $milestone->name }} </option>
					@endforeach
				</select>
			</div>

			<!-- Status -->
			<div class="field">
				<label class="ui left" for="status">Status</label>
				<select class="ui fluid search dropdown status" name="status">
					<option value="0">Coming up</option>
					<option value="2">Current</option>
					<option value="1">Done</option>
				</select>
			</div>

			<!-- TO DO: add an if statement so that done date is shown only if the status is done -->
			<!-- Done date -->
			<div class="field">
				<label class="ui left" for="doneDate">Done date</label>
				<div class="ui calendar">
					<div class="ui input left icon">
						<i class="calendar icon"></i>
						<input name="doneDate" type="text" placeholder="e.g. 30/4/2019" value="" class="doneDate">
					</div>
				</div>
			</div>

			<!-- Error message -->
			<div class="ui error message">
				<h2 class="header">Whoops! Something went wrong.</h2>
				@if($errors->any())
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				@endif
			</div>
			<input type="hidden" name="_milestoneID">
		</form>
	</div>
	<div class="actions">
		<button type="button" class="ui cancel button" onclick="hideMilestoneModal('{{ $name }}')">Cancel</button>
		<button type="submit" class="ui ok button primary submitBtn" onclick="submitForm('{{ $name }}')">{{ $name == "new" ? "Create" : "Update"}}</button>
	</div>
</div>
