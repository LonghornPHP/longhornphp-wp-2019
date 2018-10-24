import Popper from 'popper.js/dist/umd/popper.js';
window.Popper = Popper;
import 'bootstrap';
var jQuery = require('jquery');
import 'jquery-lazy';

import fontawesome from '@fortawesome/fontawesome';
import faFacebookF from '@fortawesome/fontawesome-free-brands/faFacebookF';
import faTwitter from '@fortawesome/fontawesome-free-brands/faTwitter';
import faStar from '@fortawesome/fontawesome-free-solid/faStar';
import faTwitterSquare from '@fortawesome/fontawesome-free-brands/faTwitterSquare';
import faUser from '@fortawesome/fontawesome-free-solid/faUser';
import faBriefcase from '@fortawesome/fontawesome-free-solid/faBriefcase';
import faTimesCircle from '@fortawesome/fontawesome-free-solid/faTimesCircle';

fontawesome.library.add(faFacebookF, faTwitter, faStar, faTwitterSquare, faUser, faBriefcase, faTimesCircle);

jQuery(document).ready(function($){
    if (typeof Tito !== "undefined") {
        Tito.on('event:landing', function(data){
            $('.tito-discount-code-field').val('');
        })
    }

    if ($('.page-template-sessions').length && window.location.hash != '') {
        let talk_id = window.location.hash + '-description';
        if ($(talk_id).length) {
            $(talk_id).collapse('show');
        }
    }

    if ($('.page-template-venue').length) {
        $('.page-template-venue').scrollspy({ target: '#venue-nav', offset: 50 });
    }

    $('.lazy').lazy({
        combined: true,
        // delay: 5000,

        titoLazyLoader: function(element) {
            if (typeof TitoWidget !== 'undefined') {
                TitoWidget.buildWidgets();
                element.load();
            }
        },
    });

});