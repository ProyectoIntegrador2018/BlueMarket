let reader = new FileReader();

// front-end input validation
$(".ui.form").form({
	fields: {
		teamName: ["empty", "maxLength[30]"]
	},
	onFailure: function () {
		// onFailure needs to exist to prevent form from sending request
		console.log("failed submission");
		return false;
	},
	onSuccess: function () {
		console.log("ok submission");
	}
});

// click on image uploader
$(".image-uploader").click(function (event) {
	event.preventDefault();
	$("#teamImage").click();
});

function updateImagePreview(imageInput) {
	let file = imageInput.files[0];
	reader.addEventListener("loadstart", function () {
		const maxImageSize = 1048576; // 1MiB
		// validate file
		if (!file || !isValidImage(file, maxImageSize)) {
			alert("Please upload a .png or .jpg file.");
			reader.abort();
			return;
		}
	});

	// update preview when completed successfully
	reader.addEventListener("load", function () {
		$("#preview").attr("src", reader.result);
		console.log('this is the result');
		console.log(reader.result);
	});

	reader.readAsDataURL(file);
}
