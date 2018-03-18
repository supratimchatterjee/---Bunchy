<?php
/**
 * Admin resources loader
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

require_once( BUNCHY_ADMIN_DIR . 'default-filters.php' );
require_once( BUNCHY_ADMIN_DIR . 'common.php' );
require_once( BUNCHY_ADMIN_DIR . 'tgm-config.php' );
require_once( BUNCHY_ADMIN_DIR . 'theme-activation.php' );
require_once( BUNCHY_ADMIN_DIR . 'demo-content.php' );
require_once( BUNCHY_ADMIN_DIR . 'theme-options/theme-options.php' );
require_once( BUNCHY_ADMIN_DIR . 'metaboxes/page-single-options.php' );

