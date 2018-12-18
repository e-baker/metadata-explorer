<?php
/*
 * Plugin Name: Metadata Explorer
 * Version: 1.0
 * Plugin URI: http://www.hughlashbrooke.com/
 * Description: This is your starter template for your next WordPress plugin.
 * Author: Hugh Lashbrooke
 * Author URI: http://www.hughlashbrooke.com/
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: metadata-explorer
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author Hugh Lashbrooke
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-metadata-explorer.php' );
require_once( 'includes/class-metadata-explorer-settings.php' );

// Load plugin libraries
require_once( 'includes/lib/class-metadata-explorer-admin-api.php' );
require_once( 'includes/lib/class-metadata-explorer-post-type.php' );
require_once( 'includes/lib/class-metadata-explorer-taxonomy.php' );

/**
 * Returns the main instance of Metadata_Explorer to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Metadata_Explorer
 */
function Metadata_Explorer () {
	$instance = Metadata_Explorer::instance( __FILE__, '1.0.0' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = Metadata_Explorer_Settings::instance( $instance );
	}

	return $instance;
}

Metadata_Explorer();
