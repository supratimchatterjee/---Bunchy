<?php
/**
 * The default template for displaying single post content (with sidebar).
 * This is a template part. It must be used within The Loop.
 *
 * @package Bunchy_Theme
 */

$bunchy_entry_data = bunchy_get_template_part_data();
$bunchy_elements   = $bunchy_entry_data['elements'];
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-tpl-classic' ); ?>>

	<?php if ( bunchy_can_use_plugin( 'snax/snax.php' ) ) : ?>
		<?php get_template_part( 'template-parts/snax-bar-post' ); ?>
	<?php endif; ?>

	<?php bunchy_render_entry_flags(); ?>

	<?php
	if ( $bunchy_elements['featured_media'] ) :
		bunchy_render_entry_featured_media( array(
			'size' => 'bunchy-grid-2of3',
		) );
	endif;
	?>

	<div class="entry-body">
		<div class="entry-box">
			<header class="entry-header">
				<?php the_title( sprintf( '<h2 class="g1-alpha g1-alpha-1st entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>


				<p class="entry-meta">

					<?php if ( $bunchy_elements['author'] || $bunchy_elements['date'] || $bunchy_elements['categories'] || $bunchy_elements['shares'] || $bunchy_elements['views'] || $bunchy_elements['comments_link'] ) : ?>

						<?php
						if ( $bunchy_elements['author'] ) :
							bunchy_render_entry_author( array(
								'avatar'      => $bunchy_elements['avatar'],
								'avatar_size' => 30,
							) );
						endif;
						?>

						<?php
						if ( $bunchy_elements['date'] ) :
							bunchy_render_entry_date();
						endif;
						?>

						<?php
						if ( $bunchy_elements['categories'] ) :
							bunchy_render_entry_categories();
						endif;
						?>

						<?php
						if ( $bunchy_elements['shares'] ) :
							bunchy_render_entry_share_count();
						endif;
						?>

						<?php
						if ( $bunchy_elements['views'] ) :
							bunchy_render_entry_view_count();
						endif;
						?>

						<?php
						if ( $bunchy_elements['comments_link'] ) :
							bunchy_render_entry_comments_link();
						endif;
						?>

					<?php endif; ?>
				</p>
			</header>

			<?php if ( $bunchy_elements['summary'] ) : ?>
				<div class="entry-summary g1-typography-xl">
					<?php the_excerpt(); ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="entry-actions snax">
			<?php if ( bunchy_can_use_plugin( 'snax/snax.php' ) ) : ?>
					<?php snax_render_voting_box(); ?>
			<?php endif; ?>
		</div>
	</div>
</article>
