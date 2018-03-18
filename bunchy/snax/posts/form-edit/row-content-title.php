<?php
/**
 * Snax News Post Row Title
 *
 * @package snax
 * @subpackage Theme
 */

?>
<div class="snax-edit-post-row-title<?php echo snax_has_field_errors( 'title' ) ? ' snax-validation-error' : ''; ?>">
	<label for="snax-post-title"><?php esc_html_e( 'Title', 'bunchy' ); ?></label>

	<?php if ( snax_has_field_errors( 'title' ) ) : ?>
		<span class="snax-validation-tip"><?php echo esc_html( snax_get_field_errors( 'title' ) ); ?></span>
	<?php endif; ?>

	<h1 class="g1-mega g1-mega-1st" id="snax-post-title-editable"></h1>

	<input name="snax-post-title"
		   id="snax-post-title"
		   type="text"
		   value="<?php echo esc_attr( snax_get_field_values( 'title' ) ); ?>"
		   placeholder="<?php esc_attr_e( 'Enter title&hellip;', 'bunchy' ); ?>"
		   autocomplete="off"
		   maxlength="<?php echo esc_attr( snax_get_post_title_max_length() ); ?>"
		   required
	/>
</div>

