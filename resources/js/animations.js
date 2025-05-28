export function animations() {
    /*
    |--------------------------------------------------------------------------
    | SETTINGS DROPDOWN
    |--------------------------------------------------------------------------
    */
    $("#profile-dropdown-toggle").on("click", function () {
        if ($("#profile-dropdown").attr("aria-hidden") == "true") {
            // show dropdown
            $("#curtain-invisible").addClass("block").removeClass("hidden");
            $("#profile-dropdown")
                .removeClass("hidden")
                .addClass("block")
                .attr("aria-hidden", "false");
            setTimeout(function () {
                $("#profile-dropdown")
                    .removeClass("ease-in")
                    .addClass("ease-out")
                    .removeClass("duration-75")
                    .addClass("duration-100")
                    .removeClass("opacity-0")
                    .addClass("opacity-100")
                    .removeClass("scale-95")
                    .addClass("scale-100");
            }, 100);
        } else {
            // hide dropdown
            $("#curtain-invisible").addClass("hidden").removeClass("block");
            $("#profile-dropdown")
                .removeClass("block")
                .addClass("hidden")
                .attr("aria-hidden", "true");
            setTimeout(function () {
                $("#profile-dropdown")
                    .removeClass("ease-out")
                    .addClass("ease-in")
                    .removeClass("duration-100")
                    .addClass("duration-75")
                    .removeClass("opacity-100")
                    .addClass("opacity-0")
                    .removeClass("scale-100")
                    .addClass("scale-95");
            }, 75);
        }
    });
    $("#curtain-invisible").on("click", function () {
        $("#curtain-invisible").addClass("hidden").removeClass("block");
        $("#profile-dropdown")
            .removeClass("block")
            .addClass("hidden")
            .attr("aria-hidden", "true");
        setTimeout(function () {
            $("#profile-dropdown")
                .removeClass("ease-out")
                .addClass("ease-in")
                .removeClass("duration-100")
                .addClass("duration-75")
                .removeClass("opacity-100")
                .addClass("opacity-0")
                .removeClass("scale-100")
                .addClass("scale-95");
        }, 75);
    });

    /*
    |--------------------------------------------------------------------------
    | SIDEBAR
    |--------------------------------------------------------------------------
    */
    $("#sidebar-toggle-open").on("click", function () {
        $("#sidebar")
            .removeClass("-translate-x-full")
            .addClass("translate-x-0");
        $("#curtain-mobile").addClass("block").removeClass("hidden");
        $("#sidebar-toggle-close").removeClass("hidden").addClass("block");
    });
    $("#sidebar-toggle-close, #curtain-mobile").on("click", function () {
        $("#sidebar")
            .removeClass("translate-x-0")
            .addClass("-translate-x-full");
        $("#curtain-mobile").addClass("hidden").removeClass("block");
        $("#sidebar-toggle-close").removeClass("block").addClass("hidden");
    });

    /*
    |--------------------------------------------------------------------------
    | MODAL POPUPS
    |--------------------------------------------------------------------------
    */
    $(".delete-icon").on("click", function () {
        let id = this.getAttribute("id").split("-")[1];
        $("#delete-modal-" + id)
            .addClass("flex")
            .removeClass("hidden");
        $("#curtain-modal").addClass("block").removeClass("hidden");
    });
    $("#add-resource").on("click", function () {
        $("#add-resource-modal").addClass("flex").removeClass("hidden");
        $("#curtain-modal").addClass("block").removeClass("hidden");
    });
    $("#update-resource").on("click", function () {
        $("#update-resource-modal").addClass("flex").removeClass("hidden");
        $("#curtain-modal").addClass("block").removeClass("hidden");
    });
    $(".edit-icon").on("click", function () {
        let id = this.getAttribute("id").split("-")[1];
        $("#edit-resource-modal-" + id)
            .addClass("flex")
            .removeClass("hidden");
        $("#curtain-modal").addClass("block").removeClass("hidden");
    });
    $("#cancel-meeting").on("click", function () {
        let id = this.getAttribute("datum-id");
        $("#cancel-resource-modal-" + id)
            .addClass("flex")
            .removeClass("hidden");
        $("#curtain-modal").addClass("block").removeClass("hidden");
    });
    $("#curtain-modal, #curtain-mobile, #curtain, .modal-cancel").on(
        "click",
        function () {
            $(".delete-modal").addClass("hidden").removeClass("flex");
            $(".resource-modal").addClass("hidden").removeClass("flex");
            $(".report-modal").addClass("hidden").removeClass("flex");
            $("#add-email-modal").addClass("hidden").removeClass("flex");
            $("#curtain-modal").addClass("hidden").removeClass("block");
            $("#curtain").addClass("hidden").removeClass("block");
            $("#curtain-mobile").addClass("hidden").removeClass("block");
        }
    );
    $(".report-card").on("click", function () {
        let id = this.getAttribute("id").split("-")[2];
        $("#report-modal-" + id)
            .addClass("flex")
            .removeClass("hidden");
        $("#curtain-modal").addClass("block").removeClass("hidden");
    });
    $("#create-email").on("click", function () {
        $("#add-email-modal").addClass("flex").removeClass("hidden");
        $("#curtain").addClass("block").removeClass("hidden");
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
            msg.css("display", "");
            msg.addClass("hidden");
        }, 800);
    });

    /*
    |--------------------------------------------------------------------------
    | ALL DAY CHECKBOX
    |--------------------------------------------------------------------------
    */
    $("input[name='all_day']").on("change", function () {
        if ($(this).is(":checked")) {
            $(".hide-for-all-day").addClass("hidden");
            $(".start-date-label").html("Start date");
            $(".show-for-all-day").removeClass("hidden");
        } else {
            $(".hide-for-all-day").removeClass("hidden");
            $(".start-date-label").html("Date");
            $(".show-for-all-day").addClass("hidden");
        }
    });
}

/*
|--------------------------------------------------------------------------
| FORM SUBMISSIONS
|--------------------------------------------------------------------------
*/
$("#report-filter-submit").on("click", function () {
    $("#report-filter-form").submit();
});
