<?php
/**
 * WP Customizer panel section to customize footer design options
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

$wp_customize->add_section( 'bunchy_design_footer_section', array(
	'title'    => esc_html__( 'Footer', 'bunchy' ),
	'priority' => 80,
	'panel'    => 'bunchy_design_panel',
) );

// Background Color (cs1).
$wp_customize->add_setting( $bunchy_option_name . '[footer_cs_1_background_color]', array(
	'default'           => $bunchy_customizer_defaults['footer_cs_1_background_color'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_footer_cs_1_background_color', array(
	'label'    => esc_html__( 'Background', 'bunchy' ),
	'section'  => 'bunchy_design_footer_section',
	'settings' => $bunchy_option_name . '[footer_cs_1_background_color]',
) ) );


// Text 1 (cs1).
$wp_customize->add_setting( $bunchy_option_name . '[footer_cs_1_text1]', array(
	'default'           => $bunchy_customizer_defaults['footer_cs_1_text1'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_footer_cs_1_text1', array(
	'label'    => esc_html__( 'Headings &amp; Titles', 'bunchy' ),
	'section'  => 'bunchy_design_footer_section',
	'settings' => $bunchy_option_name . '[footer_cs_1_text1]',
) ) );


// Text 2 (cs1).
$wp_customize->add_setting( $bunchy_option_name . '[footer_cs_1_text2]', array(
	'default'           => $bunchy_customizer_defaults['footer_cs_1_text2'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_footer_cs_1_text2', array(
	'label'    => esc_html__( 'Regular Text', 'bunchy' ),
	'section'  => 'bunchy_design_footer_section',
	'settings' => $bunchy_option_name . '[footer_cs_1_text2]',
) ) );


// Text 3 (cs1).
$wp_customize->add_setting( $bunchy_option_name . '[footer_cs_1_text3]', array(
	'default'           => $bunchy_customizer_defaults['footer_cs_1_text3'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_footer_cs_1_text3', array(
	'label'    => esc_html__( 'Small Text Descriptions', 'bunchy' ),
	'section'  => 'bunchy_design_footer_section',
	'settings' => $bunchy_option_name . '[footer_cs_1_text3]',
) ) );


// Accent 1 (cs1).
$wp_customize->add_setting( $bunchy_option_name . '[footer_cs_1_accent1]', array(
	'default'           => $bunchy_customizer_defaults['footer_cs_1_accent1'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_footer_cs_1_accent1', array(
	'label'    => esc_html__( 'Accent', 'bunchy' ),
	'section'  => 'bunchy_design_footer_section',
	'settings' => $bunchy_option_name . '[footer_cs_1_accent1]',
) ) );


// Divider.
$wp_customize->add_setting( 'bunchy_footer_cs_2_divider', array(
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );
$wp_customize->add_control( new Bunchy_Customize_HTML_Control( $wp_customize, 'bunchy_footer_cs_2_divider', array(
	'section'  => 'bunchy_design_footer_section',
	'settings' => 'bunchy_footer_cs_2_divider',
	'html'     =>
		'<hr />
		<h2>' . esc_html__( 'Secondary Color Scheme', 'bunchy' ) . '</h2>
		<p>' . esc_html__( 'Will be applied to buttons, badges &amp; flags.', 'bunchy' ) . '</p>',
) ) );


// Background Color (cs2).
$wp_customize->add_setting( $bunchy_option_name . '[footer_cs_2_background_color]', array(
	'default'           => $bunchy_customizer_defaults['footer_cs_2_background_color'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_footer_cs_2_background_color', array(
	'label'    => esc_html__( 'Background', 'bunchy' ),
	'section'  => 'bunchy_design_footer_section',
	'settings' => $bunchy_option_name . '[footer_cs_2_background_color]',
) ) );


// Text 1 (cs2).
$wp_customize->add_setting( $bunchy_option_name . '[footer_cs_2_text1]', array(
	'default'           => $bunchy_customizer_defaults['footer_cs_2_text1'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bunchy_footer_cs_2_text1', array(
	'label'    => esc_html__( 'Text', 'bunchy' ),
	'section'  => 'bunchy_design_footer_section',
	'settings' => $bunchy_option_name . '[footer_cs_2_text1]',
) ) );

