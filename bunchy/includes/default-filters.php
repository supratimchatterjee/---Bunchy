<?php
/**
 * Sets up the default filters and actions.
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

// Set up.
add_action( 'after_setup_theme', 'bunchy_setup_theme' );
add_action( 'after_switch_theme', 'bunchy_load_default_options' );
add_action( 'widgets_init', 'bunchy_setup_sidebars', 1 );
add_action( 'after_setup_theme', 'bunchy_setup_wpml' );
add_action( 'after_setup_theme', 'bunchy_setup_content_width', 0 );
add_filter( 'widget_title', 'bunchy_allow_empty_widget_title', 9999 );

// Widgets.
add_action( 'widgets_init', 'bunchy_widgets_init' );
add_action( 'dynamic_sidebar_after', 'bunchy_close_sticky_sidebar_wrapper', 10, 2 );

// Lists.
add_action( 'bunchy_update_hot_posts',      'bunchy_calculate_hot_posts' );
add_action( 'bunchy_update_popular_posts',  'bunchy_calculate_popular_posts' );
add_action( 'bunchy_update_trending_posts', 'bunchy_calculate_trending_posts' );

// Lists.
add_filter( 'bunchy_popular_post_ids',     'bunchy_calculate_popular_post_ids_if_empty', 10, 2 );
add_filter( 'bunchy_hot_post_ids',         'bunchy_calculate_hot_post_ids_if_empty', 10, 2 );
add_filter( 'bunchy_trending_post_ids',    'bunchy_calculate_trending_post_ids_if_empty', 10, 2 );

// Embeds.
add_filter( 'embed_defaults', 'bunchy_embed_defaults', 10, 2 );
add_filter( 'embed_oembed_html', 'bunchy_fluid_wrapper_embed_oembed_html', 10, 999 );
add_filter( 'bunchy_apply_fluid_wrapper_for_oembed', 'bunchy_apply_fluid_wrapper_for_services', 10, 2 );
