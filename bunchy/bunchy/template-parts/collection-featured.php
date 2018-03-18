<?php
/**
 *  The template for displaying featured entries
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

$bunchy_type = bunchy_get_theme_option( 'featured_entries', 'type' );

if ( 'none' === $bunchy_type ) {
	return;
}

$bunchy_title = esc_html__( 'Latest stories', 'bunchy' );

switch ( $bunchy_type ) {
	case 'most_viewed':
		$bunchy_title = esc_html__( 'Most viewed stories', 'bunchy' );
		break;

	case 'most_shared':
		$bunchy_title = esc_html__( 'Most shared stories', 'bunchy' );
		break;
}
?>

<aside class="g1-featured-row">
	<h2 class="g1-zeta g1-zeta-2nd g1-featured-title"><?php echo wp_kses_post( $bunchy_title ); ?></h2>

	<?php
	$bunchy_query = bunchy_get_global_featured_entries_query();

	if ( $bunchy_query->have_posts() ) {
		$bunchy_featured_entries_elements = explode( ',', bunchy_get_theme_option( 'featured_entries', 'hide_elements' ) );

		$bunchy_settings = apply_filters( 'bunchy_global_featured_entry_settings', array(
			'elements' => array(
				'featured_media' => true,
				'avatar'         => false,
				'categories'     => false,
				'title'          => true,
				'summary'        => false,
				'author'         => false,
				'date'           => false,
				'shares'         => ! in_array( 'share_count', $bunchy_featured_entries_elements, true ),
				'views'          => ! in_array( 'view_count', $bunchy_featured_entries_elements, true ),
				'comments_link'  => ! in_array( 'comment_count', $bunchy_featured_entries_elements, true ),
			),
		) );

		bunchy_set_template_part_data( $bunchy_settings );

		?>
		<div class="g1-featured">
			<ul class="g1-featured-items">
				<?php while ( $bunchy_query->have_posts() ) : $bunchy_query->the_post(); ?>

					<li class="g1-featured-item">
						<?php get_template_part( 'template-parts/content-tile-xl', get_post_format() ); ?>
					</li>

				<?php endwhile; ?>
			</ul>
		</div>
		<?php

		bunchy_reset_template_part_data();
		wp_reset_postdata();
	} else {
		?>
		<div class="g1-featured-no-results">
			<p>
				<?php esc_html_e( 'No featured entries match the criteria.', 'bunchy' ); ?><br/>
				<?php esc_html_e( 'For more information please refer to the documentation.', 'bunchy' ); ?>
			</p>
		</div>
		<?php
	}
	?>
</aside>
