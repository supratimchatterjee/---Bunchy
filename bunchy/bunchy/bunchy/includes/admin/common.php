<?php
/**
 * Admin common functions
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
 * Enqueue admin CSS
 */
function bunchy_admin_enqueue_styles() {
	$version = bunchy_get_theme_version();

	// Register.
	wp_enqueue_style( 'bunchy-admin', BUNCHY_ADMIN_DIR_URI . 'css/admin.css', array(), $version, 'screen' );
}

/**
 * Enqueue admin JS
 */
function bunchy_admin_enqueue_scripts() {
	$child_theme_uri = trailingslashit( get_stylesheet_directory_uri() );

	if ( BUNCHY_THEME_DIR_URI !== $child_theme_uri ) {
		wp_enqueue_script( 'bunchy-modifications-admin', $child_theme_uri . 'modifications-admin.js', array( 'jquery' ), false, true );
	}
}

/**
 * Add editor styles
 */
function bunchy_add_editor_styles() {
	add_editor_style( 'css/editor-style.css' );
}

/**
 * Add the "Id" column to post list table in admin area
 *
 * @param array $columns        List of current columns.
 *
 * @return array                Modified column list.
 */
function bunchy_post_list_add_id_column( $columns ) {
	$new_columns = array();

	foreach ( $columns as $k => $v ) {
		$new_columns[ $k ] = $v;
		if ( 'cb' === $k ) {
			$new_columns['id'] = esc_html__( 'ID', 'bunchy' );
		}
	}

	return $new_columns;
}

/**
 * Render the "Id" column on post list table in admin area
 *
 * @param string $name      Column name.
 */
function bunchy_post_list_render_id_column( $name ) {
	global $post;

	if ( 'id' === $name ) {
		echo intval( $post->ID );
	}
}

/**
 * Register custom column headers
 *
 * @param array $columns    List of columns.
 *
 * @return mixed            Modified colum list.
 */
function bunchy_post_list_custom_columns( $columns ) {
	$columns['featured_image'] = esc_html__( 'Featured Image', 'bunchy' );

	return $columns;
}

/**
 * Render custom column value
 *
 * @param string $column         Column name.
 */
function bunchy_post_list_custom_columns_data( $column ) {
	if ( 'featured_image' === $column ) {
		the_post_thumbnail( 'thumbnail' );
	}
}

/**
 * Check whether we are in autosave state
 *
 * @return bool
 */
function bunchy_is_doing_autosave() {
	return defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ? true : false;
}

/**
 * Check whether inline edit was requested
 *
 * @return bool
 */
function bunchy_is_inline_edit() {
	return isset( $_REQUEST['_inline_edit'] ) ? true : false;  // Input var okey.
}

/**
 * Check whether we are in preview state
 *
 * @return bool
 */
function bunchy_is_doing_preview() {
	return ! empty( $_REQUEST['wp-preview'] ); // Input var okey.
}

