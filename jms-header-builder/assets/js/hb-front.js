(function($) {
    $(document).ready(function () {
        $('.sidebar-btn > a').click(function (event) {
            event.preventDefault();
            $(this).closest('.addon-box').find('.sidebar-wrapper').toggleClass('show');
        });
        $('.overlay').click(function (event) {
            $(this).closest(".sidebar-wrapper").removeClass('show');
        });
    });
})(jQuery);