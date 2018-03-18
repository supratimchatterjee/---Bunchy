<?php
/**
 * WooCommerce plugin functions
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
 * Declare WooCommerce support
 */
function bunchy_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

/**
 * Render the opening markup of the content theme area
 */
function bunchy_woocommerce_content_wrapper_start() {
	?>
	<div class="g1-row g1-row-layout-page g1-row-padding-m">
	<div class="g1-row-inner">
	<div class="g1-column g1-column-2of3">

	<?php
}

/**
 * Render the closing markup of the content theme area.
 */
function bunchy_woocommerce_content_wrapper_end() {
	?>
	</div><!-- .g1-column -->
	<?php
}

/**
 * Render the closing markup of the content theme area.
 */
function bunchy_woocommerce_sidebar_wrapper_end() {
	?>
	</div>
	</div><!-- .g1-row -->
	<?php
}

