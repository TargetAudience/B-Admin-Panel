var Schedules = (function($) {
    $(document).ready(function(e) {
        // MAD-RIPPLE // (jQ+CSS)
        $(document).on("mousedown", "[data-ripple]", function(e) {
            var $self = $(this);

            if ($self.is(".btn-disabled")) {
                return;
            }
            if ($self.closest("[data-ripple]")) {
                e.stopPropagation();
            }

            var initPos = $self.css("position"),
                offs = $self.offset(),
                x = e.pageX - offs.left,
                y = e.pageY - offs.top,
                dia = Math.min(this.offsetHeight, this.offsetWidth, 100), // start diameter
                $ripple = $("<div/>", { class: "ripple", appendTo: $self });

            if (!initPos || initPos === "static") {
                $self.css({ position: "relative" });
            }

            $("<div/>", {
                class: "rippleWave",
                css: {
                    background: $self.data("ripple"),
                    width: dia,
                    height: dia,
                    left: x - dia / 2,
                    top: y - dia / 2
                },
                appendTo: $ripple,
                one: {
                    animationend: function() {
                        $ripple.remove();
                    }
                }
            });
        });

        /*$(document).on('click touch', function(event) { console.log($(event.target))
            if (!$(event.target).is('#js__filters-box, #js__filters-click, #js__filters-click > span')) {
                $('#js_filters-wrap').removeClass('nav-item--active')
            }
            event.preventDefault()
            return false
        });*/

        $(document).mouseup(function(e) {
            var popup = $("#js__filters-box");
            if (
                !$("#js__filters-click, #js__filters-click > span").is(
                    e.target
                ) &&
                !popup.is(e.target) &&
                popup.has(e.target).length == 0
            ) {
                $("#js_filters-wrap").removeClass("nav-item--active");
            }
        });

        $(document).on("contextmenu", function(e) {
            if ($(e.target).is(".js__day-actual .day-cell-inner-wrap")) {
                e.preventDefault();
                return false;
            }
        });

        $(".js__day-actual .day-cell-inner-wrap").mousedown(function(e) {
            if (e.button == 2) {
                var date = $(this)
                    .parent()
                    .attr("data-date");
                var el = $("#js__datetimepicker")
                    .find(".date")
                    .eq(0);
                el.val(date);
                $("#js__add-to-schedule-click").trigger("click", ["auto_date"]);
                return false;
            }
            return true;
        });

        $("#js__click-user-dropdown-menu, #js__user-dropdown-menu").hover(
            function() {
                if ($("body").hasClass("user-menu-active")) {
                    $("body, #js__user-dropdown-menu").removeClass(
                        "user-menu-active"
                    );
                } else {
                    $("body, #js__user-dropdown-menu").addClass(
                        "user-menu-active"
                    );
                }
            }
        );

        [].slice
            .call(
                document.querySelectorAll("select.cs-select.redirect-external")
            )
            .forEach(function(el) {
                new SelectFx(el);
            });
        [].slice
            .call(
                document.querySelectorAll("select.cs-select.redirect-calendar")
            )
            .forEach(function(el) {
                new SelectFx(el, {
                    stickyPlaceholder: true,
                    onChange: function(val) {
                        if (val) {
                            $.ajax({
                                type: "POST",
                                url:
                                    domainBase +
                                    "schedules/addDepartmentFilter",
                                data:
                                    "filter=" +
                                    encodeURIComponent(val) +
                                    "&month=" +
                                    window.month +
                                    "&year=" +
                                    window.year,
                                dataType: "json",
                                error: function(xhr, status, thrown) {},
                                success: function(data) {
                                    window.location.href = data.redirect;
                                }
                            });
                        }
                    }
                });
            });
        [].slice
            .call(document.querySelectorAll("select.cs-select.redirect-users"))
            .forEach(function(el) {
                new SelectFx(el, {
                    stickyPlaceholder: true,
                    onChange: function(val) {
                        if (val) {
                            $.ajax({
                                type: "POST",
                                url:
                                    domainBase + "users/addUsersLocationFilter",
                                data: "filter=" + encodeURIComponent(val),
                                dataType: "json",
                                error: function(xhr, status, thrown) {},
                                success: function(data) {
                                    window.location.href = data.redirect;
                                }
                            });
                        }
                    }
                });
            });
        [].slice
            .call(
                document.querySelectorAll("select.cs-select.redirect-provider")
            )
            .forEach(function(el) {
                new SelectFx(el, {
                    stickyPlaceholder: true,
                    onChange: function(val) {
                        if (val) {
                            $("#js__provider-id").val(val);
                            var formData =
                                $("#js__add-to-schedule-submit").serialize() +
                                "&providerId=" +
                                encodeURIComponent(val);
                            $.ajax({
                                type: "POST",
                                url:
                                    domainBase +
                                    "schedules/getLocationsFromPerson",
                                data: formData,
                                dataType: "json",
                                error: function(xhr, status, thrown) {},
                                success: function(results) {
                                    if (results.ok == "true") {
                                        if (results.redirect) {
                                            window.location.href =
                                                results.redirect;
                                        } else {
                                            var appendTo = $(
                                                "#js__locations-checkbox-group"
                                            );
                                            appendTo.empty();
                                            $.each(results.data, function(
                                                index,
                                                value
                                            ) {
                                                appendTo.append(
                                                    $(
                                                        '<div class="checkbox checkbox-primary list"><input id="checkbox' +
                                                            index +
                                                            '" type="checkbox" name="locations[]" value=' +
                                                            value.itemId +
                                                            "_" +
                                                            value.itemType +
                                                            ' /><label for="checkbox' +
                                                            index +
                                                            '"><span>' +
                                                            value.locationName +
                                                            "</span></label></div>"
                                                    )
                                                );
                                            });
                                            $(
                                                "input:radio[name=locations]:not(:disabled):first"
                                            ).attr("checked", true);
                                            $("#js__location-title").show();
                                        }
                                    }
                                }
                            });
                        }
                    }
                });
            });
        [].slice
            .call(document.querySelectorAll("select.cs-select.copy-calendar"))
            .forEach(function(el) {
                new SelectFx(el, {
                    stickyPlaceholder: true,
                    onChange: function(val) {
                        if (val) {
                            $.ajax({
                                type: "POST",
                                url: domainBase + "schedules/getMonthToData",
                                data: "month=" + encodeURIComponent(val),
                                dataType: "json",
                                error: function(xhr, status, thrown) {},
                                success: function(results) {
                                    if (results.ok == "true") {
                                        if (results.redirect) {
                                            window.location.href =
                                                results.redirect;
                                        } else {
                                            var placeholder = $(
                                                "#js__copy-calendar-placeholder"
                                            );
                                            placeholder.empty();
                                            var template = $(
                                                "#js__copy-calendar-template"
                                            ).html();
                                            placeholder.append(template);
                                            var appendTo = placeholder.find(
                                                "#js__copy-calendar-month-to-select"
                                            );
                                            appendTo.empty();
                                            $.each(results.data, function(
                                                index,
                                                value
                                            ) {
                                                appendTo.append(
                                                    $(
                                                        '<option value="' +
                                                            value.month_id +
                                                            '">' +
                                                            value.name +
                                                            "</option>"
                                                    )
                                                );
                                            });
                                            var el = placeholder.find(
                                                "#js__copy-calendar-month-to-select"
                                            );
                                            new SelectFx(el.get(0), {
                                                stickyPlaceholder: true
                                            });
                                            $(
                                                "#js__copy-calendar-month"
                                            ).show();
                                        }
                                    }
                                }
                            });
                        }
                    }
                });
            });

        $("#js__datetimepicker").on(
            "click",
            ".js__remove-call-day-click",
            function(e) {
                var index = $(this)
                    .closest(".call-day-wrap")
                    .index();
                $(
                    "#js__datetimepicker > div:nth-child(" + (index + 1) + ")"
                ).remove();
                return false;
            }
        );

        $(".js__nav-calendar-type .cs-options li").click(function(e) {
            var url = $(".js__nav-calendar-type .cs-options")
                .find(".cs-selected")
                .attr("data-value");
            if (url) {
                window.location = url;
            }
            return false;
        });

        var datepickerB = "";
        var pickArr = [];
        var content = $("#js__call-day-template").html();
        attachCalendar(content);
        updateEndDate("never");

        $("#js__add-day").click(function(e) {
            var radios = $("input[name=repeat]");
            var shiftType = radios.filter(":checked").val();
            if (shiftType == "never") {
                if (pickArr.length < 10) {
                    attachCalendar(content);
                    updateEndDate(shiftType);
                } else {
                    $("#js__add-day").hide();
                }
            } else {
                attachCalendar(content);
                updateEndDate(shiftType);
            }
        });

        function updateEndDate(shiftType) {
            if (shiftType == "never") {
                $(".js__call-day-second-row").hide();
            } else {
                $(".js__call-day-second-row").show();
            }
        }

        function attachCalendar(content) {
            $("#js__datetimepicker").append(content);
            var lastAppended = $("#js__datetimepicker > div:last");

            var currDate = lastAppended.find(".date.start");
            currDate.attr("name", "calendar_date_" + pickArr.length);

            var datepicker = currDate.datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                singleDatePicker: true,
                showDropdowns: true,
                startDate: new Date(),
                container: ".datetimepicker-container",
                orientation: "top auto"
            });

            var currDateB = lastAppended.find(".date.startB");
            currDateB.attr("name", "calendar_endDate_" + pickArr.length);

            datepickerB = currDateB.datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: false,
                singleDatePicker: true,
                showDropdowns: true,
                container: ".datetimepicker-container",
                orientation: "top auto"
            });

            datepicker.datepicker().on("changeDate", function(e) {
                var firstPickerDate = datepicker.datepicker("getDate");
                datepickerB.datepicker("setStartDate", firstPickerDate);
                datepickerB.datepicker("update", firstPickerDate);
            });

            var default_time_from = $("#default_time_from").attr("data-value");
            var default_time_to = $("#default_time_to").attr("data-value");

            var timeStart = lastAppended.find(".time.start");
            timeStart.attr("name", "calendar_timeStart_" + pickArr.length);
            timeStart.timepicker({
                showDuration: true,
                timeFormat: "h:i a",
                step: "5",
                appendTo: ".datetimepicker-container"
            });
            timeStart.timepicker("setTime", default_time_from);
            var timeEnd = lastAppended.find(".time.end");
            timeEnd.attr("name", "calendar_timeEnd_" + pickArr.length);
            timeEnd.timepicker({
                showDuration: true,
                timeFormat: "h:i a",
                step: "5",
                appendTo: ".datetimepicker-container"
            });
            timeEnd.timepicker("setTime", default_time_to);
            lastAppended.datepair();

            var listSize = $("#js__datetimepicker > div").length;
            if (listSize == 1) {
                lastAppended.find(".js__remove-call-day-click").hide();
            }

            pickArr.push(datepicker);
        }

        $("#js__datetimepicker").on("click", ".icon-calendar", function(e) {
            var picker = $(this).siblings(".date");
            picker.focus();
        });

        var $radios = $('input[name="repeat"]');
        $radios.change(function() {
            var $checked = $radios.filter(":checked");
            updateEndDate($checked.val());
            if ($checked.val() == "never") {
                $("#js__add-day").show();
                pickArr = [];
                pickArr.push("empty");
            } else {
                $(".call-day-wrap")
                    .slice(1)
                    .remove();
                $("#js__add-day").hide();
            }
        });

        if ($("#js__message-text").length) {
            var max = 160;
            var startingDisplay = max - $("#js__message-text").val().length;
            $("#js__chars-remaining").html(
                startingDisplay + " characters remaining"
            );
            $("#js__message-text").keyup(function() {
                var text_length = $("#js__message-text").val().length;
                var text_remaining = max - text_length;
                $("#js__chars-remaining").html(
                    text_remaining + " characters remaining"
                );
            });
        }
    });
    return {};
})(window.jQuery);

console.log("🥑 avocado!");
