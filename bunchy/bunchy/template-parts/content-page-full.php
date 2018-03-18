<?php
/**
 * The template used for displaying page content
 *
 * @package Bunchy_Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="" itemtype="<?php echo esc_attr( bunchy_get_entry_microdata_itemtype() ); ?>">
	<header class="g1-row g1-row-layout-page entry-header entry-header-row">
		<div class="g1-row-inner">
			<div class="g1-column">
				<?php the_title( '<h1 class="g1-alpha g1-alpha-2nd entry-title" itemprop="headline">', '</h1>' ); ?>

				<?php
				if ( bunchy_can_use_plugin( 'wp-subtitle/wp-subtitle.php' ) ) :
					the_subtitle( '<h2 class="g1-delta g1-delta-3rd entry-subtitle" itemprop="description">', '</h2>' );
				endif;
				?>
			</div>
		</div>
		<div class="g1-row-background">
		</div>
	</header><!-- .entry-header -->

	<?php bunchy_render_entry_featured_media(); ?>

	<div class="g1-row g1-row-layout-page g1-row-padding-m">
		<div class="g1-row-inner">
			<div class="g1-column">
				<div class="entry-content" itemprop="text">
					<?php
					the_content();
					wp_link_pages();
					?>
				</div><!-- .entry-content -->

				<?php if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif; ?>

			</div>
		</div>
		<div class="g1-row-background"></div>
	</div>

</article><!-- #post-## -->
