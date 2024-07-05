window.addEventListener('load', function () {
    $('#lai_sandbox_admin_toggle').click(function() {
        // $('#lai_sandbox_content').slideToggle();
        $('#lai_sandbox_content').slideToggle('slow', function() {
            if ($('#lai_sandbox_content').is(':hidden')) {
                $('#lai_sandbox_admin_header').text(string_lai_sandbox_view_open);
                // console.log("Closed: here we are: " + this);
                $('#lai_sandbox_admin_icon').addClass("fa-angle-down");
                $('#lai_sandbox_admin_icon').removeClass("fa-angle-up");
            } else {
                $('#lai_sandbox_admin_header').text(string_lai_sandbox_view_close);
                // console.log("Open: here we are: " + $('+ #lai_sandbox_admin_icon', this));
                $('#lai_sandbox_admin_icon').addClass("fa-angle-up");
                $('#lai_sandbox_admin_icon').removeClass("fa-angle-down");
            }
        });
    });
});



