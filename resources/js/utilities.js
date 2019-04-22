import { render, cancel } from 'timeago.js';
import _debounce from 'lodash.debounce';

function filterUsersByName(pattern) {
	$.ajax({
		// TODO: update url
		url: '/users/',
		method: 'get',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		data: {
			'pattern': pattern
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

function renderDateTimeAgoOnce() {
	render($(".needs-datetimeago"));
	cancel(); // stop real-time rendering
}
