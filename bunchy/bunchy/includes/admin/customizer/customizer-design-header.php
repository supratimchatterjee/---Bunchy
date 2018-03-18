<?php
/**
 * WP Customizer panel section to handle header design options
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

$wp_customize->add_section( 'bunchy_design_header_section', array(
	'title'    => esc_html__( 'Header', 'bunchy' ),
	'priority' => 40,
	'panel'    => 'bunchy_design_panel',
) );

// Sticky header.
$wp_customize->add_setting( $bunchy_option_name . '[header_sticky]', array(
	'default'           => $bunchy_customizer_defaults['header_sticky'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_header_sticky', array(
	'label'    => esc_html__( 'Sticky Header', 'bunchy' ),
	'section'  => 'bunchy_design_header_section',
	'settings' => $bunchy_option_name . '[header_sticky]',
	'type'     => 'select',
	'choices'  => array(
		'standard'  => esc_html__( 'enabled', 'bunchy' ),
		'none'      => esc_html__( 'disabled', 'bunchy' ),
	),
) );

// Navbar Background Color.
$wp_customize->add_setting( $bunchy_option_name . '[header_navbar_background_color]', array(
	'default'           => $bunchy_customizer_defaults['header_navbar_background_color'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_header_navbar_background_color', array(
	'label'    => esc_html__( 'Navbar Background', 'bunchy' ),
	'section'  => 'bunchy_design_header_section',
	'settings' => $bunchy_option_name . '[header_navbar_background_color]',
) ) );

// Navbar Text Color.
$wp_customize->add_setting( $bunchy_option_name . '[header_navbar_text_color]', array(
	'default'           => $bunchy_customizer_defaults['header_navbar_text_color'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_header_navbar_text_color', array(
	'label'    => esc_html__( 'Navbar Text', 'bunchy' ),
	'section'  => 'bunchy_design_header_section',
	'settings' => $bunchy_option_name . '[header_navbar_text_color]',
) ) );

// Navbar Accent Color.
$wp_customize->add_setting( $bunchy_option_name . '[header_navbar_accent_color]', array(
	'default'           => $bunchy_customizer_defaults['header_navbar_accent_color'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_header_navbar_accent_color', array(
	'label'    => esc_html__( 'Navbar Accent', 'bunchy' ),
	'section'  => 'bunchy_design_header_section',
	'settings' => $bunchy_option_name . '[header_navbar_accent_color]',
) ) );


// Logo Margin Top.
$wp_customize->add_setting( $bunchy_option_name . '[header_logo_margin_top]', array(
	'default'           => $bunchy_customizer_defaults['header_logo_margin_top'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );
$wp_customize->add_control( 'bunchy_header_logo_margin_top', array(
	'label'    => esc_html__( 'Logo Margin Top', 'bunchy' ),
	'section'  => 'bunchy_design_header_section',
	'settings' => $bunchy_option_name . '[header_logo_margin_top]',
	'type'     => 'number',
) );

// Logo Margin Bottom.
$wp_customize->add_setting( $bunchy_option_name . '[header_logo_margin_bottom]', array(
	'default'           => $bunchy_customizer_defaults['header_logo_margin_bottom'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_header_logo_margin_bottom', array(
	'label'    => esc_html__( 'Logo Margin Bottom', 'bunchy' ),
	'section'  => 'bunchy_design_header_section',
	'settings' => $bunchy_option_name . '[header_logo_margin_bottom]',
	'type'     => 'number',
) );


// Text Color.
$wp_customize->add_setting( $bunchy_option_name . '[header_text_color]', array(
	'default'           => $bunchy_customizer_defaults['header_text_color'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_header_text_color', array(
	'label'    => esc_html__( 'Text', 'bunchy' ),
	'section'  => 'bunchy_design_header_section',
	'settings' => $bunchy_option_name . '[header_text_color]',
) ) );

// Accent Color.
$wp_customize->add_setting( $bunchy_option_name . '[header_accent_color]', array(
	'default'           => $bunchy_customizer_defaults['header_accent_color'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_header_accent_color', array(
	'label'    => esc_html__( 'Accent', 'bunchy' ),
	'section'  => 'bunchy_design_header_section',
	'settings' => $bunchy_option_name . '[header_accent_color]',
) ) );

// Background Color.
$wp_customize->add_setting( $bunchy_option_name . '[header_background_color]', array(
	'default'           => $bunchy_customizer_defaults['header_background_color'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_header_background_color', array(
	'label'    => esc_html__( 'Background', 'bunchy' ),
	'section'  => 'bunchy_design_header_section',
	'settings' => $bunchy_option_name . '[header_background_color]',
) ) );


// Secondary Text Color.
$wp_customize->add_setting( $bunchy_option_name . '[header_secondary_text_color]', array(
	'default'           => $bunchy_customizer_defaults['header_secondary_text_color'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_header_secondary_text_color', array(
	'label'    => esc_html__( 'Button Text', 'bunchy' ),
	'section'  => 'bunchy_design_header_section',
	'settings' => $bunchy_option_name . '[header_secondary_text_color]',
) ) );


// Secondary Background Color.
$wp_customize->add_setting( $bunchy_option_name . '[header_secondary_background_color]', array(
	'default'           => $bunchy_customizer_defaults['header_secondary_background_color'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_header_secondary_background_color', array(
	'label'    => esc_html__( 'Button Background', 'bunchy' ),
	'section'  => 'bunchy_design_header_section',
	'settings' => $bunchy_option_name . '[header_secondary_background_color]',
) ) );




// Submenu Background Color.
$wp_customize->add_setting( $bunchy_option_name . '[header_submenu_background_color]', array(
	'default'           => $bunchy_customizer_defaults['header_submenu_background_color'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_header_submenu_background_color', array(
	'label'    => esc_html__( 'Submenu Background', 'bunchy' ),
	'section'  => 'bunchy_design_header_section',
	'settings' => $bunchy_option_name . '[header_submenu_background_color]',
) ) );

// Submenu Text Color.
$wp_customize->add_setting( $bunchy_option_name . '[header_submenu_text_color]', array(
	'default'           => $bunchy_customizer_defaults['header_submenu_text_color'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_header_submenu_text_color', array(
	'label'    => esc_html__( 'Submenu Text', 'bunchy' ),
	'section'  => 'bunchy_design_header_section',
	'settings' => $bunchy_option_name . '[header_submenu_text_color]',
) ) );

// Submenu Accent Color.
$wp_customize->add_setting( $bunchy_option_name . '[header_submenu_accent_color]', array(
	'default'           => $bunchy_customizer_defaults['header_submenu_accent_color'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_header_submenu_accent_color', array(
	'label'    => esc_html__( 'Submenu Accent', 'bunchy' ),
	'section'  => 'bunchy_design_header_section',
	'settings' => $bunchy_option_name . '[header_submenu_accent_color]',
) ) );
