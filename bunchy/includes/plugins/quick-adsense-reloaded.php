<?php
/**
 * WP QUADS plugin functions
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
 * Register custom ad locations
 */
function bunchy_quads_register_ad_locations() {
	if ( ! function_exists( 'quads_register_ad' ) ) {
		return;
	}

	quads_register_ad( array(
		'location'    => 'bunchy_before_header_theme_area',
		'description' => esc_html__( 'Before header theme area', 'bunchy' ),
	) );

	quads_register_ad( array(
		'location'    => 'bunchy_before_content_theme_area',
		'description' => esc_html__( 'Before content theme area', 'bunchy' ),
	) );

	quads_register_ad( array(
		'location'    => 'bunchy_before_related_entries',
		'description' => esc_html__( 'Before "Related Entries" section', 'bunchy' ),
	) );

	quads_register_ad( array(
		'location'    => 'bunchy_before_more_from',
		'description' => esc_html__( 'Before "More From" section', 'bunchy' ),
	) );

	quads_register_ad( array(
		'location'    => 'bunchy_before_comments',
		'description' => esc_html__( 'Before comments area', 'bunchy' ),
	) );

	quads_register_ad( array(
		'location'    => 'bunchy_before_dont_miss',
		'description' => esc_html__( 'Before "Don\'t Miss" section', 'bunchy' ),
	) );

	quads_register_ad( array(
		'location'    => 'bunchy_inside_grid',
		'description' => esc_html__( 'Inside grid collection', 'bunchy' ),
	) );

	quads_register_ad( array(
		'location'    => 'bunchy_inside_list',
		'description' => esc_html__( 'Inside list collection', 'bunchy' ),
	) );

	quads_register_ad( array(
		'location'    => 'bunchy_inside_classic',
		'description' => esc_html__( 'Inside classic collection', 'bunchy' ),
	) );
}


/**
 * Hide ads on specific pages
 *
 * @param bool $bool        Whether or not the ad is visible.
 *
 * @return bool
 */
function bunchy_quads_hide_ads( $bool ) {
	if ( is_404() || is_search() ) {
		$bool = false;
	}

	return $bool;
}


/**
 * Disable WP Quads welcome page redirect.
 *
 * We use TGM Plugin Activation to install some plugins.
 * We must be sure there are no redirects during the activation queue.
 */
function bunchy_quads_disable_welcome_redirect() {
	delete_transient( '_quads_activation_redirect' );
}
