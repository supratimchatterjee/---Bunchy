<?php
/**
 * Theme activation functions
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

define( 'BUNCHY_MODE_WELCOME', 'welcome' );
define( 'BUNCHY_MODE_IN_PROGRESS', 'in_progress' );
define( 'BUNCHY_MODE_NORMAL', 'normal' );

/**
 * Redirect user to welcome page
 */
function bunchy_redirect_to_welcome_page() {
	if ( ! bunchy_is_normal_mode_enabled() ) {
		$count       = 0;
		$attachments = wp_count_attachments();

		foreach ( $attachments as $type_counter ) {
			$count += $type_counter;
		}

		// Expire after a week.
		set_transient( 'bunchy_initial_attachment_count', $count, 60 * 60 * 24 * 7 );

		$nonce = wp_create_nonce( 'tgmpa-dismiss-' . get_current_user_id() );

		wp_redirect( admin_url( 'themes.php?page=theme-options&group=dashboard&tgmpa-dismiss&_wpnonce=' . $nonce ) );
	}
}

/**
 * Force user to see only welcome page until installation process complete
 */
function bunchy_load_welcome_page_until_installation_complete() {
	if ( ! bunchy_is_normal_mode_enabled() ) {
		// User is not on "Welcome" page.
		$is_not_theme_group = ! isset( $_GET['group'] ) || 'dashboard' !== $_GET['group']; // Input var okey.

		if ( $is_not_theme_group ) {
			$nonce = wp_create_nonce( 'tgmpa-dismiss-' . get_current_user_id() );

			wp_redirect( admin_url( 'themes.php?page=theme-options&group=dashboard&tgmps-dismiss&_wpnonce=' . $nonce ) );
		}
	}
}

/**
 * Enable theme normal mode
 *
 * @param bool $demo_installed       Whether demo was installed or not.
 */
function bunchy_enable_normal_mode( $demo_installed ) {
	bunchy_set_mode( BUNCHY_MODE_NORMAL );

	do_action( 'bunchy_normal_mode_enabled' );

	if ( $demo_installed ) {
		// Set notice that demo data was installed successfully.
		set_transient( 'bunchy_demo_data_imported', true, 60 );
	}

	// Clean up when entering normal mode.
	$wp_importer_not_installed_on_start = get_transient( 'bunchy_wp_importer_not_installed' );

	if ( $wp_importer_not_installed_on_start ) {
		delete_transient( 'bunchy_wp_importer_not_installed' );
	}
}

/**
 * Enable theme in progress mode
 */
function bunchy_enable_in_progress_mode() {
	bunchy_set_mode( BUNCHY_MODE_IN_PROGRESS );
}

/**
 * Check whether theme is in normal mode
 *
 * @return bool
 */
function bunchy_is_normal_mode_enabled() {
	return bunchy_get_mode() === BUNCHY_MODE_NORMAL;
}

/**
 * Check whether theme is in progress mode
 *
 * @return bool
 */
function bunchy_is_in_progress_mode_enabled() {
	return bunchy_get_mode() === BUNCHY_MODE_IN_PROGRESS;
}

/**
 * Return current theme mode
 *
 * @return mixed|void
 */
function bunchy_get_mode() {
	// If no value set in database (theme activate for the first time)
	// or if user didn't finish installation steps,
	// dashboard should be in "welcome" mode.
	return get_option( bunchy_get_theme_id() . '_mode', BUNCHY_MODE_WELCOME );
}

/**
 * Set theme mode
 *
 * @param string $mode      Allowed mode (normal, welocome, in_progress).
 */
function bunchy_set_mode( $mode ) {
	update_option( bunchy_get_theme_id() . '_mode', $mode );
}

