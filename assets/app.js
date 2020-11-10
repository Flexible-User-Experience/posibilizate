import './styles/app.scss';
import 'jquery.scrollto';

const $ = require('jquery');
require('bootstrap');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
    $('#navbarSupportedContent').bind('click', 'ul li a', function(event) {
        event.preventDefault();
        $.scrollTo(event.target.hash, 250, {offset: -90});
    });
});
