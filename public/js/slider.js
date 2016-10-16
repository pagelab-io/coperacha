var app = app || {};

(function(app){

    var Slider = (function() {

        /**
         * Constructor
         * @param element
         * @param options
         * @constructor
         */
        function Slider(element, options) {
            this.element = element;
            this.$element = $(element);

            if (this.init) {
                this.init(options);
            }
        }

        Slider.prototype = {

            /**
             * @type {jQuery}
             */
            control: null,

            /**
             * Flag indicates that images are already loaded
             * @type {boolean}
             */
            loaded: null,

            /**
             * Options plugin
             * @type {Object}
             */
            options: null,

            /**
             * Flag indicates that  ...
             * @type {boolean}
             */
            running: null,

            /**
             * Total of slides visibles
             *
             * @type {number}
             */
            qty: null,

            /**
             * Total of slides
             * @type {number}
             */
            total: null,

            /**
             * Ancho de cada Slide contenedor
             *
             * @type {number}
             */
            width: null,

            /**
             * Alto de cada Slide contenedor
             *
             * @type {number}
             */
            height: null,

            /**
             * Pointer to current slide
             *
             * @type {number}
             */
            current: null,

            /**
             * Pointer of prev slide
             * @type {number}
             */
            prev: null,

            /**
             * Pointer of next slide
             * @type {number}
             */
            next: null,

            /**
             * Pointer of start slide
             *
             * @type {number}
             */
            start: null,

            /**
             *
             * @type {number}
             */
            direction: null,

            /**
             *
             * @type {number}
             */
            position: null,

            /**
             *
             * @type {number}
             */
            playInterval: null,

            /**
             *
             * @type {number}
             */
            pauseTimeout: null,

            /**
             *
             * @type {number}
             */
            defaults: {
                slideSpeed: 500,
                fadeSpeed: 500,
                preload: true,
                pause: 1 * 500,
                play: 0,
                qty: 0,
                withPagination: false,
                withNavigation: true,
                classNavigation: ''
            },

            /**
             * Slides List
             * @type {Array}
             */
            slides: null,

            /**
             * @constructor
             *
             * @params {Array} options
             * @returns {void}
             */
            init: function (options) {
                var _this = this;

                // Gets all items from UI
                this.items = this.$element.find('.item');

                // Setup
                this.options = $.extend({}, this.defaults, options);

                // Declare Vars
                this.running = false;
                this.start = 1;
                this.next = 0;
                this.total = this.items.length;

                if (this.options.qty && this.options.qty > 0) {
                    this.qty = this.options.qty;

                    if (window.innerWidth < 420) {
                        this.qty = 1;
                    }

                } else {

                    this.qty = 4;

                    if (window.innerWidth < 420) {
                        this.qty = 2;
                    } else if (window.innerWidth > 420 && window.innerWidth < 769) {
                        this.qty = 3;
                    }
                }

                // Sizing
                this.height = this.$element.height();
                this.width = this.$element.width() / this.qty;

                if (this.options.start) {
                    this.start = this.options.start;
                    this.next = this.start;
                    this.current = this.start - 1;
                } else {
                    this.current = 0;
                }

                // Controls
                this.container  = $('<div class="wrapper">').appendTo(this.$element);
                this.control    = $('<div class="control">').appendTo(this.container);

                this.pagination = $('<ul class="pagination"/>');
                this.caption    = $('<div class="caption"/>');

                this.control.css({
                    position: 'relative',
                    height: this.height,
                    width: this.width * this.qty,
                    left: -(this.width)
                });

                // Iterate array of images
                for (var index = 0, len = this.items.length; index < len; index++) {
                    (function(element, index) {
                        var slide = $('<div class="slide">');
                        var position = ++index;

                        slide.css({
                            display: 'none',
                            height: _this.height + 'px',
                            width: _this.width + 'px'
                        });

                        // CONST 3
                        if (position <= _this.qty) {
                            slide.css({
                                left: (_this.width * position) + 'px',
                                zIndex: 1000
                            });
                        } else {
                            slide.css({
                                left: (_this.width * 1) + 'px',
                                zIndex: 0
                            });
                        }

                        slide.data('position', position);

                        if (element instanceof HTMLElement) {
                            $(element).show();
                            slide.append(element);
                        }

                        if (true === _this.options.withPagination) {
                            // Create pagination
                            var item = $('<li class="dot"/>').appendTo(_this.pagination);
                            item.on('click', {id: "id-" + index}, function (event) {
                                if (event.preventDefault) {
                                    event.preventDefault();
                                }
                                var clicked = parseInt(event.data.id.match('[^id-]+$'));
                                _this._onPagination(clicked);
                            });
                        }

                        // Append to control element
                        slide.appendTo(_this.control);

                    })(this.items[index], index);
                } // endfor

                // Handle navigation
                if (true === this.options.withPagination) {
                    this.pagination.appendTo(this.$element);
                }

                if (true === this.options.withNavigation) {
                    // Create elements for nav
                    this.btnPrev = $('<a class="icons prev"/>').appendTo(this.$element);
                    this.btnNext = $('<a class="icons next"/>').appendTo(this.$element);

                    this.btnPrev
                        .css({top: (this.height / 2) - (this.btnPrev.outerHeight() / 2)})
                        .click(function (event) {
                            if (event.preventDefault) {
                                event.preventDefault();
                            }
                            _this._onPrev();
                        });

                    this.btnNext
                        .css({top: (this.height / 2) - (this.btnNext.outerHeight() / 2)})
                        .click(function (event) {
                            if (event.preventDefault) {
                                event.preventDefault();
                            }

                            _this._onNext();
                        });

                    if (this.options.classNavigation) {
                        this.btnPrev.addClass(this.options.classNavigation);
                        this.btnNext.addClass(this.options.classNavigation);
                        this.pagination.addClass(this.options.classNavigation);
                    }

                }

                if (this.options.preload === true) {

                    this.container.css({
                        'background': 'url(http://coperacha.com.mx/images/loader2.gif) no-repeat center center',
                        'background-size': '32px 32px'
                    });

                    var current = _this.control.find(':eq(' + this.current + ')');

                    if (current.attr('src')) {
                        var url = current.attr('src') + '?' + (new Date()).getTime();
                        var forLoad = current.attr('src', url);

                        forLoad.load(function () {
                            _this.control.children(':eq(' + _this.current + ')').fadeIn(_this.options.fadeSpeed, function () {
                                _this.container.css({background: ''});
                                _this.loaded = true;

                                // Update pagination
                                _this.updatePagination(_this.current);
                            });
                        });

                    } else {

                        setTimeout(function() {
                            var pos = _this.getNextPositions();
                            var current = _this.current;

                            var animation = function () {
                                _this.control.children(':eq(' + current + ')').fadeIn(_this.options.fadeSpeed, function () {

                                    if (++current < pos.length) {
                                        setTimeout(function () {
                                            animation();
                                        }, 500);

                                    } else {
                                        _this.container.css({background: ''});
                                        _this.loaded = true;
                                        // Update pagination
                                        if (_this.options.withPagination) {
                                            _this.updatePagination(_this.current);
                                        }
                                        // console.log('completed');
                                    }
                                });
                            };
                            animation(current);
                        }, 500);
                    }

                } else {
                    // Set Class
                    var active = this.pagination.children(':eq(' + this.current + ')');
                    if (active) {
                        active.addClass('active');
                    }

                    var slide = this.control.children(':eq(' + _this.current + ')').fadeIn(500, function () {
                        _this.loaded = true;
                        _this.$element.css({ background: 'none'});
                    });
                }

                if (this.options.play && this.total > 1) {
                    this.playInterval = setInterval(function () {
                        _this.animate('next', 0);
                    }, this.options.play);

                    this.element.data('interval', this.playInterval);
                }

                // Handler for Resize
                $(window).on("resize", function () {
                    // return _this.update();
                });
            },

            /**
             * Animate slide
             *
             * @param {string} direction
             * @param {number} clicked
             * @returns {void}
             */
            animate: function (direction, clicked) {
                var _this = this;

                if (!this.running && this.loaded) {
                    this.running = true;

                    switch (direction) {
                        case 'prev':
                            this.prev = this.current;
                            this.next = this.current - 1;
                            this.next = this.next === -1 ? this.total - 1 : this.next;
                            this.position = 0;
                            this.direction = 0;
                            this.current = this.next;
                            break;

                        case 'next':
                            this.prev = this.current;
                            this.next = this.current + 1;
                            this.next = (this.total) === this.next ? 0 : this.next;
                            this.position = this.width * 2; // 200 * 3 = 600
                            this.direction = -(this.width * 2);
                            this.current = this.next;
                            break;

                        case 'pagination' :
                            this.prev = this.current;
                            this.next = parseInt(clicked, 10);

                            if (this.next > this.prev) {
                                this.position = this.width * 2;
                                this.direction = -(this.width * 2);

                            } else {
                                this.position = 0;
                                this.direction = 0;
                            }

                            this.current = this.next;
                            break;
                    }

                    // Update pagination
                    if (this.options.withPagination == true) {
                        this.updatePagination(_this.current);
                    }

                    // Update view control
                    var pos = this.getNextPositions();
                    for (var i = 0; i < pos.length; i++) {
                        this.control.children(':eq(' + pos[i] + ')').css({
                            left: this.position + (this.width * i),
                            display: 'flex'
                        });
                    }
                    // Animate Slide Control
                    this.control.animate({
                        left: this.direction
                    }, this.options.slideSpeed, function () {
                        // Reset position of control
                        _this.control.css({
                            left: -(_this.width)
                        });

                        for (var i = 1; i <= pos.length; i++) {
                            var p = pos[i - 1];
                            _this.control.children(':eq(' + p + ')').css({
                                left: _this.width * i,
                                zIndex: 2000
                            });
                        }

                        _this.control.children(':eq(' + _this.prev + ')').css({
                            left: _this.width,
                            display: 'none',
                            zIndex: 0
                        });


                        // Unblock effects
                        _this.running = false;
                    });
                }
            },

            getNextPositions: function() {
                var size = this.qty;
                var pos = [];

                for (var i = 0; i < size; i++) {
                    var x = this.getSinglePos(this.next, i, this.total);
                    pos.push(x);
                }

                return pos;
            },

            /**
             * Get the single value position
             *
             * @param i
             * @param next
             * @param t
             * @returns {number}
             */
            getSinglePos: function (next, i, t) {
                var x = 0;

                if ((next + i) == t) {
                    x = 0;
                } else if ((next + i) > t) {
                    x = (next + i) - this.total;
                } else {
                    x = next + i;
                }

                return x;
            },

            /**
             * Update selected dots
             * @param value
             */
            updatePagination: function (value) {
                var dotActive = this.pagination.children(':eq(' + value + ')');

                if (dotActive) {
                    dotActive.siblings().removeClass('active');
                    dotActive.addClass('active');
                }
            },

            /**
             * Paused Timers
             */
            pause: function () {
                var _this = this;

                if (_this.options.pause) {

                    clearTimeout(_this.element.data('pause'));
                    clearInterval(_this.element.data('interval'));

                    _this.pauseTimeout = setTimeout(function () {
                        clearTimeout(_this.element.data('pause'));

                        _this.playInterval = setInterval(function () {
                            _this.animate('next', 0);
                        }, _this.options.play);

                        // Store play interval
                        _this.element.data('interval', _this.playInterval);
                    }, _this.options.pause);

                    _this.element.data('pause', _this.pauseTimeout);

                } else {
                    _this.stop();
                }
            },

            /**
             * Stop Timers
             */
            stop: function () {
                clearInterval(this.element.data('interval'));
            },

            /**
             * Call when click on prev button
             *
             * @param event
             * @private
             */
            _onPrev: function () {
                // Cancel Events
                if (this.total < 2) { return false; }

                if (this.options.play) { this.pause(); }

                this.animate('prev', 0);
            },

            /**
             * Call when click on next button
             *
             * @param event
             * @private
             */
            _onNext: function () {
                // Cancel Events
                if (this.total < 2) { return false; }

                if (this.options.play) { this.pause(); }

                this.animate('next', 0);
            },

            /**
             * Call when click on pagination button
             *
             * @param clicked
             * @private
             */
            _onPagination: function (clicked) {
                if (clicked != this.current) {
                    this.animate('pagination', clicked);
                }
            }

        };

        return Slider;
    }());

    app.Slider = Slider;
})(app);

(function($, window, undefined){

    $.fn.slider = function(options){
        if (typeof options == 'object' || !options) {
            window.slider = new app.Slider(this, options);
            this.data('Slider', window.slider);
        }
        return this;
    };

})(jQuery, window);
