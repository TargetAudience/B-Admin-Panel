var ajaxURL = null;
function setAjaxURL(item) {
    ajaxURL = item;
}

$(document).ready(function() {
    // Make the pin appear when the menu is the small.
    $('#sidebar-wrapper').hover(
        function() {
            if(!$("#wrapper").hasClass('responsive-override')) {
                $(this).find('.pin-button').show();
            }
        },
        function() {
            if(!$("#wrapper").hasClass('responsive-override')) {
                $(this).find('.pin-button').hide();
            }
        }
    );

    // Activates the pin click toggle.
    $("#menu-toggle").click(function(e) {
        var current = $("#wrapper");

        if(current.hasClass('opened-min')) {
            current.removeClass('opened-min');
            current.addClass('opened-max');

            current.find('.navbar-toggle').removeClass('unpinned');
            current.find('.navbar-toggle').addClass('pinned');

            pinMenu($('#menu-toggle').attr('data-type'), 1);
        } else {
            current.removeClass('opened-max');
            current.addClass('opened-min');

            current.find('.navbar-toggle').removeClass('pinned');
            current.find('.navbar-toggle').addClass('unpinned');

            pinMenu($('#menu-toggle').attr('data-type'), 0);
        }
        e.preventDefault();
    });

    // .responsive-submenu button gets added when screen is too small.
    // .responsive-override triggers animation to show or hide.
    $('#wrapper').find('.responsive-submenu').click(function(e) {
        $("#ftue-users-link").hide();
        var current = $("#wrapper");
        current.find('.pin-button').hide();
        current.find('.menu-close-button').show();
        current.addClass('responsive-override');
        $("#sidebar-wrapper").css('display', 'block');
    });

    $('#wrapper').find('.menu-close-button').click(function(e) {
        $("#wrapper").removeClass('responsive-override');
        $('#wrapper').find('.menu-close-button').hide();
    });

    function pinMenu(menuType, pinFlag) {
        $.ajax({
            type: "GET",
            url: domainBase + "index.php/user/pinMenu",
            data: 'menu_type=' + menuType + '&pin_flag=' + pinFlag,
            dataType: 'json',
            beforeSend: function() {},
            error: function(xhr, status, thrown) {},
            success: function(data) {}
        });
    }
});