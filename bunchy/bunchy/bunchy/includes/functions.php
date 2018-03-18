<?php
/**
 * Common resources loader
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

require_once( BUNCHY_INCLUDES_DIR . 'default-filters.php' );
require_once( BUNCHY_INCLUDES_DIR . 'theme-setup.php' );
require_once( BUNCHY_INCLUDES_DIR . 'theme.php' );
require_once( BUNCHY_INCLUDES_DIR . 'plugins/functions.php' );
require_once( BUNCHY_INCLUDES_DIR . 'widgets/functions.php' );

/**
 * Below files need to be loaded for both contexts.
 */

// Uses backend panel and frontend preview.
require_once( BUNCHY_ADMIN_DIR . 'customizer/customizer.php' );

// Customizer (backend) decides if cache is stale or still valid, frontend uses cached version.
require_once( BUNCHY_FRONT_DIR . 'dynamic-style-cache.php' );

