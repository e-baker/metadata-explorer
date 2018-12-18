<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class MDE_Shortcodes {

    /**
     * Constructor function
     * @since 1.0.0
     * @access public
     * 
     * @return void
     */
    public function __construct( ) {
        // Register the shortcode
        add_shortcode( 'md-explorer', array( $this, 'show_form' ) );
    }

    /**
     * Shows the form for the h tag checker
     * @since 1.0.0
     * @access public
     * 
     * @return string An output of the form
     */
    public function show_form( ) {
        $output = '<form id="mde-form" method="get"><input id="mde-url" type="text" placeholder="https://trafficlight.me"><button id="mde-analyze">Check Tags</button></form>';
        $output .= '<div id="mde-results">Use the form above to see your results here.</div>';
        if( get_option( 'mde_credit_link', false ) == 'on' ) {
            $output .= '<div id="mde-credits"><hr />Brought to you by <a href="https://trafficlight.me/seo-tools/h-tag-checker">Traffic Light Media</a>.</div>';
        }
        return $output;
    }
}