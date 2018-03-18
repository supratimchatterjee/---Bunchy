<?php
/**
 * The template part for displaying a newsletter sign-up form inside a list collection.
 *
 * @package Bunchy_Theme
 */

?>
<li class="g1-collection-item">
	<?php if ( bunchy_can_use_plugin( 'mailchimp-for-wp/mailchimp-for-wp.php' ) ) : ?>

		<aside class="g1-box g1-box-centered g1-newsletter g1-newsletter-horizontal">
			<i class="g1-box-icon"></i>

			<header>
				<h2 class="g1-delta g1-delta-2nd"><?php esc_html_e( 'Newsletter', 'bunchy' ); ?></h2>
			</header>

			<h3 class="g1-mega g1-mega-1st"><?php echo esc_html( bunchy_get_theme_option( 'newsletter', 'title' ) ); ?></h3>
			<p class="g1-delta g1-delta-3rd"><?php echo esc_html( bunchy_get_theme_option( 'newsletter', 'subtitle' ) ); ?></p>

			<?php
			remove_filter( 'mc4wp_form_before_fields', 'bunchy_mc4wp_form_before_form', 10, 2 );
			echo do_shortcode( '[mc4wp_form]' );
			add_filter( 'mc4wp_form_before_fields', 'bunchy_mc4wp_form_before_form', 10, 2 );
			?>
		</aside>

	<?php else : ?>

		<?php get_template_part( 'template-parts/newsletter-plugin-required' ); ?>

	<?php endif; ?>
</li>
