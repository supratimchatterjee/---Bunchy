<?php
/**
 * The Template Part for displaying Comments.
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

if ( post_password_required() ) {
	return;
}

echo do_shortcode( '[fbcomments]' );
