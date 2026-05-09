import jQuery from "jquery";
import select2 from 'select2';
import './bootstrap';
import {darkMode} from "./darkmode";
import {animations} from "./animations";
import {calander} from "./calander.js";
import flatpickr from "flatpickr";

window.$ = jQuery;
darkMode();
animations();
calander();
select2();


$(document).ready(function () {
    $('.selector-for-js').each(function () {
        if ($(this).length > 0) {
            $(this).select2();
        }
    });

    $('.selector-for-calendar-users').each(function () {
        if ($(this).length > 0) {
            $(this).select2({
                templateSelection: formatPill
            });
        }
    });

    flatpickr(".js-date-range-picker", {
        mode: 'range',
    });

    flatpickr(".js-date-picker", {
        mode: 'single',
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });
});

