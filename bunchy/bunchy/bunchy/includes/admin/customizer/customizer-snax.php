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

$wp_customize->add_section( 'bunchy_snax_section', array(
	'title'    => esc_html__( 'Snax', 'bunchy' ),
	'priority' => 500,
) );

// Featured Entries.
$wp_customize->add_setting( $bunchy_option_name . '[snax_header_type]', array(
	'default'           => $bunchy_customizer_defaults['snax_header_type'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_snax_header_type', array(
	'label'    => esc_html__( 'Header on Submission Pages', 'bunchy' ),
	'section'  => 'bunchy_snax_section',
	'settings' => $bunchy_option_name . '[snax_header_type]',
	'type'     => 'select',
	'choices'  => array(
		'normal'	=> esc_html__( 'Normal', 'bunchy' ),
		'simple'	=> esc_html__( 'Simplified', 'bunchy' ),
	),
) );
