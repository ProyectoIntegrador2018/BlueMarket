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

$(".image-uploader").click(function (event) {
	event.preventDefault();
	$("#teamImage").click();
});

function updateImage(imageInput) {
	let reader = new FileReader();
	let file = imageInput.files[0];
	let preview = $("#preview");
	reader.addEventListener("load", function () {
		if (validateImage(file)) {
			$("#preview").attr("src", reader.result);
		}
	});
	if (file) {
		reader.readAsDataURL(file);
	}
}
