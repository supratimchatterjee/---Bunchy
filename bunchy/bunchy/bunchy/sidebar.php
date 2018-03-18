<?php
/**
 * The sidebar containing the main widget area
 *
 * If no active widgets are in the sidebar, hide it completely.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
?>
<div id="secondary" class="g1-column g1-column-1of3">
	<?php
	$bunchy_default_sidebar = apply_filters( 'bunchy_default_sidebar', 'primary' );
	$bunchy_sidebar         = '';

	if ( is_home() ) {
		$bunchy_sidebar = 'home';
	}
	if ( is_page() ) {
		$bunchy_sidebar = 'page';
	}
	if ( is_single() ) {
		$bunchy_sidebar = 'post_single';
	}
	if ( is_archive() ) {
		$bunchy_sidebar = 'post_archive';
	}

	if ( empty( $bunchy_sidebar ) || ! is_active_sidebar( $bunchy_sidebar ) ) {
		$bunchy_sidebar = $bunchy_default_sidebar;
	}

	dynamic_sidebar( $bunchy_sidebar );
	?>
</div><!-- #secondary -->


