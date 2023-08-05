import jQuery from "jquery";
window.$ = jQuery;

import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { darkMode } from "./darkmode";
darkMode();
import { animations } from "./animations";
animations();