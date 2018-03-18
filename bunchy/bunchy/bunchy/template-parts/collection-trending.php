<?php
/**
 * Template for displaying trending posts.
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

$bunchy_limit      = bunchy_get_trending_posts_limit();
$bunchy_post_ids   = bunchy_get_trending_post_ids( $bunchy_limit );
$bunchy_query_args = array();

if ( ! empty( $bunchy_post_ids ) ) {
	$bunchy_query_args = array(
		'post__in'            => $bunchy_post_ids,
		'orderby'             => 'post__in',
		'posts_per_page'      => $bunchy_limit,
		'ignore_sticky_posts' => true,
	);
}

$bunchy_query_args = apply_filters( 'bunchy_trending_posts_query_args', $bunchy_query_args );

$bunchy_query = new WP_Query( $bunchy_query_args );
?>

<?php if ( $bunchy_query->have_posts() ) : ?>

	<?php
	$bunchy_settings = apply_filters( 'bunchy_trending_entry_settings', array(
		'elements' => array(
			'featured_media' => true,
			'categories'     => false,
			'title'          => true,
			'summary'        => false,
			'author'         => false,
			'avatar'         => false,
			'date'           => false,
			'shares'         => false,
			'views'          => false,
			'comments_link'  => false,
		),
	) );

	bunchy_set_template_part_data( $bunchy_settings );
	?>

	<div class="g1-collection g1-trending-content">
		<div class="g1-collection-viewport">
			<ul class="g1-collection-items">

				<?php while ( $bunchy_query->have_posts() ) : $bunchy_query->the_post(); ?>
					<li class="g1-collection-item">
						<?php get_template_part( 'template-parts/content-list-fancy', get_post_format() ); ?>
					</li>
				<?php endwhile; ?>

			</ul>
		</div>

	</div><!-- .g1-collection -->

	<?php bunchy_reset_template_part_data(); ?>
	<?php wp_reset_postdata(); ?>

<?php else : ?>
	<?php get_template_part( 'template-parts/most-viewed-empty-list-info' ); ?>
<?php endif;

