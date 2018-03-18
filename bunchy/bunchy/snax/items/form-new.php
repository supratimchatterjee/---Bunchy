<?php
/**
 * New item form
 *
 * @package snax
 * @subpackage Theme
 */

?>
<?php if ( ! snax_is_post_open_for_submission() ) : ?>

	<p><?php esc_html_e( 'This list is closed for submission.', 'bunchy' ); ?></p>

<?php elseif ( is_user_logged_in() && ! current_user_can( 'snax_add_items' ) ) : ?>

	<p><?php esc_html_e( 'You don\'t have sufficient permissions to submit new item.', 'bunchy' ); ?></p>

<?php elseif ( is_user_logged_in() && snax_user_reached_submitted_items_limit() ) : ?>

	<p><?php esc_html_e( 'You\'ve reached the limit for adding new items', 'bunchy' ); ?></p>

<?php else : ?>

<div class="snax snax-new-item-wrapper" id="snax-new-item-wrapper-<?php the_ID(); ?>">

	<?php if ( 1 < count( snax_get_new_item_forms() ) ) : ?>
		<h2 class="g1-beta g1-beta-2nd snax-new-item-wrapper-title"><?php esc_html_e( 'Add your submission', 'bunchy' ); ?></h2>
	<?php endif; ?>

	<?php snax_render_snax_new_item_tabs(); ?>

	<?php foreach ( snax_get_new_item_forms() as $snax_key => $snax_value ) : ?>
		<?php
		$snax_class = array(
			'snax-tab-content',
			'snax-tab-content-blur',
			'snax-tab-content-' . $snax_key,
		);

		if ( snax_get_selected_new_item_form() === $snax_key ) {
			$snax_class[] = 'snax-tab-content-current';
		}
		?>
		<div class="<?php echo implode( ' ', array_map( 'sanitize_html_class', $snax_class ) ); ?>">
			<?php snax_get_template_part( 'items/form-new-' . $snax_key ); ?>
		</div>
	<?php endforeach; ?>
</div>

<?php endif; ?>
