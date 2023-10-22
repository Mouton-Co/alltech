export function animations() {

    /*
    |--------------------------------------------------------------------------
    | SETTINGS DROPDOWN
    |--------------------------------------------------------------------------
    */
    $('#settings-toggle').on("click", function () {
        if ($("#settings-dropdown").attr('aria-expanded') == "false") {
            $('#settings-dropdown').addClass('h-[150px]').removeClass('h-14').attr('aria-expanded', "true");
            $('#settings-arrow').addClass('rotate-180');
        } else {
            $('#settings-dropdown').addClass('h-14').removeClass('h-[150px]').attr('aria-expanded', "false");
            $('#settings-arrow').removeClass('rotate-180');
        }
    });

    /*
    |--------------------------------------------------------------------------
    | DELETE MODAL POPUP
    |--------------------------------------------------------------------------
    */
    $('.delete-icon').on("click", function () {
        let id = this.getAttribute('id').split('-')[1];
        $("#delete-modal-" + id).addClass('flex').removeClass('hidden');
        $('#curtain').addClass('block').removeClass('hidden');
    });
    $('#curtain, .modal-cancel').on("click", function () {
        $('.delete-modal').addClass('hidden').removeClass('flex');
        $('#curtain').addClass('hidden').removeClass('block');
    });

    /*
    |--------------------------------------------------------------------------
    | ADD MODAL POPUP
    |--------------------------------------------------------------------------
    */
    $('#add-resource').on("click", function () {
        $("#add-resource-modal").addClass('flex').removeClass('hidden');
        $('#curtain').addClass('block').removeClass('hidden');
    });
    $('#curtain, .modal-cancel').on("click", function () {
        $('#add-resource-modal').addClass('hidden').removeClass('flex');
        $('#curtain').addClass('hidden').removeClass('block');
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









    /*
    |--------------------------------------------------------------------------
    | DELETE MODAL POPUP
    |--------------------------------------------------------------------------
    */
    // $('svg[id^="delete-button-"], div[id^="delete-button-"]').on("click", function () {
    //     let id = this.getAttribute('id').split('-')[2];
    //     $("#delete-modal-" + id).removeClass('hidden');
    //     $('#curtain-' + id).removeClass('curtain-closed').addClass('curtain-expanded');
    //     setTimeout(function () {
    //         $("#delete-modal-popup-" + id).removeClass('modal-close');
    //         $("#delete-modal-popup-" + id).addClass('modal-popup');
    //     }, 300);
    // });

    // $('button[id^="delete-modal-cancel-"]').on("click", function () {
    //     let id = this.getAttribute('id').split('-')[3];
    //     $('#curtain-' + id).addClass('curtain-closed').removeClass('curtain-expanded');
    //     $("#delete-modal-popup-" + id).removeClass('modal-popup');
    //     $("#delete-modal-popup-" + id).addClass('modal-close');
    //     setTimeout(function () {
    //         $("#delete-modal-" + id).addClass('hidden');
    //     }, 200);
    // });










    //     /*
    //     |--------------------------------------------------------------------------
    //     | PROFILE DROPDOWN
    //     |--------------------------------------------------------------------------
    //     */
    //     $("#profile-dropdown-toggle").on("click", function () {
    //         if ($("#profile-dropdown-toggle").attr('aria-expanded') == "false") {
    //             $('#profile-dropdown').removeClass('hidden');
    //             setTimeout(function () {
    //                 $('#profile-dropdown').addClass('profile-dropdown-show').removeClass('profile-dropdown-hide');
    //                 $("#profile-dropdown-toggle").attr('aria-expanded', "true");
    //             }, 100);
    //         } else {
    //             $('#profile-dropdown').addClass('profile-dropdown-hide').removeClass('profile-dropdown-show');
    //             $("#profile-dropdown-toggle").attr('aria-expanded', "false");
    //             setTimeout(function () {
    //                 $('#profile-dropdown').addClass('hidden');
    //             }, 75);
    //         }
    //     });

    //     /*
    //     |--------------------------------------------------------------------------
    //     | OPEN AND CLOSE MOBILE MENU
    //     |--------------------------------------------------------------------------
    //     */
    //     $('#open-menu').on("click", function () {
    //         $("#mobile-nav").removeClass('-z-10').addClass('z-50');
    //         $('#curtain').addClass('curtain-expanded').removeClass('curtain-closed');
    //         $('#side-panel').addClass('side-panel-expanded').removeClass('side-panel-closed');
    //         $('#close-button').addClass('close-button-expanded').removeClass('close-button-closed');
    //     });

    //     $('#close-menu, #curtain').on("click", function () {
    //         $('#curtain').addClass('curtain-closed').removeClass('curtain-expanded');
    //         $('#side-panel').addClass('side-panel-closed').removeClass('side-panel-expanded');
    //         $('#close-button').addClass('close-button-closed').removeClass('close-button-expanded');
    //         $("#mobile-nav").removeClass('z-50').addClass('-z-10');
    //     });

    //     /*
    //     |--------------------------------------------------------------------------
    //     | DISMESS MESSAGE
    //     |--------------------------------------------------------------------------
    //     */
    //     $(".dismiss-button").on("click", function () {
    //         let msg = $(this).parent().parent();
    //         msg.fadeOut(700);

    //         setTimeout(function () {
    //             msg.css('display', '');
    //             msg.addClass('hidden');
    //         }, 800);
    //     });



    //     /*
    //     |--------------------------------------------------------------------------
    //     | ADD MEETING MODAL POPUP
    //     |--------------------------------------------------------------------------
    //     */
    //     $('button[id^="add-meeting-button-"]').on("click", function () {
    //         let id = this.getAttribute('id').split('-')[3];
    //         $("#add-modal-" + id).removeClass('hidden');
    //         $('#curtain-' + id).removeClass('curtain-closed').addClass('curtain-expanded');
    //         setTimeout(function () {
    //             $("#add-modal-popup-" + id).removeClass('modal-close');
    //             $("#add-modal-popup-" + id).addClass('modal-popup');
    //         }, 300);
    //     });

    //     $('button[id^="add-modal-cancel-"]').on("click", function () {
    //         let id = this.getAttribute('id').split('-')[3];
    //         $('#curtain-' + id).addClass('curtain-closed').removeClass('curtain-expanded');
    //         $("#add-modal-popup-" + id).removeClass('modal-popup');
    //         $("#add-modal-popup-" + id).addClass('modal-close');
    //         setTimeout(function () {
    //             $("#add-modal-" + id).addClass('hidden');
    //         }, 200);
    //     });





}
