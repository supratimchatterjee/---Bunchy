<?php
/**
 * Snax Post Voting Box Template Part
 *
 * @package snax
 * @subpackage Theme
 */

?>
<?php if ( snax_show_item_voting_box() ) : ?>
<div class="snax-voting-container">
	<h2 class="snax-voting-container-title g1-beta g1-beta-2nd"><?php esc_html_e( 'Leave your vote', 'bunchy' ); ?></h2>
	<?php snax_render_voting_box( null, 0, 'snax-voting-large' ); ?>
</div>
<?php endif; ?>
