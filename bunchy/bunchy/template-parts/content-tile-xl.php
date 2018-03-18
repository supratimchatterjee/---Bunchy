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

<article <?php post_class( 'entry-tpl-tile entry-tpl-tile-xl g1-dark' ); ?>>

	<?php if ( bunchy_can_use_plugin( 'snax/snax.php' ) ) : ?>
		<?php if ( snax_is_format( 'list' ) ) : ?>
			<a class="entry-badge entry-badge-open-list" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Open list', 'bunchy' ); ?></a>
		<?php endif; ?>
	<?php endif; ?>

	<?php
	if ( $bunchy_elements['featured_media'] ) :
		bunchy_render_entry_featured_media( array(
			'size'              => 'bunchy-tile',
			'background_image'  => true,
			'force_placeholder' => true,
		) );
	endif;
	?>

	<header class="entry-header">
		<?php the_title( sprintf( '<h3 class="g1-gamma g1-gamma-1st g1lg-beta entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

		<div class="entry-after-title">
			<?php
			bunchy_render_entry_stats( array(
				'share_count'   => $bunchy_elements['shares'],
				'view_count'    => $bunchy_elements['views'],
				'comment_count' => $bunchy_elements['comments_link'],
			) );
			?>
		</div>
	</header>
</article>
