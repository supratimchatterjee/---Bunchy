<?php
/**
 * Default options for WP Customizer
 *
 * @license For the full license information, please view the Licensing folder
 * that was distributed with this source code.
 *
 * @package Bunchy_Theme
 */

$bunchy_customizer_defaults = array(
	// Site Identity.
	'branding_show_tagline'                  => true,
	'branding_logo'                          => '',
	'branding_logo_width'                    => '',
	'branding_logo_height'                   => '',
	'branding_logo_hdpi'                     => '',
	'footer_text'                            => '',
	'footer_stamp'                           => '',
	'footer_stamp_width'                     => '',
	'footer_stamp_height'                    => '',
	'footer_stamp_hdpi'                      => '',
	'footer_stamp_label'                     => '',
	'footer_stamp_url'                       => '',

	// Static Front Page.
	'home_template'                          => 'classic-sidebar',
	'home_featured_entries'                  => 'none',
	'home_featured_entries_category'         => '',
	'home_featured_entries_tag'              => array( '' ),
	'home_featured_entries_time_range'       => 'all',
	'home_featured_entries_hide_elements'    => '',
	'home_pagination'                        => 'infinite-scroll-on-demand',
	'home_hide_elements'                     => '',
	'home_newsletter'                        => 'standard',
	'home_newsletter_after_post'             => 2,
	'home_ad'                                => 'standard',
	'home_ad_after_post'                     => 6,

	// Posts > Global.
	'posts_latest_page'                      => true,
	'posts_hot_page'                         => '',
	'posts_popular_page'                     => '',
	'posts_trending_page'                    => '',
	'posts_views_threshold'                  => 10,
	'posts_comments_threshold'               => 1,
	'posts_timeago'                          => 'standard',

	// Posts > Single.
	'post_template'                          => 'sidebar',
	'post_hide_elements'                     => '',
	'post_sharebar'                          => 'standard',
	'post_pagination_overview'               => 'page_links',
	'post_pagination_adjacent_label'         => 'adjacent',
	'post_pagination_adjacent_style'         => 'link',
	'post_dont_miss_hide_elements'           => 'categories,summary,views,comments_link',
	'post_related_hide_elements'             => 'summary,author,date,views,comments_link',
	'post_more_from_hide_elements'           => 'categories,summary,views,comments_link',

	// Posts > Archive.
	'archive_template'                       => 'three-featured-grid-sidebar',
	'archive_featured_entries'               => 'recent',
	'archive_featured_entries_time_range'    => 'all',
	'archive_featured_entries_hide_elements' => '',
	'archive_posts_per_page'                 => 12,
	'archive_pagination'                     => 'infinite-scroll-on-demand',
	'archive_hide_elements'                  => '',
	'archive_newsletter'                     => 'standard',
	'archive_newsletter_after_post'          => 2,
	'archive_ad'                             => 'standard',
	'archive_ad_after_post'                  => 6,

	// Featured Entries.
	'featured_entries_visibility'            => 'home,single_post',
	'featured_entries_type'                  => 'recent',
	'featured_entries_category'              => '',
	'featured_entries_tag'                   => array( '' ),
	'featured_entries_time_range'            => 'all',
	'featured_entries_hide_elements'         => '',

	// Design > Global.
	'global_layout'                          => 'stretched',
	'global_width'                           => '1280',
	'global_google_font_subset'              => 'latin,latin-ext',
	'global_background_color'                => '#e6e6e6',
	'content_cs_1_background_color'          => '#ffffff',
	'content_cs_1_text1'                     => '#000000',
	'content_cs_1_text2'                     => '#666666',
	'content_cs_1_text3'                     => '#999999',
	'content_cs_1_accent1'                   => '#ff552e',
	'content_cs_2_background_color'          => '#ff552e',
	'content_cs_2_text1'                     => '#ffffff',

	// Design > Header.
	'header_sticky'                          => 'standard',
	'header_logo_margin_top'                 => '15',
	'header_logo_margin_bottom'              => '15',
	'header_quicknav_margin_top'             => '15',
	'header_quicknav_margin_bottom'          => '15',
	'header_text_color'                      => '#000000',
	'header_accent_color'                    => '#ff552e',
	'header_background_color'                => '#ffffff',
	'header_secondary_text_color'            => '#ffffff',
	'header_secondary_background_color'      => '#ff552e',
	'header_navbar_background_color'         => '#f2f2f2',
	'header_navbar_text_color'               => '#666666',
	'header_navbar_accent_color'             => '#ff552e',
	'header_submenu_background_color'        => '#4d4d4d',
	'header_submenu_text_color'              => '#ffffff',
	'header_submenu_accent_color'            => '#ff552e',

	// Design > Footer.
	'footer_cs_1_background_color'           => '#f2f2f2',
	'footer_cs_1_text1'                      => '#000000',
	'footer_cs_1_text2'                      => '#666666',
	'footer_cs_1_text3'                      => '#999999',
	'footer_cs_1_accent1'                    => '#ff552e',
	'footer_cs_2_background_color'           => '#ff552e',
	'footer_cs_2_text1'                      => '#ffffff',

	// NSFW.
	'nsfw_enabled'                       	 => true,
	'nsfw_categories_ids'                    => 'nsfw',

	// Newsletter.
	'newsletter_title'                       => esc_html__( 'Want more stuff like this?', 'bunchy' ),
	'newsletter_subtitle'                    => esc_html__( 'Get the best viral stories straight into your inbox!', 'bunchy' ),
	'newsletter_compact_title'               => esc_html__( 'Get the best viral stories straight into your inbox!', 'bunchy' ),
	'newsletter_privacy'               		 => 'Don\'t worry, we don\'t spam',

	// Snax.
	'snax_header_type'                       => 'simple',
);
