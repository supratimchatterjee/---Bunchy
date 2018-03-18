<?php
/**
 * Theme setup functions
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
 * Set up the theme
 */
function bunchy_setup_theme() {
	// Make theme available for translation.
	load_theme_textdomain( 'bunchy', BUNCHY_THEME_DIR . 'languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'bunchy-grid-standard', 364, round( 364 * 9 / 16 ), true );
	add_image_size( 'bunchy-list-standard', 364, round( 364 * 9 / 16 ), true );

	add_image_size( 'bunchy-grid-fancy', 364, round( 364 * 9 / 21 ), true );
	add_image_size( 'bunchy-list-fancy', 364, round( 364 * 9 / 21 ), true );

	add_image_size( 'bunchy-index', 638, 9999 );
	add_image_size( 'bunchy-grid-2of3', 758, 9999 );

	add_image_size( 'bunchy-tile', 638, round( 638 * 9 / 16 ), true );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Enable support for Post Formats.
	add_theme_support(
		'post-formats',
		array(
			'aside',
			'gallery',
			'link',
			'image',
			'quote',
			'status',
			'video',
			'audio',
			'chat',
		)
	);

	// This theme uses wp_nav_menu() in three locations.
	register_nav_menus( array(
		'bunchy_primary_nav'    => esc_html__( 'Primary Navigation', 'bunchy' ),
		'bunchy_user_nav'       => esc_html__( 'User Navigation', 'bunchy' ),
		'bunchy_footer_nav'     => esc_html__( 'Footer Navigation', 'bunchy' ),
	) );
}

/**
 * Load default theme options
 */
function bunchy_load_default_options() {
	$theme_id = bunchy_get_theme_id();

	// Load options for WP Admin > Appearance > Customize.
	$customizer_option_name = $theme_id;
	$customizer_options     = get_option( $customizer_option_name );

	if ( ! $customizer_options ) {
		include_once( BUNCHY_ADMIN_DIR . 'customizer/customizer-defaults.php' );

		if ( isset( $bunchy_customizer_defaults ) ) {
			update_option( $customizer_option_name, $bunchy_customizer_defaults );
		}
	}

	// Load options for WP Admin > Appearance > Theme Options.
	$theme_option_name = $theme_id . '_options';
	$theme_options     = get_option( $theme_option_name );

	if ( ! $theme_options ) {
		require( BUNCHY_ADMIN_DIR . 'theme-options/theme-defaults.php' );

		if ( isset( $bunchy_theme_options_defaults ) ) {
			update_option( $theme_option_name, $bunchy_theme_options_defaults );
		}
	}
}

/**
 * Set up WPML plugin
 */
function bunchy_setup_wpml() {
	if ( bunchy_can_use_plugin( 'sitepress-multilingual-cms/sitepress.php' ) ) {

		// Remove @lang from term title.
		global $sitepress;

		if ( $sitepress ) {
			add_filter( 'single_term_title', array( $sitepress, 'the_category_name_filter' ) );
		}

		define( 'ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true );
	}
}

/**
 * Set up sidebars
 */
function bunchy_setup_sidebars() {
	$custom_sidebars = get_option( 'bunchy_custom_sidebars', array() );

	$core_sidebars = bunchy_get_predefined_sidebars();

	$sidebars = array_merge( $core_sidebars, $custom_sidebars );

	$sidebars = apply_filters( 'bunchy_setup_sidebars', $sidebars );

	if ( count( $sidebars ) ) {
		foreach ( $sidebars as $sidebar_id => $sidebar_config ) {
			if ( ! empty( $sidebar_config ) && isset( $sidebar_config['label'] ) ) {
				register_sidebar( array(
					'name'          => $sidebar_config['label'],
					'id'            => $sidebar_id,
					'before_widget' => '<aside id="%1$s" class="widget %2$s g1-widget-class">',
					'after_widget'  => '</aside>',
					'before_title'  => '<header><h2 class="g1-delta g1-delta-2nd widgettitle">',
					'after_title'   => '</h2></header>',
					'class'         => isset( $core_sidebars[ $sidebar_id ] ) ? '' : 'g1-custom',
					'description'   => isset( $sidebar_config['description'] ) ? $sidebar_config['description'] : '',
				) );
			}
		}
	}
}

/**
 * Adjust the $content_width WP global variable
 */
function bunchy_setup_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bunchy_content_width', 710 );
}

/**
 * Allow empty strings in widget titles
 *
 * @param string $title Widget title.
 *
 * @return string
 */
function bunchy_allow_empty_widget_title( $title ) {
	$title = trim( $title );
	$title = ( '&nbsp;' === $title ) ? '' : $title;

	return $title;
}
