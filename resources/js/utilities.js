import { format } from 'timeago.js';
import _debounce from 'lodash.debounce';

/* global functions */
function renderDateTimeAgoOnce() {
	$(".needs-datetimeago").each(function() {
		let currentDatetime = $(this).data("datetime") + "Z";
		let currentDatetimeUTC = new Date(currentDatetime);
		$(this).html(format(currentDatetimeUTC));
	});
};

function utcToLocal() {
	$(".needs-localdatetime").each(function () {
		let currentDatetimeUTC = $(this).data("datetimeutc") + "Z";
		let currentDatetime = new Date(currentDatetimeUTC);

		// format the string to YYYY/MM/DD hh:mm:ss
		let dateString =
			currentDatetime.getFullYear() + "/" +
			("0" + (currentDatetime.getMonth() + 1)).slice(-2) + "/" +
			("0" + currentDatetime.getDate()).slice(-2) + " " +
			("0" + currentDatetime.getHours()).slice(-2) + ":" +
			("0" + currentDatetime.getMinutes()).slice(-2) + ":" +
			("0" + currentDatetime.getSeconds()).slice(-2);
		$(this).html(dateString);
	});
};

window.renderDateTimeAgoOnce = renderDateTimeAgoOnce;
window.utcToLocal = utcToLocal;
