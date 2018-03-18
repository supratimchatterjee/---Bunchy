<?php
/**
 * Snax plugin functions
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
 * Set up defaults
 */
function bunchy_snax_set_defaults() {
	// Override defaults.
	update_option( 'snax_show_open_list_in_title', 'off' );
}

/**
 * Adjust theme for Snax
 */
function bunchy_snax_setup() {
	if ( get_option( 'snax_setup_done', false ) ) {
		return;
	}

	// Change Frontend Submission page template.
	$front_page_id 	= snax_get_frontend_submission_page_id();

	if ( $front_page_id ) {
		update_post_meta( $front_page_id, '_wp_page_template', 'g1-template-page-full.php' );
	}

	update_option( 'snax_setup_done', true );
}

/**
 * Adjust the image size used inside snax collection
 *
 * @param string $image_size Image size.
 *
 * @return string
 */
function bunchy_snax_get_collection_item_image_size( $image_size ) {
	if ( has_image_size( 'bunchy-grid-fancy' ) ) {
		$image_size = 'bunchy-grid-fancy';
	}

	return $image_size;
}

/**
 * Change order of Snax formats.
 *
 * @param array $formats Formats.
 *
 * @return array
 */
function bunchy_snax_change_formats_order( $formats ) {
	if ( isset( $formats['list'] ) && isset( $formats['list']['position'] ) ) {
		$formats['list']['position'] = 5;
	}

	return $formats;
}

/**
 * Disable sticky sharebar on the Frontend Submission page
 *
 * @param bool $bool Whether or not to use the sticky header.
 * @return bool
 */
function bunchy_snax_disable_sticky_header( $bool ) {
	if ( is_page( snax_get_frontend_submission_page_id() ) ) {
		$bool = false;
	}

	return $bool;
}

/**
 * Hide the prefooter on the frontend submission page
 *
 * @param bool $show Whether or not to show the prefooter.
 *
 * @return bool
 */
function bunchy_snax_hide_prefooter( $show ) {
	if ( is_page( snax_get_frontend_submission_page_id() ) ) {
		$show = false;
	}

	return $show;
}

/**
 * Hide the primary nav menu on the frontend submission page
 *
 * @param bool   $has_nav_menu Whether or not a menu is assigned to nav location.
 * @param string $location Nav location.
 *
 * @return bool
 */
function bunchy_snax_hide_primary_nav_menu( $has_nav_menu, $location ) {
	if ( 'bunchy_primary_nav' === $location && is_page( snax_get_frontend_submission_page_id() ) ) {
		$has_nav_menu = false;
	}

	return $has_nav_menu;
}

/**
 * Check whether to hide of not global navbar
 *
 * @param bool $show        Initial state.
 *
 * @return bool
 */
function bunchy_snax_hide_global_navbar( $show ) {
	if ( is_page( snax_get_frontend_submission_page_id() ) ) {
		$show = false;
	}

	return $show;
}

/**
 * Hide ad before the content theme area, after snax item submission
 *
 * @param bool   $bool Whether or not an ad is assigned to ad location.
 * @param string $location Ad location.
 *
 * @return bool
 */
function bunchy_snax_hide_ad_before_content_theme_area( $bool, $location ) {
	if ( 'bunchy_before_content_theme_area' === $location && ( snax_item_submitted() || snax_post_submitted() ) ) {
		$bool = false;
	}

	return $bool;
}

/**
 * Change default content width for embeds
 */
function bunchy_snax_embed_change_content_width() {
	global $content_width;
	global $snax_old_content_width;

	// Store original value.
	$snax_old_content_width = $content_width;

	// Overide.
	$content_width = 758;
}

/**
 * Set back content width for embeds
 */
function bunchy_snax_embed_revert_content_width() {
	global $content_width;
	global $snax_old_content_width;

	// Restore.
	$content_width = $snax_old_content_width;
}

/**
 * Check whether to show bar for current snax item
 *
 * @return bool
 */
function bunchy_snax_show_item_bar() {
	return apply_filters( 'bunchy_snax_show_item_bar', true );
}

/**
 * Checkc whether to show snax bar for current post
 *
 * @return bool
 */
function bunchy_snax_show_post_bar() {
	$show = snax_is_format( 'list' );

	return apply_filters( 'bunchy_snax_show_post_bar', $show );
}

/**
 * We don't want to show item bar when we're currently on a single post that the item belongs to
 */
function bunchy_snax_disable_item_bar_on_single_post() {
	add_filter( 'bunchy_snax_show_item_bar', '__return_false' );
}

/**
 * Restore current state outside single post items loop
 */
function bunchy_snax_enable_item_bar_outside_single_post() {
	remove_filter( 'bunchy_snax_show_item_bar', '__return_false' );
}

/**
 * Render item notes
 */
function bunchy_snax_item_render_notes() {
	?>
	<div class="snax snax-note-wrapper">
		<?php snax_item_render_notes(); ?>
	</div>
	<?php
}

/**
 * Render post notes
 */
function bunchy_snax_post_render_notes() {
	?>
	<div class="snax snax-note-wrapper">
		<?php snax_post_render_notes(); ?>
	</div>
	<?php
}

function bunchy_snax_setup_header_elements() {
	if ( 'simple' === bunchy_get_theme_option( 'snax', 'header_type' ) ) {
		add_filter( 'bunchy_show_global_navbar', 			'bunchy_snax_hide_global_navbar' );
		add_filter( 'has_nav_menu',                         'bunchy_snax_hide_primary_nav_menu', 10, 2 );
		add_filter( 'quads_has_ad',                         'bunchy_snax_hide_ad_before_content_theme_area', 10, 2 );
	}
}
