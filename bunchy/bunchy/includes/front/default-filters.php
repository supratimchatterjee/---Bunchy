<?php
/**
 * Front hooks
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
// Body classes.
add_filter( 'body_class', 'bunchy_body_class_global_layout' );
add_filter( 'body_class', 'bunchy_body_class_helpers' );

// Post.
add_filter( 'single_template', 'bunchy_post_alter_single_template' );
add_filter( 'post_class', 'bunchy_post_class', 20 );

// Archive.
add_filter( 'home_template', 'bunchy_home_alter_template' );
add_action( 'bunchy_home_loop_after_post', 'bunchy_home_inject_newsletter_into_loop', 10, 2 );
add_filter( 'bunchy_home_loop_after_post', 'bunchy_home_inject_ad_into_loop', 10, 2 );
add_action( 'pre_get_posts', 'bunchy_home_set_posts_per_page' );
add_action( 'pre_get_posts', 'bunchy_home_exclude_featured' );
add_filter( 'found_posts', 'bunchy_home_adjust_offset_pagination', 1, 2 );
add_action( 'bunchy_archive_loop_after_post', 'bunchy_archive_inject_newsletter_into_loop', 10, 2 );
add_filter( 'bunchy_archive_loop_after_post', 'bunchy_archive_inject_ad_into_loop', 10, 2 );
add_action( 'pre_get_posts', 'bunchy_archive_set_posts_per_page' );
add_action( 'pre_get_posts', 'bunchy_archive_exclude_featured' );
add_filter( 'found_posts', 'bunchy_archive_adjust_offset_pagination', 1, 2 );

// Lists.
add_action( 'init', 'bunchy_update_lists' );

// Page.
add_filter( 'wp_link_pages_args', 'bunchy_filter_wp_link_pages_args' );
add_filter( 'wp_link_pages_link', 'bunchy_filter_wp_link_pages_link', 10, 2 );

// Hot/Popular/Trending.
add_filter( 'the_content', 'bunchy_list_hot_entries', 11 );
add_filter( 'the_content', 'bunchy_list_popular_entries', 11 );
add_filter( 'the_content', 'bunchy_list_trending_entries', 11 );

// Comments.
add_filter( 'comment_form_default_fields', 'bunchy_comment_form_default_fields' );
add_filter( 'comment_form_field_comment', 'bunchy_comment_form_field_comment' );
add_action( 'comment_form_top', 'bunchy_comment_render_avatar_before_form' );
add_filter( 'show_recent_comments_widget_style', '__return_false' );

// Enqueue assets.
add_action( 'wp_head', 'bunchy_internal_dynamic_styles' );
add_action( 'wp_head', 'bunchy_render_head_scripts', 5 );
add_action( 'wp_enqueue_scripts', 'bunchy_enqueue_head_styles' );
add_action( 'wp_enqueue_scripts', 'bunchy_enqueue_front_scripts' );
add_filter( 'script_loader_tag', 'bunchy_load_front_scripts_conditionally', 10, 2 );

// Meta tags.
add_action( 'wp_head', 'bunchy_add_responsive_design_meta_tag', 1 );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

// Other.
add_filter( 'wp_list_categories', 'bunchy_insert_cat_count_span' );
add_filter( 'get_archives_link', 'bunchy_insert_archive_count_span' );
add_filter( 'get_calendar', 'bunchy_alter_calendar_output' );
add_filter( 'bunchy_show_sharebar', 'bunchy_hide_sharebar' );
add_filter( 'get_the_excerpt', 'bunchy_excerpt_more' );

// Shortcodes.
add_filter( 'shortcode_atts_video', 'bunchy_wp_video_shortcode_atts', 10, 3 );

// Dynamic style cache.
add_action( 'template_redirect', 'bunchy_load_dynamic_styles' );
