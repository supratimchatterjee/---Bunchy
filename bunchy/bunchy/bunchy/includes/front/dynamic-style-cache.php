<?php
/**
 * Cache functions
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
 * Print dynamic styles and exit
 */
function bunchy_load_dynamic_styles() {
	$print = filter_input( INPUT_GET, 'bunchy-dynamic-style', FILTER_SANITIZE_NUMBER_INT );

	if ( 1 === intval( $print ) ) {
		bunchy_print_dynamic_styles();
		exit;
	}
}

/**
 * Return dynamic styles content
 *
 * @return array
 */
function bunchy_get_dynamic_styles() {
	require_once( BUNCHY_FRONT_DIR . 'lib/class-bunchy-color.php' );
	require_once( BUNCHY_FRONT_DIR . 'lib/class-bunchy-color-generator.php' );

	ob_start();
	require_once( BUNCHY_THEME_DIR . 'css/dynamic-style-global.php' );
	require_once( BUNCHY_THEME_DIR . 'css/dynamic-style-header.php' );
	require_once( BUNCHY_THEME_DIR . 'css/dynamic-style-footer.php' );
	require_once( BUNCHY_THEME_DIR . 'css/dynamic-style-premade.php' );

	$size    = ob_get_length();
	$content = ob_get_contents();
	ob_end_clean();

	return array(
		'content' => $content,
		'size'    => $size,
	);
}

/**
 * Render dynamic styles content
 *
 * @param bool $with_headers        If headers should be sent.
 */
function bunchy_print_dynamic_styles( $with_headers = true ) {
	$dynamic_styles = bunchy_get_dynamic_styles();

	if ( $with_headers ) {
		$bunchy_cache_timeout = apply_filters( 'bunchy_dynamic_style_cache_timeout', 0 );

		header( 'Pragma: public' ); // HTTP 1.0 .
		header( 'Cache-Control: public' );
		header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', time() + $bunchy_cache_timeout ) . ' GMT' );
		header( 'Content-Type: text/css' );
		header( 'Content-Length: ' . intval( $dynamic_styles['size'] ) );
	}

	echo ! empty( $dynamic_styles['content'] ) ? $dynamic_styles['content'] : '';
}

/**
 * Render dynamic styles based on theme options
 */
function bunchy_internal_dynamic_styles() {
	if ( bunchy_use_external_dynamic_style() ) {
		return;
	}
	?>
	<style type="text/css" media="screen">
		<?php
		bunchy_print_dynamic_styles( false );
		?>
	</style>
	<?php
}

/**
 * Change dynamic styles cache method after saving theme options
 *
 * @param string $old_value Old state.
 * @param string $new_value New state.
 */
function bunchy_dynamic_style_theme_option_changed( $old_value, $new_value ) {
	// Cache options changed from inactive to active state.
	if ( 'external_css' !== $old_value['advanced_dynamic_style'] && 'external_css' === $new_value['advanced_dynamic_style'] ) {
		bunchy_dynamic_style_mark_cache_as_stale();
	}
}

/**
 * Mark cache as stale
 */
function bunchy_dynamic_style_mark_cache_as_stale() {
	$option_base = bunchy_get_theme_id();
	$option_name = $option_base . '_cache_dynamic_style';

	if ( bunchy_dynamic_style_is_cache_enabled() && bunchy_dynamic_style_is_cache_dir_writable() ) {
		update_option( $option_name, true );
	} else {
		delete_option( $option_name );

		$use_cache_option_name = $option_base . '_use_dynamic_style_cache';
		delete_option( $use_cache_option_name );
	}
}

/**
 * Whether or not caching of dynamic styles is enabled.
 *
 * @return bool
 */
function bunchy_dynamic_style_is_cache_enabled() {
	return 'external_css' === bunchy_get_dynamic_style_type();
}

/**
 * Whether or not caching directory of dynamic styles is enabled.
 *
 * @return bool
 */
function bunchy_dynamic_style_is_cache_dir_writable() {
	return wp_is_writable( bunchy_dynamic_style_get_cache_dir() );
}

/**
 * Get the cache directory of dynamic styles.
 *
 * @return mixed|void
 */
function bunchy_dynamic_style_get_cache_dir() {
	$upload_dir = wp_upload_dir();
	$dir        = trailingslashit( $upload_dir['basedir'] );

	return apply_filters( 'bunchy_dynamic_style_cache_dir', $dir );
}

/**
 * Get the URL of the dynamic styles file
 *
 * @return null|string
 */
function bunchy_dynamic_style_get_file_url() {
	$query_var = apply_filters( 'bunchy_dynamic_styles_query_var', 'bunchy-dynamic-style' );

	// By default it's a php script (not cached).
	$url = home_url( '?'. $query_var .'=1' );

	if ( bunchy_dynamic_style_is_cache_enabled() ) {
		// Reload cache.
		bunchy_dynamic_style_rebuild_cache();
		$cached_file_url = bunchy_dynamic_style_get_cached_file_url();

		if ( $cached_file_url ) {
			$url = $cached_file_url;
		}
	}

	return $url;
}

/**
 * Get the URL of the dynamic styles cached file
 *
 * @return null|string
 */
function bunchy_dynamic_style_get_cached_file_url() {
	$option_base                   = bunchy_get_theme_id();
	$use_dynamic_style_option_name = $option_base . '_use_dynamic_style_cache';
	$use_dynamic_style             = (bool) get_option( $use_dynamic_style_option_name );

	if ( $use_dynamic_style ) {
		$upload_dir = wp_upload_dir();

		return trailingslashit( $upload_dir['baseurl'] ) . 'dynamic-style.css';
	} else {
		return null;
	}
}

/**
 * Rebuild cache of dynamic styles.
 */
function bunchy_dynamic_style_rebuild_cache() {
	$option_base             = bunchy_get_theme_id();
	$force_cache_option_name = $option_base . '_cache_dynamic_style';
	$force_cache             = (bool) get_option( $force_cache_option_name );

	if ( $force_cache ) {
		$file_cached = bunchy_dynamic_style_cache_file();

		// Flag that indicates if we can use cached version.
		$use_cache_option_name = $option_base . '_use_dynamic_style_cache';

		if ( $file_cached ) {
			update_option( $use_cache_option_name, true );

			bunchy_dynamic_style_log( __( 'Cache file was successfully saved on disk.', 'bunchy' ), 'success' );
		} else {
			delete_option( $use_cache_option_name );

			bunchy_dynamic_style_log(
				esc_html__( 'Caching process failed. Cache file was not saved on disk.', 'bunchy' ) .
				'<br />' .
				esc_html__( 'Please check if the directory "wp-content/uploads" is writable by your web server.', 'bunchy' ),
				'error'
			);
		}

		// Regardless of whether caching was successful or not,
		// we need to remove this flag.
		// If options will be saved next time, this flag will be set again
		// and caching process will be repeated.
		delete_option( $force_cache_option_name );
	}
}

/**
 * Cache dynamic styles
 *
 * @return bool
 */
function bunchy_dynamic_style_cache_file() {
	require_once( trailingslashit( dirname( dirname( dirname( trailingslashit( get_template_directory() ) ) ) ) ) . 'wp-admin/includes/file.php' );

	WP_Filesystem();

	/**
	 * Safe way to use filesystem
	 *
	 * @var WP_Filesystem_Base $wp_filesystem
	 */
	global $wp_filesystem;

	if ( ! $wp_filesystem ) {
		return false;
	}

	// Fetch styles content.
	$dynamic_styles = bunchy_get_dynamic_styles();

	$filename = trailingslashit( bunchy_dynamic_style_get_cache_dir() ) . 'dynamic-style.css';

	// If save correctly, use cached version.
	if ( $wp_filesystem->exists( $filename ) ) {
		$wp_filesystem->delete( $filename );
	}

	if ( $wp_filesystem->put_contents( $filename, $dynamic_styles['content'], FS_CHMOD_FILE ) ) {
		return true;
	}

	return false;
}

/**
 * Log a message about the current state of dynamic styles
 *
 * @param string $message A message to log.
 * @param string $type Type.
 */
function bunchy_dynamic_style_log( $message, $type ) {
	$expire_after_one_hour = 60 * 60 * 1;

	$log_entry = array(
		'type'    => $type,
		'message' => $message,
		'date'    => date( 'F j, Y, g:i a' ),
	);

	set_transient( 'bunchy_dynamic_style_cache_log', $log_entry, $expire_after_one_hour );
}

/**
 * Whether or not we use external file for dynamic styles
 *
 * @return bool
 */
function bunchy_use_external_dynamic_style() {
	return 'internal' !== bunchy_get_dynamic_style_type();
}

/**
 * Get the type of dynamic styles
 *
 * @return mixed|void
 */
function bunchy_get_dynamic_style_type() {
	$type = bunchy_get_theme_option( 'advanced', 'dynamic_style' );

	return apply_filters( 'bunchy_dynamic_style_type', $type );
}
