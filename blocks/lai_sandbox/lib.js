window.addEventListener('load', function () {
    jQuery('#lai_sandbox_admin_toggle').click(function() {
        // $('#lai_sandbox_content').slideToggle();
        jQuery('#lai_sandbox_content').slideToggle('slow', function() {
            if (jQuery('#lai_sandbox_content').is(':hidden')) {
                jQuery('#lai_sandbox_admin_header').text(string_lai_sandbox_view_open);
                // console.log("Closed: here we are: " + this);
                jQuery('#lai_sandbox_admin_icon').addClass("fa-angle-down");
                jQuery('#lai_sandbox_admin_icon').removeClass("fa-angle-up");
            } else {
                jQuery('#lai_sandbox_admin_header').text(string_lai_sandbox_view_close);
                // console.log("Open: here we are: " + $('+ #lai_sandbox_admin_icon', this));
                jQuery('#lai_sandbox_admin_icon').addClass("fa-angle-up");
                jQuery('#lai_sandbox_admin_icon').removeClass("fa-angle-down");
            }
        });
    });

    /**
     * transmit_anything code.
     *
     * @module      block_lai_sandbox/ajax.php
     * @package     block_lai_sandbox
     * @copyright   lern.link GmbH
     * @author      Danou Nauck
     * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
     */
    jQuery('#lai_sandbox_gettoken').click(function() {

        jQuery.ajax({
                type: "POST",
                url: "/blocks/lai_sandbox/ajax.php",
                dataType: "json",
                data: {
                    action: 'getToken'
                }
            })
            .done(function(data) {
                window.console.log("AJAX DONE: Token geholt: " + data.token + " submitted: " + data.status);
                jQuery('#comp_button_token_result').html(data.token);
            })
            .fail(function() {
                window.console.log( "error" );
            })
            .always(function() {
                window.console.log( "complete" );
            });
    });
    /**
     * transmit_anything code.
     *
     * @module      block_lai_sandbox/ajax.php
     * @package     block_lai_sandbox
     * @copyright   lern.link GmbH
     * @author      Danou Nauck
     * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
     */
    jQuery('#lai_sandbox_droptoken').click(function() {
        var element = jQuery(this);
        var statsvalue = 123;
        var langstring = "Wollen sie sich wirklich von der API abmelden?";
        const response = confirm(langstring);
        if (response) {
            jQuery.ajax({
                type: "POST",
                url: "/blocks/lai_sandbox/ajax.php",
                dataType: "json",
                data: {
                    action: 'dropToken',
                    status: statsvalue,
                }
            })
                .done(function(data) {
                    window.console.log("AJAX SUCCESS: Token killed: " + data.token + " submitted: " + data.status);
                    jQuery('#comp_button_token_result').html("");
                });

        } else {
            window.console.log("Cancel was pressed");
        }
    });

});



