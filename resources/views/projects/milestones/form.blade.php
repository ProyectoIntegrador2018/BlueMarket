<!-- Milestone name -->
<div class="field">
	<label for="milestoneName">Name</label>
	<input type="text" name="milestoneName" id="milestoneName">
</div>

<!-- Previous milestone -->
<div class="field">
	<label for="prevMilestone">Previous milestone</label>
	<select class="ui fluid search dropdown" name="prevMilestone" id="prevMilestone">
		{{-- @foreach ($milestones as $prevMilestone)
			<option value="{{ $prevMilestone->id }}"> {{ $prevMilestone->name }} </option>
			@endforeach --}}
	</select>
</div>

<!-- Estimated date -->
<div class="field">
	<label for="doneDate">Done date</label>
	<div class="ui calendar">
		<div class="ui input left icon">
			<i class="calendar icon"></i>
			<input id="doneDate" name="doneDate" type="text" placeholder="e.g. 30/4/2019" value="">
		</div>
	</div>
</div>

<!-- Status -->
<div class="field">
	<label for="status">Status</label>
	<select class="ui fluid search dropdown" name="status" id="status">
		<option value="done">Done</option>
		<option value="current">Current</option>
		<option value="coming-up">Coming up</option>
	</select>
</div>

<!-- Error message -->
<div class="ui error message">
	<p class="header">Whoops! Something went wrong.</p>
	@if($errors->any())
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
	@endif
</div>
