<?php
/**
 * WP Customizer panel section to handle featured entries options
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

$bunchy_option_name = bunchy_get_theme_id();

$wp_customize->add_section( 'bunchy_featured_entries_section', array(
	'title'    => esc_html__( 'Featured Entries', 'bunchy' ),
	'priority' => 300,
) );


// Visibility.
$wp_customize->add_setting( $bunchy_option_name . '[featured_entries_visibility]', array(
	'default'           => $bunchy_customizer_defaults['featured_entries_visibility'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Bunchy_Customize_Multi_Checkbox_Control( $wp_customize, 'bunchy_featured_entries_visibility', array(
	'label'    => esc_html__( 'Visibility', 'bunchy' ),
	'section'  => 'bunchy_featured_entries_section',
	'settings' => $bunchy_option_name . '[featured_entries_visibility]',
	'choices'  => array(
		'home'        => esc_html__( 'Home', 'bunchy' ),
		'single_post' => esc_html__( 'Single post', 'bunchy' ),
	),
) ) );


// Type.
$wp_customize->add_setting( $bunchy_option_name . '[featured_entries_type]', array(
	'default'               => $bunchy_customizer_defaults['featured_entries_type'],
	'type'                  => 'option',
	'capability'            => 'edit_theme_options',
	'sanitize_callback'     => 'sanitize_text_field',
	// Reload cache when outputing preview screen.
	// It's enough to bind js callback just for one field.
	'sanitize_js_callback'  => 'bunchy_delete_transients',
) );

$wp_customize->add_control( 'bunchy_featured_entries_type', array(
	'label'    => esc_html__( 'Type', 'bunchy' ),
	'section'  => 'bunchy_featured_entries_section',
	'settings' => $bunchy_option_name . '[featured_entries_type]',
	'type'     => 'select',
	'choices'  => array(
		'most_shared' => esc_html__( 'most shared', 'bunchy' ),
		'most_viewed' => esc_html__( 'most viewed', 'bunchy' ),
		'recent'      => esc_html__( 'recent', 'bunchy' ),
		'none'        => esc_html__( 'none', 'bunchy' ),
	),
) );

/**
 * Check whether user selected global featued entries
 *
 * @param WP_Customize_Control $control     Control instance for which this callback is executed.
 *
 * @return bool
 */
function bunchy_customizer_has_global_featured_entries( $control ) {
	$type = $control->manager->get_setting( bunchy_get_theme_id() . '[featured_entries_type]' )->value();

	return 'none' !== $type;
}

/**
 * Check whether featured entries tag filter is supported
 *
 * @param WP_Customize_Control $control     Control instance for which this callback is executed.
 *
 * @return bool
 */
function bunchy_customizer_global_featured_entries_tag_is_active( $control ) {
	$has_featured_entries = bunchy_customizer_has_global_featured_entries( $control );

	// Skip if home doesn't use the Featured Entries.
	if ( ! $has_featured_entries ) {
		return false;
	}

	$featured_entries_type = $control->manager->get_setting( bunchy_get_theme_id() . '[featured_entries_type]' )->value();

	// The most viewed types doesn't support tag filter.
	if ( 'most_viewed' === $featured_entries_type ) {
		return false;
	}

	return true;
}

// Category.
$wp_customize->add_setting( $bunchy_option_name . '[featured_entries_category]', array(
	'default'               => $bunchy_customizer_defaults['featured_entries_category'],
	'type'                  => 'option',
	'capability'            => 'edit_theme_options',
	'sanitize_callback'     => 'bunchy_sanitize_multi_choice',
) );

$wp_customize->add_control( new Bunchy_Customize_Multi_Checkbox_Control( $wp_customize, 'bunchy_featured_entries_category', array(
	'label'           => esc_html__( 'Category', 'bunchy' ),
	'description'     => esc_html__( 'you can choose many', 'bunchy' ),
	'section'         => 'bunchy_featured_entries_section',
	'settings'        => $bunchy_option_name . '[featured_entries_category]',
	'choices'         => bunchy_customizer_get_category_choices(),
	'active_callback' => 'bunchy_customizer_has_global_featured_entries',
) ) );


// Tag.
$wp_customize->add_setting( $bunchy_option_name . '[featured_entries_tag]', array(
	'default'               => $bunchy_customizer_defaults['featured_entries_tag'],
	'type'                  => 'option',
	'capability'            => 'edit_theme_options',
	'sanitize_callback'     => 'bunchy_sanitize_multi_choice',
) );

$wp_customize->add_control( new Bunchy_Customize_Multi_Select_Control( $wp_customize, 'bunchy_featured_entries_tag', array(
	'label'           => esc_html__( 'Tag', 'bunchy' ),
	'description'     => esc_html__( 'you can choose many', 'bunchy' ),
	'section'         => 'bunchy_featured_entries_section',
	'settings'        => $bunchy_option_name . '[featured_entries_tag]',
	'choices'         => bunchy_customizer_get_tag_choices(),
	'active_callback' => 'bunchy_customizer_global_featured_entries_tag_is_active',
) ) );


// Time range.
$wp_customize->add_setting( $bunchy_option_name . '[featured_entries_time_range]', array(
	'default'               => $bunchy_customizer_defaults['featured_entries_time_range'],
	'type'                  => 'option',
	'capability'            => 'edit_theme_options',
	'sanitize_callback'     => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_featured_entries_time_range', array(
	'label'           => esc_html__( 'Time range', 'bunchy' ),
	'section'         => 'bunchy_featured_entries_section',
	'settings'        => $bunchy_option_name . '[featured_entries_time_range]',
	'type'            => 'select',
	'choices'         => array(
		'day'   => esc_html__( 'last 24 hours', 'bunchy' ),
		'week'  => esc_html__( 'last 7 days', 'bunchy' ),
		'month' => esc_html__( 'last 30 days', 'bunchy' ),
		'all'   => esc_html__( 'all time', 'bunchy' ),
	),
	'active_callback' => 'bunchy_customizer_has_global_featured_entries',
) );

// Hide Elements.
$wp_customize->add_setting( $bunchy_option_name . '[featured_entries_hide_elements]', array(
	'default'           => $bunchy_customizer_defaults['featured_entries_hide_elements'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Bunchy_Customize_Multi_Checkbox_Control( $wp_customize, 'bunchy_featured_entries_hide_elements', array(
	'label'    => esc_html__( 'Hide Elements', 'bunchy' ),
	'section'  => 'bunchy_featured_entries_section',
	'settings' => $bunchy_option_name . '[featured_entries_hide_elements]',
	'choices'  => array(
		'share_count'   => esc_html__( 'Share Count', 'bunchy' ),
		'view_count'    => esc_html__( 'View Count', 'bunchy' ),
		'comment_count' => esc_html__( 'Comment Count', 'bunchy' ),
	),
	'active_callback' => 'bunchy_customizer_has_global_featured_entries',
) ) );
