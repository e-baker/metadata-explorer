<?php

require 'class-mde-request.php';
require 'class-mde-result.php';

/**
 * If this page is requested, we look for the specific 'u' variable
 * to use. If it's there, we create a request and tender the results but
 * if it's not found, we let them know.
 */
if ( isset( $_GET['u'] ) ) { // The GET variable 'u' is set
    if( good_url( $_GET['u'] ) ) {
        $req = new MDE_Request( $_GET['u'] );
        $res = new MDE_Result( $req );
        print_r( $res->print_result() );
    } else {
        echo "Please use a valid URL.";
    }
} else { // The GET variable 'u' has not been set.
    echo "Please set an appropriate url.";
}

function good_url( $url ) {
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_TIMEOUT, 100 );
    $http_res = curl_exec( $ch );
    $http_res = trim( strip_tags( $http_res ) );
    $http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
    $code_type = substr($http_code, 0, 1);
    if(  $code_type === "2" || $code_type === "3" ) {
        return true;
    } else {
        print("That URL was not available. Error code: {$http_code}");
        exit;
    }
    curl_close( $ch );
}