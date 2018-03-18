<?php
/**
 * WP Customizer panel section to handle general design options
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

$wp_customize->add_section( 'bunchy_design_global_section', array(
	'title'    => esc_html__( 'Global', 'bunchy' ),
	'priority' => 10,
	'panel'    => 'bunchy_design_panel',
) );

// Page layout.
$wp_customize->add_setting( $bunchy_option_name . '[global_layout]', array(
	'default'           => $bunchy_customizer_defaults['global_layout'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_global_layout', array(
	'label'    => esc_html__( 'Layout', 'bunchy' ),
	'section'  => 'bunchy_design_global_section',
	'settings' => $bunchy_option_name . '[global_layout]',
	'type'     => 'select',
	'choices'  => array(
		'boxed'     => esc_html__( 'boxed', 'bunchy' ),
		'stretched' => esc_html__( 'stretched', 'bunchy' ),
	),
) );

// Page width.
$wp_customize->add_setting( $bunchy_option_name . '[global_width]', array(
	'default'           => $bunchy_customizer_defaults['global_width'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( 'bunchy_global_width', array(
	'label'    => esc_html__( 'Boxed Layout Width', 'bunchy' ),
	'section'  => 'bunchy_design_global_section',
	'settings' => $bunchy_option_name . '[global_width]',
	'type'     => 'text',
) );

// Background Color.
$wp_customize->add_setting( $bunchy_option_name . '[global_background_color]', array(
	'default'           => $bunchy_customizer_defaults['global_background_color'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_global_background_color', array(
	'label'    => esc_html__( 'Boxed Layout Background', 'bunchy' ),
	'section'  => 'bunchy_design_global_section',
	'settings' => $bunchy_option_name . '[global_background_color]',
) ) );


// Google Font Subset.
$wp_customize->add_setting( $bunchy_option_name . '[global_google_font_subset]', array(
	'default'           => $bunchy_customizer_defaults['global_google_font_subset'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Bunchy_Customize_Multi_Checkbox_Control( $wp_customize, 'bunchy_global_google_font_subset', array(
	'label'    => esc_html__( 'Google Font Subset', 'bunchy' ),
	'section'  => 'bunchy_design_global_section',
	'settings' => $bunchy_option_name . '[global_google_font_subset]',
	'choices'  => array(
		'latin'        => esc_html__( 'Latin', 'bunchy' ),
		'latin-ext'    => esc_html__( 'Latin Extended', 'bunchy' ),
		'cyrillic'     => esc_html__( 'Cyrillic', 'bunchy' ),
		'cyrillic-ext' => esc_html__( 'Cyrillic Extended', 'bunchy' ),
		'greek'        => esc_html__( 'Greek', 'bunchy' ),
		'greek-ext'    => esc_html__( 'Greek Extended', 'bunchy' ),
		'vietnamese'   => esc_html__( 'Vietnamese', 'bunchy' ),
	),
) ) );

// Divider.
$wp_customize->add_setting( 'bunchy_global_cs_1_divider', array(
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );
$wp_customize->add_control( new Bunchy_Customize_HTML_Control( $wp_customize, 'bunchy_global_cs_1_divider', array(
	'section'  => 'bunchy_design_global_section',
	'settings' => 'bunchy_global_cs_1_divider',
	'html'     =>
		'<hr />
		<h2>' . esc_html__( 'Basic Color Scheme', 'bunchy' ) . '</h2>
		<p>' . esc_html__( 'Will be applied to buttons, badges.', 'bunchy' ) . '</p>',
) ) );


// Background Color (cs1).
$wp_customize->add_setting( $bunchy_option_name . '[content_cs_1_background_color]', array(
	'default'           => $bunchy_customizer_defaults['content_cs_1_background_color'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_content_cs_1_background_color', array(
	'label'    => esc_html__( 'Background', 'bunchy' ),
	'section'  => 'bunchy_design_global_section',
	'settings' => $bunchy_option_name . '[content_cs_1_background_color]',
) ) );


// Text 1 (cs1).
$wp_customize->add_setting( $bunchy_option_name . '[content_cs_1_text1]', array(
	'default'           => $bunchy_customizer_defaults['content_cs_1_text1'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_content_cs_1_text1', array(
	'label'    => esc_html__( 'Headings &amp; Titles', 'bunchy' ),
	'section'  => 'bunchy_design_global_section',
	'settings' => $bunchy_option_name . '[content_cs_1_text1]',
) ) );


// Text 2 (cs1).
$wp_customize->add_setting( $bunchy_option_name . '[content_cs_1_text2]', array(
	'default'           => $bunchy_customizer_defaults['content_cs_1_text2'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_content_cs_1_text2', array(
	'label'    => esc_html__( 'Regular Text', 'bunchy' ),
	'section'  => 'bunchy_design_global_section',
	'settings' => $bunchy_option_name . '[content_cs_1_text2]',
) ) );


// Text 3 (cs1).
$wp_customize->add_setting( $bunchy_option_name . '[content_cs_1_text3]', array(
	'default'           => $bunchy_customizer_defaults['content_cs_1_text3'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_content_cs_1_text3', array(
	'label'       => esc_html__( 'Small Text Descriptions', 'bunchy' ),
	'description' => esc_html__( 'Post bylines, comment dates, meta information', 'bunchy' ),
	'section'     => 'bunchy_design_global_section',
	'settings'    => $bunchy_option_name . '[content_cs_1_text3]',
) ) );


// Accent 1 (cs1).
$wp_customize->add_setting( $bunchy_option_name . '[content_cs_1_accent1]', array(
	'default'           => $bunchy_customizer_defaults['content_cs_1_accent1'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_content_cs_1_accent1', array(
	'label'    => esc_html__( 'Accent', 'bunchy' ),
	'section'  => 'bunchy_design_global_section',
	'settings' => $bunchy_option_name . '[content_cs_1_accent1]',
) ) );


// Divider.
$wp_customize->add_setting( 'bunchy_global_cs_2_divider', array(
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );
$wp_customize->add_control( new Bunchy_Customize_HTML_Control( $wp_customize, 'bunchy_global_cs_2_divider', array(
	'section'  => 'bunchy_design_global_section',
	'settings' => 'bunchy_global_cs_2_divider',
	'html'     =>
		'<hr />
		<h2>' . esc_html__( 'Secondary Color Scheme', 'bunchy' ) . '</h2>
		<p>' . esc_html__( 'Will be applied to buttons, badges &amp; flags', 'bunchy' ) . '</p>',
) ) );


// Background Color (cs2).
$wp_customize->add_setting( $bunchy_option_name . '[content_cs_2_background_color]', array(
	'default'           => $bunchy_customizer_defaults['content_cs_2_background_color'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_content_cs_2_background_color', array(
	'label'    => esc_html__( 'Background', 'bunchy' ),
	'section'  => 'bunchy_design_global_section',
	'settings' => $bunchy_option_name . '[content_cs_2_background_color]',
) ) );


// Text 1 (cs2).
$wp_customize->add_setting( $bunchy_option_name . '[content_cs_2_text1]', array(
	'default'           => $bunchy_customizer_defaults['content_cs_2_text1'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_content_cs_2_text1', array(
	'label'    => esc_html__( 'Text', 'bunchy' ),
	'section'  => 'bunchy_design_global_section',
	'settings' => $bunchy_option_name . '[content_cs_2_text1]',
) ) );


