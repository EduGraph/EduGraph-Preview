$( document ).ready(function() {

    //var url = 'https://bmake.th-brandenburg.de/tests/EduGraph/html-embedded-jsonld-extractor-multiple.html';
    //var url = 'https://bmake.th-brandenburg.de/tests/EduGraph/html-json-ld.html';

    $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        return results[1] || 0;
    };

    var url = decodeURIComponent($.urlParam('url'));

    if(url){
        $('#url-input').val(url);
        any23TurtleRequest(url);
    }

    function any23TurtleRequest(url){
        var service = 'http://fbwsvcdev.th-brandenburg.de:8080/any23/any23/';
        var format = 'turtle';
        var parms = '&fix=on&report=on';

        $('.spinner').show();
        $.ajax( service + '?format=' + format + '&uri=' + url + parms)
            .done(function (response) {
                $('.spinner').hide();
                $('#preview').show();

                var responseXML = $.parseXML( response);
                var data = $(responseXML).find( "data").text();
                console.log(data);
                $('#turtle').text(data)
            })
            .fail(function (jqXHR, exception) {
                // Our error logic here
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                }
                //Any23 Error Reporting
                else if (jqXHR.status == 400) {
                    msg = 'Bad Request: Missing or malformed input parameter.';
                } else if (jqXHR.status == 404) {
                    msg = 'Not Found: Malformed request IRI.';
                } else if (jqXHR.status == 406) {
                    msg = 'Not Acceptable:  None of the media types specified in the Accept header are supported.';
                } else if (jqXHR.status == 415) {
                    msg = 'Unsupported Media Type: Document body with unsupported media type was POSTed.';
                } else if (jqXHR.status == 501) {
                    msg = 'Not Implemented:  Extraction from input was successful, but yielded zero triples.';
                } else if (jqXHR.status == 502) {
                    msg = 'Bad Gateway: Input document from a remote server could not be fetched or parsed.';

                    var errorReporting = $.parseXML( responseText);
                    try {
                        responseText = jqXHR.responseText
                        var errorReporting = $.parseXML( responseText);
                    }
                    catch(err) {
                        //console.log(err);
                        var responseText = jqXHR.responseText + '</issueReport></report>';
                        var errorReporting = $.parseXML( responseText);
                    }
                    var message = $(errorReporting).find( "message").text();
                    var errorRaw = $(errorReporting).find( "error").text();
                    var rx = /([A-Z]+):[ \t]+'(.+)'/g;
                    //error = rx.exec(errorRaw);
                    while (error = rx.exec(errorRaw)) {

                        var errorCode = error[1];
                        var errorMessage = error[2];

                        if(errorCode == 'WARNING'){
                            cssClass = 'text-warning';
                            icon = 'warning';

                        }
                        else if(errorCode = 'ERROR'){
                            cssClass = 'text-danger';
                            icon = 'error';
                        }
                        else {
                            errorCode = 'Undefined error'
                            icon = 'error_outline';
                        }

                        $("#errorMessage ul").append('<li class="list-group-item"><i class="material-icons ' + cssClass +'">'+ icon + '</i>  <strong>'+ errorCode +':</strong>&nbsp;'+errorMessage+'</li>');

                    }
                }

                else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }

                $('.spinner').hide();
                $('#error').show();

                if(message){
                    $('#errorHeader').text(message)
                }

                if(error){
                    //console.log(error);
                    //$('#errorMessage').text(error)
                }

        })
        .always(function () {
            //alert("complete");
        });

    }

});