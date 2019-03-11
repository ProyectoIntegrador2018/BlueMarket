function isAlphanumeric(id){
	var val = $("input#" + id).val();
	var pattern = new RegExp("^[a-zA-Z0-9][a-zA-Z0-9\\s]+");
	console.log("Alfanumeric " + id + " " + val);
	return val !== null && val !== undefined && val !== '' && pattern.test(val);
}

function hasSelection(id){
	var selected = $("select#" + id).val().length;
	console.log("Select " + id + " " + selected);
	return selected !== null && selected !== undefined && selected !== '' && selected > 0;
}

function isInteger(id){
	var num = $("input#" + id).val();
	var pattern = new RegExp("^[0-9]+$");
	console.log($("Number " + id + " " + $("input#" + id).val()));
	return num > 0 && pattern.test(num);
}

function isValidImage(file, maxImageSize, acceptedTypes) {
	return acceptedTypes.has(file.type) && file.size <= maxImageSize;
}
