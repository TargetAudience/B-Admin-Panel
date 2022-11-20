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

var SCHEDULES = (function() {
    function SCHEDULES(doc) {
        _classCallCheck(this, SCHEDULES)

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

    _createClass(SCHEDULES, [
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
                        return new Function(
                            '',
                            'const json = ' +
                                str +
                                '; return JSON.parse(JSON.stringify(json));'
                        )()
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

                if (
                    string.indexOf(':') !== -1 &&
                    string.trim().substr(-1) !== '}'
                ) {
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
                    plugin.reachPopups
                        .filter('[data-popup="' + popupName + '"]')
                        .addClass('opened')
                    // plugin.bodyEl.css('overflow-y', 'scroll');
                    // plugin.topPanelEl.css('padding-right', scrollSettings.width);
                    plugin.htmlEl.addClass('popup-opened')

                    if (callback) callback()
                }

                plugin.closePopup = function(popupName, callback) {
                    var $popup = plugin.reachPopups.filter(
                        '[data-popup="' + popupName + '"]'
                    )
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

                plugin.changePopup = function(
                    closingPopup,
                    openingPopup,
                    callback
                ) {
                    plugin.reachPopups
                        .filter('[data-popup="' + closingPopup + '"]')
                        .removeClass('opened')
                    plugin.reachPopups
                        .filter('[data-popup="' + openingPopup + '"]')
                        .addClass('opened')

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
                        var className = options.reachElementClass.replace(
                            '.',
                            ''
                        )
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
                    $('body, html').animate(
                        {
                            scrollTop:
                                $($(this).attr('href')).offset().top -
                                headerHeight
                        },
                        2000
                    )
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

    return SCHEDULES
})()
;(function() {
    var app = new SCHEDULES(document)

    app.appLoad('loading', function(e) {
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

        function attachCopyCalendar() {
            var currDate = $('#js__copy-calendar-submit').find('.date.start')
            var datepicker = currDate.datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: false,
                singleDatePicker: true,
                showDropdowns: true,
                daysOfWeekDisabled: [0,2,3,4,5,6],
                container: '.js__copy-datetimepicker-container',
                orientation: 'bottom auto'
            })

            var currDateB = $('#js__copy-calendar-submit').find('.date.end')
            var datepickerB = currDateB.datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: false,
                singleDatePicker: true,
                showDropdowns: true,
                daysOfWeekDisabled: [0,2,3,4,5,6],
                container: '.js__copy-datetimepicker-container',
                orientation: 'bottom auto'
            })

            datepicker.datepicker().on('changeDate', function(e) {
                var firstPickerDate = datepicker.datepicker('getDate')
                var newdate = new Date(firstPickerDate);
                newdate.setDate(firstPickerDate.getDate() + 7);
                datepickerB.datepicker('setStartDate', newdate)
                datepickerB.datepicker('update', newdate)
            })
        }

        $('#js__copy-calendar-submit').on('click', '.icon-calendar', function(e) {
            var picker = $(this).siblings('.date')
            picker.focus()
        })

        $('#js__copy-calendar-click').click(function(e) {
            app.popups().openPopup('copy-calendar')
            attachCopyCalendar()
            e.preventDefault()
            return false
        })

        $('#js__copy-calendar-submit').submit(function(e) {
            var postURLCopyCalendar = $(this).attr('data-src')
            var data = $('#js__copy-calendar-submit :input').serialize()
            redirectForm(e, this, postURLCopyCalendar, data, 'Copy Week')
        })

        $('.js__day-cell').click(function(e) {
            resetPanels()
            app.popups().openPopup('day-cell-info')

            var dataDate = $(this).attr('data-date')
            var heading = $(this).attr('data-date-heading')
            $('#js__date-heading').text(heading)
            $('#js__shifts-office-heading').addClass('hide')
            $('#js__shifts-hospital-heading').addClass('hide')

            var containerOffice = $('#js__shifts-office-insert')
            var containerHospital = $('#js__shifts-hospital-insert')
            containerOffice.empty()
            containerHospital.empty()

            var content = $('#js__shift-insert-template').html()
            var postURL = $('#js__day-data-url').attr('data-src')

            $.ajax({
                type: 'GET',
                url: postURL + '&date=' + dataDate,
                success: function(data) {
                    if (data.ok == 'true') {
                        if (data.redirect) {
                            window.location.href = data.redirect
                            return false
                        }
                        var json = JSON.parse(data.content)
                        var foundOffice = false
                        $.each(json, function(index, value) {
                            if (value.locationType == 'location') {
                                foundOffice = true
                                $('#js__shifts-office-heading').removeClass('hide')
                                containerOffice.append(content)
                                var insert = containerOffice
                                    .children('.location')
                                    .last()
                                insert.find('.name').text(value.locationName)
                            } else {
                                $('#js__shifts-hospital-heading').removeClass('hide')
                                containerHospital.append(content)
                                var insert = containerHospital
                                    .children('.location')
                                    .last()
                                insert.find('.name').text(value.hospitalName)
                            }
                            insert.find('.person').text(value.personName)
                            insert
                                .find('.time')
                                .text(
                                    value.startTimeDisplay +
                                        ' to ' +
                                        value.endTimeDisplay
                                )
                            if (value.repeat != '') {
                                insert.find('.badge span').text(value.repeat)
                            } else {
                                insert.find('.badge span').addClass('hide')
                            }
                            insert
                                .find('.js__shift-remove')
                                .attr('data-remove-json', value.personJson)
                            insert
                                .find('.js__shift-contact')
                                .attr('data-person-json', value.personJson)
                        })
                        if (!foundOffice) {
                            $('#js__shifts-hospital-heading').removeClass(
                                'second'
                            )
                        } else {
                            $('#js__shifts-hospital-heading').addClass('second')
                        }
                    } else {
                    }
                },
                error: function(xhr, status, thrown) {},
                beforeSend: function() {}
            })
            e.preventDefault()
            return false
        })

        var resetSmsMessaging = function() {
            setTimeout(function() {
                $('#js__chars-remaining').html('160 characters remaining')
                $('#js__message-text').val('')
            }, 200)
        }

        var resetPanels = function() {
            resetSmsMessaging()

            $('.js__panel-info')
                .addClass('transition-instant')
                .removeClass('slide-partial-left')
                .removeClass('open-slide')
            setTimeout(function() {
                $('.js__panel-info').removeClass('transition-instant')
            }, 200)
        }

        $('#js__panel-cell-info').on('click', '.js__shift-remove', function(e) {
            var data = JSON.parse($(this).attr('data-remove-json'))
            var container = $('#js__remove-items-list')
            container.find('.location span').text(data.locationDisplayName)
            container.find('.person span').text(data.personName)
            container.find('.time span').text(data.time)
            container.find('.repeat span').text(data.repeat)
            if (data.repeat != '') {
                $('#js__remove-series').removeClass('hide')
            } else {
                $('#js__remove-series').addClass('hide')
            }

            $('#js__remove-shift-schedule-id').val(data.calendarId)

            $('#js__cell-info-panel-main').addClass('slide-partial-left')
            $('#js__cell-info-panel-remove').addClass('open-slide')
        })

        $('#js__cell-info-panel-main').on('click', '.js__request-change-click', function(
            e
        ) {
            $('#js__panel-main').addClass('slide-partial-left')
            $('#js__panel-request-change').addClass('open-slide')
            var data = JSON.parse($(this).attr('data-person-json'))
            $('#js__send-message-heading').text(data.personName)
            $('#js__sms-person-data').val($(this).attr('data-person-json'))
        })

        $('#js__cell-info-panel-main').on('click', '.js__shift-contact', function(e) {
            $('#js__cell-info-panel-main').addClass('slide-partial-left')
            $('#js__cell-info-panel-contact').addClass('open-slide')
            var data = JSON.parse($(this).attr('data-person-json'))
            $('#js__send-message-heading').text(data.personName)
            $('#js__sms-person-data').val($(this).attr('data-person-json'))
        })

        $('#js__calendar-sms-message-submit').submit(function(e) {
            var url = $(this).attr('data-src')
            var data = $('#js__calendar-sms-message-submit :input').serialize()
            callbackForm(
                e,
                this,
                url,
                data,
                'admin-sms-message',
                'Send Sms',
                function(message) {
                    hideAlert()
                    showAlert('success-inside', '', message)
                    setTimeout(function() {
                        $.toast().reset('all');
                    }, 2000)
                    $('.js__pane-back-arrow').click()
                }
            )
        })

        $('.js__pane-back-arrow').click(function(e) {
            $('#js__cell-info-panel-main').removeClass('slide-partial-left')
            $('#js__cell-info-panel-remove').removeClass('open-slide')
            $('#js__cell-info-panel-contact').removeClass('open-slide')
            $('#js__panel-request-change').removeClass('open-slide')
            resetSmsMessaging()
        })

        $('#js__remove-shift-submit')
            .find('button[type=submit]')
            .click(function(e) {
                $('#button_action').val($(this).attr('name'))
            })

        $('#js__remove-shift-submit').submit(function(e) {
            var data = $('#js__remove-shift-submit').serialize()
            var url = $('#js__shift-delete-url').attr('data-src')

            var shiftType = $('#button_action').val()
            if (shiftType == 'remove_shift') {
                var buttonName = 'Remove Shift'
                var buttonType = 'shift'
            } else {
                var buttonName = 'Remove Series'
                var buttonType = 'series'
            }
            inlineForm(
                e,
                this,
                url,
                data,
                'add-to-schedule',
                buttonName,
                buttonType
            )
        })

        var loadMyShifts = function() {
            var formData = 'dateFrom=' + $('#js__request-change-datepicker-1').find('.date.switch-from').val()
            $.ajax({
                type: 'POST',
                url: domainBase + 'schedules/getLocationsToForRequestChangeMyShifts',
                data: formData,
                dataType: 'json',
                error: function(xhr, status, thrown) {},
                success: function(results) {
                    if (results.ok == 'true') {
                        if (results.redirect) {
                            window.location.href = results.redirect
                        } else {
                            $('#js__switch-locations-title').addClass('hide')
                            $('#js__request-change-panel-1-message').text('').addClass('hide')
                            $('#js__request-change-panel-1-message-2').text('').addClass('hide')

                            var appendTo = $('#js__request-change-switch-locations-placeholder')
                            appendTo.empty()
                            let resultsData = JSON.parse(results.data)
                            $.each(resultsData, function(index, value) {
                                appendTo.append(
                                    $(
                                        '<div class="checkbox checkbox-primary list"><input id="checkboxto' +
                                            index +
                                            '" type="checkbox" class="switch-from-checkbox" name="switchfrom[]" value=' +
                                            value.calendarId + ' /><label for="checkboxto' +
                                            index +
                                            '"><span>' +
                                            value.locationDisplayName + ' (' + value.personName + ', ' + value.startTimeDisplay  + ' to ' + value.endTimeDisplay  + ')' +
                                            '</span></label></div>'
                                    )
                                )
                            })
                            if (resultsData.length) {
                                $('#js__switch-locations-title').removeClass('hide')
                            } else {
                                $('#js__request-change-panel-1-message').text('We couldn\'t find any locations scheduled for you on that date.').removeClass('hide')
                            }
                        }
                    }
                }
            })
        }

        var loadOtherPersonsShifts = function() {
            var formData = 'dateTo=' + $('#js__request-change-datepicker-2').find('.date.switch-to').val()
            $.ajax({
                type: 'POST',
                url: domainBase + 'schedules/getLocationsToForRequestChange',
                data: formData,
                dataType: 'json',
                error: function(xhr, status, thrown) {},
                success: function(results) {
                    if (results.ok == 'true') {
                        if (results.redirect) {
                            window.location.href = results.redirect
                        } else {
                            $('#js__switch-locations-title-2').addClass('hide')
                            $('#js__request-change-panel-2-message').text('').addClass('hide')

                            var appendTo = $('#js__request-change-switch-providers-placeholder')
                            appendTo.empty()
                            let resultsData = JSON.parse(results.data)
                            $.each(resultsData, function(index, value) {
                                var addClass = ''
                                if (value.gap) {
                                    addClass = 'gap-top'
                                }
                                appendTo.append(
                                    $(
                                        '<div class="checkbox checkbox-primary list ' + addClass + '"><input id="checkboxfrom' +
                                            index +
                                            '" type="checkbox" class="switch-to-checkbox" name="switchto[]" value=' +
                                            value.calendarId + ' /><label for="checkboxfrom' +
                                            index +
                                            '"><span>' +
                                            value.locationDisplayName + ' (' + value.personName + ', ' + value.startTimeDisplay  + ' to ' + value.endTimeDisplay  + ')' +
                                            '</span></label></div>'
                                    )
                                )
                            })
                            if (resultsData.length) {
                                $('#js__switch-locations-title-2').removeClass('hide')
                            } else {
                                $('#js__request-change-panel-2-message').text('We couldn\'t find any other provider\'s locations scheduled on that date.').removeClass('hide')
                            }
                        }
                    }
                }
            })
        }

        var loadManageRequests = function() {
            var placeholderMain = $('#js__request-change-manage-requests-placeholder')
            placeholderMain.empty()

            var mainTemplate = $('#js__request-insert-main-template').html()
            var subTemplate = $('#js__request-insert-sub-template').html()

            var postURL = $('#js__manage-request-url').attr('data-src')
 
            $.ajax({
                type: 'GET',
                url: postURL,
                success: function(data) {
                    if (data.ok == 'true') {
                        if (data.redirect) {
                            window.location.href = data.redirect
                            return false
                        }
                        var json = JSON.parse(data.content)

                        $.each(json, function(index, value) { console.log(value)      
                            placeholderMain.append(mainTemplate)
                            var insert = placeholderMain
                                .children('.main-item')
                                .last()
                            insert.find('.badge span').text(value.status)
                            insert.find('.text .fullname').text(value.personName)
                            insert.find('.text .message').text(value.personMessage)

                            if (value.offerDirection == 'OUT') {
                                insert.find('.js__request-main-template-top-area-offer-out').removeClass('hide')
                                insert.find('.js__request-main-template-top-area-offer-in').addClass('hide')
                            } else {
                                insert.find('.js__request-main-template-top-area-offer-out').addClass('hide')
                                insert.find('.js__request-main-template-top-area-offer-in').removeClass('hide')
                            }

                            $.each(value.shifts, function(index2, value2) {
                                var placeholderSub = insert.find('.js__request-change-manage-requests-sub-placeholder')

                                placeholderSub.append(subTemplate)
                                var insert2 = placeholderSub
                                    .children('.sub-item')
                                    .last()
                                
                                insert2.find('.direction').text(value2.directionDisplay)
                                insert2.find('.name').text(value2.locationDisplayName)
                                insert2.find('.person').text(value2.personName)
                                insert2.find('.date').text(value2.dateDisplay)
                                insert2
                                    .find('.time')
                                    .text(
                                        value2.startTimeDisplay +
                                            ' to ' +
                                            value2.endTimeDisplay
                                    )
                            })
                        })
                    } else {
                    }
                },
                error: function(xhr, status, thrown) {},
                beforeSend: function() {}
            })
        }

        $('#js__request-change-manage-click').click(function(e) {
            loadManageRequests()
            $('#js__request-change-panel-main').addClass('slide-partial-left')
            $('#js__request-change-panel-manage-main').addClass('open-slide')
            e.preventDefault()
            return false
        })

        $('.js__request-popup-back-arrow-3').click(function(e) {
            $('#js__request-change-panel-main').removeClass('slide-partial-left').addClass('open-slide')
            $('#js__request-change-panel-manage-main').removeClass('open-slide')
        })

        $('#js__request-change-next-click').click(function(e) {
            $('#js__request-change-panel-1-message').text('').addClass('hide')
            $('#js__request-change-panel-1-message-2').text('').addClass('hide')

            var datepicker_date = $('#js__request-change-datepicker-1').find('.date.switch-from').val()
            var datepicker_results = $('#js__request-change-switch-locations-placeholder').is(':empty')
            var checked = $('#js__request-change-switch-locations-placeholder input:checked').length > 0;
     
            if (datepicker_date == '') {
                console.log($('#js__request-change-panel-1-message'))
                $('#js__request-change-panel-1-message').text('Please select a date you\'d like to switch from.').removeClass('hide')
            } else if (!checked) {
                $('#js__request-change-panel-1-message-2').text('Please select at least one location.').removeClass('hide')
            } else {
                if (!datepicker_results) {
                    $('#js__request-change-panel-main').addClass('slide-partial-left')
                    $('#js__request-change-panel-2').addClass('open-slide')
                } else {
                    $('#js__request-change-panel-1-message').text('We couldn\'t find any locations scheduled for you on that date.').removeClass('hide')
                }
            }
        })

        $('#js__request-change-next-click-2').click(function(e) {
            $('#js__request-change-panel-2-message').text('').addClass('hide')
            $('#js__request-change-panel-2-message-2').text('').addClass('hide')

            var datepicker_to_date = $('#js__request-change-datepicker-2').find('.date.switch-to').val()
            var checked = $('#js__request-change-switch-providers-placeholder input:checked').length > 0;

            if (datepicker_to_date == '') {
                $('#js__request-change-panel-2-message').text('Please select a date you\'d like to switch to.').removeClass('hide')
            } else if (!checked) {
                $('#js__request-change-panel-2-message-2').text('Please select at least one location.').removeClass('hide')
            } else {
                var data = $('#js__request-change-submit :input').serialize()
                callbackForm(
                    e,
                    $(this).parent(),
                    postURLRequestChangeValidate,
                    data,
                    null,
                    'Next',
                    function(message) {
                        if (message) {
                            $('#js__request-change-panel-2-message-2').text(message).removeClass('hide')
                        } else {
                            $('#js__request-change-panel-2').addClass('slide-partial-left').removeClass('open-slide')
                            $('#js__request-change-panel-3').addClass('open-slide')
                        }
                    }
                )
                e.preventDefault()
                return false 
            }
        })

        $(document).on('change', '.switch-from-checkbox', function() {
            if(this.checked) {
              $('#js__request-change-panel-1-message-2').text('').addClass('hide')
            }
        });

        $(document).on('change', '.switch-to-checkbox', function() {
            if(this.checked) {
              $('#js__request-change-panel-2-message-2').text('').addClass('hide')
            }
        });

        $('.switch-from-checkbox').click(function() { 
            if ($(this).is(':checked')) {
                $('#js__request-change-panel-1-message-2').text('').addClass('hide')
            }
        });

        $('.js__request-popup-back-arrow').click(function(e) {
            $('#js__request-change-panel-main').removeClass('slide-partial-left')
            $('#js__request-change-panel-2').removeClass('open-slide')
        })

        $('.js__request-popup-back-arrow-2').click(function(e) {
            $('#js__request-change-panel-2').removeClass('slide-partial-left').addClass('open-slide')
            $('#js__request-change-panel-3').removeClass('open-slide')
        })

        var resetRequestPanels = function() {
            $('#js__request-change-datepicker-1').find('.date.switch-from').val('')
            $('#js__request-change-datepicker-2').find('.date.switch-to').val('')
            $('#js__request-change-switch-locations-placeholder').empty()
            $('#js__request-change-switch-providers-placeholder').empty()
            $('#js__switch-locations-title').addClass('hide')
            $('#js__switch-locations-title-2').addClass('hide')

            $('.js__panel-change')
                .addClass('transition-instant')
                .removeClass('slide-partial-left')
                .removeClass('open-slide')
            setTimeout(function() {
                $('.js__panel-change').removeClass('transition-instant')
            }, 200)
        }

        var datepicker_change_date = $('#js__request-change-datepicker-1').find('.date.switch-from').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            singleDatePicker: true,
            showDropdowns: true,
            startDate: new Date(),
            container: '.datetimepicker-container-2',
            orientation: 'bottom auto'
        })

        $('#js__request-change-datepicker-1').on('click', '.icon-calendar', function(e) {
            var picker = $(this).siblings('.date')
            picker.focus()
        })

        datepicker_change_date.datepicker().on('changeDate', function(e) {
            loadMyShifts()
        })

        var datepicker_change_date_2 = $('#js__request-change-datepicker-2').find('.date.switch-to').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            singleDatePicker: true,
            showDropdowns: true,
            startDate: new Date(),
            container: '.datetimepicker-container-3',
            orientation: 'bottom auto'
        })

        datepicker_change_date_2.datepicker().on('changeDate', function(e) {
            $('#js__request-change-panel-2-message').text('').addClass('hide')
            $('#js__request-change-panel-2-message-2').text('').addClass('hide')

            loadOtherPersonsShifts()
        })

        $('#js__request-change-datepicker-2').on('click', '.icon-calendar', function(e) {
            var picker = $(this).siblings('.date')
            picker.focus()
        })

        var postURLRequestChangeValidate
        var postURLRequestChange

        $('#js__request-change-click').on('click', function(e) {
            resetRequestPanels()
            app.popups().openPopup('request-change')
            postURLRequestChange = $(this).attr('data-src')
            postURLRequestChangeValidate = $(this).attr('data-src-2')
        })

        $('#js__request-change-submit').submit(function(e) {
            var data = $('#js__request-change-submit :input').serialize()
            redirectForm(
                e,
                $('#js__request-change-scope'),
                postURLRequestChange,
                data,
                'Request Change'
            )
        })

        var postURLAddToSchedule

        $('#js__add-to-schedule-click').on('click', function(e, param) {
            if (param != 'auto_date') {
                var el = $('#js__datetimepicker')
                    .find('.date')
                    .eq(0)
                el.val('')
            }
            app.popups().openPopup('add-to-schedule')
            postURLAddToSchedule = $(this).attr('data-src')
        })

        $('#js__add-to-schedule-submit').submit(function(e) {
            var data = $('#js__add-to-schedule-submit :input').serialize()
            redirectForm(e, this, postURLAddToSchedule, data, 'Add to Schedule')
        })

        $('#js__publish-click').click(function(e) {
            if ($(this).hasClass('bg-green')) {
                var url = $(this).attr('data-src')
                var that = this
                callbackForm(
                    e,
                    $(this).parent(),
                    url,
                    null,
                    'Publish',
                    'Publish',
                    function(message) {
                        hideAlert()
                        showAlert('success-inside', '', message)
                        setTimeout(function() {
                            $.toast().reset('all');
                        }, 2000)
                        $(that).removeClass('bg-green')
                        $(that).addClass('bg-green-disabled').addClass('btn-disabled')
                    }
                )
            }
            e.preventDefault()
            return false
        })

        function redirectForm(e, that, postURL, inputData, buttonLabel) {
            var spinner_div = $(that)
                .find('.js__submit-spinner')
                .get(0)
            var button = $(that).find('.js__submit')
            button.val('')
            button.html('')
            $(that)
                .find('.js__submit-spinner')
                .position(button.position())

            if (spinner == null) {
                spinner = new Spinner(opts).spin(spinner_div)
            } else {
                spinner.spin(spinner_div)
            }

            $.ajax({
                type: 'POST',
                url: postURL,
                data: inputData,
                success: function(data) {
                    spinner.stop(spinner_div)
                    button.val(buttonLabel)
                    button.html(buttonLabel)
                    if (data.ok == 'true') {
                        window.location.href = data.redirect
                    } else {
                        button.blur()
                        var json = JSON.parse(data.content)
                        var error = ''
                        if (json.length >= 1) {
                            if (json.length > 1) {
                                error += '<br />'
                            }
                            for (var i in json) {
                                error += json[i] + '<br />'
                            }
                        }
                        hideAlert()
                        showAlert('danger', data.title, error)
                    }
                },
                error: function(xhr, status, thrown) {},
                beforeSend: function() {}
            })
            e.preventDefault()
            return false
        }

        function inlineForm(
            e,
            that,
            postURL,
            inputData,
            closePopup,
            buttonLabel,
            buttonType
        ) {
            var spinner_div = $(that)
                .find('.js__submit-spinner-' + buttonType)
                .get(0)
            var button = $(that).find('.js__submit-' + buttonType)
            button.val('')
            button.html('')
            $(that)
                .find('.js__submit-spinner-' + buttonType)
                .position(button.position())

            if (spinner == null) {
                spinner = new Spinner(opts).spin(spinner_div)
            } else {
                spinner.spin(spinner_div)
            }

            $.ajax({
                type: 'POST',
                url: postURL,
                data: inputData,
                success: function(data) {
                    spinner.stop(spinner_div)
                    button.val(buttonLabel)
                    button.html(buttonLabel)
                    if (data.ok == 'true') {
                        window.location.href = data.redirect
                    } else {
                        button.blur()
                        var json = JSON.parse(data.content)
                        var error = ''
                        if (json.length >= 1) {
                            if (json.length > 1) {
                                error += '<br />'
                            }
                            for (var i in json) {
                                error += json[i] + '<br />'
                            }
                        }
                        hideAlert()
                        showAlert('danger', data.title, error)
                    }
                },
                error: function(xhr, status, thrown) {},
                beforeSend: function() {}
            })
            e.preventDefault()
            return false
        }

        function callbackForm(
            e,
            that,
            postURL,
            inputData,
            closePopup,
            buttonLabel,
            callback
        ) {
            var spinner_div = $(that)
                .find('.js__submit-spinner')
                .get(0)
            var button = $(that).find('.js__submit')
            button.val('')
            button.html('')
            $(that)
                .find('.js__submit-spinner')
                .position(button.position())

            if (spinner == null) {
                spinner = new Spinner(opts).spin(spinner_div)
            } else {
                spinner.spin(spinner_div)
            }

            $.ajax({
                type: 'POST',
                url: postURL,
                data: inputData,
                success: function(data) {
                    spinner.stop(spinner_div)
                    button.val(buttonLabel)
                    button.html(buttonLabel)
                    if (data.ok == 'true') {
                        if (data.redirect) {
                            window.location.href = data.redirect
                        } else {
                            callback(data.content)
                        }
                    } else {
                        button.blur()
                        var json = JSON.parse(data.content)
                        var error = ''
                        if (json.length >= 1) {
                            if (json.length > 1) {
                                error += '<br />'
                            }
                            for (var i in json) {
                                error += json[i] + '<br />'
                            }
                        }
                        hideAlert()
                        showAlert('danger', data.title, error)
                    }
                },
                error: function(xhr, status, thrown) {},
                beforeSend: function() {}
            })
            e.preventDefault()
            return false
        }

        $('#js__filters-click').click(function(e) {
            if ($('#js_filters-wrap').hasClass('nav-item--active')) {
                $('#js_filters-wrap').removeClass('nav-item--active')
            } else {
                $('#js_filters-wrap').addClass('nav-item--active')
            }
        })

        $('#js__filter-popup-cancel').click(function(e) {
            $('#js_filters-wrap').removeClass('nav-item--active')
        })

        $('#js__filter-popup-submit')
            .find('input[type=submit]')
            .click(function(e) {
                $('#filters_button_action').val($(this).attr('name'))
            })

        $('#js__filter-popup-submit').submit(function(e) {
            var data = $('#js__filter-popup-submit').serialize()
            var url = $('#js__filter-popup-submit-url').attr('data-src')

            var submitType = $('#filters_button_action').val()
            if (submitType == 'clear_filter') {
                var buttonName = 'Clear Filter'
                var buttonType = 'clear'
            } else {
                var buttonName = 'Update'
                var buttonType = 'update'
            }
            inlineForm(
                e,
                this,
                url,
                data,
                'add-to-schedule',
                buttonName,
                buttonType
            )
        })

        $('#js__filters-x-filter').click(function(e) {
            inlineForm(e, this, url, data, '', '', '')
        })

        $('#js__form-popup-submit').submit(function(e) {
            var url = $(this).attr('data-href')
            redirectForm(e, this, url, null, 'Clear Filter')
        })
    })

    app.appLoad('dom', function() {
        // DOM is loaded! Paste your app code here (Pure JS code).
        // Do not use jQuery here cause external libs do not loads here...
    })

    app.appLoad('full', function(e) {})
})()
