import './styles/app.scss';
import 'jquery.scrollto';
import { cookieExists, cookieHasValue, deleteCookie, setCookie } from 'cookies-utils';

const $ = require('jquery');
require('bootstrap');

$(document).ready(function() {
    // Cookies management & behaviour
    let appBody = document.getElementById('app-body');
    let googleTagManagerId = appBody.dataset.appGtm;
    let cookieConsent = appBody.dataset.appCookieConsent;
    let cookieConsentGtm = appBody.dataset.appCookieConsentGtm;
    let cookiesConsentButtonDeclineAllNode = $('#cookies-consent-button-decline-all');
    let cookiesConsentButtonAcceptAllNode = $('#cookies-consent-button-accept-all');
    let customSwitch2Node = $('#customSwitch2');
    $('#cookie-modal2-opener-button').bind('click', 'button', function(event) {
        $('#cookieStaticBackdropModal1').modal('hide');
        $('#cookieStaticBackdropModal2').modal('show');
    });
    $('#cookie-modal1-opener-button').bind('click', 'button', function(event) {
        $('#cookieStaticBackdropModal1').modal('show');
        $('#cookieStaticBackdropModal2').modal('hide');
    });
    const cookieConsentOptions = {
        name: cookieConsent,
        value: 'yes',
        maxAge: 31536000, // 1 year
        path: '/',
        secure: false,
        sameSite: 'lax' // optional enum 'lax' | 'strict' | 'none'
    };
    cookiesConsentButtonDeclineAllNode.bind('click', 'button', function(event) {
        event.preventDefault();
        setCookie(cookieConsentOptions);
        setCookie({
            name: cookieConsentGtm,
            value: 'no',
            maxAge: 31536000,
            path: '/',
            secure: false,
            sameSite: 'lax'
        });
        $('#cookieStaticBackdropModal1').modal('hide');
        deleteCookie('_ga');
        deleteCookie('_gat_carsadvidor.devel');
        deleteCookie('_gat_carsadvidor.es');
        deleteCookie('_gid');
    });
    cookiesConsentButtonAcceptAllNode.bind('click', 'button', function(event) {
        event.preventDefault();
        setCookie(cookieConsentOptions);
        setCookie({
            name: cookieConsentGtm,
            value: 'yes',
            maxAge: 31536000,
            path: '/',
            secure: false,
            sameSite: 'lax'
        });
        $('#cookieStaticBackdropModal1').modal('hide');
        addGtmDynamicScript(googleTagManagerId);
    });
    if (cookieExists(cookieConsentGtm) && cookieHasValue(cookieConsentGtm, 'yes')) {
        customSwitch2Node.prop('checked', true);
    }
    if (cookieExists(cookieConsentGtm) && cookieHasValue(cookieConsentGtm, 'no')) {
        customSwitch2Node.prop('checked', false);
    }
    customSwitch2Node.bind('click', 'input', function() {
        if (customSwitch2Node.prop('checked')) {
            cookiesConsentButtonDeclineAllNode.prop('disabled', true);
            cookiesConsentButtonAcceptAllNode.prop('disabled', false);
        } else {
            cookiesConsentButtonDeclineAllNode.prop('disabled', false);
            cookiesConsentButtonAcceptAllNode.prop('disabled', true);
        }
    });
    if (googleTagManagerId) {
        if (!cookieExists(cookieConsent)) {
            $('#cookieStaticBackdropModal1').modal('show');
        } else {
            if (cookieExists(cookieConsentGtm) && cookieHasValue(cookieConsentGtm, 'yes')) {
                addGtmDynamicScript(googleTagManagerId);
            }
        }
    }
    // Bootstrap init & scroll on click behaviour in some UI elements
    $('[data-toggle="popover"]').popover();
    $('#navbarSupportedContent').bind('click', 'ul li a', function(event) {
        if (event.target.hash) {
            event.preventDefault();
            $.scrollTo(event.target.hash, 250, {offset: -90});
        }
    });
    // Move to flash messages
    let errorNode = $('.alert-danger');
    let envelopeNode = $('.fa-thumbs-up');
    let exclamationTriangleNode = $('.fa-exclamation-triangle');
    moveToNode(errorNode);
    moveToNode(envelopeNode);
    moveToNode(exclamationTriangleNode);
});

function addGtmDynamicScript(googleTagManagerId) {
    let gtmScriptToAdd = document.createElement('script');
    gtmScriptToAdd.type = 'text/javascript';
    let gtmScriptTextNode = document.createTextNode(
        "(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':" +
        "new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0]," +
        "j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=" +
        "'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);" +
        "})(window,document,'script','dataLayer','"+googleTagManagerId+"');");
    gtmScriptToAdd.appendChild(gtmScriptTextNode);
    document.head.appendChild(gtmScriptToAdd);
}

function moveToNode(node) {
    if (node.length > 0) {
        $('html,body').animate({scrollTop: node.offset().top - 100}, 'slow');
    }
}
