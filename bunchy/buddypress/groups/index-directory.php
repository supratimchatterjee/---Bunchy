<?php
/**
 * The Template for displaying pages.
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
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope=""
				         itemtype="<?php echo esc_attr( bunchy_get_entry_microdata_itemtype() ); ?>">
					<header class="g1-row g1-row-layout-page entry-header entry-header-row g1-bp-header-row">
						<div class="g1-row-inner">
							<div class="g1-column">
								<?php the_title( '<h1 class="g1-alpha g1-alpha-2nd entry-title">', '</h1>' ); ?>

								<?php
								if ( bunchy_can_use_plugin( 'wp-subtitle/wp-subtitle.php' ) ) :
									the_subtitle( '<h2 class="g1-delta g1-delta-3rd entry-subtitle">', '</h2>' );
								endif;
								?>

								<div id="group-dir-search" class="dir-search" role="search">
									<?php bp_directory_groups_search_form(); ?>
								</div><!-- #group-dir-search -->

							</div>
						</div>
						<div class="g1-row-background">
						</div>
					</header><!-- .entry-header -->

					<div class="g1-row g1-row-layout-page g1-row-padding-m">
						<div class="g1-row-inner">

							<div class="g1-column g1-column-2of3">
								<div class="entry-content">
									<?php
									the_content();
									wp_link_pages();
									?>
								</div><!-- .entry-content -->
							</div>

							<?php get_sidebar(); ?>

						</div>
						<div class="g1-row-background">
						</div>
					</div>

				</article><!-- #post-## -->

			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer();
