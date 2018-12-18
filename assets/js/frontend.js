jQuery( document ).ready( function ( j ) {
    mdeKeepCredits();
    var mdeGetUrl = mdegetUrlParam( 'url', 'null');
    if( mdeGetUrl != 'null' ) {
        j('#mde-url').val( mdeGetUrl );
        
        mdeGetResults( mdeGetUrl);
    }

	j('form#mde-form').submit( function( e ) {
        e.preventDefault();
        var url = document.getElementById('mde-url').value;
        mdeGetResults( url );
    });

    function mdeGetUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
    }

    function mdegetUrlParam(parameter, defaultvalue){
        var urlparameter = defaultvalue;
        if(window.location.href.indexOf(parameter) > -1){
            urlparameter = mdeGetUrlVars()[parameter];
            }
        return urlparameter;
    }

    function mdeUpdateDivs( resp ) {
        document.getElementById('mde-results').innerHTML = resp;
    }

    function mdeKeepCredits( ) {
        var credits = j('div#mde-credits');
        if( credits.is(":hidden") ) {
            credits.css( 'display', 'block' );
        }
    }

    function mdeValidURL( string ) {
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

    function mdeGetResults( urlString ) {
        var req_url = window.location.origin + '/wp-content/plugins/metadata-explorer/includes/lib/class-mde-api.php?u=' + encodeURIComponent(urlString);
        if( mdeValidURL(urlString) ) {
            j.ajax({
                type: "GET",
                url: req_url,
                success: function (response) {
                    mdeUpdateDivs( response );
                    mdeKeepCredits();
                },
                error: function ( err_resp ) {
                    console.log( 'Error: ' + err_resp.responseText );
                }
            });
        } else {
            mdeUpdateDivs( "<h3>Please enter a valid URL.</h3>");
        }
    }
});