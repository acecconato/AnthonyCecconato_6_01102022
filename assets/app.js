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

$(document).ready(function () {
    $('[data-toggle="popover"]').popover({
        trigger: 'hover click focus',
        placement: 'top'
    });

    document.querySelector('a[data-action="toggle-medias"]').addEventListener('click', (e) => {
        document.querySelector('#medias-toggle').classList.remove('d-none');
        e.currentTarget.remove()
    })
});
