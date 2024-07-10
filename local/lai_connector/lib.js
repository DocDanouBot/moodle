window.addEventListener('load', function () {
    console.log("local_lai_connector JS loaded !");

    if ((document.location.href.lastIndexOf('localhost') !== -1) || (document.location.href.lastIndexOf('127.0.0.1') !== -1)) {
        var wwwroot = 'https://localhost/';
    } else {
         var wwwroot = '/';
    }

    var ajaxgettoken = function() {
        var facilityid = jQuery('#facility_select').val();

        jQuery.ajax({
            url : wwwroot + 'local/lai_connector/classes/ajaxcommand.php',
            type : 'GET',
            dataType: 'html',
            data : {
                'facility' : facilityid
            },
            success : function(data) {
                // console.log('Data: '+data);
                jQuery("#renderblock").html(data);
            },
            error : function(request,error)
            {
                console.log("Request: "+JSON.stringify(request));
            }
        });

    };

    // initial load up
    // ajaxfacilitysearch();
});


