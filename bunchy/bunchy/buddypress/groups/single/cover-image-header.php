<?php
/**
 * BuddyPress - Groups Cover Image Header.
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<div id="cover-image-container">
	<a id="header-cover-image" href="<?php bp_group_permalink(); ?>"></a>

	<?php if ( bunchy_bp_show_group_cover_image_change_link() ) : ?>
		<?php bunchy_bp_render_group_cover_image_change_link(); ?>
	<?php endif; ?>

	<div id="item-header-cover-image">
	</div><!-- #item-header-cover-image -->
</div><!-- #cover-image-container -->

