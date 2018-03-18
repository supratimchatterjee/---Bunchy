<?php
/**
 * Template part for displaying single post related entries.
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

$bunchy_max_posts_to_show = 6;
$bunchy_min_posts_to_show = 6; // If there is not enough related posts, list will be supplemented with recent posts.

$bunchy_related_posts_ids = bunchy_get_related_posts_ids(
	get_the_ID(),
	$bunchy_max_posts_to_show,
	$bunchy_min_posts_to_show
);

if ( ! empty( $bunchy_related_posts_ids ) ) {
	$bunchy_args = array(
		'post__in'            => $bunchy_related_posts_ids,
		'orderby'             => 'post__in',
		'posts_per_page'      => 6,
		'ignore_sticky_posts' => true,
	);
} else {
	$bunchy_args = array();
}

$bunchy_query = new WP_Query( $bunchy_args );
?>

<?php if ( $bunchy_query->have_posts() ) : ?>
	<aside class="g1-related-entries">

		<?php
		$bunchy_related_elements = bunchy_conver_string_to_bool_array(
			bunchy_get_theme_option( 'post', 'related_hide_elements' ),
			array(
				'featured_media' => true,
				'categories'     => true,
				'summary'        => true,
				'author'         => true,
				'avatar'         => true,
				'date'           => true,
				'shares'         => true,
				'views'          => true,
				'comments_link'  => true,
			)
		);

		$bunchy_related_entries_settings = apply_filters( 'bunchy_entry_related_entries_settings', array(
			'elements' => $bunchy_related_elements,
		) );

		bunchy_set_template_part_data( $bunchy_related_entries_settings );
		?>

		<h2 class="g1-beta g1-beta-2nd"><?php esc_html_e( 'You may also like', 'bunchy' ) ?></h2>

		<div class="g1-collection g1-collection-columns-2">
			<div class="g1-collection-viewport">
				<ul class="g1-collection-items  ">
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
	</aside>
<?php endif;






