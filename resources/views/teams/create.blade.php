
@extends('layouts.app')

@section('title', 'Create team')

@section('content')
<div class="padded content">
	<h1>Create team</h1>
	<form class="ui form" method="POST" action="/route">
		@csrf
		@form
		@endform
		<!-- Submit button -->
		<button id="send" type="submit" class="ui button primary">Create team</button>
	</form>
</div>
@section('scripts')
<script src="/js/teams.js"></script>
@endsection
@endsection
