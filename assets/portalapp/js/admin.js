(function($) {
    'use strict';

    $(document).ready(function() {
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

        var spinner_div = $('#js__submit-spinner').get(0);
        var button = $('#js__submit');

        var spinner = null;
        var opts = {
            lines:     11,        // The number of lines to draw
            length:    4,         // The length of each line
            width:     2,         // The line thickness
            radius:    5,         // The radius of the inner circle
            corners:   0,         // Corner roundness (0..1)
            rotate:    0,         // The rotation offset
            direction: 1,         // 1: clockwise, -1: counterclockwise
            color:     '#fff',    // #rgb or #rrggbb or array of colors
            speed:     1.0,       // Rounds per second
            trail:     60,        // Afterglow percentage
            shadow:    false,     // Whether to render a shadow
            hwaccel:   false,     // Whether to use hardware acceleration
            className: 'spinner', // The CSS class to assign to the spinner
            top:       'auto',    // Top position relative to parent in px
            left:      'auto'     // Left position relative to parent in px
        };

        function showResponse(data, statusText, xhr, $form)  {
            spinner.stop(spinner_div);
            button.prop('value', 'Save Information');

            if(data.ok == 'true') {
                window.location.href = data.redirect;
            } else {
                var json = JSON.parse(data.content);
                var error = '';
                if(json.length >= 1) {
                    if(json.length > 1) {
                        error += "<br />";
                    }
                    for(var i in json) {
                        error += json[i] + "<br />";
                    }
                }
                hideAlert();
                showAlert('danger', data.title, error);
            }
        } 

        function requestForm(e) {
            var postURL = $('#js__form').attr('data-src');
            var $inputs = $('#js__form :input');

            $.ajax({
                type: 'POST',
                url: postURL,
                data: $inputs.serialize(),
                success: function(data) {
                    if(data.ok == 'true') {
                        window.location.href = data.redirect;
                    } else {
                        var json = JSON.parse(data.content);
                        var error = '';
                        if(json.length >= 1) {
                            if(json.length > 1) {
                                error += "<br />";
                            }
                            for(var i in json) {
                                error += json[i] + "<br />";
                            }
                        }
                        hideAlert();
                        showAlert('danger', data.title, error);
                    }
                },
                error: function(xhr, status, thrown) {},
                beforeSend:function() {}
            });
            e.preventDefault();
            return false;
        }

        $('#login-form').submit(function(e) {
            var button = $('#js__submit');
            button.val('');
            $('#js__submit-spinner').position(button.position());

            if(spinner == null) {
                spinner = new Spinner(opts).spin(spinner_div);
            } else {
                spinner.spin(spinner_div);
            }

            var $inputs = $('#login-form :input');
            var postURL = $('#login-form').attr('data-src');

            $.ajax({
                type: 'POST',
                url: postURL,
                data: $inputs.serialize(),
                success: function(data) {
                    if(data.ok == 'true') {
                        window.location.href = data.redirect;
                    } else {
                        spinner.stop(spinner_div);
                        button.val('Sign In');

                        $('#password').val('');
                        $('#password').focus();

                        var json = JSON.parse(data.content);
                        var error = '';
                        if(json.length >= 1) {
                            if(json.length > 1) {
                                error += "<br />";
                            }
                            for(var i in json) {
                                error += json[i] + "<br />";
                            }
                        }
                        hideAlert();
                        showAlert('danger', data.title, error);
                    }
                },
                error: function(xhr, status, thrown) {},
                beforeSend:function() {}
            });
            e.preventDefault();
            return false;
        });

        $('#password-form').submit(function(e) {
            var button = $('#js__submit');
            button.val('');
            $('#js__submit-spinner').position(button.position());

            if(spinner == null) {
                spinner = new Spinner(opts).spin(spinner_div);
            } else {
                spinner.spin(spinner_div);
            }

            button.attr('disabled', 'disabled');

            var $inputs = $('#password-form :input');
            var postURL = $('#password-form').attr('data-src');

            $.ajax({
                type: 'POST',
                url: postURL,
                data: $inputs.serialize(),
                success: function(data) {
                    spinner.stop(spinner_div);
                    button.val('Reset Password');
                    button.removeAttr('disabled', 'disabled');

                    if(data.ok == 'true') {
                        var json = JSON.parse(data.content);

                        $('#emailAddress').val('');
                        hideAlert();
                        showAlert('success', '', json);
                    } else {
                        $('#emailAddress').val('');
                        $('#emailAddress').focus();

                        var json = JSON.parse(data.content);
                        var error = '';
                        if(json.length >= 1) {
                            if(json.length > 1) {
                                error += "<br />";
                            }
                            for(var i in json) {
                                error += json[i] + "<br />";
                            }
                        }
                        hideAlert();
                        showAlert('danger', data.title, error);
                    }
                },
                error: function(xhr, status, thrown) {},
                beforeSend:function() {}
            });
            e.preventDefault();
            return false;
        });

        $('#complete-resetPassword-form').submit(function(e) {
            var button = $('#js__submit');
            button.val('');
            $('#js__submit-spinner').position(button.position());

            if(spinner == null) {
                spinner = new Spinner(opts).spin(spinner_div);
            } else {
                spinner.spin(spinner_div);
            }

            var $inputs = $('#complete-resetPassword-form :input');
            var postURL = $('#complete-resetPassword-form').attr('data-src');

            $.ajax({
                type: 'POST',
                url: postURL,
                data: $(this).serialize(),
                success: function(data) {
                    spinner.stop(spinner_div);
                    button.val('Save My New Password');

                    if(data.ok == 'true') {
                        window.location.href = data.redirect;
                    } else {
                        button.blur();

                        var json = JSON.parse(data.content);
                        var error = '';
                        if(json.length >= 1) {
                            if(json.length > 1) {
                                error += "<br />";
                            }
                            for(var i in json) {
                                error += json[i] + "<br />";
                            }
                        }
                        hideAlert();
                        showAlert('danger', data.title, error);
                    }
                },
                error: function(xhr, status, thrown) {},
                beforeSend:function() {}
            });
            e.preventDefault();
            return false;
        });

        $('#registration-form').submit(function(e) {
            var button = $('#js__submit');
            button.val('');
            $('#js__submit-spinner').position(button.position());

            if(spinner == null) {
                spinner = new Spinner(opts).spin(spinner_div);
            } else {
                spinner.spin(spinner_div);
            }

            button.attr('disabled', 'disabled');

            var $inputs = $('#registration-form :input');
            var postURL = $('#registration-form').attr('data-src');

            $.ajax({
                type: 'POST',
                url: postURL,
                data: $(this).serialize(),
                success: function(data) {
                    spinner.stop(spinner_div);
                    button.val("Let's Get Started");
                    button.removeAttr('disabled', 'disabled');
                    
                    if(data.ok == 'true') {
                        window.location.href = data.redirect;
                    } else {
                        button.blur();

                        var json = JSON.parse(data.content);
                        var error = '';
                        if(json.length >= 1) {
                            if(json.length > 1) {
                                error += "<br />";
                            }
                            for(var i in json) {
                                error += json[i] + "<br />";
                            }
                        }

                        hideAlert();
                        showAlert('danger', data.title, error);
                    }
                },
                error: function(xhr, status, thrown) {},
                beforeSend:function() {}
            });
            e.preventDefault();
            return false;
        });

        function showAlert(type, title, message) {
            if (type ==  'danger') type = 'error'
            $.toast({
                heading: title,
                text: message,
                icon: type,
                bgColor: '#3889f3',
                textColor: 'white',
                position: 'top-center',
                allowToastClose: true,
                hideAfter: 3000,
                loader: false,
            });
        };

        function hideAlert() {
            $.toast().reset('all');
        }

        $('#js__avatar-link').click(function(e) {
            if ($("#js__avatar-parent").hasClass("menu-active")) {
                $("#js__avatar-parent").removeClass(
                    "menu-active"
                );
            } else {
                $("#js__avatar-parent").addClass(
                    "menu-active"
                );
            }
            e.preventDefault();
            return false;
        });
    });
})(window.jQuery);

console.log('🥑 avocado!');