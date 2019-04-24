@extends('layouts.app')

@section('title', 'Users') <!--check if its Users or Students-->

@section('content')
<div class="padded content">
	<h1>Students</h1>
	<!-- Filters -->
	<form class="ui form">
		<!-- Search by name -->
		<div class="field">
			<label for="searchName">Name</label>
			<input id="searchName" type="text" name="searchName" placeholder="e.g. Maria Garza">
		</div>
		<!-- Search by skills -->
		<div class="field">
			<label for="skills">Skills</label>
			<select id="searchSkills" name="skills" class="ui fluid search dropdown searchSkills" multiple>
				@foreach ($skills as $skill)
					<option value="{{ $skill->name }}">{{ $skill->name }}</option>
				@endforeach
			</select>
		</div>
		<button id="searchButton" type="button" class="ui primary submit button">Search</button>
	</form>
	<!-- Message -->
	<div hidden class="ui message noStudentsMessage">
		<div class="header">
			No Students Found
		</div>
		<p>No students meet search criteria.</p>
	</div>
	<!-- Student cards -->
	<div class="ui four column stackable grid">
		@foreach ($users as $user)
			@studentCard(['user' => $user])
			@endstudentCard
		@endforeach
	</div>
</div>
@endsection
@section('scripts')
<script>
	$('.ui.dropdown').dropdown();
	let students = {!! $users !!};
</script>
<script src="{{ mix('js/searchFunction.js')}}"></script>
<script>
	const fzs = new FuzzySearch('#searchName', '#searchSkills', '.studentCard-container', students, 'skillset');
</script>

@endsection
