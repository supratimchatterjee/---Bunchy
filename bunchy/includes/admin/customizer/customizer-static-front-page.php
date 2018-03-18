<?php
/**
 * WP Customizer panel section to handle homepage options
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

// Show info about currently previewing page.
$wp_customize->add_setting( 'bunchy_on_posts_page_info', array(
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Bunchy_Customize_HTML_Control( $wp_customize, 'bunchy_on_posts_page_info', array(
	'section'         => 'static_front_page',
	'settings'        => 'bunchy_on_posts_page_info',
	'html'            =>
		'<p class="g1-customizer-on-page-info">
			<strong>' . esc_html__( 'You\'re previewing the posts page.', 'bunchy' ) . '</strong>
		</p>',
	'active_callback' => 'is_home',
) ) );


// Template.
$wp_customize->add_setting( $bunchy_option_name . '[home_template]', array(
	'default'           => $bunchy_customizer_defaults['home_template'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_home_template', array(
	'label'           => esc_html__( 'Template', 'bunchy' ),
	'section'         => 'static_front_page',
	'settings'        => $bunchy_option_name . '[home_template]',
	'type'            => 'select',
	'choices'         => array(
		'one-featured-list-sidebar'      => esc_html__( '1 Featured + List with Sidebar', 'bunchy' ),
		'one-featured-grid-sidebar'      => esc_html__( '1 Featured + Grid with Sidebar', 'bunchy' ),
		'grid'            				 => esc_html__( 'Grid', 'bunchy' ),
		'one-featured-classic-sidebar'	 => esc_html__( '1 Featured + Classic with Sidebar', 'bunchy' ),
	),
	'active_callback' => 'bunchy_customizer_is_posts_page_selected',
) );

/**
 * Check whether user chose page for Posts
 *
 * @param WP_Customize_Control $control     Control instance for which this callback is executed.
 *
 * @return bool
 */
function bunchy_customizer_is_posts_page_selected( $control ) {
	$show_on_front = $control->manager->get_setting( 'show_on_front' )->value();

	// Front page displays.
	if ( 'posts' === $show_on_front ) {
		// Your Latest posts.
		return true;
	} else {
		// A static page.
		$page_for_posts = $control->manager->get_setting( 'page_for_posts' )->value();

		// A page is selected (0 means no selection).
		return '0' !== $page_for_posts;
	}
}


// Featured Entries.
$wp_customize->add_setting( $bunchy_option_name . '[home_featured_entries]', array(
	'default'           => $bunchy_customizer_defaults['home_featured_entries'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_home_featured_entries', array(
	'label'    => esc_html__( 'Featured Entries', 'bunchy' ),
	'section'  => 'static_front_page',
	'settings' => $bunchy_option_name . '[home_featured_entries]',
	'type'     => 'select',
	'choices'  => array(
		'most_shared' => esc_html__( 'most shared', 'bunchy' ),
		'most_viewed' => esc_html__( 'most viewed', 'bunchy' ),
		'recent'      => esc_html__( 'recent', 'bunchy' ),
		'none'        => esc_html__( 'none', 'bunchy' ),
	),
) );

/**
 * Check whether featured entries are enabled for homepage
 *
 * @param WP_Customize_Control $control     Control instance for which this callback is executed.
 *
 * @return bool
 */
function bunchy_customizer_home_has_featured_entries( $control ) {
	if ( ! bunchy_customizer_is_posts_page_selected( $control ) ) {
		return false;
	}

	$type = $control->manager->get_setting( bunchy_get_theme_id() . '[home_featured_entries]' )->value();

	return 'none' !== $type;
}

/**
 * Check whether featured entries tag filter is supported
 *
 * @param WP_Customize_Control $control     Control instance for which this callback is executed.
 *
 * @return bool
 */
function bunchy_customizer_home_featured_entries_tag_is_active( $control ) {
	$has_featured_entries = bunchy_customizer_home_has_featured_entries( $control );

	// Skip if home doesn't use the Featured Entries.
	if ( ! $has_featured_entries ) {
		return false;
	}

	$featured_entries_type = $control->manager->get_setting( bunchy_get_theme_id() . '[home_featured_entries]' )->value();

	// The most viewed types doesn't support tag filter.
	if ( 'most_viewed' === $featured_entries_type ) {
		return false;
	}

	return true;
}


// Category.
$wp_customize->add_setting( $bunchy_option_name . '[home_featured_entries_category]', array(
	'default'           => $bunchy_customizer_defaults['home_featured_entries_category'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'bunchy_sanitize_multi_choice',
) );

$wp_customize->add_control( new Bunchy_Customize_Multi_Checkbox_Control( $wp_customize, 'bunchy_home_featured_entries_category', array(
	'label'           => esc_html__( 'Featured Entries Category', 'bunchy' ),
	'section'         => 'static_front_page',
	'settings'        => $bunchy_option_name . '[home_featured_entries_category]',
	'choices'         => bunchy_customizer_get_category_choices(),
	'active_callback' => 'bunchy_customizer_home_has_featured_entries',
) ) );


// Tag.
$wp_customize->add_setting( $bunchy_option_name . '[home_featured_entries_tag]', array(
	'default'           => $bunchy_customizer_defaults['home_featured_entries_tag'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'bunchy_sanitize_multi_choice',
) );

$wp_customize->add_control( new Bunchy_Customize_Multi_Select_Control( $wp_customize, 'bunchy_home_featured_entries_tag', array(
	'label'           => esc_html__( 'Featured Entries Tag', 'bunchy' ),
	'description'     => esc_html__( 'you can choose many', 'bunchy' ),
	'section'         => 'static_front_page',
	'settings'        => $bunchy_option_name . '[home_featured_entries_tag]',
	'choices'         => bunchy_customizer_get_tag_choices(),
	'active_callback' => 'bunchy_customizer_home_featured_entries_tag_is_active',
) ) );


// Featured Entries Time range.
$wp_customize->add_setting( $bunchy_option_name . '[home_featured_entries_time_range]', array(
	'default'           => $bunchy_customizer_defaults['home_featured_entries_time_range'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_home_featured_entries_time_range', array(
	'label'           => esc_html__( 'Featured Entries Time range', 'bunchy' ),
	'section'         => 'static_front_page',
	'settings'        => $bunchy_option_name . '[home_featured_entries_time_range]',
	'type'            => 'select',
	'choices'         => array(
		'day'   => esc_html__( 'last 24 hours', 'bunchy' ),
		'week'  => esc_html__( 'last 7 days', 'bunchy' ),
		'month' => esc_html__( 'last 30 days', 'bunchy' ),
		'all'   => esc_html__( 'all time', 'bunchy' ),
	),
	'active_callback' => 'bunchy_customizer_home_has_featured_entries',
) );

// Featured Entries Hide Elements.
$wp_customize->add_setting( $bunchy_option_name . '[home_featured_entries_hide_elements]', array(
	'default'           => $bunchy_customizer_defaults['home_featured_entries_hide_elements'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Bunchy_Customize_Multi_Checkbox_Control( $wp_customize, 'bunchy_home_featured_entries_hide_elements', array(
	'label'           => esc_html__( 'Featured Entries Hide Elements', 'bunchy' ),
	'section'         => 'static_front_page',
	'settings'        => $bunchy_option_name . '[home_featured_entries_hide_elements]',
	'choices'         => array(
		'shares'        => esc_html__( 'Shares', 'bunchy' ),
		'views'         => esc_html__( 'Views', 'bunchy' ),
		'comments_link' => esc_html__( 'Comments Link', 'bunchy' ),
		'avatar'         => esc_html__( 'Avatar', 'bunchy' ),
		'author'         => esc_html__( 'Author', 'bunchy' ),
		'date'           => esc_html__( 'Date', 'bunchy' ),
		'categories'    => esc_html__( 'Categories', 'bunchy' ),
		'summary'        => esc_html__( 'Summary', 'bunchy' ),
	),
	'active_callback' => 'bunchy_customizer_home_has_featured_entries',
) ) );


// Posts Per Page.
$wp_customize->add_setting( 'posts_per_page', array(
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_home_posts_per_page', array(
	'label'    => esc_html__( 'Entries per page', 'bunchy' ),
	'section'  => 'static_front_page',
	'settings' => 'posts_per_page',
	'type'     => 'number',
) );


// Pagination.
$wp_customize->add_setting( $bunchy_option_name . '[home_pagination]', array(
	'default'           => $bunchy_customizer_defaults['home_pagination'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_home_pagination', array(
	'label'    => esc_html__( 'Pagination', 'bunchy' ),
	'section'  => 'static_front_page',
	'settings' => $bunchy_option_name . '[home_pagination]',
	'type'     => 'select',
	'choices'  => array(
		'load-more'                 => esc_html__( 'Load More', 'bunchy' ),
		'infinite-scroll'           => esc_html__( 'Infinite Scroll', 'bunchy' ),
		'infinite-scroll-on-demand' => esc_html__( 'Infinite Scroll (first load via click)', 'bunchy' ),
		'pages'                     => esc_html__( 'Prev/Next Pages', 'bunchy' ),
	),
) );


// Hide Elements.
$wp_customize->add_setting( $bunchy_option_name . '[home_hide_elements]', array(
	'default'           => $bunchy_customizer_defaults['home_hide_elements'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Bunchy_Customize_Multi_Checkbox_Control( $wp_customize, 'bunchy_home_hide_elements', array(
	'label'    => esc_html__( 'Hide Elements', 'bunchy' ),
	'section'  => 'static_front_page',
	'settings' => $bunchy_option_name . '[home_hide_elements]',
	'choices'  => array(
		'featured_media' => esc_html__( 'Featured Media', 'bunchy' ),
		'categories'     => esc_html__( 'Categories', 'bunchy' ),
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
$wp_customize->add_setting( $bunchy_option_name . '[home_newsletter]', array(
	'default'           => $bunchy_customizer_defaults['home_newsletter'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_home_newsletter', array(
	'label'           => esc_html__( 'Newsletter', 'bunchy' ),
	'section'         => 'static_front_page',
	'settings'        => $bunchy_option_name . '[home_newsletter]',
	'type'            => 'select',
	'choices'         => array(
		'standard' => esc_html__( 'inject into post collection', 'bunchy' ),
		'none'     => esc_html__( 'hide', 'bunchy' ),
	),
	'active_callback' => 'bunchy_customizer_is_posts_page_selected',
) );

$wp_customize->add_setting( $bunchy_option_name . '[home_newsletter_after_post]', array(
	'default'           => $bunchy_customizer_defaults['home_newsletter_after_post'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_home_newsletter_after_post', array(
	'label'           => esc_html__( 'Inject newsletter after post', 'bunchy' ),
	'section'         => 'static_front_page',
	'settings'        => $bunchy_option_name . '[home_newsletter_after_post]',
	'type'            => 'number',
	'input_attrs'     => array(
		'placeholder' => esc_html__( 'eg. 2', 'bunchy' ),
	),
	'active_callback' => 'bunchy_customizer_is_home_newsletter_checked',
) );

/**
 * Check whether newsletter is enabled for homepage
 *
 * @param WP_Customize_Control $control     Control instance for which this callback is executed.
 *
 * @return bool
 */
function bunchy_customizer_is_home_newsletter_checked( $control ) {
	if ( ! bunchy_customizer_is_posts_page_selected( $control ) ) {
		return false;
	}

	return $control->manager->get_setting( bunchy_get_theme_id() . '[home_newsletter]' )->value() === 'standard';
}


// Ad.
$wp_customize->add_setting( $bunchy_option_name . '[home_ad]', array(
	'default'           => $bunchy_customizer_defaults['home_ad'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_home_ad', array(
	'label'           => esc_html__( 'Ad', 'bunchy' ),
	'section'         => 'static_front_page',
	'settings'        => $bunchy_option_name . '[home_ad]',
	'type'            => 'select',
	'choices'         => array(
		'standard' => esc_html__( 'inject into post collection', 'bunchy' ),
		'none'     => esc_html__( 'hide', 'bunchy' ),
	),
	'active_callback' => 'bunchy_customizer_is_posts_page_selected',
) );

$wp_customize->add_setting( $bunchy_option_name . '[home_ad_after_post]', array(
	'default'           => $bunchy_customizer_defaults['home_ad_after_post'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_home_ad_after_post', array(
	'label'           => esc_html__( 'Inject ad after post', 'bunchy' ),
	'section'         => 'static_front_page',
	'settings'        => $bunchy_option_name . '[home_ad_after_post]',
	'type'            => 'number',
	'input_attrs'     => array(
		'placeholder' => esc_html__( 'eg. 5', 'bunchy' ),
	),
	'active_callback' => 'bunchy_customizer_is_home_ad_checked',
) );

/**
 * Check whether ad is enabled for homepage
 *
 * @param WP_Customize_Control $control     Control instance for which this callback is executed.
 *
 * @return bool
 */
function bunchy_customizer_is_home_ad_checked( $control ) {
	if ( ! bunchy_customizer_is_posts_page_selected( $control ) ) {
		return false;
	}

	return $control->manager->get_setting( bunchy_get_theme_id() . '[home_ad]' )->value() === 'standard';
}
