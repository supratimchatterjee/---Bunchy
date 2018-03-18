<?php
/**
 * The template part for displaying the site identification inside the header.
 *
 * @package Bunchy_Theme
 */

?>

<div class="g1-id">
	<?php
	$bunchy_site_title = get_bloginfo( 'name' );
	$bunchy_logo       = bunchy_get_logo();
	?>
	<?php if ( is_front_page() ) : ?>
		<h1 class="g1-mega g1-mega-2nd site-title">
	<?php else : ?>
		<p class="g1-mega g1-mega-2nd site-title">
	<?php endif; ?>

		<a class="<?php echo sanitize_html_class( ! empty( $bunchy_logo ) ? 'g1-logo-wrapper' : '' ); ?>"
		   href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php if ( ! empty( $bunchy_logo ) ) : ?>
				<img
					class="g1-logo g1-logo-default"
					<?php echo $bunchy_logo['width'] ? 'width="' . absint( $bunchy_logo['width'] ) . '"' : '';  ?>
					<?php echo $bunchy_logo['height'] ? 'height="' . absint( $bunchy_logo['height'] ) . '"' : '';  ?>
					src="<?php echo esc_url( $bunchy_logo['src'] ); ?>"
					<?php echo isset( $bunchy_logo['srcset'] ) ? 'srcset="' . esc_attr( $bunchy_logo['srcset'] ) . '"' : '';  ?>
					alt="<?php echo esc_attr( $bunchy_site_title ); ?>"
				/>
			<?php else : ?>
				<?php echo wp_kses_post( $bunchy_site_title ); ?>
			<?php endif; ?>
		</a>

	<?php if ( is_front_page() ) : ?>
		</h1>
	<?php else : ?>
		</p>
	<?php endif; ?>

	<?php if ( bunchy_get_theme_option( 'branding', 'show_tagline' ) ) : ?>
		<p class="g1-delta g1-delta-3rd site-description"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
	<?php endif; ?>
</div>
