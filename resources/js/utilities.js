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
		let month = (currentDatetime.getMonth() + 1).toString().padStart(2, '0');
		let day = currentDatetime.getDate().toString().padStart(2, '0');
		let year = currentDatetime.getFullYear();
		let hours = currentDatetime.getHours();
		let minutes = currentDatetime.getMinutes().toString().padStart(2, '0');
		let ampm = hours >= 12 ? 'PM' : 'AM';

		hours = hours % 12;
		hours = hours ? hours : 12; // the hour '0' should be '12'

		let dateString = `${month}/${day}/${year} ${hours}:${minutes} ${ampm}`;
		$(this).html(dateString);
	});
};

window.renderDateTimeAgoOnce = renderDateTimeAgoOnce;
window.utcToLocal = utcToLocal;
