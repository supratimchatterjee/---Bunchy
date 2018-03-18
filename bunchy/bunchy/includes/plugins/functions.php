<?php
/**
 * Plugin resources loader
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

require_once( BUNCHY_PLUGINS_DIR . 'default-filters.php' );

if ( bunchy_can_use_plugin( 'snax/snax.php' ) ) {
	require_once( BUNCHY_PLUGINS_DIR . 'snax.php' );
}

if ( bunchy_can_use_plugin( 'buddypress/bp-loader.php' ) ) {
	require_once( BUNCHY_PLUGINS_DIR . 'buddypress.php' );
}

if ( bunchy_can_use_plugin( 'wordpress-popular-posts/wordpress-popular-posts.php' ) ) {
	require_once( BUNCHY_PLUGINS_DIR . 'wordpress-popular-posts.php' );
}

if ( bunchy_can_use_plugin( 'mailchimp-for-wp/mailchimp-for-wp.php' ) ) {
	require_once( BUNCHY_PLUGINS_DIR . 'mailchimp-for-wp.php' );
}

if ( bunchy_can_use_plugin( 'woocommerce/woocommerce.php' ) ) {
	require_once( BUNCHY_PLUGINS_DIR . 'woocommerce.php' );
}

if ( bunchy_can_use_plugin( 'loco-translate/loco.php' ) ) {
	require_once( BUNCHY_PLUGINS_DIR . 'loco-translate.php' );
}

if ( bunchy_can_use_plugin( 'auto-load-next-post/auto-load-next-post.php' ) ) {
	require_once( BUNCHY_PLUGINS_DIR . 'auto-load-next-post.php' );
}

if ( bunchy_can_use_plugin( 'facebook-comments-plugin/facebook-comments.php' ) ) {
	require_once( BUNCHY_PLUGINS_DIR . 'facebook-comments.php' );
}

// Load without condition check, below files contain functions that have to be loaded even if plugin is not activated.
require_once( BUNCHY_PLUGINS_DIR . 'mashsharer.php' );
require_once( BUNCHY_PLUGINS_DIR . 'quick-adsense-reloaded.php' );
