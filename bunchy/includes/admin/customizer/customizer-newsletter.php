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

$wp_customize->add_section( 'bunchy_newsletter_section', array(
	'title'    => esc_html__( 'Newsletter', 'bunchy' ),
	'priority' => 400,
) );


// Title.
$wp_customize->add_setting( $bunchy_option_name . '[newsletter_title]', array(
	'default'           => $bunchy_customizer_defaults['newsletter_title'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_newsletter_title', array(
	'label'       => esc_html__( 'Title', 'bunchy' ),
	'description' => esc_html__( 'Main title, used after a single post content and inside list collection.', 'bunchy' ),
	'section'     => 'bunchy_newsletter_section',
	'settings'    => $bunchy_option_name . '[newsletter_title]',
	'type'        => 'textarea',
) );

// Subtitle.
$wp_customize->add_setting( $bunchy_option_name . '[newsletter_subtitle]', array(
	'default'           => $bunchy_customizer_defaults['newsletter_subtitle'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_newsletter_subtitle', array(
	'label'       => esc_html__( 'Subtitle', 'bunchy' ),
	'description' => esc_html__( 'Used below the main title.', 'bunchy' ),
	'section'     => 'bunchy_newsletter_section',
	'settings'    => $bunchy_option_name . '[newsletter_subtitle]',
	'type'        => 'textarea',
) );

// Compact title.
$wp_customize->add_setting( $bunchy_option_name . '[newsletter_compact_title]', array(
	'default'           => $bunchy_customizer_defaults['newsletter_compact_title'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_newsletter_compact_title', array(
	'label'       => esc_html__( 'Compact title', 'bunchy' ),
	'description' => esc_html__( 'Used for widgets and inside grid collection.', 'bunchy' ),
	'section'     => 'bunchy_newsletter_section',
	'settings'    => $bunchy_option_name . '[newsletter_compact_title]',
	'type'        => 'textarea',
) );

// Privacy.
$wp_customize->add_setting( $bunchy_option_name . '[newsletter_privacy]', array(
	'default'           => $bunchy_customizer_defaults['newsletter_privacy'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'wp_kses_post',
) );

$wp_customize->add_control( 'bunchy_newsletter_privacy', array(
	'label'       => esc_html__( 'Privacy', 'bunchy' ),
	'section'     => 'bunchy_newsletter_section',
	'settings'    => $bunchy_option_name . '[newsletter_privacy]',
	'type'        => 'textarea',
) );
