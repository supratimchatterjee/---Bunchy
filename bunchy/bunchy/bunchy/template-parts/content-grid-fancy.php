<?php
/**
 * The template part for displaying content
 *
 * @package Bunchy_Theme
 */

?>
<?php

$bunchy_entry_data = bunchy_get_template_part_data();
$bunchy_elements   = $bunchy_entry_data['elements'];
?>
<article <?php post_class( 'entry-tpl-grid-fancy' ); ?>>

	<?php if ( bunchy_can_use_plugin( 'snax/snax.php' ) ) : ?>
		<?php if ( snax_is_format( 'list' ) ) : ?>
			<a class="entry-badge entry-badge-open-list" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Open list', 'bunchy' ); ?></a>
		<?php endif; ?>
	<?php endif; ?>

	<div class="entry-counter"></div>

	<?php
	if ( $bunchy_elements['featured_media'] ) :
		bunchy_render_entry_featured_media( array(
			'size' => 'bunchy-grid-fancy',
		) );
	endif;
	?>

	<div class="entry-body">
		<header class="entry-header">

			<?php
			bunchy_render_entry_stats( array(
				'share_count'   => $bunchy_elements['shares'],
				'view_count'    => $bunchy_elements['views'],
				'comment_count' => $bunchy_elements['comments_link'],
			) );
			?>

			<?php the_title( sprintf( '<h3 class="g1-delta g1-delta-1st entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
		</header>

		<?php
		if ( $bunchy_elements['summary'] ) :
			the_excerpt();
		endif;
		?>

		<?php if ( $bunchy_elements['author'] || $bunchy_elements['date'] || $bunchy_elements['categories'] ) : ?>
			<footer>

				<?php if ( $bunchy_elements['author'] && $bunchy_elements['avatar'] ) : ?>
					<p class="entry-meta entry-meta-with-avatar">
				<?php else : ?>
					<p class="entry-meta">
				<?php endif; ?>

					<?php
					if ( $bunchy_elements['author'] ) :
						bunchy_render_entry_author( array( 'avatar' => $bunchy_elements['avatar'] ) );
					endif;
					?>

					<?php
					if ( $bunchy_elements['date'] ) :
						bunchy_render_entry_date();
					endif;
					?>

					<?php
					if ( $bunchy_elements['categories'] ) :
						bunchy_render_entry_categories( array( 'class' => 'entry-categories-solid' ) );
					endif;
					?>
				</p>
			</footer>
		<?php endif; ?>
	</div>
</article>
