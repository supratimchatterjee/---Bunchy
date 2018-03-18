<?php
/**
 * Theme options "Dynamic style" section
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


$section_id = 'g1ui-settings-section-dynamic-styles';

add_settings_section(
	$section_id,                // ID used to identify this section and with which to register options.
	'',                         // Title to be displayed on the administration page.
	'',
	$this->get_page()           // Page on which to add this section of options.
);

// Section fields.
// Dynamic cache.
$cache_log_status = '';
$cache_log        = get_transient( 'bunchy_dynamic_style_cache_log' );

if ( false !== $cache_log && is_array( $cache_log ) ) {
	$cache_log_status .= '<br /><br />';
	$cache_log_status .= '<h4>' . esc_html__( 'Last action status', 'bunchy' ) . ':</h4>';

	$cache_log_status .= '<div class="g1-log g1-log-' . $cache_log['type'] . '">' . $cache_log['message'] . ' (' . $cache_log['date'] . ')</div>';
}

add_settings_field(
	'advanced_dynamic_style',
	esc_html__( 'Use', 'bunchy' ),
	array(
		$this,
		'render_select',
	),
	$this->get_page(),
	$section_id,
	array(
		'field_name'    => 'advanced_dynamic_style',
		'options'       => array(
			'internal'     => esc_html__( 'internal stylesheet', 'bunchy' ),
			'external_php' => esc_html__( 'external file (PHP)', 'bunchy' ),
			'external_css' => esc_html__( 'external file (CSS)', 'bunchy' ),

		),
		'default_value' => $bunchy_theme_options_defaults['advanced_dynamic_style'],
		'hint'          => $cache_log_status,
	)
);
