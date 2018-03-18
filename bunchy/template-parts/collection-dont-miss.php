<?php
/**
 * Template part for displaying single post "Don't Miss" section.
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
$bunchy_query = get_transient( 'bunchy_dont_miss_query' );

if ( false === $bunchy_query ) {
	$bunchy_query_args = array(
		'posts_per_page'      => 6,
		'time_range'          => 'month',
		'ignore_sticky_posts' => true,
	);

	// Exclude the current post.
	if ( is_single() ) {
		$bunchy_query_args['post__not_in'] = array( get_the_ID() );
	}

	// Short circuit.
	if ( has_filter( 'bunchy_pre_dont_miss_query_args', false ) ) {
		$bunchy_query_args = apply_filters( 'bunchy_pre_dont_miss_query_args', $bunchy_query_args );
	} else {
		$bunchy_query_args = bunchy_get_most_viewed_query_args( $bunchy_query_args, 'dont_miss' );
	}

	$bunchy_query = new WP_Query( $bunchy_query_args );

	set_transient( 'bunchy_dont_miss_query', $bunchy_query );
}
?>

<aside class="g1-dont-miss">
	<h2 class="g1-beta g1-beta-2nd"><?php esc_html_e( 'Don\'t Miss', 'bunchy' ); ?></h2>

	<?php if ( $bunchy_query->have_posts() ) : ?>

		<?php
		$bunchy_dont_miss_elements = bunchy_conver_string_to_bool_array(
			bunchy_get_theme_option( 'post', 'dont_miss_hide_elements' ),
			array(
				'featured_media' => true,
				'avatar'         => true,
				'categories'     => true,
				'summary'        => true,
				'author'         => true,
				'date'           => true,
				'shares'         => true,
				'views'          => true,
				'comments_link'  => true,
			)
		);

		$bunchy_settings = apply_filters( 'bunchy_entry_dont_miss_settings', array(
			'elements' => $bunchy_dont_miss_elements,
		) );

		bunchy_set_template_part_data( $bunchy_settings );
		?>
		<div class="g1-collection g1-collection-columns-2">
			<div class="g1-collection-viewport">
				<ul class="g1-collection-items">
					<?php while ( $bunchy_query->have_posts() ) : $bunchy_query->the_post(); ?>

						<li class="g1-collection-item g1-collection-item-1of3">
							<?php get_template_part( 'template-parts/content-grid-standard', get_post_format() ); ?>
						</li>

					<?php endwhile; ?>
				</ul>
			</div>
		</div>

		<?php bunchy_reset_template_part_data(); ?>
		<?php wp_reset_postdata(); ?>

	<?php else : ?>
		<?php get_template_part( 'template-parts/most-viewed-empty-list-info' ); ?>
	<?php endif; ?>

</aside>

