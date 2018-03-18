<?php
/**
 * Admin hooks
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

// Post.
add_filter( 'manage_posts_columns',         'bunchy_post_list_add_id_column' );
add_action( 'manage_posts_custom_column',   'bunchy_post_list_render_id_column' );
add_filter( 'manage_posts_columns',         'bunchy_post_list_custom_columns' );
add_action( 'manage_posts_custom_column',   'bunchy_post_list_custom_columns_data', 10, 2 );

// Enqueue assets.
add_action( 'admin_enqueue_scripts', 'bunchy_admin_enqueue_styles' );
add_action( 'admin_enqueue_scripts', 'bunchy_admin_enqueue_scripts' );

// Ajax.
add_action( 'wp_ajax_bunchy_change_mode_to_normal',         'bunchy_ajax_change_mode_to_normal' );
add_action( 'wp_ajax_bunchy_change_mode_to_in_progress',    'bunchy_ajax_change_mode_to_in_progress' );

// Theme Activation.
add_action( 'after_switch_theme',                   'bunchy_redirect_to_welcome_page' );
add_action( 'load-appearance_page_theme-options',   'bunchy_load_welcome_page_until_installation_complete' );

// TGM.
add_action( 'tgmpa_register', 'bunchy_register_required_plugins' );
add_action( 'bunchy_tgm_plugins_config', 'bunchy_register_wordpress_importer' );

// Dynamic style cache.
add_action( 'customize_save', 'bunchy_dynamic_style_mark_cache_as_stale' );
add_action( 'update_option_' . bunchy_get_theme_options_id(), 'bunchy_dynamic_style_theme_option_changed', 999, 2 );

// Styles.
add_action( 'admin_init', 'bunchy_add_editor_styles' );

// Demo content.
add_action( 'admin_init', 'bunchy_handle_import_action' );
add_action( 'admin_action_bunchy_import_demo', 'bunchy_import_demo' );

// Cache.
add_action( 'save_post',        'bunchy_delete_transients' );     // Fires once a post has been saved.
add_action( 'deleted_post',     'bunchy_delete_transients' );     // Fires immediately after a post is deleted from the database.
add_action( 'switch_theme',     'bunchy_delete_transients' );     // Fires once user activate/deactivate the theme.
