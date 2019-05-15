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

		// format the string
		let month = ("0" + (currentDatetime.getMonth() + 1)).slice(-2);
		let day = ("0" + currentDatetime.getDate()).slice(-2);
		let year = currentDatetime.getFullYear();
		let hours = currentDatetime.getHours();
		let minutes = currentDatetime.getMinutes();
		let ampm = hours >= 12 ? 'PM' : 'AM';

		hours = hours % 12;
		hours = hours ? hours : 12; // the hour '0' should be '12'
		minutes = minutes < 10 ? '0' + minutes : minutes;

		let dateString = `${month}/${day}/${year} ${hours}:${minutes} ${ampm}`;
		$(this).html(dateString);
	});
};

window.renderDateTimeAgoOnce = renderDateTimeAgoOnce;
window.utcToLocal = utcToLocal;
