<?php
/**
 * Widgets
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

/**
 * Init widgets
 */
function bunchy_widgets_init() {
	register_widget( 'Bunchy_Widget_Facebook_Page' );
	register_widget( 'Bunchy_Widget_Posts' );
	register_widget( 'Bunchy_Widget_Sticky_Start_Point' );
}

/**
 * Render closing tag for sticky sidebar wrapper
 *
 * @param int $sidebar_index    Sidebar index.
 */
function bunchy_close_sticky_sidebar_wrapper( $sidebar_index ) {
	if ( is_admin() ) {
		return;
	}

	$sticky_sidebar_opened = false;
	$sidebars_widgets      = wp_get_sidebars_widgets();

	if ( isset( $sidebars_widgets[ $sidebar_index ] ) ) {
		$widgets = $sidebars_widgets[ $sidebar_index ];

		// Check if sticky start point was added to sidebar.
		foreach ( $widgets as $widget ) {
			if ( strpos( $widget, 'bunchy_sticky_start_point_widget' ) !== false ) {
				$sticky_sidebar_opened = true;
				break;
			}
		}
	}

	// If sticky wrapper opened we need to close it.
	if ( $sticky_sidebar_opened ) {
		echo '</div>';
	}
}

