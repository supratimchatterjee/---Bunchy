<?php
/**
 * Bunchy Theme functions and definitions
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

define( 'BUNCHY_THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'BUNCHY_THEME_DIR_URI', trailingslashit( get_template_directory_uri() ) );
define( 'BUNCHY_INCLUDES_DIR', trailingslashit( get_template_directory() ) . 'includes/' );
define( 'BUNCHY_ADMIN_DIR', trailingslashit( get_template_directory() ) . 'includes/admin/' );
define( 'BUNCHY_ADMIN_DIR_URI', trailingslashit( get_template_directory_uri() ) . 'includes/admin/' );
define( 'BUNCHY_FRONT_DIR', trailingslashit( get_template_directory() ) . 'includes/front/' );
define( 'BUNCHY_FRONT_DIR_URI', trailingslashit( get_template_directory_uri() ) . 'includes/front/' );
define( 'BUNCHY_PLUGINS_DIR', trailingslashit( get_template_directory() ) . 'includes/plugins/' );
define( 'BUNCHY_PLUGINS_DIR_URI', trailingslashit( get_template_directory_uri() ) . 'includes/plugins/' );

// Load common resources (required by both, admin and front, contexts).
require_once( BUNCHY_INCLUDES_DIR . 'functions.php' );

// Load context resources.
if ( is_admin() ) {
	require_once( BUNCHY_ADMIN_DIR . 'functions.php' );
} else {
	require_once( BUNCHY_FRONT_DIR . 'functions.php' );
}