	<h1>{{ $title }}</h1>
	<form class="ui error form" method="{{ $method }}" action="{{ $action }}">
		@csrf
		<!-- Team avatar -->
		<div id ="image" class="field">
			<label for="teamImage">Team image</label>
			<div class="image-container">
				<div class="image-uploader preview-container">
					<img id="preview" for="teamImage" src="{{ isset($image) ? $image : 'https://avatars1.githubusercontent.com/u/42351872?s=200&v=4' }}" alt="Team image" class="ui small image preview"/>
				</div>
				<a href="#" class="image-uploader">
					<button type="button" class="ui button primary" for="teamImage">Upload image</button>
				</a>
			</div>
			<input id="teamImage" type="file" name="teamImage" accept="image/x-png,image/jpeg" onchange="updateImage(this)" style="display: none">
		</div>
		<!-- Team name -->
		<div class="field">
			<label for="teamName">Team name</label>
			<input type="text" name="teamName" id="teamName" value="{{ isset($teamName) ? $teamName : '' }}">
		</div>
		<!-- Error message -->
		<div id="error" class="ui error hidden message">
			<div class="header">Whoops! Something went wrong.</div>
			<p>Please make sure to properly fill out all required fields.</p>
		</div>
		<!-- Register button -->
		<button id="send" type="submit" class="ui button primary">Create team</button>
	</form>
</div>

<script>
	$(".image-uploader").click(function(event) {
		event.preventDefault();
		$("#teamImage").click();
	});

 	function updateImage(imageInput) {
		let reader  = new FileReader();
		let file = imageInput.files[0];
		let preview = $( "#preview" );
 		reader.addEventListener("load", function () {
			if(validateImage(file)) {
				$( "#preview" ).attr("src", reader.result);
			}
		});
 		if (file) {
			reader.readAsDataURL(file);
		}
	}

	$(document).ready(function(){
		console.log("hello!");
	})

</script>
