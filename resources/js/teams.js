// front-end input validation
$(".ui.form").form({
	fields: {
		teamName: ["empty", "maxLength[30]"]
	},
	onFailure: function () {
		// onFailure needs to exist to prevent form from sending request
		return false;
	}
});

// click on image uploader
$(".image-uploader").click(function (event) {
	event.preventDefault();
	$("#teamImage").trigger('click');
});

function updateImagePreview(imageInput) {
	const reader = new FileReader();

	const file = imageInput.files[0];
	const maxImageSize = 1024 * 1024 * 1; // 1MiB

	// validate file
	if (!file || !isValidImage(file, maxImageSize)) {
		alert("Please upload a .png or .jpeg file. Maximum size: 1MiB.");
		return false;
	}

	// update preview when completed successfully
	reader.addEventListener("load", function () {
		$("#preview").attr("src", reader.result);
		$(".preview-container").removeClass("hidden");
	});
	reader.readAsDataURL(file);
}
