<?php
/**
 * Plugin Name: Ninja Forms WooCommerce Order
 * Plugin URI: http://wordpress.org/plugins/ninja-forms-wooorders-field/
 * Description: This plugin add woocommerce orders of loggedin users in dropdown
 * Version: 1.0.0
 * Author: wpboxr
 * Author URI: http://www.wpboxr.com
 * License:  GPLv2 or later
 */
 
 
// Extension directory
define("NINJA_FORMS_WOOORDERS_FIELD_DIR", WP_PLUGIN_DIR."/".basename( dirname( __FILE__ ) ) );
 
// Check if Ninja Forms plugin is activated
if( in_array( 'ninja-forms/ninja-forms.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	// Load field file
	require_once( NINJA_FORMS_WOOORDERS_FIELD_DIR . "/includes/fields/wooorders.php" );

}