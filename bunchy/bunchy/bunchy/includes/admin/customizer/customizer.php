<?php
/**
 * Register theme sections into the WP Customizer
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

add_action( 'customize_register', 'bunchy_customize_register' );
add_action( 'customize_preview_init', 'bunchy_customizer_live_preview' );

/**
 * Register theme options
 *
 * @param WP_Customize_Manager $wp_customize        WP Customizer instance.
 */
function bunchy_customize_register( $wp_customize ) {

	// Load custom controls classes.
	require_once( 'lib/class-bunchy-customize-html-control.php' );
	require_once( 'lib/class-bunchy-customize-multi-checkbox-control.php' );
	require_once( 'lib/class-bunchy-customize-multi-select-control.php' );

	// Load defaults.
	require_once( 'customizer-defaults.php' );

	require_once( 'customizer-site-identity.php' );
	require_once( 'customizer-static-front-page.php' );

	// Define posts panel.
	$wp_customize->add_panel( 'bunchy_posts_panel', array(
		'title'    => esc_html__( 'Posts', 'bunchy' ),
		'priority' => 200,
	) );

	require_once( 'customizer-posts-single.php' );
	require_once( 'customizer-posts-archive.php' );
	require_once( 'customizer-posts-global.php' );
	require_once( 'customizer-posts-nsfw.php' );
	require_once( 'customizer-featured-entries.php' );

	// Define design panel.
	$wp_customize->add_panel( 'bunchy_design_panel', array(
		'title'    => esc_html__( 'Design', 'bunchy' ),
		'priority' => 190,
	) );

	require_once( 'customizer-design-global.php' );
	require_once( 'customizer-design-header.php' );
	require_once( 'customizer-design-footer.php' );

	if ( bunchy_can_use_plugin( 'mailchimp-for-wp/mailchimp-for-wp.php' ) ) {
		require_once( 'customizer-newsletter.php' );
	}

	if ( bunchy_can_use_plugin( 'snax/snax.php' ) ) {
		require_once 'customizer-snax.php';
	}
}

/**
 * Force theme to use head inline css (for dynamic styles) in WP Customize Preview mode
 */
function bunchy_customizer_live_preview() {
	add_filter( 'bunchy_dynamic_style_type', 'bunchy_use_internal_dynamic_style_in_customizer_preview' );
}

/**
 * Return dynamic style type used in live preview
 *
 * @return string
 */
function bunchy_use_internal_dynamic_style_in_customizer_preview() {
	return 'internal';
}

/**
 * Return list of categories
 *
 * @return array
 */
function bunchy_customizer_get_category_choices() {
	$choices    = array();
	$categories = get_categories( 'hide_empty=0' );

	foreach ( $categories as $category_obj ) {
		$choices[ $category_obj->slug ] = $category_obj->name;
	}

	return $choices;
}

/**
 * Return list of tags
 *
 * @return array
 */
function bunchy_customizer_get_tag_choices() {
	$choices = array();
	$tags    = get_tags( 'hide_empty=0' );

	$choices[''] = esc_html__( '- None -', 'bunchy' );

	foreach ( $tags as $tag_obj ) {
		$choices[ $tag_obj->slug ] = $tag_obj->name;
	}

	return $choices;
}

/**
 * Sanitize value of multi-choice control
 *
 * @param array $input   List of choices.
 *
 * @return array
 */
function bunchy_sanitize_multi_choice( $input ) {
	return $input;
}
