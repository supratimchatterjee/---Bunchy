<?php
/**
 * Front common functions
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
 * Get logo image.
 *
 * @return array
 */
function bunchy_get_logo() {
	$result = array();

	$logo = bunchy_get_theme_option( 'branding', 'logo' );

	if ( empty( $logo ) ) {
		return array();
	}

	$result['src'] = $logo;

	$logo_2x = bunchy_get_theme_option( 'branding', 'logo_hdpi' );

	if ( ! empty( $logo_2x ) ) {
		$result['srcset'] = $logo_2x . ' 2x,' . $logo . ' 1x';
	}

	$result['width']  = bunchy_get_theme_option( 'branding', 'logo_width' );
	$result['height'] = bunchy_get_theme_option( 'branding', 'logo_height' );

	return $result;
}

/**
 * Get microdata organization logo URL.
 */
function bunchy_get_microdata_organization_logo_url() {
	$url = bunchy_get_theme_option( 'branding', 'logo_hdpi' );

	return $url;
}

/**
 * Get footer stamp image.
 *
 * @return array
 */
function bunchy_get_footer_stamp() {
	$result = array();

	$stamp = bunchy_get_theme_option( 'footer', 'stamp' );

	if ( empty( $stamp ) ) {
		return array();
	}

	$result['src'] = $stamp;

	$stamp_2x = bunchy_get_theme_option( 'footer', 'stamp_hdpi' );

	if ( ! empty( $stamp_2x ) ) {
		$result['srcset'] = $stamp_2x;
	}

	$result['width']  = bunchy_get_theme_option( 'footer', 'stamp_width' );
	$result['height'] = bunchy_get_theme_option( 'footer', 'stamp_height' );

	return $result;
}

/**
 * Set template part data.
 *
 * @param mixed|void $data Data.
 */
function bunchy_set_template_part_data( $data ) {
	global $bunchy_template_data;
	global $bunchy_template_data_last;

	$bunchy_template_data_last = $bunchy_template_data;
	$bunchy_template_data      = $data;
}

/**
 * Get template part data.
 *
 * @return mixed
 */
function bunchy_get_template_part_data() {
	global $bunchy_template_data;

	return $bunchy_template_data;
}

/**
 * Reset template part data
 */
function bunchy_reset_template_part_data() {
	global $bunchy_template_data;
	global $bunchy_template_data_last;

	$bunchy_template_data = $bunchy_template_data_last;
}

/**
 * Enqueue stylesheets in the head
 */
function bunchy_enqueue_head_styles() {
	// Prevent CSS|JS caching during updates.
	$version = bunchy_get_theme_version();
	$uri     = trailingslashit( get_template_directory_uri() );

	$variant         = 'main';
	$variant_css_id  = 'g1-' . $variant;
	$variant_css_uri = $uri . 'css/' . $variant . '.css';
	wp_enqueue_style( $variant_css_id, $variant_css_uri, array(), $version );
	wp_style_add_data( $variant_css_id, 'rtl', 'replace' );

	// @todo - Move it to the appropriate place
	if ( bunchy_can_use_plugin( 'snax/snax.php' ) ) {
		wp_enqueue_style( 'bunchy-snax-extra', $uri . 'css/snax-extra.css', array(), $version );
		wp_style_add_data( 'bunchy-snax-extra', 'rtl', 'replace' );
	}

	wp_enqueue_style( 'bunchy-google-fonts', bunchy_google_fonts_url(), array(), $version );

	if ( bunchy_use_external_dynamic_style() ) {
		wp_enqueue_style( 'bunchy-dynamic-style', bunchy_dynamic_style_get_file_url() . '?respondjs=no', array(), $version );
	}

	// Load the stylesheet from the child theme.
	if ( get_template_directory() !== get_stylesheet_directory() ) {
		wp_register_style( 'bunchy-style', get_stylesheet_uri(), array(), false, 'screen' );
		wp_style_add_data( 'bunchy-style', 'rtl', trailingslashit( get_stylesheet_directory_uri() ) . 'rtl.css' );
		wp_enqueue_style( 'bunchy-style' );
	}
}

/**
 * Google fonts
 */
function bunchy_google_fonts_url() {
	$fonts_url = '';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Roboto, translate this to 'off'. Do not translate into your own language.
	 */
	$roboto = _x( 'on', 'Roboto font: on or off', 'bunchy' );

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Roboto Condensed, translate this to 'off'. Do not translate into your own language.
	 */
	$roboto_condensed = _x( 'on', 'Roboto Condensed font: on or off', 'bunchy' );

	if ( 'off' !== $roboto || 'off' !== $roboto_condensed ) {
		$font_families = array();

		if ( 'off' !== $roboto ) {
			$font_families[] = 'Roboto:400,300,500,600,700';
		}

		if ( 'off' !== $roboto_condensed ) {
			$font_families[] = 'Roboto Condensed:400,300,500,600,700';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( bunchy_get_google_font_subset() ),
		);

		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Get Google Font font subset
 *
 * @return string
 */
function bunchy_get_google_font_subset() {
	$subset = bunchy_get_theme_option( 'global', 'google_font_subset' );

	return apply_filters( 'bunchy_google_font_subset', $subset );
}

/**
 * Render scripts in the HTML head
 */
function bunchy_render_head_scripts() {
}

/**
 * Enqueue scripts used only on the frontend
 */
function bunchy_enqueue_front_scripts() {
	// Prevent CSS|JS caching during updates.
	$version = bunchy_get_theme_version();

	$parent_uri = trailingslashit( get_template_directory_uri() );
	$child_uri  = trailingslashit( get_stylesheet_directory_uri() );

	wp_enqueue_script( 'jquery' );

	if ( is_singular() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/**
	 * Head scripts.
	 */

	wp_enqueue_script( 'modernizr', $parent_uri . 'js/modernizr/modernizr-custom.min.js', array(), '3.3.0', false );

	/**
	 * Footer scripts.
	 */

	// Postion sticky polyfill.
	wp_enqueue_script( 'stickyfill', $parent_uri . 'js/stickyfill/stickyfill.min.js', array( 'jquery' ), '1.3.1', true );

	// Enqueue input::placeholder polyfill for IE9.
	wp_enqueue_script( 'jquery-placeholder', $parent_uri . 'js/jquery.placeholder/placeholders.jquery.min.js', array( 'jquery' ), '4.0.1', true );

	// Conver dates into fuzzy timestaps.
	wp_enqueue_script( 'jquery-timeago', $parent_uri . 'js/jquery.timeago/jquery.timeago.js', array( 'jquery' ), '1.5.2', true );
	bunchy_enqueue_timeago_i10n_script( $parent_uri );

	// Enqueue matchmedia polyfill.
	wp_enqueue_script( 'match-media', $parent_uri . 'js/matchMedia/matchMedia.js', array(), null, true );

	// Enqueue matchmedia addListener polyfill (media query events on window resize) for IE9.
	wp_enqueue_script( 'match-media-add-listener', $parent_uri . 'js/matchMedia/matchMedia.addListener.js', array( 'match-media' ), null, true );

	// Enqueue <picture> polyfill, <img srcset="" /> polyfill for Safari 7.0-, FF 37-, etc.
	wp_enqueue_script( 'picturefill', $parent_uri . 'js/picturefill/picturefill.min.js', array( 'match-media' ), '2.3.1', true );

	// Scroll events.
	wp_enqueue_script( 'jquery-waypoints', $parent_uri . 'js/jquery.waypoints/jquery.waypoints.min.js', array( 'jquery' ), '4.0.0', true );

	// GifPlayer.
	wp_enqueue_script( 'libgif', $parent_uri . 'js/libgif/libgif.js', array(), null, true );

	// Media queries in javascript.
	wp_enqueue_script( 'enquire', $parent_uri . 'js/enquire/enquire.min.js', array(
		'match-media',
		'match-media-add-listener',
	), '2.1.2', true );

	wp_enqueue_script( 'bunchy-front', $parent_uri . 'js/front.js', array( 'jquery', 'enquire' ), $version, true );
	wp_enqueue_script( 'bunchy-menu', $parent_uri . 'js/menu.js', array( 'bunchy-front' ), $version, true );

	// If child theme is activated, we can use this script to override theme js code.
	if ( $parent_uri !== $child_uri ) {
		wp_enqueue_script( 'bunchy-child', $child_uri . 'modifications.js', array( 'bunchy-front' ), null, true );
	}

	// Prepare js config.
	$config = array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'timeago'  => bunchy_get_theme_option( 'posts', 'timeago', 'standard' ) === 'standard' ? 'on' : 'off',
		'sharebar' => bunchy_get_theme_option( 'post', 'sharebar', 'standard' ) === 'standard' ? 'on' : 'off',
		'i10n'     => array(
			'subscribe_mail_subject_tpl'    => esc_html__( 'Check out this great article: %subject%', 'bunchy' ),
			'more'                          => esc_html__( 'More', 'bunchy' ),
		),
	);

	wp_localize_script( 'bunchy-front', 'bunchy_front_config', wp_json_encode( $config ) );
}

/**
 * Enqueue translation file for the timeago script
 *
 * @param string $parent_uri Parent Theme URI.
 */
function bunchy_enqueue_timeago_i10n_script( $parent_uri ) {
	$locale       = get_locale();
	$locale_parts = explode( '_', $locale );
	$lang_code    = $locale_parts[0];

	$exceptions_map = array(
		'pt_BR' => 'pt-br',
		'zh_CN' => 'zh-CN',
		'zh_TW' => 'zh-TW',
	);

	$script_i10n_ext = $lang_code;

	if ( isset( $exceptions_map[ $locale ] ) ) {
		$script_i10n_ext = $exceptions_map[ $locale ];
	}

	// Check if translation file exists in "locales" dir.
	if ( ! file_exists( BUNCHY_THEME_DIR . 'js/jquery.timeago/locales/jquery.timeago.' . $script_i10n_ext . '.js' ) ) {
		return;
	}

	wp_enqueue_script( 'jquery-timeago-' . $script_i10n_ext, $parent_uri . 'js/jquery.timeago/locales/jquery.timeago.' . $script_i10n_ext . '.js', array( 'jquery-timeago' ), null, true );
}

/**
 * Load front scripts conditionally
 *
 * @param string $tag Script tag.
 * @param string $handle Script handle.
 *
 * @return string
 */
function bunchy_load_front_scripts_conditionally( $tag, $handle ) {
	if ( in_array( $handle, array( 'placeholder' ), true ) ) {
		$tag = "\n<!--[if IE 9]>\n$tag<![endif]-->\n";
	}

	return $tag;
}

/**
 * Render meta tag with proper viewport.
 */
function bunchy_add_responsive_design_meta_tag() {
	echo "\n" . '<meta name="viewport" content="initial-scale=1.0, width=device-width" />' . "\n";
}

/**
 * Alter the HTML markup of the calendar widget.
 *
 * @param string $out Markup.
 *
 * @return string
 */
function bunchy_alter_calendar_output( $out ) {
	$out = str_replace(
		array(
			'<td class="pad" colspan="1">&nbsp;</td>',
			'<td class="pad" colspan="2">&nbsp;</td>',
			'<td class="pad" colspan="3">&nbsp;</td>',
			'<td class="pad" colspan="4">&nbsp;</td>',
			'<td class="pad" colspan="5">&nbsp;</td>',
			'<td class="pad" colspan="6">&nbsp;</td>',
			'<td colspan="1" class="pad">&nbsp;</td>',
			'<td colspan="2" class="pad">&nbsp;</td>',
			'<td colspan="3" class="pad">&nbsp;</td>',
			'<td colspan="4" class="pad">&nbsp;</td>',
			'<td colspan="5" class="pad">&nbsp;</td>',
			'<td colspan="6" class="pad">&nbsp;</td>',
			'<td colspan="3" id="prev" class="pad">&nbsp;</td>',
			'<td colspan="3" id="next" class="pad">&nbsp;</td>',
		),
		array(
			str_repeat( '<td class="pad">&nbsp;</td>', 1 ),
			str_repeat( '<td class="pad">&nbsp;</td>', 2 ),
			str_repeat( '<td class="pad">&nbsp;</td>', 3 ),
			str_repeat( '<td class="pad">&nbsp;</td>', 4 ),
			str_repeat( '<td class="pad">&nbsp;</td>', 5 ),
			str_repeat( '<td class="pad">&nbsp;</td>', 6 ),
			str_repeat( '<td class="pad">&nbsp;</td>', 1 ),
			str_repeat( '<td class="pad">&nbsp;</td>', 2 ),
			str_repeat( '<td class="pad">&nbsp;</td>', 3 ),
			str_repeat( '<td class="pad">&nbsp;</td>', 4 ),
			str_repeat( '<td class="pad">&nbsp;</td>', 5 ),
			str_repeat( '<td class="pad">&nbsp;</td>', 6 ),
			'<td colspan="3" id="prev" class="pad"><span></span></td>',
			'<td colspan="3" id="next" class="pad"><span></span></td>',
		),
		$out
	);

	return $out;
}

/**
 * Whether or not to show global featured content
 *
 * @return boolean
 */
function bunchy_show_global_featured_entries() {
	$bunchy_fe_visibility = explode( ',', bunchy_get_theme_option( 'featured_entries', 'visibility' ) );

	$bunchy_fe_show_on_home        = is_home() && in_array( 'home', $bunchy_fe_visibility, true );
	$bunchy_fe_show_on_single_post = is_single() && in_array( 'single_post', $bunchy_fe_visibility, true );

	return apply_filters( 'bunchy_show_global_featured_entries', $bunchy_fe_show_on_home || $bunchy_fe_show_on_single_post );
}

/**
 * Add body class responsible for boxed|stretched layout
 *
 * @param array $classes Body classes.
 *
 * @return array
 */
function bunchy_body_class_global_layout( $classes ) {
	$layout    = bunchy_get_theme_option( 'global', 'layout' );
	$classes[] = 'g1-layout-' . $layout;

	return $classes;
}

/**
 * Add some body classes.
 *
 * @param array $classes Body classes.
 *
 * @return array
 */
function bunchy_body_class_helpers( $classes ) {
	$classes[] = 'g1-hoverable';

	return $classes;
}

/**
 * Hide sharebar on specific pages.
 *
 * @param bool $bool Whether or not the sharebar is visible.
 *
 * @return bool
 */
function bunchy_hide_sharebar( $bool ) {
	if ( ! is_single() ) {
		$bool = false;
	}

	return $bool;
}

/**
 * Inserts spans into category listing
 *
 * @param string $in Markup.
 *
 * @return string
 */
function bunchy_insert_cat_count_span( $in ) {
	$out = preg_replace( '/<\/a> \(([0-9]+)\)/', ' <span class="g1-meta">\\1</span></a>', $in );

	return $out;
}

/**
 * Inserts spans into archive listing
 *
 * @param string $in Markup.
 *
 * @return string
 */
function bunchy_insert_archive_count_span( $in ) {

	if ( false !== strpos( $in, '<li>' ) ) {
		$out = preg_replace( '/<\/a>&nbsp;\(([0-9]+)\)/', ' <span class="g1-meta">\\1</span></a>', $in );

		return $out;
	}

	return $in;
}

/**
 * Change video shortcode attributes to better match the content width
 *
 * @param string $out Markup.
 * @param array  $pairs Entire list of supported attributes and their defaults.
 * @param array  $atts User defined attributes in shortcode tag.
 *
 * @return mixed
 */
function bunchy_wp_video_shortcode_atts( $out, $pairs, $atts ) {
	global $content_width;
	$width  = $out['width'];
	$height = $out['height'];

	$out['width']  = $content_width;
	$out['height'] = round( $content_width * $height / $width );

	return $out;
}

/**
 * Shorten number
 *
 * @param int $value        Input.
 *
 * @return string
 */
function bunchy_shorten_number( $value ) {
	if ( $value > 1000000 ) {
		$value = round( $value / 1000000, 1 ) . 'M';
	} elseif ( $value > 1000 ) {
		$value = round( $value / 1000, 1 ) . 'k';
	}

	return $value;
}

/**
 * Whether or not to show the navbar
 *
 * @return bool
 */
function bunchy_show_global_navbar() {
	$show = true;

	return apply_filters( 'bunchy_show_global_navbar', $show );
}

/**
 * Check whether to show prefooter
 *
 * @return bool
 */
function bunchy_show_prefooter() {
	$show = false;

	foreach ( array( 'footer-1', 'footer-2', 'footer-3' ) as $id ) {
		if ( is_active_sidebar( $id ) ) {
			$show = true;
		}
	}

	return apply_filters( 'bunchy_show_prefooter', $show );
}

/**
 * Check whether to use sticky header
 *
 * @return bool
 */
function bunchy_use_sticky_header() {
	$use_sticky_header = 'standard' === bunchy_get_theme_option( 'header', 'sticky' );

	return apply_filters( 'bunchy_use_sticky_header', $use_sticky_header );
}

/**
 * Generates color variations based on a single color
 *
 * @param Bunchy_Color $color Color.
 *
 * @return array
 */
function bunchy_get_color_variations( $color ) {
	$result = array();

	if ( ! is_a( $color, 'Bunchy_Color' ) ) {
		$color = new Bunchy_Color( $color );
	}

	$color_rgb = $color->get_rgb();
	$color_rgb = array_map( 'round', $color_rgb );

	$result['hex'] = $color->get_hex();
	$result['r']   = $color_rgb[0];
	$result['g']   = $color_rgb[1];
	$result['b']   = $color_rgb[2];

	$result['from_hex'] = $color->get_hex();
	$result['from_r']   = $color_rgb[0];
	$result['from_g']   = $color_rgb[1];
	$result['from_b']   = $color_rgb[2];
	$result['to_hex']   = $color->get_hex();
	$result['to_r']     = $color_rgb[0];
	$result['to_g']     = $color_rgb[1];
	$result['to_b']     = $color_rgb[2];

	$border2     = Bunchy_Color_Generator::get_tone_color( $color, 20 );
	$border2_rgb = $border2->get_rgb();
	$border2_rgb = array_map( 'round', $border2_rgb );

	$border1 = clone $color;
	$border1->set_lightness( round( ( $border1->get_lightness() + $border2->get_lightness() ) / 2 ) );
	$border1_rgb = $border1->get_rgb();
	$border1_rgb = array_map( 'round', $border1_rgb );

	$result['border2_hex'] = $border2->get_hex();
	$result['border2_r']   = $border2_rgb[0];
	$result['border2_g']   = $border2_rgb[1];
	$result['border2_b']   = $border2_rgb[2];

	$result['border1_hex'] = $border1->get_hex();
	$result['border1_r']   = $border1_rgb[0];
	$result['border1_g']   = $border1_rgb[1];
	$result['border1_b']   = $border1_rgb[2];

	if ( $color->get_lightness() >= 50 ) {
		$result['border1_start'] = 0;
		$result['border1_end']   = 0.66;
	} else {
		$result['border1_start'] = 0.66;
		$result['border1_end']   = 0;
	}

	$tone_20_20     = Bunchy_Color_Generator::get_tone_color( $color, 20, 20 );
	$tone_20_20_rgb = $tone_20_20->get_rgb();
	$tone_20_20_rgb = array_map( 'round', $tone_20_20_rgb );

	$result['tone_20_20_hex'] = $tone_20_20->get_hex();
	$result['tone_20_20_r']   = $tone_20_20_rgb[0];
	$result['tone_20_20_g']   = $tone_20_20_rgb[1];
	$result['tone_20_20_b']   = $tone_20_20_rgb[2];

	$tone_5_90     = Bunchy_Color_Generator::get_tone_color( $color, 5, 90 );
	$tone_5_90_rgb = $tone_5_90->get_rgb();
	$tone_5_90_rgb = array_map( 'round', $tone_5_90_rgb );

	$result['tone_5_90_hex'] = $tone_5_90->get_hex();
	$result['tone_5_90_r']   = $tone_5_90_rgb[0];
	$result['tone_5_90_g']   = $tone_5_90_rgb[1];
	$result['tone_5_90_b']   = $tone_5_90_rgb[2];

	return $result;
}
