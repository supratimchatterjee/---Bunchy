<?php
/**
 * The Template Part for displaying post navigation.
 *
 * For the full license information, please view the Licensing folder
 * that was distributed with this source code.
 *
 * @package Bunchy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

?>
<nav class="g1-nav-single">
	<div class="g1-nav-single-inner">
		<p class="g1-single-nav-label"><?php esc_html_e( 'See more', 'bunchy' ); ?></p>
		<ul class="g1-nav-single-links">
			<li class="g1-nav-single-prev"><?php previous_post_link( '%link', '<strong>' . esc_html__( 'Previous article', 'bunchy' ) . '</strong>  <span class="g1-delta g1-delta-1st">%title</span>' ); ?></li>
			<li class="g1-nav-single-next"><?php next_post_link( '%link', '<strong>' . esc_html__( 'Next article', 'bunchy' ) . '</strong> <span class="g1-delta g1-delta-1st">%title</span>' ); ?></li>
		</ul>
	</div>
</nav>
