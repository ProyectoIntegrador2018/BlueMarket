
@extends('layouts.app')

@section('title', 'Register a course')

@section('content')
<div class="padded content">
	@form([
		'title' => 'Create team',
		'method' => 'POST',
		'action' => '/route'
	])
	@endform
</div>
@endsection
