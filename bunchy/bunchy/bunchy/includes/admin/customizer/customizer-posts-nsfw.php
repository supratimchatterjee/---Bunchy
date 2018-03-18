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

$wp_customize->add_section( 'bunchy_nsfw_section', array(
	'title'    => esc_html__( 'NSFW', 'bunchy' ),
	'priority' => 350,
	'panel'    => 'bunchy_posts_panel',
) );


// Enabled?
$wp_customize->add_setting( $bunchy_option_name . '[nsfw_enabled]', array(
	'default'           => $bunchy_customizer_defaults['nsfw_enabled'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'bunchy_nsfw_enabled', array(
	'label'    => esc_html__( 'Enabled?', 'bunchy' ),
	'section'  => 'bunchy_nsfw_section',
	'settings' => $bunchy_option_name . '[nsfw_enabled]',
	'type'     => 'checkbox',
) );

// Categories ids.
$wp_customize->add_setting( $bunchy_option_name . '[nsfw_categories_ids]', array(
	'default'           => $bunchy_customizer_defaults['nsfw_categories_ids'],
	'type'              => 'option',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'bunchy_sanitize_multi_choice',
) );

$wp_customize->add_control( new Bunchy_Customize_Multi_Checkbox_Control( $wp_customize, 'bunchy_nsfw_categories_ids', array(
	'label'           => esc_html__( 'NSFW categories', 'bunchy' ),
	'section'         => 'bunchy_nsfw_section',
	'settings'        => $bunchy_option_name . '[nsfw_categories_ids]',
	'choices'         => bunchy_customizer_get_category_choices(),
	'active_callback' => 'bunchy_customizer_nsfw_enabled',
) ) );

/**
 * Check whether NSFW is enabled
 *
 * @param WP_Customize_Control $control     Control instance for which this callback is executed.
 *
 * @return bool
 */
function bunchy_customizer_nsfw_enabled( $control ) {
	$type = $control->manager->get_setting( bunchy_get_theme_id() . '[nsfw_enabled]' )->value();

	return (bool) $type;
}
