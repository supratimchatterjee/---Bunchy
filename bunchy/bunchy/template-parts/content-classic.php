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

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-tpl-index entry-tpl-index-stickies' ); ?>>
	<div class="entry-box">
		<?php
		bunchy_render_entry_stats( array(
			'share_count'   => $bunchy_elements['shares'],
			'view_count'    => $bunchy_elements['views'],
			'comment_count' => $bunchy_elements['comments_link'],
		) );
		?>


		<header class="entry-header">
			<?php the_title( sprintf( '<h2 class="g1-alpha g1-alpha-1st entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		</header>

		<?php if ( bunchy_can_use_plugin( 'snax/snax.php' ) ) : ?>
			<?php get_template_part( 'template-parts/snax-bar-post' ); ?>
		<?php endif; ?>

		<?php bunchy_render_entry_flags(); ?>

		<?php
		if ( $bunchy_elements['featured_media'] ) :
			bunchy_render_entry_featured_media( array(
				'size' => 'bunchy-index',
			) );
		endif;
		?>


		<?php if ( $bunchy_elements['author'] && $bunchy_elements['avatar'] ) : ?>
			<p class="entry-meta entry-meta-with-avatar">
		<?php else : ?>
			<p class="entry-meta">
		<?php endif; ?>

			<?php if ( $bunchy_elements['author'] || $bunchy_elements['date'] || $bunchy_elements['categories'] ) : ?>

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
			<?php endif; ?>
		</p>

		<div class="entry-body">
			<?php if ( $bunchy_elements['summary'] ) : ?>
				<div class="entry-summary g1-typography-xl">
					<?php the_excerpt(); ?>
				</div>
			<?php endif; ?>


		</div>
	</div>

	<div class="entry-actions snax">
		<?php if ( bunchy_can_use_plugin( 'snax/snax.php' ) ) : ?>
			<?php snax_render_voting_box(); ?>
		<?php endif; ?>
	</div>
</article>
