<?php
/**
 * Mailchimp for WP plugin functions
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
 * Render some HTML markup before the newsletter sign-up form fields
 *
 * @param string $html  HTML markup.
 *
 * @return string
 */
function bunchy_mc4wp_form_before_form( $html ) {
	$html .= '<p class="g1-alpha g1-alpha-1st">' . esc_html( bunchy_get_theme_option( 'newsletter', 'compact_title' ) ) . '</p>';

	return $html;
}

/**
 * Render some HTML markup after the newsletter sign-up form fields
 *
 * @param string $html      HTML markup.
 *
 * @return string
 */
function bunchy_mc4wp_form_after_form( $html ) {
	$html .= '<p class="g1-newsletter-privacy">' . wp_kses_post( bunchy_get_theme_option( 'newsletter', 'privacy' ) ) . '</p>';

	return $html;
}

/**
 * Set up default newsletter sign-up form id
 */
function bunchy_mc4wp_set_up_default_form_id() {
	$form_id = (int) get_option( 'mc4wp_default_form_id', 0 );

	// Return if already set.
	if ( 0 !== $form_id ) {
		return;
	}

	$query_args = array(
		'posts_per_page'        => 1,
		'post_type'             => 'mc4wp-form',
		'post_status'           => 'publish',
		'ignore_sticky_posts'   => true,
	);

	$query = new WP_Query();
	$forms = $query->query( $query_args );

	if ( ! empty( $forms ) ) {
		$form = $forms[0];

		update_option( 'mc4wp_default_form_id', $form->ID );
	}
}
