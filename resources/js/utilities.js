import { render, cancel } from 'timeago.js';
import _debounce from 'lodash.debounce';

/* global functions */
window.renderDateTimeAgoOnce = () => {
	render($(".needs-datetimeago"));
	cancel(); // stop real-time rendering
};
