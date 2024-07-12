window.addEventListener('load', function () {
    console.log("local_lai_connector JS loaded !");

    if ((document.location.href.lastIndexOf('localhost') !== -1) || (document.location.href.lastIndexOf('127.0.0.1') !== -1)) {
        var wwwroot = 'https://localhost/';
    } else {
         var wwwroot = '/';
    }

    /**
     * transmit_anything code.
     *
     * @module      local_lai_connector/classes/ajax.php
     * @package     local_lai_connector
     * @copyright   lern.link GmbH
     * @author      Danou Nauck
     * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
     */
    $('#tarsus_ajax_add_course_to_brain').click(function() {
        window.console.log("tarsus_ajax_add_course_to_brain_new clicked");
        // Save the new order in the db.
        $.ajax({
            type: "POST",
            url: M.cfg.wwwroot + "/local/lai_connector/classes/ajax.php",
            data: {
                action: 'addCourseToBrain',
                courseid: M.cfg.courseId,
                sesskey: M.cfg.sesskey
            },
            dataType: "json",
            success: function(data) {
                let textstring = JSON.stringify(data);
                window.console.log("AJAX DONE: addCourseToBrain: " + data.token + " submitted: " + data.status);
                window.console.log(textstring);
                $('#tarsus_ajax_add_course_to_brain_result').html(data.token);
            },
            fail: function (data) {
                window.console.log( "error" );
                $('#tarsus_ajax_add_course_to_brain_result').html("Error");
            }
        });
    });


    /**
     * get all the available brains.
     *
     * @module      local_lai_connector/classes/ajax.php
     * @package     local_lai_connector
     * @copyright   lern.link GmbH
     * @author      Danou Nauck
     * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
     */
    $('#tarsus_ajax_showallbrains').click(function() {
        window.console.log("tarsus_ajax_showallbrains clicked");
        // Save the new order in the db.
        $.ajax({
            type: "POST",
            url: M.cfg.wwwroot + "/local/lai_connector/classes/ajax.php",
            data: {
                action: 'showAllBrains',
                sesskey: M.cfg.sesskey
            },
            dataType: "json",
            success: function(data) {
                let textstring = JSON.stringify(data);
                window.console.log("AJAX DONE: tarsus_ajax_showallbrains");
                // window.console.log(textstring);
                $('#tarsus_ajax_resultarea').html(textstring);
            },
            fail: function (data) {
                let textstring = JSON.stringify(data);
                window.console.log( "ERROR" );
                $('#tarsus_ajax_resultarea').html("ERROR: " + textstring);
            }
        });
    });

    /**
     * get all the brains usage and quotas.
     *
     * @module      local_lai_connector/classes/ajax.php
     * @package     local_lai_connector
     * @copyright   lern.link GmbH
     * @author      Danou Nauck
     * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
     */
    $('#tarsus_ajax_showbrainquotas').click(function() {
        window.console.log("tarsus_ajax_showbrainquotas clicked");
        // Save the new order in the db.
        $.ajax({
            type: "POST",
            url: M.cfg.wwwroot + "/local/lai_connector/classes/ajax.php",
            data: {
                action: 'showBrainsQuotas',
                sesskey: M.cfg.sesskey
            },
            dataType: "json",
            success: function(data) {
                let textstring = JSON.stringify(data);
                window.console.log("AJAX DONE: tarsus_ajax_showbrainquotas");
                $('#tarsus_ajax_resultarea').html(textstring);
            },
            fail: function (data) {
                let textstring = JSON.stringify(data);
                window.console.log( "ERROR" );
                $('#tarsus_ajax_resultarea').html("ERROR: " + textstring);
            }
        });
    });


    /**
     * generate a new API Token
     *
     * @module      local_lai_connector/classes/ajax.php
     * @package     local_lai_connector
     * @copyright   lern.link GmbH
     * @author      Danou Nauck
     * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
     */
    $('#tarsus_ajax_generateapitoken').click(function() {
        window.console.log("tarsus_ajax_generateapitoken clicked");
        // Save the new order in the db.
        $.ajax({
            type: "POST",
            url: M.cfg.wwwroot + "/local/lai_connector/classes/ajax.php",
            data: {
                action: 'generateAPIToken',
                sesskey: M.cfg.sesskey
            },
            dataType: "json",
            success: function(data) {
                let textstring = JSON.stringify(data);
                window.console.log("AJAX DONE: tarsus_ajax_generateapitoken");
                $('#tarsus_ajax_resultarea').html(textstring);
            },
            fail: function (data) {
                let textstring = JSON.stringify(data);
                window.console.log( "ERROR" );
                $('#tarsus_ajax_resultarea').html("ERROR: " + textstring);
            }
        });
    });

});
