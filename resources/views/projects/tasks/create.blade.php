@extends('layouts.app')

@section('title', 'New task')

@section('content')
<div class="padded content">
	<h1>New task</h1>
	<!-- TODO: action url -->
	<form class="ui form {{ $errors->any() ? 'error': '' }}" method="post" enctype="multipart/form-data" action="">
		@csrf
		<div class="ui stackable grid">
			<div class="ten wide column" style="padding-left: 0 !important;">
				<!-- Title -->
				<div class="field {{ $errors->has('title') ? 'error': '' }}">
					<label for="title">Title</label>
					<input type="text" id="title" name="title" placeholder="e.g. Design UI layout" value="{{ old('title') }}">
				</div>
				<!-- Description -->
				<div class="field {{ $errors->has('description') ? 'error': '' }}">
					<label for="description">Description</label>
					<textarea id="description" name="description" placeholder="e.g. Design the layout for the application in all devices...">{{ old('description') }}</textarea>
				</div>
			</div>
			<div class="six wide column" style="padding-left: 0 !important;">
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
			</div>
		</div>
		<!-- Save button -->
		<button type="submit" class="ui primary submit button">Save</button>
		<!-- Error message -->
		<div class="ui error message">
			<div class="header">Whoops! Something went wrong.</div>
			@if($errors->any())
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			@endif
		</div>
	</form>
</div>
@section('scripts')
<script src="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.js"></script>
<script>
	/* Due date datetime picker */
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

	/* Semantic UI form validation */
	$(".ui.form").form({
		fields: {
			title: ["empty", "maxLength[30]"],
			description: ["empty", "maxLength[2000]"],
			dueDate: ["empty"]
		},
		onFailure: function() {
			return false;
		}
	});

</script>
@endsection
@endsection
