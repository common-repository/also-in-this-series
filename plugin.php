<?php
/*
Plugin Name: Also In This Series
Plugin URI: https://planetjon.ca/projects/also-in-this-series/
Description: Group related posts in a series with a custom Series taxonomy. and a list of all posts in the series in your content.
Version: 2.0.1
Requires at least: 4.6
Requires PHP: 5.5
Tested up to: 5.9.0
Author: Jonathan Weatherhead
Author URI: https://planetjon.ca
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if( also_in_this_series_meets_requirements() ) {
	require_once 'plugin-core.php';
	require_once 'plugin-taxonomies.php';
	require_once 'plugin-widgets.php';
	require_once 'plugin-shortcodes.php';
	
	if( !wp_doing_ajax() && is_admin() ) {
		require_once plugin_dir_path( __file__ ) . 'plugin-admin.php';
	}
}
else {
	add_action( 'admin_notices', 'also_in_this_series_requirements_notice' );
	return;
}

function also_in_this_series_requirements_notice() {
	printf( '<div class="error"><p>%s</p></div>', __( 'Also In This Series requires PHP 5.4 or later to run. Please update your server.', 'also-in-this-series' ) );
}

function also_in_this_series_meets_requirements() {
	return version_compare( PHP_VERSION, '5.4.0' ) >= 0;
}

function also_in_this_series_activate() {
    add_option( 'alsointhisseries_activate', true );
}

function also_in_this_series_uninstall() {
	add_option( 'alsointhisseries_deactivate', true );
}

function also_in_this_series_maintenance() {
	if( get_option( 'alsointhisseries_activate' ) ) {
        flush_rewrite_rules();
        delete_option( 'alsointhisseries_activate' );
    }

	if( get_option( 'alsointhisseries_deactivate' ) ) {
		delete_option( SERIES_SLUG );
		delete_option( 'alsointhisseries_deactivate' );
	}
}

register_activation_hook( __FILE__, 'also_in_this_series_activate' );
register_uninstall_hook( __FILE__, 'also_in_this_series_uninstall' );
add_action( 'init', 'also_in_this_series_maintenance', 11 );
