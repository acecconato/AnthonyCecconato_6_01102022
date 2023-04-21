/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// start the Stimulus application
import './bootstrap';

import './styles/common.scss';

const $ = require('jquery');

require('bootstrap');

import '@fortawesome/fontawesome-free/js/all.min.js';
import '@fortawesome/fontawesome-free/css/all.min.css';

import './vendor/css/flash.min.css';
import './vendor/js/flash.min.js';

document.addEventListener('DOMContentLoaded', () => {
   window.Flash.create('.flash-message');
});
