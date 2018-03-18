<?php
/**
 * The Template Part for displaying the footer.
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
?>

<?php if ( bunchy_show_prefooter() ) : ?>
	<div class="g1-row g1-row-layout-page g1-prefooter">
		<div class="g1-row-inner">

			<div class="g1-column g1-column-1of3">
				<?php dynamic_sidebar( 'footer-1' ); ?>
			</div>

			<div class="g1-column g1-column-1of3">
				<?php dynamic_sidebar( 'footer-2' ); ?>
			</div>

			<div class="g1-column g1-column-1of3">
				<?php dynamic_sidebar( 'footer-3' ); ?>
			</div>

		</div>
		<div class="g1-row-background">
		</div>
	</div>
<?php endif; ?>

<div class="g1-row g1-row-layout-page g1-footer">
	<div class="g1-row-inner">
		<div class="g1-column">

			<p class="g1-footer-text"><?php echo wp_kses_post( bunchy_get_theme_option( 'footer', 'text' ) ); ?></p>

			<?php
			if ( has_nav_menu( 'bunchy_footer_nav' ) ) :
				wp_nav_menu( array(
					'theme_location'  => 'bunchy_footer_nav',
					'container'       => 'nav',
					'container_class' => 'g1-footer-nav',
					'container_id'    => 'g1-footer-nav',
					'menu_class'      => '',
					'menu_id'         => 'g1-footer-nav-menu',
					'depth'           => 0,
				) );
			endif;
			?>

			<?php get_template_part( 'template-parts/footer-stamp' ); ?>

		</div><!-- .g1-column -->
	</div>
	<div class="g1-row-background">
	</div>
</div><!-- .g1-row -->

<?php if ( apply_filters( 'bunchy_render_back_to_top', true ) ) : ?>
	<a href="#page" class="g1-back-to-top"><?php esc_html_e( 'Back to Top', 'bunchy' ); ?></a>
<?php endif; ?>

</div><!-- #page -->

<div class="g1-canvas-overlay"></div>

</div><!-- .g1-body-inner -->
<div id="g1-breakpoint-desktop"></div>
<div class="g1-canvas g1-canvas-global">
	<a class="g1-canvas-toggle" href="#"></a>
	<div class="g1-canvas-content">
	</div>
</div>


<?php wp_footer(); ?>
</body>
</html>
