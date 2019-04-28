import { format, render, cancel } from 'timeago.js';
import _debounce from 'lodash.debounce';

/* global functions */
function renderDateTimeAgoOnce() {
	$(".needs-datetimeago").each(function() {
		let currentDatetime = $(this).data("datetime") + " UTC";
		let currentDatetimeUTC = new Date(currentDatetime);
		$(this).html(format(currentDatetimeUTC));
	});
};

window.renderDateTimeAgoOnce = renderDateTimeAgoOnce;
