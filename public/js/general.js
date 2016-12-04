'use strict';

var general = {

    /**
     * @type {jQuery}
     */
    $body: $('body'),

    /**
     * @type {jQuery}
     */
    $window: $(window),

    /**
     * Initialize page scripts.
     */
    init: function() {

        // Initialize page parts.
        general.MobileNavigation.init();
        general.Navigation.init();
        general.OuterWrapper.init();

        general.FaqLayout.init();
        general.setScrollToLinks();

        // Events
        general.$window.on('load', function(){ general._onLoad(); });
        general.$window.on('resize', function(){ general._onResize(); });
        general.$window.on('scroll', function(){ general._onScroll(); });

        var utils = new Utils();
        utils.initAlertEvents();
    },

    /**
     * Fires when the page is loaded.
     * @private
     */
    _onLoad: function() { general.checkUrl(); },

    /**
     * Fires when the page is resize.
     * @private
     */
    _onResize: function() {  },

    /**
     * Fires on scrolling.
     * @private
     */
    _onScroll: function() {
        var sTop  = general.$window.scrollTop(),
            limit = 50;

        if (sTop > limit) {
            general.Navigation.toggleMiniClass(true);
        } else {
            general.Navigation.toggleMiniClass(false);
        }

    },

    /**
     * Verify ir URL has a hashtag.
     */
    checkUrl: function() {
        var hash = location.hash;
        if (hash) { general.scrollTo(hash); }
    },
    
    /**
     * Validate if a text is a valid anchor.
     * @param {string} text
     * @returns {boolean}
     */
    isAnchor: function(text) {
        var regex = /^\/?#.+/;
        return regex.test(text);
    },

    /**
     * Scroll to a section indicated by hash.
     * @param {string} hash
     * @param {number} scrollTime
     * @param {number} extraOffset
     */
    scrollTo: function(hash, scrollTime, extraOffset) {
        var section = $(hash);

        if (section.length) {
            var st = scrollTime || 1000, eo = extraOffset || 0;
            var offset = section.offset().top - eo;

            if (general.Navigation.elem.length && offset > 0) {

                if (general.$window.width() > 767) {
                    offset -= 60;
                } else if (general.$window.width() > 480 && general.$window.width() < 768) {
                    offset -= 60;
                } else {
                    offset -= 60;
                }
            }

            $('html, body').stop().animate({scrollTop: offset}, st);
        }
    },
    
    /**
     * Initialize anchor links.
     */
    setScrollToLinks: function() {
        var links = $('.scroll-to');

        if (links.length) {
            links.on('click', function(ev) {
                var href = $(this).attr('href');
                var path = href.split('#');
                var anchor = '';

                if (location.pathname == '/') {
                    if (path.length == 2) {
                        anchor = '#' + path[1];
                    } else {
                        anchor = href;
                    }
                } else {
                    anchor = href;
                }

                if (general.isAnchor(anchor)) {
                    ev.preventDefault();
                    general.scrollTo(anchor);
                }

            });
        }

    },

    /**
     * MobileNavigation.
     */
    MobileNavigation: {
        /**
         * @type jQuery
         */
        elem: null,

        /**
         * Initialize page part.
         */
        init: function() {
            this.elem = $('.mobile-navigation');

            if(this.elem.length) {

            }
        }
    },

    /**
     * Navigation.
     */
    Navigation: {
        /**
         * @type jQuery
         */
        elem: null,

        /**
         * @type jQuery
         */
        navigationToggleBtn: null,

        /**
         * Initialize page part.
         */
        init: function() {

            this.elem = $('.navigation2');

            if (this.elem.length) {
                var _this = this;
                this.navigationToggleBtn = this.elem.find('.navigation-toggle');
                this.navigationToggleBtn.on('click', function() { _this.openMobileNavigation(); });
            }
        },

        openMobileNavigation: function() {
            if(this.navigationToggleBtn.hasClass('mobile-navigation-open')) {
                general.MobileNavigation.elem.removeClass('mobile-navigation-open');
                general.Navigation.elem.removeClass('mobile-navigation-open');
                general.OuterWrapper.elem.removeClass('mobile-navigation-open');
                general.$body.removeClass('mobile-navigation-open');

                this.navigationToggleBtn.removeClass('mobile-navigation-open');

            } else {
                general.MobileNavigation.elem.addClass('mobile-navigation-open');
                general.Navigation.elem.addClass('mobile-navigation-open');
                general.OuterWrapper.elem.addClass('mobile-navigation-open');
                general.$body.addClass('mobile-navigation-open');

                this.navigationToggleBtn.addClass('mobile-navigation-open');

            }
        },

        /**
         * Add or remove mini class.
         * @param {boolean} band
         */
        toggleMiniClass: function(band) {
            if (band) {
                this.elem.addClass('mini');
            } else {
                this.elem.removeClass('mini');
            }
        }
    },

    /**
     * OuterWrapper.
     */
    OuterWrapper: {
        /**
         * @type jQuery
         */
        elem: null,

        /**
         * Initialize page part.
         */
        init: function() {
            this.elem = $('.outer-wrapper');

            if(this.elem.length) {

            }
        }
    },

    /**
     * Represent Faq Layout
     * @type {Object}
     */
    FaqLayout: {
        /**
         * @type jQuery
         */
        elem: null,

        /**
         * @type jQuery
         */
        faqs: null,

        /**
         * Initialize page part.
         */
        init: function() {
            this.elem = $('.faqs-layout');

            if(this.elem.length) {
                this.faqs = this.elem.find('.faq');
                this.questions = this.faqs.find('.question');

                this.questions.on('click', this.toggleFaq);
            }
        },

        /**
         * Shows or hide faq
         */
        toggleFaq: function() {
            var $question = $(this),
                $faq = $question.parent(),
                $answer = $question.next('.answer'),
                $inner = $answer.children('.inner');

            if ($faq.hasClass('displayed')) {
                $answer.animate({height: 0}, 400);
                $faq.removeClass('displayed');
            } else {
                $answer.animate({height: $inner.outerHeight()}, 400);
                $faq.addClass('displayed');
            }
        }
    }

};

$(general.init);