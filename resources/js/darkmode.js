export function darkMode() {
    $('.dark-toggle').on("click", function () {
        let checked = this.getAttribute('aria-checked');
        if (checked == "true") {
            $('.dark-toggle').removeClass('bg-orange').addClass('bg-gray-200');
            $('.dark-toggle span').removeClass('translate-x-5').addClass('translate-x-0');
            $('.logo-light').removeClass('hidden');
            $('.logo-dark').addClass('hidden');
            $(".dark-toggle").attr('aria-checked', "false");
            $('html').removeClass('dark');
            toggleAjax();
        } else if (checked == "false") {
            $('.dark-toggle').removeClass('bg-gray-200').addClass('bg-orange');
            $('.dark-toggle span').removeClass('translate-x-0').addClass('translate-x-5');
            $('.logo-dark').removeClass('hidden');
            $('.logo-light').addClass('hidden');
            $(".dark-toggle").attr('aria-checked', "true");
            $('html').addClass('dark');
            toggleAjax();
        }
    });

    function toggleAjax() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "/toggle-dark-mode",
        });
    }
}