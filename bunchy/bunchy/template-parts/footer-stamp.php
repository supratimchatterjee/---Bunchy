<?php
/**
 * The template part for displaying the footer stamp
 *
 * @package Bunchy_Theme
 */

?>
<?php
$bunchy_stamp       = bunchy_get_footer_stamp();
$bunchy_stamp_label = bunchy_get_theme_option( 'footer', 'stamp_label' );
?>

<?php if ( ! empty( $bunchy_stamp ) ) : ?>
	<a class="g1-footer-stamp" href="<?php echo esc_url( bunchy_get_theme_option( 'footer', 'stamp_url' ) ); ?>">
		<img
			class="g1-footer-stamp-icon"
			<?php echo $bunchy_stamp['width'] ? 'width="' . absint( $bunchy_stamp['width'] ) . '"' : '';  ?>
			<?php echo $bunchy_stamp['height'] ? 'height="' . absint( $bunchy_stamp['height'] ) . '"' : '';  ?>
			 src="<?php echo esc_url( $bunchy_stamp['src'] ); ?>"
			<?php echo isset( $bunchy_stamp['srcset'] ) ? 'srcset="' . esc_attr( $bunchy_stamp['srcset'] ) . '"' : '';  ?>
			 alt=""
		/>
		<?php if ( strlen( $bunchy_stamp_label ) ) : ?>
			<span class="g1-footer-stamp-label"><?php echo esc_html( $bunchy_stamp_label ); ?></span>
		<?php endif; ?>
	</a>
<?php endif;
