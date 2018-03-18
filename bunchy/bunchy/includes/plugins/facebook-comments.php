<?php
/**
 * Facebook Comments plugin functions
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
 * Load custom template
 *
 * @return string
 */
function bunchy_fb_comments_template( $value ) {
	global $post;

	if ( ! ( is_singular() && ( have_comments() || 'open' === $post->comment_status ) ) ) {
		return;
	}

	$options = get_option( 'fbcomments' );

	if ( ! isset( $options['posts'] ) || 'on' !== $options['posts'] ) {
		return $value;
	}

	$templates = array(
		'comments-facebook.php'
	);

	$located = locate_template( $templates );

	if ( empty( $located ) ) {
		return $value;
	}

	return $located;
}
