<?php
/**
 * Theme common functions
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
 * Get theme identificator
 *
 * @return string
 */
function bunchy_get_theme_id() {
	return 'bunchy_theme';
}

/**
 * Get the id of the option where we store all theme options
 *
 * @return string
 */
function bunchy_get_theme_options_id() {
	return 'bunchy_theme_options';
}

/**
 * Get theme name
 *
 * @return string
 */
function bunchy_get_theme_name() {
	return 'bunchy';
}

/**
 * Get theme version
 *
 * @return string
 */
function bunchy_get_theme_version() {
	$current_theme = wp_get_theme( bunchy_get_theme_name() );

	return $current_theme->exists() ? $current_theme->get( 'Version' ) : '1.0';
}

/**
 * Get theme options prefixes
 *
 * @return array
 */
function bunchy_get_theme_options_vars_prefixes() {
	return array(
		'theme_update',
		'advanced',
	);
}

/**
 * Get default theme option values
 *
 * @return array
 */
function bunchy_get_theme_defaults() {
	static $defaults;

	// Load only once.
	if ( ! $defaults ) {
		require( BUNCHY_ADMIN_DIR . 'customizer/customizer-defaults.php' );
		require( BUNCHY_ADMIN_DIR . 'theme-options/theme-defaults.php' );

		$storage_name = bunchy_get_theme_id();

		/**
		 * Vars from included files
		 *
		 * @var array $bunchy_customizer_defaults
		 * @var array $bunchy_theme_options_defaults
		 */
		$defaults = array(
			$storage_name              => $bunchy_customizer_defaults,
			$storage_name . '_options' => $bunchy_theme_options_defaults,
		);
	}

	return $defaults;
}

/**
 * Get theme option value
 *
 * @param string $base Base.
 * @param string $key Key.
 *
 * @return mixed
 */
function bunchy_get_theme_option( $base, $key ) {
	$storage_name = bunchy_get_theme_id();

	// Use different storage for WP Admin > Appearance > Theme Options values.
	if ( in_array( $base, bunchy_get_theme_options_vars_prefixes(), true ) ) {
		$storage_name .= '_options';
	}

	$storage_values = get_option( $storage_name, array() );

	$option_name = $base;

	if ( strlen( $key ) > 0 ) {
		$option_name .= '_' . $key;
	}

	$defaults = bunchy_get_theme_defaults();

	$result = isset( $storage_values[ $option_name ] ) ? $storage_values[ $option_name ] : $defaults[ $storage_name ][ $option_name ];

	return $result;
}

/**
 * Set theme option value
 *
 * @param string $base Base.
 * @param string $key Key.
 * @param mixed  $value Value.
 */
function bunchy_set_theme_option( $base, $key, $value ) {
	$storage_name = bunchy_get_theme_id();

	// Use different storage for WP Admin > Appearance > Theme Options values.
	if ( in_array( $base, bunchy_get_theme_options_vars_prefixes(), true ) ) {
		$storage_name .= '_options';
	}

	$storage_values = get_option( $storage_name, array() );

	$option_name = $base;

	if ( strlen( $key ) > 0 ) {
		$option_name .= '_' . $key;
	}

	$storage_values[ $option_name ] = $value;

	update_option( $storage_name, $storage_values );
}

/**
 * Return query args for most shared posts
 *
 * @param array $query_args         Arguments.
 *
 * @return array
 */
function bunchy_get_most_shared_query_args( $query_args ) {
	if ( isset( $query_args['time_range'] ) ) {
		$query_args = bunchy_time_range_to_date_query( $query_args['time_range'], $query_args );
	}

	return apply_filters( 'bunchy_most_shared_query_args', $query_args );
}

/**
 * Return query args for most viewed posts
 *
 * @param array  $query_args    Arguments.
 * @param string $type          Optional. Type of posts (popular | trending | hot). Default: all types.
 *
 * @return array
 */
function bunchy_get_most_viewed_query_args( $query_args, $type = '' ) {
	if ( isset( $query_args['time_range'] ) ) {
		$query_args = bunchy_time_range_to_date_query( $query_args['time_range'], $query_args );
	}

	// By default there are no most viewed posts,
	// so to make sure that no posts will be returned we use none existing post id.
	$query_args['post__in'] = array( -1 );

	return apply_filters( 'bunchy_most_viewed_query_args', $query_args, $type );
}

/**
 * Get the maximum number of hot posts
 *
 * @return int
 */
function bunchy_get_hot_posts_limit() {
	return apply_filters( 'bunchy_hot_posts_limit', 10 );
}

/**
 * Get the maximum number of popular posts
 *
 * @return int
 */
function bunchy_get_popular_posts_limit() {
	return apply_filters( 'bunchy_popular_posts_limit', 10 );
}

/**
 * Get the maximum number of trending posts
 *
 * @return int
 */
function bunchy_get_trending_posts_limit() {
	return apply_filters( 'bunchy_trending_posts_limit', 10 );
}

/**
 * Convert custom time range to date query args
 *
 * @param string $time_range      Time range type.
 * @param array  $query_args       Arguments.
 *
 * @return array
 */
function bunchy_time_range_to_date_query( $time_range, $query_args ) {
	switch ( $time_range ) {
		case 'day':
			$date_ago = '1 day ago';
			break;

		case 'week':
			$date_ago = '1 week ago';
			break;

		case 'month':
			$date_ago = '1 month ago';
			break;
	}

	// Keep it for further use (eg. for 3rd party plugins like WPP).
	$query_args['time_range'] = $time_range;

	if ( isset( $date_ago ) ) {
		$query_args['date_query'] = array(
			array(
				'after' => $date_ago,
			),
		);
	}

	return $query_args;
}

/**
 * Get predefined sidebars
 *
 * @return array
 */
function bunchy_get_predefined_sidebars() {
	return array(
		'primary'      => array(
			'label' => esc_html__( 'Primary', 'bunchy' ),
		),
		'home'         => array(
			'label'       => esc_html__( 'Home', 'bunchy' ),
			'description' => esc_html__( 'Leave empty to use the Primary sidebar', 'bunchy' ),
		),
		'post_single'  => array(
			'label'       => esc_html__( 'Single Post', 'bunchy' ),
			'description' => esc_html__( 'Leave empty to use the Primary sidebar', 'bunchy' ),
		),
		'post_archive' => array(
			'label'       => esc_html__( 'Post Archives', 'bunchy' ),
			'description' => esc_html__( 'For posts archive pages (categories, tags). Leave empty to use the Primary sidebar', 'bunchy' ),
		),
		'page'         => array(
			'label'       => esc_html__( 'Pages', 'bunchy' ),
			'description' => esc_html__( 'Leave empty to use the Primary sidebar', 'bunchy' ),
		),
		'footer-1'     => array(
			'label' => esc_html__( 'Footer 1', 'bunchy' ),
		),
		'footer-2'     => array(
			'label' => esc_html__( 'Footer 2', 'bunchy' ),
		),
		'footer-3'     => array(
			'label' => esc_html__( 'Footer 3', 'bunchy' ),
		),
	);
}

/**
 * Get nice name of a sidebar
 *
 * @param string $sidebar_id Sidebar identificator.
 *
 * @return mixed|string
 */
function bunchy_get_nice_sidebar_name( $sidebar_id ) {
	$sidebar_name = str_replace( '-', ' ', $sidebar_id );

	// Split to single words.
	$parts = explode( ' ', $sidebar_name );

	// Each word with first letter capitalized.
	$parts = array_map( 'ucfirst', $parts );

	// Join to one string.
	$sidebar_name = implode( ' ', $parts );

	return $sidebar_name;
}

/**
 * Check whether the plugin is active and theme can rely on it
 *
 * @param string $plugin        Base plugin path.
 * @return bool
 */
function bunchy_can_use_plugin( $plugin ) {
	// Detect plugin. For use on Front End only.
	require_once( trailingslashit( dirname( dirname( dirname( trailingslashit( get_template_directory() ) ) ) ) ) . 'wp-admin/includes/plugin.php' );

	return is_plugin_active( $plugin );
}

/**
 * Empty theme related transients.
 */
function bunchy_delete_transients() {
	delete_transient( 'bunchy_featured_entries_query' );
	delete_transient( 'bunchy_dont_miss_query' );
}

/**
 * Calculate hot posts.
 *
 * The list position is stored in the "_bunchy_hot" post meta.
 *
 * @return array            Calculated post ids.
 */
function bunchy_calculate_hot_posts() {
	delete_post_meta_by_key( '_bunchy_hot' );

	$query_args = bunchy_get_most_viewed_query_args( array(
		'posts_per_page' => bunchy_get_hot_posts_limit(),
		'time_range'     => 'month',
	), 'hot' );

	$query = new WP_Query();
	$posts = $query->query( $query_args );
	$ids = array();

	foreach ( $posts as $index => $post ) {
		$ids[] = $post->ID;
		update_post_meta( $post->ID, '_bunchy_hot', $index + 1 );
	}

	return $ids;
}

/**
 * If list empty, calculate
 *
 * @param array $ids                    Current list of ids.
 * @param int   $limit                  Limit.
 *
 * @return array                        Calculated list.
 */
function bunchy_calculate_hot_post_ids_if_empty( $ids, $limit ) {
	if ( empty( $ids ) ) {
		$ids = bunchy_calculate_hot_posts();
	}

	return $ids;
}

/**
 * Calculate popular posts.
 *
 * The list position is stored in the "_bunchy_popular" post meta.
 *
 * @return array    Calculated post ids.
 */
function bunchy_calculate_popular_posts() {
	delete_post_meta_by_key( '_bunchy_popular' );

	$query_args = bunchy_get_most_viewed_query_args( array(
		'posts_per_page' => bunchy_get_popular_posts_limit(),
	), 'popular' );

	$query = new WP_Query();
	$posts = $query->query( $query_args );
	$ids = array();

	foreach ( $posts as $index => $post ) {
		$ids[] = $post->ID;
		update_post_meta( $post->ID, '_bunchy_popular', $index + 1 );
	}

	return $ids;
}

/**
 * If list empty, calculate
 *
 * @param array $ids                    Current list of ids.
 * @param int   $limit                  Limit.
 *
 * @return array                        Calculated list.
 */
function bunchy_calculate_popular_post_ids_if_empty( $ids, $limit ) {
	if ( empty( $ids ) ) {
		$ids = bunchy_calculate_popular_posts();
	}

	return $ids;
}

/**
 * Calculate trending posts.
 *
 * The list position is stored in the "_bunchy_popular" post meta.
 *
 * @return array    Calculated post ids.
 */
function bunchy_calculate_trending_posts() {
	delete_post_meta_by_key( '_bunchy_trending' );

	$query_args = bunchy_get_most_viewed_query_args( array(
		'posts_per_page' => bunchy_get_trending_posts_limit(),
		'time_range'     => 'day',
	), 'trending' );

	$query = new WP_Query();
	$posts = $query->query( $query_args );
	$ids = array();

	foreach ( $posts as $index => $post ) {
		$ids[] = $post->ID;
		update_post_meta( $post->ID, '_bunchy_trending', $index + 1 );
	}

	return $ids;
}

/**
 * If list empty, calculate
 *
 * @param array $ids                    Current list of ids.
 * @param int   $limit                  Limit.
 *
 * @return array                        Calculated list.
 */
function bunchy_calculate_trending_post_ids_if_empty( $ids, $limit ) {
	if ( empty( $ids ) ) {
		$ids = bunchy_calculate_trending_posts();
	}

	return $ids;
}

/**
 * Convers string (opt1,opt2,opt3) into bool array (array( opt1 => true ))
 *
 * @param string $string        Comma-separated list of elements.
 * @param array  $array         All elements.
 *
 * @return array
 */
function bunchy_conver_string_to_bool_array( $string, $array ) {
	$string_arr = explode( ',', $string );

	foreach ( $array as $key => $value ) {
		if ( in_array( $key, $string_arr, true ) ) {
			$array[ $key ] = false;
		}
	}

	return $array;
}

/**
 * Adjust embed defaul values.
 *
 * @param array  $dims Dimensions.
 * @param string $url URL.
 *
 * @return mixed
 */
function bunchy_embed_defaults( $dims, $url ) {
	// 16:9 aspect ratio.
	$video_16_9_domains = apply_filters( 'bunchy_oembed_video_16_9_domains', array(
		'youtube.com',
		'youtu.be',
		'vimeo.com',
		'dailymotion.com',
		'facebook.com/plugins/video.php',
	) );

	$is_video_16_9 = false;

	foreach ( $video_16_9_domains as $video_16_9_domain ) {
		if ( strpos( $url, $video_16_9_domain ) !== false ) {
			$is_video_16_9 = true;
			break;
		}
	}

	if ( $is_video_16_9 ) {
		$dims['height'] = absint( round( 9 * $dims['width'] / 16 ) );
	}

	// 1:1 aspect ratio.
	$video_1_1_domains = apply_filters( 'bunchy_oembed_video_1_1_domains', array(
		'vine.co',
	) );

	$is_video_1_1 = false;

	foreach ( $video_1_1_domains as $video_1_1_domain ) {
		if ( strpos( $url, $video_1_1_domain ) !== false ) {
			$is_video_1_1 = true;
			break;
		}
	}

	if ( $is_video_1_1 ) {
		$dims['height'] = $dims['width'];
	}

	return $dims;
}

/**
 * Wrap embeds in fluid wrapper
 *
 * @param string $html oembed HTML markup.
 * @param string $url Embed URL.
 * @param array  $attr Attributes.
 *
 * @return string
 */
function bunchy_fluid_wrapper_embed_oembed_html( $html, $url, $attr ) {
	$apply = apply_filters( 'bunchy_apply_fluid_wrapper_for_oembed', false, $url );

	if ( ! $apply ) {
		return $html;
	}

	return bunchy_fluid_wrapper( array(
		'width'  => esc_attr( $attr['width'] ),
		'height' => esc_attr( $attr['height'] ),
	), $html );
}

/**
 * Keep element ratio while scaling.
 *
 * @param array  $atts Attributes.
 * @param string $content Content.
 *
 * @return string
 */
function bunchy_fluid_wrapper( $atts, $content ) {
	/* We need a static counter to trace a shortcode without the id attribute */
	static $counter = 0;
	$counter ++;

	$vars = shortcode_atts( array(
		'id'     => '',
		'class'  => '',
		'width'  => '',
		'height' => '',
	), $atts, 'bunchy_fluid_wrapper' );

	$id     = $vars['id'];
	$class  = $vars['class'];
	$width  = $vars['width'];
	$height = $vars['height'];

	$content = preg_replace( '#^<\/p>|<p>$#', '', $content );

	// Compose final HTML id attribute.
	$final_id = strlen( $id ) ? $id : 'g1-fluid-wrapper-counter-' . $counter;

	// Compose final HTML class attribute.
	$final_class = array(
		'g1-fluid-wrapper',
	);

	$final_class = array_merge( $final_class, explode( ' ', $class ) );

	// Get width and height values.
	$width  = absint( $width );
	$height = absint( $height );

	if ( ! $width ) {
		$re    = '/width=[\'"]?(\d+)[\'"]?/';
		$width = preg_match( $re, $content, $match );
		$width = $width ? absint( $match[1] ) : 0;
	}

	if ( ! $height ) {
		$re     = '/height=[\'"]?(\d+)[\'"]?/';
		$height = preg_match( $re, $content, $match );
		$height = $height ? absint( $match[1] ) : 0;
	}

	$height = ( 9999 === $height ) ? round( $width * 9 / 16 ) : $height;

	// Compose output.
	$out = '<div id="%id%" class="%class%" %outer_style% data-g1-fluid-width="%fluid_width%" data-g1-fluid-height="%fluid_height%">
	       <div class="g1-fluid-wrapper-inner" %inner_style%>
	       %content%
	       </div>
	       </div>';
	$out = str_replace(
		array(
			'%id%',
			'%class%',
			'%outer_style%',
			'%fluid_width%',
			'%fluid_height%',
			'%inner_style%',
			'%content%',
		),
		array(
			esc_attr( $final_id ),
			implode( ' ', array_map( 'sanitize_html_class', $final_class ) ),
			( $width && $height ? 'style="width:' . absint( $width ) . 'px;"' : '' ),
			$width,
			$height,
			( $width && $height ? 'style="padding-bottom:' . ( absint( $height ) / absint( $width ) ) * 100 . '%;"' : '' ),
			do_shortcode( shortcode_unautop( $content ) ),
		),
		$out
	);

	return $out;
}

/**
 * Apply fluid wrapper for embedded services
 *
 * @param bool   $apply     Current state.
 * @param string $url       Service url.
 *
 * @return bool
 */
function bunchy_apply_fluid_wrapper_for_services( $apply, $url ) {
	$services = apply_filters( 'bunchy_fluid_wrapper_services', array(
		'youtube.com',
		'youtu.be',
		'vimeo.com',
		'dailymotion.com',
		'vine.co',
		'facebook.com/plugins/video.php',
	) );

	foreach ( $services as $service ) {
		if ( strpos( $url, $service ) !== false ) {
			$apply = true;
			break;
		}
	}

	return $apply;
}
