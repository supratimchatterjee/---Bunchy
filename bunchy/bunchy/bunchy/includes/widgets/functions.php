<?php
/**
 * Widget resources loader
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

require_once( BUNCHY_INCLUDES_DIR . 'widgets/widgets.php' );
require_once( BUNCHY_INCLUDES_DIR . 'widgets/lib/class-bunchy-widget-facebook-page.php' );
require_once( BUNCHY_INCLUDES_DIR . 'widgets/lib/class-bunchy-widget-posts.php' );
require_once( BUNCHY_INCLUDES_DIR . 'widgets/lib/class-bunchy-widget-sticky-start-point.php' );

