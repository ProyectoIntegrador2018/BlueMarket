import { render, cancel } from 'timeago.js';
import _debounce from 'lodash.debounce';

/* global functions */
window.renderDateTimeAgoOnce = () => {
	render($(".needs-datetimeago"));
	cancel(); // stop real-time rendering
};

function filterStudentsByName(pattern) {
	$.ajax({
		// TODO: update url
		url: '/users/',
		method: 'get',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		data: {
			'pattern': pattern,
			'role' : 3 // student
		},
		dataType: 'json',
		success: function (data) {
			return data;
		},
		error: function (data) {
			// TODO: error handling (need possible errors)
		}
	});
}

function updateUserSearchDropdown() {
	const pattern = $(".text.filtered").text();

	let dropdownOptions = filterUsersByName(pattern);

	// TODO: update options in dropdown programatically
}

$(".search.dropdown.user-search").on("keyup", _debounce(updateUserSearchDropdown, 400));
