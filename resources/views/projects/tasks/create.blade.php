<div class="padded content">
	<!-- TODO: action url -->
		<div class="ui stackable grid">
				<div class="row">
					<div class="sixteen wide column">
						<h1>New task</h1>
					</div>
				</div>
				<div class="row">
					<form class="ui form tasks create{{ $errors->any() ? 'error': '' }}" method="post" enctype="multipart/form-data" action="/tasks" style="width: 100%;">
						@csrf
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
									@if($errors->any())
										<ul>
											@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									@endif
								</div>
							</div>
						</div>
					</form>
				</div>
		</div>
</div>
