<?php
/**
 * Call to action
 *
 * @package snax
 * @subpackage Theme
 */

?>
<div class="snax-cta">
	<?php do_action( 'snax_cta_start' ); ?>

	<div class="snax-cta-body">
		<p class="g1-alpha g1-alpha-1st"><?php echo esc_html( $snax_cta_text_before ); ?></p>

		<form action="<?php echo esc_url( snax_get_frontend_submission_page_url() ); ?>" method="get">
			<button class="snax-button snax-button-create"><?php echo esc_html( $snax_cta_button_label ); ?></button>
		</form>
	</div>

	<?php do_action( 'snax_cta_end' ); ?>
</div>





