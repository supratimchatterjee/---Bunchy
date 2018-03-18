<?php
/**
 * The template part for displaying the featured content.
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

$bunchy_template_data                      = bunchy_get_template_part_data();
$bunchy_featured_entries                   = $bunchy_template_data['featured_entries'];
$bunchy_featured_entries['posts_per_page'] = 1;

$bunchy_featured_ids = bunchy_get_featured_posts_ids( $bunchy_featured_entries );

$bunchy_query_args = array();

if ( ! empty( $bunchy_featured_ids ) ) {
	$bunchy_query_args['post__in']            = $bunchy_featured_ids;
	$bunchy_query_args['orderby']             = 'post__in';
	$bunchy_query_args['ignore_sticky_posts'] = true;
}

$bunchy_title = wp_kses_post( __( 'Latest <span>stories</span>', 'bunchy' ) );

switch ( $bunchy_featured_entries['type'] ) {
	case 'most_shared':
		$bunchy_title = wp_kses_post( __( 'Most <span>shared</span>', 'bunchy' ) );
		break;

	case 'most_viewed':
		$bunchy_title = wp_kses_post( __( 'Most <span>viewed</span>', 'bunchy' ) );
		break;
}

$bunchy_query = new WP_Query( $bunchy_query_args );
?>

<?php if ( $bunchy_query->have_posts() ) : ?>
	<section class="archive-featured">
		<?php bunchy_set_template_part_data( $bunchy_featured_entries ); ?>

		<h2 class="g1-delta g1-delta-2nd archive-featured-title"><?php echo wp_kses_post( $bunchy_title ); ?></h2>

		<?php while ( $bunchy_query->have_posts() ) : $bunchy_query->the_post(); ?>

			<?php get_template_part( 'template-parts/content-feat', get_post_format() ); ?>

		<?php endwhile; ?>

		<?php
		bunchy_reset_template_part_data();
		wp_reset_postdata();
		?>
	</section>
<?php endif;
