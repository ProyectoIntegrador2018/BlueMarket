import { render, cancel } from 'timeago.js';
import _debounce from 'lodash.debounce';

/* global functions */
function renderDateTimeAgoOnce() {
	render($(".needs-datetimeago"));
	cancel(); // stop real-time rendering
};

window.renderDateTimeAgoOnce = renderDateTimeAgoOnce;
