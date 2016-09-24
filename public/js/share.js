
var Share = (function() {

    String.prototype.to_rfc3986 = function () {
        var tmp;
        tmp = encodeURIComponent(this);
        return tmp.replace(/[!'()*]/g, function (c) {
            return "%" + c.charCodeAt(0).toString(16);
        });
    };

    var Share = (function () {

        function Share(element1, options) {
            this.element = element1;
            this.el = {
                head: document.getElementsByTagName('head')[0],
                body: document.getElementsByTagName('body')[0]
            };
            this.config = {
                enabled_networks: 0,
                protocol: ['http', 'https'].indexOf(window.location.href.split(':')[0]) === -1 ? 'https://' : '//',
                url: window.location.href,
                caption: null,
                title: '',
                image: '',
                description: '',
                networks: {
                    twitter: {
                        enabled: true,
                        url: null,
                        description: null
                    },
                    facebook: {
                        enabled: true,
                        load_sdk: true,
                        url: null,
                        app_id: null,
                        title: null,
                        caption: null,
                        description: null,
                        image: null
                    }
                }
            };
            //this.setup(options);
            return this;
        }

        Share.prototype.setup = function (opts) {
            $.extend(this.config, opts, true);
        };

        Share.prototype.network_facebook = function () {
            if (this.config.networks.facebook.load_sdk) {
                if (!window.FB) {
                    return console.error("The Facebook JS SDK hasn't loaded yet.");
                }
                return FB.ui({
                    method: 'feed',
                    name: this.config.networks.facebook.title,
                    link: this.config.networks.facebook.url,
                    picture: this.config.networks.facebook.image,
                    caption: this.config.networks.facebook.caption,
                    description: this.config.networks.facebook.description
                });
            } else {
                return this.popup('https://www.facebook.com/sharer/sharer.php', {
                    u: this.config.networks.facebook.url
                });
            }
        };

        Share.prototype.network_twitter = function () {
            return this.popup('https://twitter.com/intent/tweet', {
                text: this.config.networks.twitter.description,
                url: this.config.networks.twitter.url
            });
        };

        Share.prototype.popup = function (url, params) {
            var k, popup, qs, v;
            if (params == null) {
                params = {};
            }
            popup = {
                width: 500,
                height: 350
            };
            popup.top = (screen.height / 2) - (popup.height / 2);
            popup.left = (screen.width / 2) - (popup.width / 2);
            qs = ((function () {
                var results;
                results = [];
                for (k in params) {
                    v = params[k];
                    results.push(k + "=" + (this.encode(v)));
                }
                return results;
            }).call(this)).join('&');
            if (qs) {
                qs = "?" + qs;
            }
            return window.open(url + qs, 'targetWindow', "toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,left=" + popup.left + ",top=" + popup.top + ",width=" + popup.width + ",height=" + popup.height);
        };

        Share.prototype.is_encoded = function (str) {
            str = str.to_rfc3986();
            return decodeURIComponent(str) !== str;
        };

        Share.prototype.encode = function (str) {
            if (typeof str === "undefined" || this.is_encoded(str)) {
                return str;
            } else {
                return str.to_rfc3986();
            }
        };
        return Share;

    })();

    return Share;
})();

var App = (function($, window){

    var Application = {

        init: function () {

            var btnShareFb = $('#btnShareFb');
            var id = $("#moneybox-id").val();
            var title = $("#moneybox-name").val();
            var caption = $("#moneybox-caption").val();
            var desc = $("#moneybox-desc").val();
            var image = $("#moneybox-image").attr('src');

            if (id > 0 && image.length > 0) {

                var share = new Share();
                share.setup({
                    networks: {
                        facebook: {
                            load_sdk: true,
                            app_id: "1581295808831173",
                            title: title,
                            image: image,
                            description: desc,
                            url: location.toString(),
                            caption: caption
                        }
                    }
                });

                btnShareFb.on("click", function (evt) {
                    evt.preventDefault();
                    share.network_facebook();
                });
            }
        }
    };


    Application.init();

})(jQuery, window);