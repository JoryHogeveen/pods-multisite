<?php
/*
Plugin Name: Pods Multisite
Plugin URI: http://pods.io/
Description: Supercharge Pods for your multisites
Version: 0.1
Author: Jory Hogeveen
Author URI: http://www.keraweb.nl
Text Domain: pods-multisite
Domain Path: /languages/

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * @package Pods
 */

! defined( 'ABSPATH' ) and die();
/**
 * Initialize plugin
 */
function pods_init_multisite() {

	if ( ! is_multisite() || ! function_exists( 'pods' ) ) {
		return;
	}

	load_plugin_textdomain( 'pods-multisite', false, plugin_dir_path( __FILE__ ) . 'languages/' );


	pods_multisite();

}

/**
 * Function helper to return plugin instance
 *
 * @return \Pods_Multisite_Sync
 */
function pods_multisite() {
	require_once plugin_dir_path( __FILE__ ) . 'class-pods-multisite-sync.php';

	return Pods_Multisite_Sync::get_instance();
}

add_action( 'init', 'pods_init_multisite' );