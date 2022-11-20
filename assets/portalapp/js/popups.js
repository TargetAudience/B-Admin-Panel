'use strict'

var _createClass = (function() {
    function defineProperties(target, props) {
        for (var i = 0; i < props.length; i++) {
            var descriptor = props[i]
            descriptor.enumerable = descriptor.enumerable || false
            descriptor.configurable = true
            if ('value' in descriptor) descriptor.writable = true
            Object.defineProperty(target, descriptor.key, descriptor)
        }
    }
    return function(Constructor, protoProps, staticProps) {
        if (protoProps) defineProperties(Constructor.prototype, protoProps)
        if (staticProps) defineProperties(Constructor, staticProps)
        return Constructor
    }
})()

function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) {
        throw new TypeError('Cannot call a class as a function')
    }
}

var YOURAPPNAME = (function() {
    function YOURAPPNAME(doc) {
        _classCallCheck(this, YOURAPPNAME)

        this.doc = doc
        this.window = window
        this.html = this.doc.querySelector('html')
        this.body = this.doc.body
        this.location = location
        this.hash = location.hash
        this.Object = Object
        this.scrollWidth = 0
    }

    // Window load types (loading, dom, full)

    _createClass(YOURAPPNAME, [
        {
            key: 'appLoad',
            value: function appLoad(type, callback) {
                var _self = this

                switch (type) {
                    case 'loading':
                        if (_self.doc.readyState === 'loading') callback()

                        break
                    case 'dom':
                        _self.doc.onreadystatechange = function() {
                            if (_self.doc.readyState === 'complete') callback()
                        }

                        break
                    case 'full':
                        _self.window.onload = function(e) {
                            callback(e)
                        }

                        break
                    default:
                        callback()
                }
            }
        },
        {
            key: 'str2json',
            value: function str2json(str, notevil) {
                try {
                    if (notevil) {
                        return JSON.parse(
                            str
                                .replace(/([\$\w]+)\s*:/g, function(_, $1) {
                                    return '"' + $1 + '":'
                                })
                                .replace(/'([^']+)'/g, function(_, $1) {
                                    return '"' + $1 + '"'
                                })
                        )
                    } else {
                        return new Function('', 'const json = ' + str + '; return JSON.parse(JSON.stringify(json));')()
                    }
                } catch (e) {
                    return false
                }
            }
        },
        {
            key: 'options',
            value: function options(string) {
                var _self = this

                if (typeof string !== 'string') return string

                if (string.indexOf(':') !== -1 && string.trim().substr(-1) !== '}') {
                    string = '{' + string + '}'
                }

                var start = string ? string.indexOf('{') : -1
                var options = {}

                if (start !== -1) {
                    try {
                        options = _self.str2json(string.substr(start))
                    } catch (e) {}
                }

                return options
            }
        },
        {
            key: 'popups',
            value: function popups(options) {
                var _self = this

                var defaults = {
                    reachElementClass: '.js-popup',
                    closePopupClass: '.js__close-popup',
                    currentElementClass: '.js-open-popup',
                    changePopupClass: '.js__change-popup'
                }

                options = $.extend({}, options, defaults)

                var plugin = {
                    reachPopups: $(options.reachElementClass),
                    bodyEl: $('body'),
                    topPanelEl: $('.top-panel-wrapper'),
                    htmlEl: $('html'),
                    closePopupEl: $(options.closePopupClass),
                    openPopupEl: $(options.currentElementClass),
                    changePopupEl: $(options.changePopupClass),
                    bodyPos: 0
                }

                plugin.openPopup = function(popupName, callback) {
                    plugin.reachPopups.filter('[data-popup="' + popupName + '"]').addClass('opened')
                    // plugin.bodyEl.css('overflow-y', 'scroll');
                    // plugin.topPanelEl.css('padding-right', scrollSettings.width);
                    plugin.htmlEl.addClass('popup-opened')

                    if (callback) callback()
                }

                plugin.closePopup = function(popupName, callback) {
                    var $popup = plugin.reachPopups.filter('[data-popup="' + popupName + '"]')
                    $popup.removeClass('opened')
                    setTimeout(function() {
                        plugin.bodyEl.removeAttr('style')
                        plugin.htmlEl.removeClass('popup-opened')
                        plugin.topPanelEl.removeAttr('style')
                    }, 300)

                    if ($popup.find('iframe').length > 0) {
                        var $frame = $popup.find('iframe')
                        var url = $frame.attr('src')
                        $frame.attr('src', url)
                    }

                    if (callback) callback()
                }

                plugin.changePopup = function(closingPopup, openingPopup, callback) {
                    plugin.reachPopups.filter('[data-popup="' + closingPopup + '"]').removeClass('opened')
                    plugin.reachPopups.filter('[data-popup="' + openingPopup + '"]').addClass('opened')

                    if (callback) callback()
                }

                plugin.init = function() {
                    plugin.bindings()
                }

                plugin.bindings = function() {
                    plugin.openPopupEl.on('click', function(e) {
                        e.preventDefault()
                        var pop = $(this).attr('data-popup-target')
                        plugin.openPopup(pop)
                    })

                    plugin.closePopupEl.on('click', function(e) {
                        e.preventDefault()
                        var pop = void 0
                        if (this.hasAttribute('data-popup-target')) {
                            pop = $(this).attr('data-popup-target')
                        } else {
                            pop = $(this)
                                .closest(options.reachElementClass)
                                .attr('data-popup')
                        }

                        plugin.closePopup(pop)
                    })

                    plugin.changePopupEl.on('click', function(e) {
                        e.preventDefault()
                        var closingPop = $(this).attr('data-closing-popup')
                        var openingPop = $(this).attr('data-opening-popup')

                        plugin.changePopup(closingPop, openingPop)
                    })

                    plugin.reachPopups.on('click', function(e) {
                        var target = $(e.target)
                        var className = options.reachElementClass.replace('.', '')
                        if (target.hasClass(className)) {
                            plugin.closePopup($(e.target).attr('data-popup'))
                        }
                    })
                }

                if (options) plugin.init()

                return plugin
            }
        },
        {
            key: 'scrollTo',
            value: function scrollTo() {
                var headerHeight = $('.header').outerHeight()
                $('.js-scroll-to').on('click', function(e) {
                    e.preventDefault()
                    console.log()

                    $('body, html').animate({ scrollTop: $($(this).attr('href')).offset().top - headerHeight }, 2000)
                })
            }
        },
        {
            key: 'inputNumberValidate',
            value: function inputNumberValidate() {
                $('.js__number-validation').on('keyup', function(event) {
                    var regex = /[+-]?\d+(\.)?(\d{0,8})?/g
                    var content = $(this).val()
                    content = content.replace(/[^\d.-]/g, '')
                    content = content.match(regex)
                    // console.log(content);
                    if (content) {
                        $(this).val(content[0])
                    } else {
                        $(this).val('')
                    }
                })
            }
        },
        {
            key: 'headerDetection',
            value: function headerDetection() {
                var _self = this
                var header = _self.doc.getElementsByClassName('header')[0]
                var colored = false

                detectHeader()
                $(window).scroll(function() {
                    detectHeader()
                })

                function detectHeader() {
                    var scrollTop = $(window).scrollTop()
                    if (scrollTop > 0 && colored === false) {
                        colored = true
                        header.classList.add('scrolled-down')
                    } else if (scrollTop < 1 && colored === true) {
                        colored = false
                        header.classList.remove('scrolled-down')
                    }
                }
            }
        }
    ])

    return YOURAPPNAME
})()
;(function() {
    var app = new YOURAPPNAME(document)

    app.appLoad('loading', function() {
        app.popups()
        app.inputNumberValidate()
        app.scrollTo()

        var spinner = null
        var opts = {
            lines: 11, // The number of lines to draw
            length: 4, // The length of each line
            width: 2, // The line thickness
            radius: 5, // The radius of the inner circle
            corners: 0, // Corner roundness (0..1)
            rotate: 0, // The rotation offset
            direction: 1, // 1: clockwise, -1: counterclockwise
            color: '#fff', // #rgb or #rrggbb or array of colors
            speed: 1.0, // Rounds per second
            trail: 60, // Afterglow percentage
            shadow: false, // Whether to render a shadow
            hwaccel: false, // Whether to use hardware acceleration
            className: 'spinner', // The CSS class to assign to the spinner
            top: 'auto', // Top position relative to parent in px
            left: 'auto' // Left position relative to parent in px
        }

        var postURLRemoveItem;

        $('.js__admin-remove-item').click(function(e) {
            app.popups().openPopup('admin-delete-confirm');
            postURLRemoveItem = $(this).attr('data-src');
        })

        $('#js__admin-remove-submit').submit(function(e) {
            redirectForm(e, this, postURLRemoveItem, null, 'admin-delete-confirm', 'Remove Item');
        })

        function redirectForm(e, that, postURL, inputData, closePopup, buttonLabel) {
            var spinner_div = $(that)
                .find('.js__submit-spinner')
                .get(0);
            var button = $(that).find('.js__submit');
            button.val('');
            $(that)
                .find('.js__submit-spinner')
                .position(button.position());

            if (spinner == null) {
                spinner = new Spinner(opts).spin(spinner_div);
            } else {
                spinner.spin(spinner_div);
            }

            $.ajax({
                type: 'POST',
                url: postURL,
                data: inputData,
                success: function(data) {
                    app.popups().closePopup(closePopup);
                    spinner.stop(spinner_div);
                    button.val(buttonLabel);

                    if (data.ok == 'true') {
                        window.location.href = data.redirect;
                    } else {
                        button.blur();

                        var json = JSON.parse(data.content);
                        var error = '';
                        if (json.length >= 1) {
                            if (json.length > 1) {
                                error += '<br />';
                            }
                            for (var i in json) {
                                error += json[i] + '<br />';
                            }
                        }

                        hideAlert();
                        showAlert('danger', data.title, error);
                    }
                },
                error: function(xhr, status, thrown) {},
                beforeSend: function() {}
            })
            e.preventDefault()
            return false
        }
    })

    app.appLoad('dom', function() {
        // DOM is loaded! Paste your app code here (Pure JS code).
        // Do not use jQuery here cause external libs do not loads here...
    })

    app.appLoad('full', function(e) {
        // app.parallax();
    })
})()
