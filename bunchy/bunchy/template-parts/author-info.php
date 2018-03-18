<?php
/**
 * The Template Part for displaying "About Author" box.
 *
 * For the full license information, please view the Licensing folder
 * that was distributed with this source code.
 *
 * @package Bunchy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
?>
<?php if ( post_type_supports( get_post_type(), 'author' ) && get_the_author_meta( 'description' ) ) : ?>
	<section class="author-info" itemscope="" itemtype="http://schema.org/Person">
		<div class="author-info-inner">

			<header class="author-title">
				<h2 class="g1-delta g1-delta-1st"><?php printf( wp_kses_post( __( 'Written by <a href="%s"><span itemprop="name">%s</span></a>', 'bunchy' ) ), esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), get_the_author() ); ?></h2>
			</header>

			<figure class="author-avatar">
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
					<?php echo get_avatar( get_the_author_meta( 'email' ), 70 ); ?>
				</a>
			</figure>

			<div itemprop="description" class="author-bio">
				<?php echo wp_kses_post( wpautop( get_the_author_meta( 'description' ) ) ); ?>
			</div>

		</div>
	</section>
<?php endif;
