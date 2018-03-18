<?php
/**
 * WP Customizer panel section to handle posts archive options
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

$wp_customize->add_section( 'bunchy_posts_archive_section', array(
	'title'    => esc_html__( 'Archive', 'bunchy' ),
	'priority' => 40,
	'panel'    => 'bunchy_posts_panel',
) );


// Template.
$wp_customize->add_setting( $bunchy_option_name . '[archive_template]', array(
	'default'           => $bunchy_customizer_defaults['archive_template'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_archive_template', array(
	'label'    => esc_html__( 'Template', 'bunchy' ),
	'section'  => 'bunchy_posts_archive_section',
	'settings' => $bunchy_option_name . '[archive_template]',
	'type'     => 'select',
	'choices'  => array(
		'one-featured-list-sidebar'      => esc_html__( '1 Featured + List with Sidebar', 'bunchy' ),
		'three-featured-list-sidebar'    => esc_html__( '3 Featured + List with Sidebar', 'bunchy' ),
		'one-featured-grid-sidebar'      => esc_html__( '1 Featured + Grid with Sidebar', 'bunchy' ),
		'three-featured-grid-sidebar'    => esc_html__( '3 Featured + Grid with Sidebar', 'bunchy' ),
		'three-featured-grid'            => esc_html__( '3 Featured + Grid', 'bunchy' ),
		'one-featured-classic-sidebar'   => esc_html__( '1 Featured + Classic with Sidebar', 'bunchy' ),
		'three-featured-classic-sidebar' => esc_html__( '3 Featured + Classic with Sidebar', 'bunchy' ),
	),
) );


// Featured Entries.
$wp_customize->add_setting( $bunchy_option_name . '[archive_featured_entries]', array(
	'default'           => $bunchy_customizer_defaults['archive_featured_entries'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_archive_featured_entries', array(
	'label'    => esc_html__( 'Featured Entries', 'bunchy' ),
	'section'  => 'bunchy_posts_archive_section',
	'settings' => $bunchy_option_name . '[archive_featured_entries]',
	'type'     => 'select',
	'choices'  => array(
		'most_shared' => esc_html__( 'most shared', 'bunchy' ),
		'most_viewed' => esc_html__( 'most viewed', 'bunchy' ),
		'recent'      => esc_html__( 'recent', 'bunchy' ),
		'none'        => esc_html__( 'none', 'bunchy' ),
	),
) );


// Featured Entries Time range.
$wp_customize->add_setting( $bunchy_option_name . '[archive_featured_entries_time_range]', array(
	'default'           => $bunchy_customizer_defaults['archive_featured_entries_time_range'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_archive_featured_entries_time_range', array(
	'label'           => esc_html__( 'Featured Entries Time range', 'bunchy' ),
	'section'         => 'bunchy_posts_archive_section',
	'settings'        => $bunchy_option_name . '[archive_featured_entries_time_range]',
	'type'            => 'select',
	'choices'         => array(
		'day'   => esc_html__( 'last 24 hours', 'bunchy' ),
		'week'  => esc_html__( 'last 7 days', 'bunchy' ),
		'month' => esc_html__( 'last 30 days', 'bunchy' ),
		'all'   => esc_html__( 'all time', 'bunchy' ),
	),
	'active_callback' => 'bunchy_customizer_archive_has_featured_entries',
) );


// Featured Entries Hide Elements.
$wp_customize->add_setting( $bunchy_option_name . '[archive_featured_entries_hide_elements]', array(
	'default'           => $bunchy_customizer_defaults['archive_featured_entries_hide_elements'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Bunchy_Customize_Multi_Checkbox_Control( $wp_customize, 'bunchy_archive_featured_entries_hide_elements', array(
	'label'           => esc_html__( 'Featured Entries Hide Elements', 'bunchy' ),
	'section'         => 'bunchy_posts_archive_section',
	'settings'        => $bunchy_option_name . '[archive_featured_entries_hide_elements]',
	'choices'         => array(
		'shares'        => esc_html__( 'Shares', 'bunchy' ),
		'views'         => esc_html__( 'Views', 'bunchy' ),
		'comments_link' => esc_html__( 'Comments Link', 'bunchy' ),
		'categories'    => esc_html__( 'Categories', 'bunchy' ),
	),
	'active_callback' => 'bunchy_customizer_archive_has_featured_entries',
) ) );

/**
 * Check whether featured entries are enabled for archive pages
 *
 * @param WP_Customize_Control $control     Control instance for which this callback is executed.
 *
 * @return bool
 */
function bunchy_customizer_archive_has_featured_entries( $control ) {
	$type = $control->manager->get_setting( bunchy_get_theme_id() . '[archive_featured_entries]' )->value();

	return 'none' !== $type;
}


// Posts Per Page.
$wp_customize->add_setting( $bunchy_option_name . '[archive_posts_per_page]', array(
	'default'           => $bunchy_customizer_defaults['archive_posts_per_page'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_archive_posts_per_page', array(
	'label'    => esc_html__( 'Entries per page', 'bunchy' ),
	'section'  => 'bunchy_posts_archive_section',
	'settings' => $bunchy_option_name . '[archive_posts_per_page]',
	'type'     => 'number',
) );


// Pagination.
$wp_customize->add_setting( $bunchy_option_name . '[archive_pagination]', array(
	'default'           => $bunchy_customizer_defaults['archive_pagination'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_archive_pagination', array(
	'label'    => esc_html__( 'Pagination', 'bunchy' ),
	'section'  => 'bunchy_posts_archive_section',
	'settings' => $bunchy_option_name . '[archive_pagination]',
	'type'     => 'select',
	'choices'  => array(
		'load-more'                 => esc_html__( 'Load More', 'bunchy' ),
		'infinite-scroll'           => esc_html__( 'Infinite Scroll', 'bunchy' ),
		'infinite-scroll-on-demand' => esc_html__( 'Infinite Scroll (first load via click)', 'bunchy' ),
		'pages'                     => esc_html__( 'Prev/Next Pages', 'bunchy' ),
	),
) );


// Hide Elements.
$wp_customize->add_setting( $bunchy_option_name . '[archive_hide_elements]', array(
	'default'           => $bunchy_customizer_defaults['archive_hide_elements'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Bunchy_Customize_Multi_Checkbox_Control( $wp_customize, 'bunchy_archive_hide_elements', array(
	'label'    => esc_html__( 'Hide Elements', 'bunchy' ),
	'section'  => 'bunchy_posts_archive_section',
	'settings' => $bunchy_option_name . '[archive_hide_elements]',
	'choices'  => array(
		'featured_media' => esc_html__( 'Featured Media', 'bunchy' ),
		'categories'     => esc_html__( 'Categories', 'bunchy' ),
		'title'          => esc_html__( 'Title', 'bunchy' ),
		'summary'        => esc_html__( 'Summary', 'bunchy' ),
		'author'         => esc_html__( 'Author', 'bunchy' ),
		'avatar'         => esc_html__( 'Avatar', 'bunchy' ),
		'date'           => esc_html__( 'Date', 'bunchy' ),
		'shares'         => esc_html__( 'Shares', 'bunchy' ),
		'views'          => esc_html__( 'Views', 'bunchy' ),
		'comments_link'  => esc_html__( 'Comments Link', 'bunchy' ),
	),
) ) );


// Newsletter.
$wp_customize->add_setting( $bunchy_option_name . '[archive_newsletter]', array(
	'default'           => $bunchy_customizer_defaults['archive_newsletter'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_archive_newsletter', array(
	'label'    => esc_html__( 'Newsletter', 'bunchy' ),
	'section'  => 'bunchy_posts_archive_section',
	'settings' => $bunchy_option_name . '[archive_newsletter]',
	'type'     => 'select',
	'choices'  => array(
		'standard' => esc_html__( 'inject into post collection', 'bunchy' ),
		'none'     => esc_html__( 'hide', 'bunchy' ),
	),
) );

$wp_customize->add_setting( $bunchy_option_name . '[archive_newsletter_after_post]', array(
	'default'           => $bunchy_customizer_defaults['archive_newsletter_after_post'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_archive_newsletter_after_post', array(
	'label'           => esc_html__( 'Inject newsletter after post', 'bunchy' ),
	'section'         => 'bunchy_posts_archive_section',
	'settings'        => $bunchy_option_name . '[archive_newsletter_after_post]',
	'type'            => 'number',
	'input_attrs'     => array(
		'placeholder' => esc_html__( 'eg. 2', 'bunchy' ),
	),
	'active_callback' => 'bunchy_customizer_is_archive_newsletter_checked',
) );

/**
 * Check whether newsletter is enabled for archive pages
 *
 * @param WP_Customize_Control $control     Control instance for which this callback is executed.
 *
 * @return bool
 */
function bunchy_customizer_is_archive_newsletter_checked( $control ) {
	return $control->manager->get_setting( bunchy_get_theme_id() . '[archive_newsletter]' )->value() === 'standard';
}


// Ad.
$wp_customize->add_setting( $bunchy_option_name . '[archive_ad]', array(
	'default'           => $bunchy_customizer_defaults['archive_ad'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_archive_ad', array(
	'label'    => esc_html__( 'Ad', 'bunchy' ),
	'section'  => 'bunchy_posts_archive_section',
	'settings' => $bunchy_option_name . '[archive_ad]',
	'type'     => 'select',
	'choices'  => array(
		'standard' => esc_html__( 'inject into post collection', 'bunchy' ),
		'none'     => esc_html__( 'hide', 'bunchy' ),
	),
) );

$wp_customize->add_setting( $bunchy_option_name . '[archive_ad_after_post]', array(
	'default'           => $bunchy_customizer_defaults['archive_ad_after_post'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_archive_ad_after_post', array(
	'label'           => esc_html__( 'Inject ad after post', 'bunchy' ),
	'section'         => 'bunchy_posts_archive_section',
	'settings'        => $bunchy_option_name . '[archive_ad_after_post]',
	'type'            => 'number',
	'input_attrs'     => array(
		'placeholder' => esc_html__( 'eg. 5', 'bunchy' ),
	),
	'active_callback' => 'bunchy_customizer_is_archive_ad_checked',
) );

/**
 * Check whether ad is enabled for archive pages
 *
 * @param WP_Customize_Control $control     Control instance for which this callback is executed.
 *
 * @return bool
 */
function bunchy_customizer_is_archive_ad_checked( $control ) {
	return $control->manager->get_setting( bunchy_get_theme_id() . '[archive_ad]' )->value() === 'standard';
}
