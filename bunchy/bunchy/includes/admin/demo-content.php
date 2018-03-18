<?php
/**
 * Demo content functions
 *
 * @license For the full license information, please view the Licensing folder
 * that was distributed with this source code.
 *
 * @package Bunchy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

/**
 * Load WP Importers (if plugin Wordpress Importer active) but prevent admin import action
 */
function bunchy_handle_import_action() {
	// -- Explanation
	// if $_GET['import'] is set, WP defines the WP_LOAD_IMPORTERS const (in wp-admin/admin.php).
	// This, in turn, loads WP_Import class and triggers admin import action.
	// We want to use only WP_Import class to import our demo content, import action is redundant.
	// To achieve this, we have to unset $_GET['import'] after defining const but before action call.
	// The "admin_init" hook is a right place to do that.
	if ( isset( $_GET['import'] ) && 'bunchy' === $_GET['import'] ) { // Input var okey.
		unset( $_GET['import'] ); // Input var okey.
	}
}

/**
 * Import demo data
 */
function bunchy_import_demo() {
	$allowed_types = array( 'content', 'theme_options', 'all' );
	$type          = isset( $_GET['import-type'] ) ? sanitize_text_field( wp_unslash( $_GET['import-type'] ) ) : ''; // Input var okey.

	if ( ! in_array( $type, $allowed_types, true ) ) {
		wp_die(
			'<h1>' . esc_html__( 'Cheatin&#8217; uh?', 'bunchy' ) . '</h1>
			<p>' . sprintf( esc_html__( 'Demo data import type not allowed. Allowed values: %s.', 'bunchy' ), esc_html( implode( ', ', $allowed_types ) ) ) . '</p>',
			403
		);
	}

	require_once BUNCHY_ADMIN_DIR . 'lib/class-bunchy-demo-data.php';

	$demo_data = new Bunchy_Demo_Data();
	$response = null;

	switch ( $type ) {
		case 'content':
			$response = $demo_data->import_content();
			break;

		case 'theme_options':
			$response = $demo_data->import_theme_options();
			break;

		case 'all':
			$response = $demo_data->import_all();
			break;
	}

	set_transient( 'bunchy_import_demo_response', $response );

	wp_redirect( admin_url( 'themes.php?page=theme-options' ) );
}

/**
 * Return url to import demo content action
 *
 * @return string
 */
function bunchy_get_import_demo_content_url() {
	return admin_url( 'admin.php?action=bunchy_import_demo&import-type=content&import=bunchy' );
}

/**
 * Return url to import demo theme options action
 *
 * @return string
 */
function bunchy_get_import_demo_theme_options_url() {
	return admin_url( 'admin.php?action=bunchy_import_demo&import-type=theme_options&import=bunchy' );
}

/**
 * Return url to import demo all action
 *
 * @return string
 */
function bunchy_get_import_demo_all_url() {
	return admin_url( 'admin.php?action=bunchy_import_demo&import-type=all&import=bunchy' );
}

/**
 * Switch theme mode to normal
 */
function bunchy_ajax_change_mode_to_normal() {
	check_ajax_referer( 'bunchy-change-mode-ajax-nonce', 'security' );

	$demo_installed = isset( $_POST['demo_state'] ) && 'installed' === $_POST['demo_state']; // Input var okey.

	bunchy_enable_normal_mode( $demo_installed );

	echo wp_json_encode( array(
		'status' => 'success',
	) );
	exit;
}

/**
 * Switch theme mode to in progress
 */
function bunchy_ajax_change_mode_to_in_progress() {
	check_ajax_referer( 'bunchy-change-mode-ajax-nonce', 'security' );

	bunchy_enable_in_progress_mode();

	echo wp_json_encode( array(
		'status' => 'success',
	) );
	exit;
}
