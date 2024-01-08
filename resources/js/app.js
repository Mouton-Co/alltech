import jQuery from "jquery";

import './bootstrap';
import Alpine from 'alpinejs';
import { darkMode } from "./darkmode";
import { animations } from "./animations";
import { Calendar } from '@fullcalendar/core';
import timeGridPlugin from '@fullcalendar/timegrid'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction';
import {calander} from "./calander.js";

window.$ = jQuery;
window.Alpine = Alpine;
Alpine.start();
darkMode();
animations();
calander();
