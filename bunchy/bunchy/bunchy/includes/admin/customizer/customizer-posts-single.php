<?php
/**
 * WP Customizer panel section to handle post single options
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

$wp_customize->add_section( 'bunchy_posts_single_section', array(
	'title'    => esc_html__( 'Single', 'bunchy' ),
	'priority' => 20,
	'panel'    => 'bunchy_posts_panel',
) );

// Template.
$wp_customize->add_setting( $bunchy_option_name . '[post_template]', array(
	'default'           => $bunchy_customizer_defaults['post_template'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_post_template', array(
	'label'    => esc_html__( 'Template', 'bunchy' ),
	'section'  => 'bunchy_posts_single_section',
	'settings' => $bunchy_option_name . '[post_template]',
	'type'     => 'select',
	'choices'  => array(
		'classic' => esc_html__( 'Classic, no sidebar', 'bunchy' ),
		'sidebar' => esc_html__( 'Classic, with sidebar', 'bunchy' ),
	),
) );


// Hide Elements.
$wp_customize->add_setting( $bunchy_option_name . '[post_hide_elements]', array(
	'default'           => $bunchy_customizer_defaults['post_hide_elements'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Bunchy_Customize_Multi_Checkbox_Control( $wp_customize, 'bunchy_post_hide_elements', array(
	'label'    => esc_html__( 'Hide Elements', 'bunchy' ),
	'section'  => 'bunchy_posts_single_section',
	'settings' => $bunchy_option_name . '[post_hide_elements]',
	'choices'  => array(
		'categories'      => esc_html__( 'Categories', 'bunchy' ),
		'author'          => esc_html__( 'Author', 'bunchy' ),
		'avatar'          => esc_html__( 'Avatar', 'bunchy' ),
		'date'            => esc_html__( 'Date', 'bunchy' ),
		'comments_link'   => esc_html__( 'Comments Link', 'bunchy' ),
		'views'           => esc_html__( 'Views', 'bunchy' ),
		'featured_media'  => esc_html__( 'Featured Media', 'bunchy' ),
		'tags'            => esc_html__( 'Tags', 'bunchy' ),
		'newsletter'      => esc_html__( 'Newsletter', 'bunchy' ),
		'navigation'      => esc_html__( 'Prev/Next Links', 'bunchy' ),
		'author_info'     => esc_html__( 'Author info', 'bunchy' ),
		'related_entries' => esc_html__( 'You May Also Like', 'bunchy' ),
		'more_from'       => esc_html__( 'More from category', 'bunchy' ),
		'dont_miss'       => esc_html__( 'Don\'t miss', 'bunchy' ),
		'comments'        => esc_html__( 'Comments', 'bunchy' ),
	),
) ) );


// ShareBar.
$wp_customize->add_setting( $bunchy_option_name . '[post_sharebar]', array(
	'default'           => $bunchy_customizer_defaults['post_sharebar'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_post_sharebar', array(
	'label'       => esc_html__( 'Sticky ShareBar', 'bunchy' ),
	'section'     => 'bunchy_posts_single_section',
	'settings'    => $bunchy_option_name . '[post_sharebar]',
	'type'        => 'select',
	'choices'     => array(
		'none'     => esc_html__( 'disabled', 'bunchy' ),
		'standard' => esc_html__( 'enabled', 'bunchy' ),
	),
) );


// Pagination.
$wp_customize->add_setting( 'bunchy_post_pagination_header', array(
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );
$wp_customize->add_control( new Bunchy_Customize_HTML_Control( $wp_customize, 'bunchy_post_pagination_header', array(
	'section'  => 'bunchy_posts_single_section',
	'settings' => 'bunchy_post_pagination_header',
	'html'     =>
		'<hr />
		<h2>' . esc_html__( 'Pagination', 'bunchy' ) . '</h2>',
) ) );



// Pagination: overview.
$wp_customize->add_setting( $bunchy_option_name . '[post_pagination_overview]', array(
	'default'           => $bunchy_customizer_defaults['post_pagination_overview'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_post_pagination_overview', array(
	'label'       => esc_html__( 'Overview', 'bunchy' ),
	'section'     => 'bunchy_posts_single_section',
	'settings'    => $bunchy_option_name . '[post_pagination_overview]',
	'type'        => 'select',
	'choices'     => array(
		'page_links'        => esc_html__( 'page links', 'bunchy' ),
		'page_xofy'         => esc_html__( 'page X of Y', 'bunchy' ),
		'none'              => esc_html__( 'none', 'bunchy' ),
	),
) );

// Pagination: adjacent label.
$wp_customize->add_setting( $bunchy_option_name . '[post_pagination_adjacent_label]', array(
	'default'           => $bunchy_customizer_defaults['post_pagination_adjacent_label'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_post_pagination_adjacent_label', array(
	'label'       => esc_html__( 'Adjacent label', 'bunchy' ),
	'section'     => 'bunchy_posts_single_section',
	'settings'    => $bunchy_option_name . '[post_pagination_adjacent_label]',
	'type'        => 'select',
	'choices'     => array(
		'adjacent'      => esc_html__( 'previous | next', 'bunchy' ),
		'adjacent_page' => esc_html__( 'previous page | next page', 'bunchy' ),
		'arrow'         => esc_html__( 'just arrow', 'bunchy' ),
	),
) );

// Pagination: adjacent style.
$wp_customize->add_setting( $bunchy_option_name . '[post_pagination_adjacent_style]', array(
	'default'           => $bunchy_customizer_defaults['post_pagination_adjacent_style'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_post_pagination_adjacent_style', array(
	'label'       => esc_html__( 'Adjacent style', 'bunchy' ),
	'section'     => 'bunchy_posts_single_section',
	'settings'    => $bunchy_option_name . '[post_pagination_adjacent_style]',
	'type'        => 'select',
	'choices'     => array(
		'link'      => esc_html__( 'link', 'bunchy' ),
		'button'    => esc_html__( 'button', 'bunchy' ),
	),
) );




// You May Also Like section header.
$wp_customize->add_setting( 'bunchy_post_related_header', array(
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );
$wp_customize->add_control( new Bunchy_Customize_HTML_Control( $wp_customize, 'bunchy_post_related_header', array(
	'section'  => 'bunchy_posts_single_section',
	'settings' => 'bunchy_post_related_header',
	'html'     =>
		'<hr />
		<h2>' . esc_html__( 'You May Also Like', 'bunchy' ) . '</h2>',
	'active_callback' => 'bunchy_customizer_is_related_active',
) ) );

// You May Also Like section.
$wp_customize->add_setting( $bunchy_option_name . '[post_related_hide_elements]', array(
	'default'           => $bunchy_customizer_defaults['post_related_hide_elements'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Bunchy_Customize_Multi_Checkbox_Control( $wp_customize, 'bunchy_post_related_hide_elements', array(
	'label'    => esc_html__( 'Hide Elements', 'bunchy' ),
	'section'  => 'bunchy_posts_single_section',
	'settings' => $bunchy_option_name . '[post_related_hide_elements]',
	'choices'  => array(
		'featured_media'  => esc_html__( 'Featured Media', 'bunchy' ),
		'shares'          => esc_html__( 'Shares', 'bunchy' ),
		'views'           => esc_html__( 'Views', 'bunchy' ),
		'comments_link'   => esc_html__( 'Comments Link', 'bunchy' ),
		'categories'      => esc_html__( 'Categories', 'bunchy' ),
		'summary'         => esc_html__( 'Summary', 'bunchy' ),
		'author'          => esc_html__( 'Author', 'bunchy' ),
		'avatar'          => esc_html__( 'Avatar', 'bunchy' ),
		'date'            => esc_html__( 'Date', 'bunchy' ),
	),
	'active_callback' => 'bunchy_customizer_is_related_active',
) ) );

/**
 * Check whether user hide the You May Also Like section
 *
 * @param WP_Customize_Control $control     Control instance for which this callback is executed.
 *
 * @return bool
 */
function bunchy_customizer_is_related_active( $control ) {
	$hidden_elements = $control->manager->get_setting( bunchy_get_theme_id() . '[post_hide_elements]' )->value();

	return false === strpos( $hidden_elements, 'related_entries' );
}

// More From section header.
$wp_customize->add_setting( 'bunchy_post_more_from_header', array(
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );
$wp_customize->add_control( new Bunchy_Customize_HTML_Control( $wp_customize, 'bunchy_post_more_from_header', array(
	'section'  => 'bunchy_posts_single_section',
	'settings' => 'bunchy_post_more_from_header',
	'html'     =>
		'<hr />
		<h2>' . esc_html__( 'More From', 'bunchy' ) . '</h2>',
	'active_callback' => 'bunchy_customizer_is_more_from_active',
) ) );

// More From section.
$wp_customize->add_setting( $bunchy_option_name . '[post_more_from_hide_elements]', array(
	'default'           => $bunchy_customizer_defaults['post_more_from_hide_elements'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Bunchy_Customize_Multi_Checkbox_Control( $wp_customize, 'bunchy_post_more_from_hide_elements', array(
	'label'    => esc_html__( 'Hide Elements', 'bunchy' ),
	'section'  => 'bunchy_posts_single_section',
	'settings' => $bunchy_option_name . '[post_more_from_hide_elements]',
	'choices'  => array(
		'featured_media'  => esc_html__( 'Featured Media', 'bunchy' ),
		'shares'          => esc_html__( 'Shares', 'bunchy' ),
		'views'           => esc_html__( 'Views', 'bunchy' ),
		'comments_link'   => esc_html__( 'Comments Link', 'bunchy' ),
		'categories'      => esc_html__( 'Categories', 'bunchy' ),
		'summary'         => esc_html__( 'Summary', 'bunchy' ),
		'author'          => esc_html__( 'Author', 'bunchy' ),
		'avatar'          => esc_html__( 'Avatar', 'bunchy' ),
		'date'            => esc_html__( 'Date', 'bunchy' ),
	),
	'active_callback' => 'bunchy_customizer_is_more_from_active',
) ) );


/**
 * Check whether user hide the More From section
 *
 * @param WP_Customize_Control $control     Control instance for which this callback is executed.
 *
 * @return bool
 */
function bunchy_customizer_is_more_from_active( $control ) {
	$hidden_elements = $control->manager->get_setting( bunchy_get_theme_id() . '[post_hide_elements]' )->value();

	return false === strpos( $hidden_elements, 'more_from' );
}

// Don't Miss section header.
$wp_customize->add_setting( 'bunchy_post_dont_miss_hide_elements_header', array(
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );
$wp_customize->add_control( new Bunchy_Customize_HTML_Control( $wp_customize, 'bunchy_post_dont_miss_hide_elements_header', array(
	'section'  => 'bunchy_posts_single_section',
	'settings' => 'bunchy_post_dont_miss_hide_elements_header',
	'html'     =>
		'<hr />
		<h2>' . esc_html__( 'Don\'t Miss', 'bunchy' ) . '</h2>',
	'active_callback' => 'bunchy_customizer_is_dont_miss_active',
) ) );

// Don't Miss section.
$wp_customize->add_setting( $bunchy_option_name . '[post_dont_miss_hide_elements]', array(
	'default'           => $bunchy_customizer_defaults['post_dont_miss_hide_elements'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Bunchy_Customize_Multi_Checkbox_Control( $wp_customize, 'bunchy_post_dont_miss_hide_elements', array(
	'label'    => esc_html__( 'Hide Elements', 'bunchy' ),
	'section'  => 'bunchy_posts_single_section',
	'settings' => $bunchy_option_name . '[post_dont_miss_hide_elements]',
	'choices'  => array(
		'featured_media'  => esc_html__( 'Featured Media', 'bunchy' ),
		'shares'          => esc_html__( 'Shares', 'bunchy' ),
		'views'           => esc_html__( 'Views', 'bunchy' ),
		'comments_link'   => esc_html__( 'Comments Link', 'bunchy' ),
		'categories'      => esc_html__( 'Categories', 'bunchy' ),
		'summary'         => esc_html__( 'Summary', 'bunchy' ),
		'author'          => esc_html__( 'Author', 'bunchy' ),
		'avatar'          => esc_html__( 'Avatar', 'bunchy' ),
		'date'            => esc_html__( 'Date', 'bunchy' ),
	),
	'active_callback' => 'bunchy_customizer_is_dont_miss_active',
) ) );

/**
 * Check whether user hide the Don't Miss section
 *
 * @param WP_Customize_Control $control     Control instance for which this callback is executed.
 *
 * @return bool
 */
function bunchy_customizer_is_dont_miss_active( $control ) {
	$hidden_elements = $control->manager->get_setting( bunchy_get_theme_id() . '[post_hide_elements]' )->value();

	return false === strpos( $hidden_elements, 'dont_miss' );
}
