import jQuery from "jquery";
import select2 from 'select2';
import './bootstrap';
import Alpine from 'alpinejs';
import {darkMode} from "./darkmode";
import {animations} from "./animations";
import {calander} from "./calander.js";
import flatpickr from "flatpickr";

window.$ = jQuery;
window.Alpine = Alpine;
Alpine.start();
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
    flatpickr(".js-date-range-picker", {
        mode: 'range',
    });
});

