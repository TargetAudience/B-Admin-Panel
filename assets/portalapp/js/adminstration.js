(function($) {
    'use strict';

    $(document).ready(function() {
        $('#js__select-push-type').change(function() {
            var targetId = $(this).val();
            if (targetId === 'singleUser') {
                $('#js__single_user_push').show();
            } else {
                $('#js__single_user_push').hide();
            }
        });

        $('#sortedTable').DataTable({
            "searching": false,
            "paging": false,
            "info": false,
            columnDefs: [
                { orderable: false, targets: -1 }
             ]
        });

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'https://admin.boom.health/administration/getUsersAutoComplete',
            success: function(sourceValues) {
                $('#userAutoComplete').autocomplete({
                    minLength: 2,
                    source: function (request, response) {
                      const term = request.term.toLowerCase();
                      const matches = sourceValues.filter(value => {
                        var name = value.firstName + " " + value.lastName;
                        return name.toLowerCase().includes(term);
                      }).map(value => ({
                        label: value.firstName + " " + value.lastName,
                        value: value.userId
                      }));
                      response(matches);
                    },
                    select: function(event, ui) {
                      event.preventDefault();
                      $('#userAutoComplete').val(ui.item.label);
                      $('#specificUserId').val(ui.item.value);
                    }
                });
            }
        });

        $.ajax({
            type: 'POST',
            dataType: 'json',
			url: 'https://admin.boom.health/administration/getUsersPushAutoComplete',
            success: function(sourceValues) {
                $('#userPushAutoComplete').autocomplete({
                    minLength: 2,
                    source: function (request, response) {
                      const term = request.term.toLowerCase();
                      const matches = sourceValues.filter(value => {
                        var name = value.firstName + " " + value.lastName;
                        return name.toLowerCase().includes(term);
                      }).map(value => ({
                        label: value.firstName + " " + value.lastName,
                        value: value.userId
                      }));
                      response(matches);
                    },
                    select: function(event, ui) {
                      event.preventDefault();
                      $('#userPushAutoComplete').val(ui.item.label);
                      $('#selectedUserId').val(ui.item.value);
                    }
                });
            }
        });

        $('#js__profile-admin-password-edit').submit(function(e) {
            var postURL = $('#js__profile-admin-password-edit').attr('data-src');
            var data = $('#js__profile-admin-password-edit :input').serialize();
            globalForm(e, postURL, data);
        });


        $('#js__form-meals-add-to-week').submit(function(e) {
            var postURL = $('#js__form-meals-add-to-week').attr('data-src');
            var data = $('#js__form-meals-add-to-week :input').serialize();
            globalForm(e, postURL, data);
        });

        $('#js__form-equipment-new').submit(function(e) {
            var postURL = $('#js__form-equipment-new').attr('data-src');
            var data = $('#js__form-equipment-new :input').serialize();
            globalForm(e, postURL, data);
        });

        $('#js__user-edit').submit(function(e) {
            var postURL = $('#js__user-edit').attr('data-src');
            var data = $('#js__user-edit :input').serialize();
            globalForm(e, postURL, data);
        });

        $('#js__user-add').submit(function(e) {
            var postURL = $('#js__user-add').attr('data-src');
            var data = $('#js__user-add :input').serialize();
            globalForm(e, postURL, data);
        });

        $('#js__user-admin-edit').submit(function(e) {
            var postURL = $('#js__user-admin-edit').attr('data-src');
            var data = $('#js__user-admin-edit :input').serialize();
            globalForm(e, postURL, data);
        });

        $('#js__user-admin-add').submit(function(e) {
            var postURL = $('#js__user-admin-add').attr('data-src');
            var data = $('#js__user-admin-add :input').serialize();
            globalForm(e, postURL, data);
        });

        $('#js__caregivers-edit').submit(function(e) {
            var postURL = $('#js__caregivers-edit').attr('data-src');
            var data = $('#js__caregivers-edit :input').serialize();
            console.log(data);
            globalForm(e, postURL, data);
        });

        $('#js__personal-care-worker-edit').submit(function(e) {
            var postURL = $('#js__personal-care-worker-edit').attr('data-src');
            var data = $('#js__personal-care-worker-edit :input').serialize();
            console.log(data);
            globalForm(e, postURL, data);
        });

        $('#js__caregivers-add').submit(function(e) {
            var postURL = $('#js__caregivers-add').attr('data-src');
            var data = $('#js__caregivers-add :input').serialize();
            console.log(data);
            globalForm(e, postURL, data);
        });

        $('#js__personal-care-worker-add').submit(function(e) {
            var postURL = $('#js__personal-care-worker-add').attr('data-src');
            var data = $('#js__personal-care-worker-add :input').serialize();
            console.log(data);
            globalForm(e, postURL, data);
        });

        $('#js__form-meals').submit(function(e) {
            var postURL = $('#js__form-meals').attr('data-src');
            var data = $('#js__form-meals :input').serialize();
            globalForm(e, postURL, data);
        });

        $('#js__profile-admin-edit').submit(function(e) {
            var postURL = $('#js__profile-admin-edit').attr('data-src');
            var data = $('#js__profile-admin-edit :input').serialize();
            globalForm(e, postURL, data);
        });

        $('#js__form-promo-code').submit(function(e) {
            var postURL = $('#js__form-promo-code').attr('data-src');
            var data = $('#js__form-promo-code :input').serialize();
            globalForm(e, postURL, data);
        });

        $('#js__promo-code-edit').submit(function(e) {
            var postURL = $('#js__promo-code-edit').attr('data-src');
            var data = $('#js__promo-code-edit :input').serialize();
            globalForm(e, postURL, data);
        });

        $('#js__allpurchases-admin-edit').submit(function(e) {
            var postURL = $('#js__allpurchases-admin-edit').attr('data-src');
            var data = $('#js__allpurchases-admin-edit :input').serialize();
            globalForm(e, postURL, data);
        });

        $('#js__form-equipment-pricing').submit(function(e) {
            var postURL = $('#js__form-equipment-pricing').attr('data-src');
            console.log('postURL', postURL)
            var data = $('#js__form-equipment-pricing :input').serialize();
            globalForm(e, postURL, data);
        });

        $('#js__form-equipment-sizes').submit(function(e) {
            var postURL = $('#js__form-equipment-sizes').attr('data-src');
            console.log('postURL', postURL)
            var data = $('#js__form-equipment-sizes :input').serialize();
            globalForm(e, postURL, data);
        });

        $('#js__push-notification-send').submit(function(e) {
            var postURL = $('#js__push-notification-send').attr('data-src');
            var data = $('#js__push-notification-send :input').serialize();
            globalForm(e, postURL, data);
        });

        function globalForm(e, postURL, data) {
            var spinner_div = $('#js__submit-spinner').get(0);
            var button = $('#js__submit');
            var buttonLabel = button.val();
            button.val('');
            $('#js__submit-spinner').position(button.position());

            if (spinner == null) {
                spinner = new Spinner(opts).spin(spinner_div);
            } else {
                spinner.spin(spinner_div);
            }

            button.attr('disabled', 'disabled');


            $.ajax({
                type: 'POST',
                url: postURL,
                data: data,
                success: function(data) {
                    console.log(data);
                    spinner.stop(spinner_div)
                    button.val(buttonLabel)
                    button.removeAttr('disabled', 'disabled');
                    if (data.ok == 'true') {
                        window.location.href = data.redirect;
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
    });
})(window.jQuery);