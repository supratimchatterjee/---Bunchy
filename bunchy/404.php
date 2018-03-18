<?php
/**
 * The Template for displaying the 404 page (Not Found).
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

get_header();
?>

	<div id="primary" class="g1-primary-max">
		<div id="content" role="main">

			<article id="post-0">
				<header class="g1-row g1-row-layout-page entry-header entry-header-row">
					<div class="g1-row-inner">
						<div class="g1-column">

							<h1 class="g1-alpha g1-alpha-2nd entry-title"><?php esc_html_e( 'Ooops, sorry! We couldn\'t find it', 'bunchy' ); ?></h1>
							<h2 class="g1-delta g1-delta-3rd entry-subtitle"><?php esc_html_e( 'You have requested a page or file which doesn\'t exist', 'bunchy' ); ?></h2>

						</div><!-- .g1-column -->
					</div>
					<div class="g1-row-background">
					</div>
				</header><!-- .g1-row -->

				<div class="g1-row g1-row-layout-page g1-row-padding-l entry-content">
					<div class="g1-row-inner">

						<div class="g1-column g1-column-1of3 g1-404-search">
							<div class="g1-column-inner">
								<i class="g1-404-icon"></i>
								<h2 class="g1-gamma g1-gamma-2nd"><?php esc_html_e( 'Search Our Website', 'bunchy' ); ?></h2>
								<?php get_search_form(); ?>
							</div>
						</div><!-- .g1-column -->

						<div class="g1-column g1-column-1of3 g1-404-report">
							<div class="g1-column-inner">
								<i class="g1-404-icon"></i>
								<h2 class="g1-gamma g1-gamma-2nd"><?php esc_html_e( 'Report a Problem', 'bunchy' ); ?></h2>
								<p><?php printf( wp_kses_post( __( 'Please write some descriptive information about your problem, and email our <a href="%s">webmaster</a>.', 'bunchy' ) ), esc_url( 'mailto:' . antispambot( get_option( 'admin_email' ), true ) ) ); ?></p>
							</div>
						</div><!-- .g1-column -->

						<div class="g1-column g1-column-1of3 g1-404-home">
							<div class="g1-column-inner">
								<i class="g1-404-icon"></i>
								<h2 class="g1-gamma g1-gamma-2nd"><?php esc_html_e( 'Back to the Homepage', 'bunchy' ); ?></h2>
								<p><?php printf( wp_kses_post( __( 'You can also <a href="%s">go back to the homepage</a> and start browsing from there.', 'bunchy' ) ), esc_url( home_url() ) ); ?></p>
							</div>
						</div>
					</div>

					<div class="g1-row-background">
					</div>
				</div><!-- .entry-content -->

			</article><!-- #post-0 -->

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer();
