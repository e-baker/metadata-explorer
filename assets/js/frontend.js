jQuery( document ).ready( function ( j ) {
    keepCredits();
    var getUrl = getUrlParam( 'url', 'null');
    if( getUrl != 'null' ) {
        j('#htc-url').val( getUrl );
        
        getResults( getUrl );
    }

	j('form#htc-form').submit( function( e ) {
        e.preventDefault();
        var url = document.getElementById('htc-url').value;
        getResults( url );
    });

    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
    }

    function getUrlParam(parameter, defaultvalue){
        var urlparameter = defaultvalue;
        if(window.location.href.indexOf(parameter) > -1){
            urlparameter = getUrlVars()[parameter];
            }
        return urlparameter;
    }

    function updateDivs( resp ) {
        document.getElementById('htc-results').innerHTML = resp;
    }

    function keepCredits( ) {
        var credits = j('div#htc-credits');
        if( credits.is(":hidden") ) {
            credits.css( 'display', 'block' );
        }
    }

    function includesProtocol( string ) {
        var regex = /http/gmi;
        if ( string.search( regex ) > -1 ) {
            return true;
        } else {
            return false;
        }
    }

    function validURL( string ) {
        var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
            '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
            '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
            '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
            '(\\#[-a-z\\d_]*)?$','i'); // fragment locater
        if(!pattern.test(string)) {
            return false;
        } else {
            return true;
        }
    }

    function getResults( urlString ) {
        if( !includesProtocol( urlString ) ) { 
            var defaultProtocol = window.location.protocol;
            urlString = defaultProtocol.concat( '//', urlString );
        }
        var req_url = window.location.origin + '/wp-content/plugins/h-tag-checker/includes/lib/class-htc-api.php?u=' + encodeURIComponent(urlString);
        if( validURL(urlString) ) {
            j.ajax({
                type: "GET",
                url: req_url,
                success: function (response) {
                    updateDivs( response );
                    keepCredits();
                },
                error: function ( err_resp ) {
                    console.log( 'Error: ' + err_resp.responseText );
                }
            });
        } else {
            updateDivs( "<h3>Please enter a valid URL.</h3>");
        }
    }
});