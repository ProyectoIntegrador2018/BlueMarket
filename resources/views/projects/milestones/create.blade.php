<form class="ui form {{ $errors->any() ? 'error': '' }}" method="post" enctype="multipart/form-data" action="">
@csrf

@include('projects.milestones.form')

<!-- Submit button -->
<button type="submit" class="ui button submit primary">Create</button>
<a href="" title="Back" class="ui button">Back</a>
</form>
</div>

@section('scripts')
<script>
$(document).ready(function(){
	$(".ui.fluid.search.dropdown").dropdown();
})

$(".ui.form").form({
	fields: {
		milestoneName: ["empty", "maxLength[30]"],
		prevMilestone: ["empty"],
		estimatedDate: ["empty"],
		status: ["empty"]
	},
	onFailure: function() {
		return false;
	}
});
</script>
@endsection
