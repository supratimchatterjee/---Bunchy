<?php
/**
 * The Template for displaying archive pages.
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
		<div id="content" role="main" class="archive-wrapper">

			<header class="g1-row g1-row-layout-page archive-header">
				<div class="g1-row-inner">
					<?php
					// Get user by id.
					$bunchy_user = get_user_by( 'id', get_query_var( 'author' ) );

					// If id not set, get it via slug.
					if ( false === $bunchy_user ) {
						$bunchy_user = get_user_by( 'slug', get_query_var( 'author_name' ) );
					}

					$bunchy_title   = $bunchy_user->display_name;

					$bunchy_subtitle    = '';
					$bunchy_description = get_the_author_meta( 'description', $bunchy_user->ID );
					?>

					<div class="g1-column g1-column-1of2">
						<p class="archive-icon"><?php echo get_avatar( $bunchy_user->ID, 70 ); ?></p>

						<h1 class="g1-alpha g1-alpha-2nd archive-title"><?php echo wp_kses_post( $bunchy_title ); ?></h1>

						<?php if ( strlen( $bunchy_subtitle ) ) : ?>
							<h2 class="g1-delta g1-delta-3rd archive-subtitle"><?php echo wp_kses_post( $bunchy_subtitle ); ?></h2>
						<?php endif; ?>
					</div>

					<div class="g1-column g1-column-1of2">
						<?php if ( strlen( $bunchy_description ) ) : ?>
							<p class="archive-description"><?php echo wp_kses_post( $bunchy_description ); ?></p>
						<?php endif; ?>
					</div>
				</div>
				<div class="g1-row-background"></div>
			</header>

			<?php
			$bunchy_archive_settings                       = bunchy_get_archive_settings();
			$bunchy_archive_settings['elements']['author'] = false;

			bunchy_set_template_part_data( $bunchy_archive_settings );

			get_template_part( 'template-parts/archive-' . $bunchy_archive_settings['template'] );

			bunchy_reset_template_part_data();
			?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer();
