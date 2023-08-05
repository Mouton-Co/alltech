export function animations() {
    $("#profile-dropdown-toggle").on("click", function () {
        if ($("#profile-dropdown-toggle").attr('aria-expanded') == "false") {
            $('#profile-dropdown').removeClass('hidden');
            setTimeout(function () {
                $('#profile-dropdown').addClass('profile-dropdown-show').removeClass('profile-dropdown-hide');
                $("#profile-dropdown-toggle").attr('aria-expanded', "true");
            }, 100);
        } else {
            $('#profile-dropdown').addClass('profile-dropdown-hide').removeClass('profile-dropdown-show');
            $("#profile-dropdown-toggle").attr('aria-expanded', "false");
            setTimeout(function () {
                $('#profile-dropdown').addClass('hidden');
            }, 75);
        }
    });

    $('#open-menu').on("click", function () {
        $("#mobile-nav").removeClass('-z-10').addClass('z-50');
        $('#curtain').addClass('curtain-expanded').removeClass('curtain-closed');
        $('#side-panel').addClass('side-panel-expanded').removeClass('side-panel-closed');
        $('#close-button').addClass('close-button-expanded').removeClass('close-button-closed');
    });

    $('#close-menu, #curtain').on("click", function () {
        $('#curtain').addClass('curtain-closed').removeClass('curtain-expanded');
        $('#side-panel').addClass('side-panel-closed').removeClass('side-panel-expanded');
        $('#close-button').addClass('close-button-closed').removeClass('close-button-expanded');
        $("#mobile-nav").removeClass('z-50').addClass('-z-10');
    });

    $('#test-press-me').on("click", function () {
        console.log('clicked');
    });
}