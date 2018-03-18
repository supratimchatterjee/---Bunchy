<?php
/**
 * WP Customizer panel section to handle general side options (like logo, footer text)
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

// Show tagline.
$wp_customize->add_setting( $bunchy_option_name . '[branding_show_tagline]', array(
	'default'           => $bunchy_customizer_defaults['branding_show_tagline'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_branding_show_tagline', array(
	'label'    => esc_html__( 'Show Tagline', 'bunchy' ),
	'section'  => 'title_tagline',
	'settings' => $bunchy_option_name . '[branding_show_tagline]',
	'priority' => 55,
	'type'     => 'checkbox',
) );

// Logo.
$wp_customize->add_setting( $bunchy_option_name . '[branding_logo]', array(
	'default'           => $bunchy_customizer_defaults['branding_logo'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bunchy_branding_logo', array(
	'label'    => esc_html__( 'Logo', 'bunchy' ),
	'section'  => 'title_tagline',
	'settings' => $bunchy_option_name . '[branding_logo]',
	'priority' => 70,
) ) );


// Logo width.
$wp_customize->add_setting( $bunchy_option_name . '[branding_logo_width]', array(
	'default'           => $bunchy_customizer_defaults['branding_logo_width'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( 'bunchy_branding_logo_width', array(
	'label'    => esc_html__( 'Logo Width', 'bunchy' ),
	'section'  => 'title_tagline',
	'settings' => $bunchy_option_name . '[branding_logo_width]',
	'priority' => 71,
	'type'     => 'number',
) );


// Logo height.
$wp_customize->add_setting( $bunchy_option_name . '[branding_logo_height]', array(
	'default'           => $bunchy_customizer_defaults['branding_logo_height'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( 'bunchy_branding_logo_height', array(
	'label'    => esc_html__( 'Logo Height', 'bunchy' ),
	'section'  => 'title_tagline',
	'settings' => $bunchy_option_name . '[branding_logo_height]',
	'priority' => 72,
	'type'     => 'number',
) );


// Logo HDPI.
$wp_customize->add_setting( $bunchy_option_name . '[branding_logo_hdpi]', array(
	'default'           => $bunchy_customizer_defaults['branding_logo_hdpi'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bunchy_branding_logo_hdpi', array(
	'label'       => esc_html__( 'Logo HDPI', 'bunchy' ),
	'description' => esc_html__( 'An image for High DPI screen (like Retina) should be twice as big.', 'bunchy' ),
	'section'     => 'title_tagline',
	'settings'    => $bunchy_option_name . '[branding_logo_hdpi]',
	'priority'    => 80,
) ) );

// Footer Text.
$wp_customize->add_setting( $bunchy_option_name . '[footer_text]', array(
	'default'           => $bunchy_customizer_defaults['footer_text'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_footer_text', array(
	'label'    => esc_html__( 'Footer Text', 'bunchy' ),
	'section'  => 'title_tagline',
	'settings' => $bunchy_option_name . '[footer_text]',
	'priority' => 90,
	'type'     => 'text',
) );

// Footer Stamp.
$wp_customize->add_setting( $bunchy_option_name . '[footer_stamp]', array(
	'default'           => $bunchy_customizer_defaults['footer_stamp'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bunchy_footer_stamp', array(
	'label'    => esc_html__( 'Footer Stamp', 'bunchy' ),
	'section'  => 'title_tagline',
	'settings' => $bunchy_option_name . '[footer_stamp]',
	'priority' => 100,
) ) );


// Footer Stamp Width.
$wp_customize->add_setting( $bunchy_option_name . '[footer_stamp_width]', array(
	'default'           => $bunchy_customizer_defaults['footer_stamp_width'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( 'bunchy_footer_stamp_width', array(
	'label'    => esc_html__( 'Footer Stamp Width', 'bunchy' ),
	'section'  => 'title_tagline',
	'settings' => $bunchy_option_name . '[footer_stamp_width]',
	'priority' => 110,
	'type'     => 'number',
) );


// Footer Stamp Height.
$wp_customize->add_setting( $bunchy_option_name . '[footer_stamp_height]', array(
	'default'           => $bunchy_customizer_defaults['footer_stamp_height'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( 'bunchy_footer_stamp_height', array(
	'label'    => esc_html__( 'Footer Stamp Height', 'bunchy' ),
	'section'  => 'title_tagline',
	'settings' => $bunchy_option_name . '[footer_stamp_height]',
	'priority' => 115,
	'type'     => 'number',
) );


// Footer Stamp HDPI.
$wp_customize->add_setting( $bunchy_option_name . '[footer_stamp_hdpi]', array(
	'default'           => $bunchy_customizer_defaults['footer_stamp_hdpi'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bunchy_footer_stamp_hdpi', array(
	'label'       => esc_html__( 'Footer Stamp HDPI', 'bunchy' ),
	'description' => esc_html__( 'An image for High DPI screen (like Retina) should be twice as big.', 'bunchy' ),
	'section'     => 'title_tagline',
	'settings'    => $bunchy_option_name . '[footer_stamp_hdpi]',
	'priority'    => 120,
) ) );


// Footer Stamp Label.
$wp_customize->add_setting( $bunchy_option_name . '[footer_stamp_label]', array(
	'default'           => $bunchy_customizer_defaults['footer_stamp_label'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_footer_stamp_label', array(
	'label'    => esc_html__( 'Footer Stamp Label', 'bunchy' ),
	'section'  => 'title_tagline',
	'settings' => $bunchy_option_name . '[footer_stamp_label]',
	'priority' => 150,
	'type'     => 'text',
) );


// Footer Stamp Url.
$wp_customize->add_setting( $bunchy_option_name . '[footer_stamp_url]', array(
	'default'           => $bunchy_customizer_defaults['footer_stamp_url'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_footer_stamp_url', array(
	'label'       => esc_html__( 'Footer Stamp URL', 'bunchy' ),
	'section'     => 'title_tagline',
	'settings'    => $bunchy_option_name . '[footer_stamp_url]',
	'priority'    => 160,
	'type'        => 'text',
	'input_attrs' => array(
		'placeholder' => esc_html__( 'http://', 'bunchy' ),
	),
) );
