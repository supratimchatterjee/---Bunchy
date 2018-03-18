<?php
/**
 * The Template for displaying date archive pages.
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

$bunchy_archive_title    = '';
$bunchy_archive_subtitle = '';

if ( is_year() ) {
	$bunchy_archive_title    = get_the_date( 'Y' );
	$bunchy_archive_subtitle = esc_html__( 'Yearly Archives', 'bunchy' );
}

if ( is_month() ) {
	$bunchy_archive_title    = get_the_date( 'F Y' );
	$bunchy_archive_subtitle = esc_html__( 'Monthly Archives', 'bunchy' );
}

if ( is_day() ) {
	$bunchy_archive_title    = get_the_date();
	$bunchy_archive_subtitle = esc_html__( 'Daily Archives', 'bunchy' );
}

get_header();
?>
	<div id="primary" class="g1-primary-max">
		<div id="content" role="main" class="archive-wrapper">

			<header class="g1-row g1-row-layout-page archive-header">
				<div class="g1-row-inner">
					<div class="g1-column">
						<?php if ( ! empty( $bunchy_archive_title ) ) : ?>
							<h1 class="g1-alpha g1-alpha-2nd archive-title"><?php echo wp_kses_post( $bunchy_archive_title ); ?></h1>
						<?php endif; ?>
						<?php if ( ! empty( $bunchy_archive_subtitle ) ) : ?>
							<h2 class="g1-delta g1-delta-3rd archive-subtitle"><?php echo wp_kses_post( $bunchy_archive_subtitle ); ?></h2>
						<?php endif; ?>
					</div>
				</div>
				<div class="g1-row-background"></div>
			</header>

			<?php
			$bunchy_archive_settings = bunchy_get_archive_settings();
			bunchy_set_template_part_data( $bunchy_archive_settings );

			get_template_part( 'template-parts/archive-' . $bunchy_archive_settings['template'] );

			bunchy_reset_template_part_data();
			?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer();
