<?php
/**
 * Mashshare plugin functions
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
 * Return share count from Mashsharer
 *
 * @return int
 */
function bunchy_mashsharer_get_share_count() {
	$url    = mashsb_get_url();
	$number = getSharedcount( $url );

	return $number;
}

/**
 * Check whether to show or now share count
 *
 * @param bool $show            Current state.
 * @param int  $share_count     Number of shares.
 *
 * @return bool
 */
function bunchy_mashsharer_show_share_count( $show, $share_count ) {
	$settings = mashsb_get_settings();

	$share_count_threshold = isset( $settings['hide_sharecount'] ) ? $settings['hide_sharecount'] : 0;

	if ( absint( $share_count ) < absint( $share_count_threshold ) ) {
		$show = false;
	}

	return $show;
}


/**
 * Get query arguments for the most shared collection
 *
 * @param array $query_args Query arguments.
 *
 * @return array
 */
function bunchy_mashsharer_get_most_shared_query_args( $query_args ) {
	$defaults = array(
		'posts_per_page'      => 10,
		'ignore_sticky_posts' => true,
		'meta_key'            => 'mashsb_shares',
		'orderby'             => 'meta_value_num',
		'order'               => 'DESC',
		// This way we can be sure that only "shared" posts will be used.
		'meta_query'          => array(
			array(
				'key'     => 'mashsb_shares',
				'compare' => '>',
				'value'   => 0,
			),
		),
	);

	$query_args = wp_parse_args( $query_args, $defaults );

	return $query_args;
}

/**
 * Add custom newtworks for Mashsharer
 *
 * @param array $networks       Available network list.
 *
 * @return array
 */
function bunchy_mashsharer_array_networks( $networks ) {
	$image     = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium' );
	$image_url = $image ? $image[0] : '';

	if ( ! isset( $networks['pinterest'] ) ) {
		$networks['pinterest'] = 'https://www.pinterest.com/pin/create/button/?url=' . $networks['url'] . '&media=' . $image_url . '&description=' . $networks['title'];
	}

	if ( ! isset( $networks['google'] ) ) {
		$networks['google'] = 'https://plus.google.com/share?url=' . $networks['url'];
	}

	return $networks;
}

/**
 * Init custom caching rules.
 */
function bunchy_mashsharer_init_custom_caching_rules() {
	if ( false === apply_filters( 'bunchy_mashsharer_custom_cache', true ) ) {
		return;
	}

	global $mashsb_options;

	if ( isset( $mashsb_options ) ) {
		$default_cache = isset( $mashsb_options['mashsharer_cache'] ) ? $mashsb_options['mashsharer_cache'] : 21600; // 6h, from theme defaults.

		// Store default and new values for further use.
		$mashsb_options['mashsharer_default_cache'] = $default_cache;
		$mashsb_options['mashsharer_custom_cache'] = 2592000; // One month.

		bunchy_mashsharer_enable_custom_caching_rules();
	}
}

/**
 * Enable custom caching rules.
 */
function bunchy_mashsharer_enable_custom_caching_rules() {
	bunchy_mashsharer_switch_cache( 'mashsharer_custom_cache' );
}

/**
 * Enable custom caching rules.
 */
function bunchy_mashsharer_disable_custom_caching_rules() {
	bunchy_mashsharer_switch_cache( 'mashsharer_default_cache' );
}

/**
 * Change cache value by type
 *
 * @param string $type         Cache type: mashsharer_custom_cache | mashsharer_default_cache.
 */
function bunchy_mashsharer_switch_cache( $type ) {
	global $mashsb_options;

	if ( isset( $mashsb_options ) && isset( $mashsb_options[ $type ] ) ) {
		$mashsb_options['mashsharer_cache'] = $mashsb_options[ $type ];
	}
}

/**
 * Activate remote calls (for fetching current shares count) when entering singe post content.
 *
 * @param string $content           Post content.
 *
 * @return string
 */
function bunchy_mashsharer_activate_curl( $content ) {
	if ( apply_filters( 'bunchy_mashsharer_custom_cache', true ) && is_single() ) {
		bunchy_mashsharer_disable_custom_caching_rules();
	}

	return $content;
}

/**
 * Deactivate remote calls when leaving singe post content.
 *
 * @param string $content           Post content.
 *
 * @return string
 */
function bunchy_mashsharer_deactivate_curl( $content ) {
	if ( apply_filters( 'bunchy_mashsharer_custom_cache', true ) && is_single() ) {
		bunchy_mashsharer_enable_custom_caching_rules();
	}

	return $content;
}

/**
 * Register custom networks
 */
function bunchy_mashsharer_register_new_networks() {
	$networks = get_option( 'mashsb_networks' );

	// These networks can be already added by addon.
	if ( ! in_array( 'Pinterest', $networks, true ) ) {
		$networks[] = esc_html__( 'Pinterest', 'bunchy' );
	}

	if ( ! in_array( 'Google', $networks, true ) ) {
		$networks[] = esc_html__( 'Google', 'bunchy' );
	}

	update_option( 'mashsb_networks', $networks );
}

/**
 * Deregister custom networks
 */
function bunchy_mashsharer_deregister_new_networks() {
	$networks = get_option( 'mashsb_networks' );

	$custom_pinterest 	= isset( $networks[3] ) && 'Pinterest' === $networks[3];
	$custom_google 		= isset( $networks[4] ) && 'Google' === $networks[4];

	if ( $custom_pinterest && $custom_google ) {
		unset( $networks[3] );
		unset( $networks[4] );

		// Now should be only 3 networks loaded: FB, Twitter, Subscirbe.
		// But during Mashshare Networks addon activation new networks (e.g. Telegram) are added unconditionally
		// so we need to remove it here. It'll be added again after the call MashshareNetworks::mashnet_during_activation();

		// Telegram.
		$telegram_added = isset( $networks[5] ) && 'Telegram' === $networks[5];

		if ( $telegram_added ) {
			unset( $networks[5] ); // Telegram.
		}

		// Flipboard, overrides Telegram so index is also 5 here.
		$flipboard_added = isset( $networks[5] ) && 'Flipboard' === $networks[5];

		if ( $flipboard_added ) {
			unset( $networks[5] ); // Flipboard.
		}

		// Hackernews.
		$hackernews_added = isset( $networks[6] ) && 'Hackernews' === $networks[6];

		if ( $hackernews_added ) {
			unset( $networks[6] ); // Hackernews.
		}

		// Update db.
		update_option( 'mashsb_networks', $networks );

		// Run activation function again to load addon networks.
		MashshareNetworks::mashnet_during_activation();
	}
}

/**
 * Create networks class if needed
 */
function bunchy_mashsharer_add_networks_class() {
	if ( ! class_exists( 'MashshareNetworks' ) ) {
		/**
		 * Class MashshareNetworks
		 */
		class MashshareNetworks {
			// This class is required to enable custom networks counting.
			// It won't be used if "MashshareNetworks" add-on is installed.
		}
	}
}

/**
 * Disable MashShare welcome page redirect.
 *
 * We use TGM Plugin Activation to install some plugins.
 * We must be sure there are no redirects during the activation queue.
 */
function bunchy_mashsharer_disable_welcome_redirect() {
	delete_transient( '_mashsb_activation_redirect' );
}

/**
 * Set default option values for fresh MashShare plugin installations.
 */
function bunchy_mashsharer_set_defaults() {
	$settings = get_option( 'mashsb_settings', array() );

	// Skip if already set.
	if ( ! empty( $settings ) ) {
		return;
	}

	$defaults = array(
		'mashsharer_cache'    => '21600', // 6 hours.
		'hide_sharecount'     => '1',
		'mashsharer_round'    => '1',
		'subscribe_behavior'  => 'link',
		'mashsharer_position' => 'both',
		'post_types'          => array(
			'post' => 'post',
		),
		'visible_services'    => '1',
		'networks'            => array(
			// Facebook.
			array(
				'id'     => 'facebook',
				'status' => '1',
				'name'   => '',
			),
			// Twitter.
			array(
				'id'     => 'twitter',
				'status' => '1',
				'name'   => '',
			),
			// Subscribe.
			array(
				'id'     => 'subscribe',
				'status' => '1',
				'name'   => '',
			),
			// Pinterest.
			array(
				'id'     => 'pinterest',
				'status' => '1',
				'name'   => '',
			),
			// Google.
			array(
				'id'     => 'google',
				'status' => '1',
				'name'   => '',
			),
		),
	);

	update_option( 'mashsb_settings', $defaults );
}
