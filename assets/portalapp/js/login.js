(function($) {
    'use strict';

    $(document).ready(function() {
        var spinner_div = $('#submit_spinner').get(0);
        var button = $(".submit-button");

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
        
        $('#complete-resetPassword-form').submit(function(e) {
            var button = $(".submit-buttonb");
            button.val('');
            $('#submit_spinner').position(button.position());

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

        $('#login-form').submit(function(e) {
            button.val('');
            $('#submit_spinner').position(button.position());

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
                        if(data.cookieEmail) {
                            createCookie('cookieEmail', data.cookieEmail, '30');
                        } else {
                            deleteCookie('cookieEmail');
                        }

                        window.location.href = data.redirect;
                    } else {
                        spinner.stop(spinner_div);
                        button.val('SIGN IN');

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
            button.val('');
            $('#submit_spinner').position(button.position());

            if(spinner == null) {
                spinner = new Spinner(opts).spin(spinner_div);
            } else {
                spinner.spin(spinner_div);
            }

            var $inputs = $('#password-form :input');
            var postURL = $('#password-form').attr('data-src');

            $.ajax({
                type: 'POST',
                url: postURL,
                data: $inputs.serialize(),
                success: function(data) {
                    if(data.ok == 'true') {
                        window.location.href = data.redirect;
                    } else {
                        spinner.stop(spinner_div);
                        button.val('Reset Password');

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

        $('#select-login-form button').click(function() {
            var submit_val = $(this).attr('data-val');
            $('[name="action"]').val(submit_val);
        });

        $('#select-login-form').submit(function(e) {
            var postURL = $('#select-login-form').attr('data-src');

            $.ajax({
                type: 'POST',
                url: postURL,
                data: 'loginEncrypt=' + $('#action').val(),
                success: function(data) {
                    window.location.href = data.redirect;
                },
                error: function(xhr, status, thrown) {},
                beforeSend:function() {}
            });
            e.preventDefault();
            return false;
        });

        $('#password-form').submit(function(e) {
            var button = $(".submit-buttonb");
            button.val('');
            $('#submit_spinner').position(button.position());

            if(spinner == null) {
                spinner = new Spinner(opts).spin(spinner_div);
            } else {
                spinner.spin(spinner_div);
            }

            var $inputs = $('#password-form :input');
            var postURL = $('#password-form').attr('data-src');

            $.ajax({
                type: 'POST',
                url: postURL,
                data: $inputs.serialize(),
                success: function(data) {
                    spinner.stop(spinner_div);
                    button.val('CONTINUE');

                    if(data.ok == 'true') {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            $('#emailAddress').val('');
                            hideAlert();
                            showAlert('success', '', data.content);
                        }
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

        $('#password-form2').submit(function(e) {
            var button = $(".submit-buttonb");
            button.val('');
            $('#submit_spinner').position(button.position());

            if(spinner == null) {
                spinner = new Spinner(opts).spin(spinner_div);
            } else {
                spinner.spin(spinner_div);
            }

            var $inputs = $('#password-form2 :input');
            var postURL = $('#password-form2').attr('data-src');

            $.ajax({
                type: 'POST',
                url: postURL,
                data: $inputs.serialize(),
                success: function(data) {
                    spinner.stop(spinner_div);
                    button.val('Reset Your Password');

                    if(data.ok == 'true') {
                        $('#answer').val('');
                        hideAlert();
                        showAlert('success', '', data.content);
                    } else {
                        $('#answer').val('');
                        $('#answer').focus();

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

        function deleteCookie(name) {
            createCookie(name,"",-1);
        }

        function readCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for(var i=0;i < ca.length;i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
            }
            return null;
        }

        function createCookie(name,value,days) {
            if(days) {
                var date = new Date();
                date.setTime(date.getTime()+(days*24*60*60*1000));
                var expires = "; expires="+date.toGMTString();
            }
            else var expires = "";
            document.cookie = name+"="+value+expires+"; path=/;";
        }

        function navClick() {
            $('#main-navigation a').removeClass('active');
            $(this).addClass('active');
        }
    });
})(window.jQuery);