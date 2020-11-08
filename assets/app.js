import './styles/app.scss';
import '~font-awesome/less/font-awesome.less';

const $ = require('jquery');
require('bootstrap');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});
