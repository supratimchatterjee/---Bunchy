<?php
/**
 * Plugin hooks
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

// Snax.
add_action( 'snax_setup_theme', 'bunchy_snax_setup' );	// On plugin activation.

if ( bunchy_can_use_plugin( 'snax/snax.php' ) ) {
	add_action( 'bunchy_after_import_content',          'bunchy_snax_set_defaults' );

	add_action( 'after_switch_theme', 'bunchy_snax_setup' ); // On theme activation.

	// It's not optimal way but it's the only one.
	// We can't hook into plugin activation because the hook process performs an instant redirect after it fires.
	// We can use recommended workaround (add_option()) but it's exaclty the same, in case of performance.
	add_action( 'admin_init', 'bunchy_snax_setup' ); // On plugin activation.

	add_filter( 'snax_get_formats',                     'bunchy_snax_change_formats_order' );
	add_filter( 'snax_get_collection_item_image_size',  'bunchy_snax_get_collection_item_image_size' );
	add_filter( 'bunchy_use_sticky_header',             'bunchy_snax_disable_sticky_header' );
	add_filter( 'bunchy_show_prefooter',                'bunchy_snax_hide_prefooter' );

	add_action( 'wp_loaded', 							'bunchy_snax_setup_header_elements' );

	// Change the location on success submissions notes.
	remove_filter( 'the_content',            'snax_item_prepend_notes' );
	add_action( 'bunchy_before_content_theme_area',     'bunchy_snax_item_render_notes' );
	remove_filter( 'the_content',            'snax_post_prepend_notes' );
	add_action( 'bunchy_before_content_theme_area',     'bunchy_snax_post_render_notes' );

	// Embed width.
	add_action( 'snax_before_card_media',               'bunchy_snax_embed_change_content_width' );
	add_action( 'snax_after_card_media',                'bunchy_snax_embed_revert_content_width' );

	add_action( 'snax_before_items_loop',               'bunchy_snax_disable_item_bar_on_single_post' );
	add_action( 'snax_after_items_loop',                'bunchy_snax_enable_item_bar_outside_single_post' );
}

// @todo - Fire only if BP installed during theme activation.
remove_action( 'bp_admin_init', 'bp_do_activation_redirect', 1 );

if ( bunchy_can_use_plugin( 'buddypress/bp-loader.php' ) ) {
	add_action( 'bunchy_after_import_content',  'bunchy_snax_bp_setup' );
	add_filter( 'snax_bp_component_main_nav',   'bunchy_snax_bp_component_main_nav', 999, 2 );

	add_action( 'bp_member_header_actions', 'bunchy_bp_member_add_button_class_filters', 1 );
	add_action( 'bp_member_header_actions', 'bunchy_bp_member_remove_button_class_filters', 9999 );

	add_action( 'bp_group_header_actions', 'bunchy_bp_group_add_button_class_filters', 1 );
	add_action( 'bp_group_header_actions', 'bunchy_bp_group_remove_button_class_filters', 9999 );

	add_filter( 'bp_get_add_friend_button', 			'bunchy_bp_get_solid_xs_button', 99 );
	add_filter( 'bp_get_group_join_button', 			'bunchy_bp_get_solid_xs_button', 99 );
	add_filter( 'bp_get_send_public_message_button', 	'bunchy_bp_get_solid_xs_button', 99 );
	add_filter( 'bp_get_send_message_button_args', 		'bunchy_bp_get_solid_xs_button', 99 );

	add_filter( 'bp_before_xprofile_cover_image_settings_parse_args', 'bunchy_cover_image_css', 10, 1 );
	add_filter( 'bp_before_groups_cover_image_settings_parse_args', 'bunchy_cover_image_css', 10, 1 );

	add_action( 'snax_template_after_list_items_loop', 'bunchy_render_markup_after_list_items_loop' );

	add_action( 'snax_template_before_list_items_loop', 'bunchy_render_markup_before_list_items_loop' );

	add_filter( 'bp_directory_members_search_form', 'bunchy_bp_directory_search_form' );
	add_filter( 'bp_directory_groups_search_form', 'bunchy_bp_directory_search_form' );

	add_filter( 'author_link', 'bunchy_bp_get_author_link', 10, 3 );
}

// Wordpress Popular Posts.
if ( bunchy_can_use_plugin( 'wordpress-popular-posts/wordpress-popular-posts.php' ) ) {
	add_action( 'widgets_init', 'bunchy_wpp_remove_widget' );
	add_filter( 'bunchy_most_viewed_query_args', 'bunchy_wpp_get_most_viewed_query_args', 10, 2 );
	add_filter( 'bunchy_entry_view_count', 'bunchy_wpp_get_view_count' );
}

// Mashshare.
add_action( 'after_setup_theme', 'bunchy_mashsharer_disable_welcome_redirect' );

// Only core loaded.
if ( bunchy_can_use_plugin( 'mashsharer/mashshare.php' ) ) {
	add_filter( 'bunchy_most_shared_query_args',    'bunchy_mashsharer_get_most_shared_query_args', 10, 2 );
	add_filter( 'bunchy_entry_share_count',         'bunchy_mashsharer_get_share_count' );
	add_filter( 'bunchy_show_entry_share_count',    'bunchy_mashsharer_show_share_count', 10, 2 );
	add_action( 'bunchy_after_import_content',      'bunchy_mashsharer_set_defaults' );

	// Custom caching rules to not refresh counters on archives.
	// Curl requests coast too much, so reload cache only on a single page.
	if ( ! is_admin() ) {
		add_action( 'init',         'bunchy_mashsharer_init_custom_caching_rules' );
		add_filter( 'the_content',  'bunchy_mashsharer_activate_curl', 1 );
		add_filter( 'the_content',  'bunchy_mashsharer_deactivate_curl', 9999 );
	}
}

// Core loaded but not Networks addon.
if ( bunchy_can_use_plugin( 'mashsharer/mashshare.php' ) && ! bunchy_can_use_plugin( 'mashshare-networks/mashshare-networks.php' ) ) {
	add_filter( 'mashsb_array_networks',    'bunchy_mashsharer_array_networks' );
	add_action( 'init',                     'bunchy_mashsharer_register_new_networks' );
	add_action( 'plugins_loaded',           'bunchy_mashsharer_add_networks_class' );
}

// Core and Networks addon loaded.
if ( bunchy_can_use_plugin( 'mashsharer/mashshare.php' ) && bunchy_can_use_plugin( 'mashshare-networks/mashshare-networks.php' ) ) {
	add_action( 'init', 'bunchy_mashsharer_deregister_new_networks' );
}

// Core and ShareBar addon loaded.
if ( bunchy_can_use_plugin( 'mashsharer/mashshare.php' ) && bunchy_can_use_plugin( 'mashshare-sharebar/mashshare-sharebar.php' ) ) {
	// Disable our built-in bar.
	add_filter( 'bunchy_show_sharebar', '__return_false', 99 );
}

// Mailchimp for WP.
if ( bunchy_can_use_plugin( 'mailchimp-for-wp/mailchimp-for-wp.php' ) ) {
	add_filter( 'mc4wp_form_before_fields', 'bunchy_mc4wp_form_before_form', 10, 2 );
	add_filter( 'mc4wp_form_after_fields', 'bunchy_mc4wp_form_after_form', 10, 2 );
	add_action( 'bunchy_after_import_content', 'bunchy_mc4wp_set_up_default_form_id' );
}

// WP QUADS - Quick AdSense Reloaded.
add_action( 'after_setup_theme', 'bunchy_quads_disable_welcome_redirect' );

if ( bunchy_can_use_plugin( 'quick-adsense-reloaded/quick-adsense-reloaded.php' ) ) {
	add_action( 'after_setup_theme', 'bunchy_quads_register_ad_locations' );
	add_filter( 'quads_has_ad', 'bunchy_quads_hide_ads', 10, 2 );
}

// WooCommerce.
if ( bunchy_can_use_plugin( 'woocommerce/woocommerce.php' ) ) {
	add_action( 'after_setup_theme', 'bunchy_woocommerce_support' );
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	add_action( 'woocommerce_before_main_content', 'bunchy_woocommerce_content_wrapper_start', 10 );
	add_action( 'woocommerce_after_main_content', 'bunchy_woocommerce_content_wrapper_end', 10 );
	add_action( 'woocommerce_sidebar', 'bunchy_woocommerce_sidebar_wrapper_end', 10 );
}

// Loco Translate.
if ( bunchy_can_use_plugin( 'loco-translate/loco.php' ) ) {
	add_action( 'admin_notices', 'bunchy_loco_notices' );
	add_action( 'admin_enqueue_scripts', 'bunchy_logo_admin_enqueue_scripts' );
}

// Auto Load Next Post.
if ( bunchy_can_use_plugin( 'auto-load-next-post/auto-load-next-post.php' ) ) {
	// Disable plugin's partial location function that doesn't support child themes.
	remove_action( 'template_redirect', 'auto_load_next_post_template_redirect' );

	// Use custom function with child theme support (till plugin doesn't fix it).
	add_action( 'template_redirect', 'bunchy_auto_load_next_post_template_redirect' );

	add_filter( 'auto_load_next_post_general_settings', 'bunchy_auto_load_next_post_general_settings' );

	// Return values valid for the theme.
	add_filter( 'pre_option_auto_load_next_post_content_container', 	'bunchy_auto_load_next_post_content_container' );
	add_filter( 'pre_option_auto_load_next_post_title_selector', 		'bunchy_auto_load_next_post_title_selector' );
	add_filter( 'pre_option_auto_load_next_post_navigation_container', 	'bunchy_auto_load_next_post_navigation_container' );
	add_filter( 'pre_option_auto_load_next_post_comments_container',	'bunchy_auto_load_next_post_comments_container' );
}

// Facebook Comments.
if ( bunchy_can_use_plugin( 'facebook-comments-plugin/facebook-comments.php' ) ) {
	// Disable plugin default location.
	remove_filter( 'the_content', 'fbcommentbox', 100 );

	// Override comments template with FB comments.
	add_filter( 'comments_template', 'bunchy_fb_comments_template' );
}
