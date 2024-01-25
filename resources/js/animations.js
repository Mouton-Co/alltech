export function animations() {

    /*
    |--------------------------------------------------------------------------
    | SETTINGS DROPDOWN
    |--------------------------------------------------------------------------
    */
    $('#profile-dropdown-toggle').on("click", function () {
        if ($("#profile-dropdown").attr('aria-hidden') == "true") {
            // show dropdown
            $('#curtain-invisible').addClass('block').removeClass('hidden');
            $('#profile-dropdown').removeClass('hidden').addClass('block').attr('aria-hidden', "false");
            setTimeout(function () {
                $('#profile-dropdown')
                    .removeClass('ease-in').addClass('ease-out')
                    .removeClass('duration-75').addClass('duration-100')
                    .removeClass('opacity-0').addClass('opacity-100')
                    .removeClass('scale-95').addClass('scale-100');
            }, 100);
        } else {
            // hide dropdown
            $('#profile-dropdown').removeClass('block').addClass('hidden').attr('aria-hidden', "true");
            setTimeout(function () {
                $('#profile-dropdown')
                    .removeClass('ease-out').addClass('ease-in')
                    .removeClass('duration-100').addClass('duration-75')
                    .removeClass('opacity-100').addClass('opacity-0')
                    .removeClass('scale-100').addClass('scale-95');
            }, 75);
        }
    });
    $('#curtain-invisible').on("click", function () {
        $('#curtain-invisible').addClass('hidden').removeClass('block');
        $('#profile-dropdown').removeClass('block').addClass('hidden').attr('aria-hidden', "true");
        setTimeout(function () {
            $('#profile-dropdown')
                .removeClass('ease-out').addClass('ease-in')
                .removeClass('duration-100').addClass('duration-75')
                .removeClass('opacity-100').addClass('opacity-0')
                .removeClass('scale-100').addClass('scale-95');
        }, 75);
    });

    /*
    |--------------------------------------------------------------------------
    | SIDEBAR
    |--------------------------------------------------------------------------
    */
    $('#sidebar-toggle-open').on("click", function () {
        $('#sidebar').removeClass('-translate-x-full').addClass('translate-x-0');
        $('#curtain').addClass('block').removeClass('hidden');
        $('#sidebar-toggle-close').removeClass('hidden').addClass('block');
    });
    $('#sidebar-toggle-close, #curtain').on("click", function () {
        $('#sidebar').removeClass('translate-x-0').addClass('-translate-x-full');
        $('#curtain').addClass('hidden').removeClass('block');
        $('#sidebar-toggle-close').removeClass('block').addClass('hidden');
    });

    /*
    |--------------------------------------------------------------------------
    | MODAL POPUPS
    |--------------------------------------------------------------------------
    */
    $('.delete-icon').on("click", function () {
        let id = this.getAttribute('id').split('-')[1];
        $("#delete-modal-" + id).addClass('flex').removeClass('hidden');
        $('#curtain-modal').addClass('block').removeClass('hidden');
    });
    $('#add-resource').on("click", function () {
        $("#add-resource-modal").addClass('flex').removeClass('hidden');
        $('#curtain-modal').addClass('block').removeClass('hidden');
    });
    $('#update-resource').on("click", function () {
        $("#update-resource-modal").addClass('flex').removeClass('hidden');
        $('#curtain-modal').addClass('block').removeClass('hidden');
    });
    $('.edit-icon').on("click", function () {
        let id = this.getAttribute('id').split('-')[1];
        $("#edit-resource-modal-" + id).addClass('flex').removeClass('hidden');
        $('#curtain-modal').addClass('block').removeClass('hidden');
    });
    $('#curtain-modal, #curtain, .modal-cancel').on("click", function () {
        $('.delete-modal').addClass('hidden').removeClass('flex');
        $('.resource-modal').addClass('hidden').removeClass('flex');
        $('.report-modal').addClass('hidden').removeClass('flex');
        $('#curtain-modal').addClass('hidden').removeClass('block');
    });
    $('.report-card').on("click", function () {
        let id = this.getAttribute('id').split('-')[2];
        $("#report-modal-" + id).addClass('flex').removeClass('hidden');
        $('#curtain-modal').addClass('block').removeClass('hidden');
    });

    /*
    |--------------------------------------------------------------------------
    | DISMESS MESSAGE
    |--------------------------------------------------------------------------
    */
    $(".dismiss-button").on("click", function () {
        let msg = $(this).parent().parent();
        msg.fadeOut(700);

        setTimeout(function () {
            msg.css('display', '');
            msg.addClass('hidden');
        }, 800);
    });
}
