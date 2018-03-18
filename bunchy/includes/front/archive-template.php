<?php
/**
 * Archive template tags
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
 * Whether of not to show home featured content.
 *
 * @return mixed|void
 */
function bunchy_show_home_featured_entries() {
	$bool = true;

	$home_settings = bunchy_get_home_settings();
	if ( 'none' === $home_settings['featured_entries']['type'] ) {
		$bool = false;
	}

	$paged = absint( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

	// Show only on the first page.
	if ( $paged > 1 ) {
		$bool = false;
	}

	return apply_filters( 'bunchy_show_home_featured_entries', $bool );
}

/**
 * Whether or not to show archive featured content
 *
 * @return mixed|void
 */
function bunchy_show_archive_featured_entries() {
	$bool = true;

	$archive_settings = bunchy_get_archive_settings();
	if ( 'none' === $archive_settings['featured_entries']['type'] ) {
		$bool = false;
	}

	$paged = absint( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

	// Show only on first page.
	if ( $paged > 1 ) {
		$bool = false;
	}

	return apply_filters( 'bunchy_show_archive_featured_entries', $bool );
}
