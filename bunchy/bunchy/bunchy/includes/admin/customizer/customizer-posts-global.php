<?php
/**
 * WP Customizer panel section to handle posts global options
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

$wp_customize->add_section( 'bunchy_posts_global_section', array(
	'title'    => esc_html__( 'Global', 'bunchy' ),
	'priority' => 10,
	'panel'    => 'bunchy_posts_panel',
) );


// Latest posts page.
$wp_customize->add_setting( $bunchy_option_name . '[posts_latest_page]', array(
	'default'           => $bunchy_customizer_defaults['posts_latest_page'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_posts_latest_page', array(
	'label'    => esc_html__( 'Latest posts page', 'bunchy' ),
	'section'  => 'bunchy_posts_global_section',
	'settings' => $bunchy_option_name . '[posts_latest_page]',
	'type'     => 'checkbox',
) );


// Hot posts page.
$wp_customize->add_setting( $bunchy_option_name . '[posts_hot_page]', array(
	'default'           => $bunchy_customizer_defaults['posts_hot_page'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( 'bunchy_posts_hot_page', array(
	'label'    => esc_html__( 'Hot posts page', 'bunchy' ),
	'section'  => 'bunchy_posts_global_section',
	'settings' => $bunchy_option_name . '[posts_hot_page]',
	'type'     => 'dropdown-pages',
) );


// Popular posts page.
$wp_customize->add_setting( $bunchy_option_name . '[posts_popular_page]', array(
	'default'           => $bunchy_customizer_defaults['posts_popular_page'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( 'bunchy_posts_popular_page', array(
	'label'    => esc_html__( 'Popular posts page', 'bunchy' ),
	'section'  => 'bunchy_posts_global_section',
	'settings' => $bunchy_option_name . '[posts_popular_page]',
	'type'     => 'dropdown-pages',
) );


// Trending posts page.
$wp_customize->add_setting( $bunchy_option_name . '[posts_trending_page]', array(
	'default'           => $bunchy_customizer_defaults['posts_trending_page'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( 'bunchy_posts_trending_page', array(
	'label'    => esc_html__( 'Trending posts page', 'bunchy' ),
	'section'  => 'bunchy_posts_global_section',
	'settings' => $bunchy_option_name . '[posts_trending_page]',
	'type'     => 'dropdown-pages',
) );


// Views Threshold.
$wp_customize->add_setting( $bunchy_option_name . '[posts_views_threshold]', array(
	'default'           => $bunchy_customizer_defaults['posts_views_threshold'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( 'bunchy_posts_views_threshold', array(
	'label'       => esc_html__( 'Hide views', 'bunchy' ),
	'description' => esc_html__( 'If you fill in any number here, the views for a specific post are not shown until the view count of this number is reached.', 'bunchy' ),
	'section'     => 'bunchy_posts_global_section',
	'settings'    => $bunchy_option_name . '[posts_views_threshold]',
	'type'        => 'number',
) );

// Comments Threshold.
$wp_customize->add_setting( $bunchy_option_name . '[posts_comments_threshold]', array(
	'default'           => $bunchy_customizer_defaults['posts_comments_threshold'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( 'bunchy_posts_comments_threshold', array(
	'label'       => esc_html__( 'Hide comments', 'bunchy' ),
	'description' => esc_html__( 'If you fill in any number here, the comments for a specific post are not shown until the comment count of this number is reached.', 'bunchy' ),
	'section'     => 'bunchy_posts_global_section',
	'settings'    => $bunchy_option_name . '[posts_comments_threshold]',
	'type'        => 'number',
) );


// Timeago.
$wp_customize->add_setting( $bunchy_option_name . '[posts_timeago]', array(
	'default'           => $bunchy_customizer_defaults['posts_timeago'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_posts_timeago', array(
	'label'       => esc_html__( 'Convert date to time ago', 'bunchy' ),
	'description' => esc_html__( 'Instead of displaying full date, use timestamps like "4 minutes ago", "1 day ago".', 'bunchy' ),
	'section'     => 'bunchy_posts_global_section',
	'settings'    => $bunchy_option_name . '[posts_timeago]',
	'type'        => 'select',
	'choices'     => array(
		'none'     => esc_html__( 'disabled', 'bunchy' ),
		'standard' => esc_html__( 'enabled', 'bunchy' ),
	),
) );
