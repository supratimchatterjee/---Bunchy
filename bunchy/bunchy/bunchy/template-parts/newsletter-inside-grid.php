<?php
/**
 * The template part for a newsletter sign-up form inside a grid collection.
 *
 * @package Bunchy_Theme
 */

?>
<li class="g1-collection-item">
	<?php if ( bunchy_can_use_plugin( 'mailchimp-for-wp/mailchimp-for-wp.php' ) ) : ?>

		<div class="g1-box g1-box-centered g1-newsletter">
			<i class="g1-box-icon"></i>

			<header>
				<h2 class="g1-delta g1-delta-2nd"><?php esc_html_e( 'Newsletter', 'bunchy' ); ?></h2>
			</header>

			<?php echo do_shortcode( '[mc4wp_form]' ); ?>
		</div>

	<?php else : ?>

		<?php get_template_part( 'template-parts/newsletter-plugin-required' ); ?>

	<?php endif; ?>
</li>
