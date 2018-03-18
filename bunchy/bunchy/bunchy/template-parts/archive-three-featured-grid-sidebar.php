<?php
/**
 * The Template for displaying archive body.
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
?>

<?php
$bunchy_template_data = bunchy_get_template_part_data();
?>

<?php
if ( bunchy_show_archive_featured_entries() ) :
	get_template_part( 'template-parts/featured-content-3' );
endif;
?>
<?php if ( have_posts() ) : ?>
	<div class="g1-row g1-row-layout-page archive-body">
		<div class="g1-row-inner">

			<div id="primary" class="g1-column g1-column-2of3">

				<div class="g1-collection g1-collection-columns-2">
					<div class="g1-collection-viewport">
						<ul class="g1-collection-items">
							<?php $bunchy_post_number = 0; ?>
							<?php while ( have_posts() ) : the_post();
								$bunchy_post_number ++; ?>
								<?php do_action( 'bunchy_archive_loop_before_post', 'grid', $bunchy_post_number ); ?>

								<li class="g1-collection-item g1-collection-item-1of3">
									<?php get_template_part( 'template-parts/content-grid-standard', get_post_format() ); ?>
								</li>

								<?php do_action( 'bunchy_archive_loop_after_post', 'grid', $bunchy_post_number ); ?>
							<?php endwhile; ?>
						</ul>
					</div>

					<?php get_template_part( 'template-parts/archive-pagination', $bunchy_template_data['pagination'] ); ?>
				</div><!-- .g1-collection -->

			</div><!-- .g1-column -->

			<?php get_sidebar(); ?>

		</div>
		<div class="g1-row-background"></div>
	</div><!-- .g1-row -->
<?php else : ?>
	<?php get_template_part( 'template-parts/archive-no-results' ); ?>
<?php endif;

