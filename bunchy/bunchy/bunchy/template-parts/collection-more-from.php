<?php
/**
 * Template part for displaying posts from the same category as current post.
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

$bunchy_post_first_category = bunchy_get_post_first_category( get_the_ID() );

if ( ! empty( $bunchy_post_first_category ) ) {
	$bunchy_args = array(
		'cat'                 => $bunchy_post_first_category->term_id,
		'post__not_in'        => array( get_the_ID() ), // Exclude current post.
		'posts_per_page'      => 6,
		'ignore_sticky_posts' => true,
	);
} else {
	$bunchy_args = array();
}

$bunchy_query = new WP_Query( $bunchy_args );
?>

<?php if ( $bunchy_query->have_posts() ) : ?>

	<?php
	$bunchy_more_from_elements = bunchy_conver_string_to_bool_array(
		bunchy_get_theme_option( 'post', 'more_from_hide_elements' ),
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

	$bunchy_settings = apply_filters( 'bunchy_entry_more_from_settings', array(
		'elements' => $bunchy_more_from_elements,
	) );

	bunchy_set_template_part_data( $bunchy_settings );
	?>
	<aside class="g1-more-from">
		<h2 class="g1-beta g1-beta-2nd"><?php printf( wp_kses_post( __( 'More From: <a href="%s">%s</a>', 'bunchy' ) ), esc_url( get_category_link( $bunchy_post_first_category->term_id ) ), esc_html( $bunchy_post_first_category->name ) ) ?></h2>

		<div class="g1-collection">
			<div class="g1-collection-viewport">
				<ul class="g1-collection-items">
					<?php while ( $bunchy_query->have_posts() ) : $bunchy_query->the_post(); ?>

						<li class="g1-collection-item">
							<?php get_template_part( 'template-parts/content-list-standard', get_post_format() ); ?>
						</li>

					<?php endwhile; ?>
				</ul>
			</div>
		</div>

		<?php bunchy_reset_template_part_data(); ?>
		<?php wp_reset_postdata(); ?>
	</aside>
<?php endif;
