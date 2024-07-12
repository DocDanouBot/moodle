window.addEventListener('load', function () {
    console.log("local_lai_connector JS loaded !");

    if ((document.location.href.lastIndexOf('localhost') !== -1) || (document.location.href.lastIndexOf('127.0.0.1') !== -1)) {
        var wwwroot = 'https://localhost/';
    } else {
         var wwwroot = '/';
    }

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
     * get all the available voices from the api for TARSUS
     *
     * @module      local_lai_connector/classes/ajax.php
     * @package     local_lai_connector
     * @copyright   lern.link GmbH
     * @author      Danou Nauck
     * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
     */
    $('#tarsus_ajax_listclonevoices').click(function() {
        window.console.log("tarsus_ajax_listclonevoices clicked");
        // Save the new order in the db.
        $.ajax({
            type: "POST",
            url: M.cfg.wwwroot + "/local/lai_connector/classes/ajax.php",
            data: {
                action: 'listCloneVoices',
                sesskey: M.cfg.sesskey
            },
            dataType: "json",
            success: function(data) {
                let textstring = JSON.stringify(data);
                window.console.log("AJAX DONE: tarsus_ajax_listclonevoices");
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
     * get all the latest and most used keywords from this brain
     *
     * @module      local_lai_connector/classes/ajax.php
     * @package     local_lai_connector
     * @copyright   lern.link GmbH
     * @author      Danou Nauck
     * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
     */
    $('#tarsus_ajax_gethotkeywords').click(function() {
        window.console.log("tarsus_ajax_gethotkeywords clicked");
        // Save the new order in the db.
        $.ajax({
            type: "POST",
            url: M.cfg.wwwroot + "/local/lai_connector/classes/ajax.php",
            data: {
                action: 'getHotKeywords',
                sesskey: M.cfg.sesskey
            },
            dataType: "json",
            success: function(data) {
                let textstring = JSON.stringify(data);
                window.console.log("AJAX DONE: tarsus_ajax_gethotkeywords");
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
     * get all the latest and most used keywords from this brain
     *
     * @module      local_lai_connector/classes/ajax.php
     * @package     local_lai_connector
     * @copyright   lern.link GmbH
     * @author      Danou Nauck
     * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
     */
    $('#tarsus_ajax_brainpage_createnewbrain').click(function() {
        window.console.log("tarsus_ajax_brainpage_createnewbrain clicked");

        let newbrainname = $('#tarsus_ajax_create_new_brain_name').val();
        // alert("newbrainname: " + newbrainname);

        if(newbrainname.length < 3) {
            $('#tarsus_ajax_create_new_brain_name').html('Bitte tragen Sie einen Brainnamen ein');
        } else {
            // Save the new order in the db.
            $.ajax({
                type: "POST",
                url: M.cfg.wwwroot + "/local/lai_connector/classes/ajax.php",
                data: {
                    action: 'createNewBrain',
                    brainname: newbrainname,
                    userid: 1234,
                    sesskey: M.cfg.sesskey
                },
                dataType: "json",
                success: function (data) {
                    // Refresh the page
                    location.reload();
                    // let textstring = JSON.stringify(data);
                    // window.console.log("AJAX DONE: tarsus_ajax_brainpage_createnewbrain " + textstring);
                },
                fail: function (data) {
                    let textstring = JSON.stringify(data);
                    window.console.log("ERROR " + textstring);
                }
            });
        }
    });


    /**
     * get all the latest and most used keywords from this brain
     *
     * @module      local_lai_connector/classes/ajax.php
     * @package     local_lai_connector
     * @copyright   lern.link GmbH
     * @author      Danou Nauck
     * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
     */
    $('.tarsus_ajax_brainpage_deletebrain').click(function(e) {
        // Get the brainname from the data-attribute.
        let oldbrainname = $(this).attr('data-attribute');
        window.console.log("tarsus_ajax_brainpage_deletebrain " + oldbrainname);

        if(oldbrainname.length < 3) {
            $('#tarsus_ajax_create_new_brain_name').html('Der Brainname ist zu kurz');
        } else {
            // Save the new order in the db.
            $.ajax({
                type: "POST",
                url: M.cfg.wwwroot + "/local/lai_connector/classes/ajax.php",
                data: {
                    action: 'deleteBrain',
                    brainname: oldbrainname,
                    sesskey: M.cfg.sesskey
                },
                dataType: "json",
                success: function (data) {
                    // Refresh the page
                    location.reload();
                    // let textstring = JSON.stringify(data);
                    // window.console.log("AJAX DONE: tarsus_ajax_brainpage_deletebrain " + textstring);
                },
                fail: function (data) {
                    let textstring = JSON.stringify(data);
                    window.console.log("ERROR " + textstring);
                }
            });
        }
    });

});
