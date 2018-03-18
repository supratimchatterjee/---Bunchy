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
		<div id="content" role="main">

			<header class="g1-row g1-row-layout-page archive-header">
				<div class="g1-row-inner">

					<div class="g1-column">
						<h1 class="g1-alpha g1-alpha-2nd archive-title"><?php printf( esc_html__( 'Phrase: %s', 'bunchy' ), esc_html( get_search_query() ) ); ?></h1>
						<h2 class="g1-delta g1-delta-3rd archive-subtitle"><?php esc_html_e( 'Search results', 'bunchy' ); ?></h2>
					</div>

				</div>
				<div class="g1-row-background"></div>
			</header>

			<?php if ( have_posts() ) : ?>
				<div class="g1-row g1-row-layout-page archive-body">
					<div class="g1-row-inner">

						<div class="g1-column g1-column-2of3">

							<div class="g1-collection">
								<div class="g1-collection-viewport">
									<ul class="g1-collection-items">
										<?php while ( have_posts() ) : the_post(); ?>
											<li class="g1-collection-item">
												<?php
												$bunchy_content_settings = array(
													'elements' => array(
														'featured_media' => true,
														'categories'     => true,
														'title'          => true,
														'summary'        => true,
														'author'         => true,
														'avatar'         => true,
														'date'           => true,
														'shares'         => true,
														'views'          => true,
														'comments_link'  => true,
													),
												);
												bunchy_set_template_part_data( $bunchy_content_settings );

												get_template_part( 'template-parts/content-classic', get_post_format() );
												?>
											</li>
										<?php endwhile; ?>
									</ul>
								</div>

								<?php get_template_part( 'template-parts/archive-pagination', 'pages' ); ?>
							</div><!-- .g1-collection -->
						</div><!-- .g1-column -->

						<?php get_sidebar(); ?>

					</div>
					<div class="g1-row-background g1-current-background">
					</div>
				</div><!-- .archive-body -->
			<?php else : ?>
				<?php get_template_part( 'template-parts/archive-no-results' ); ?>
			<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer();

