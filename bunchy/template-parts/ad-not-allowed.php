<?php
/**
 * The Template for displaying info about missing plugin to render an ad box.
 *
 * @package Bunchy_Theme
 * @license For the full license information, please view the Licensing folder
 * that was distributed with this source code.
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
?>

<?php if ( current_user_can( 'edit_plugins' ) ) : ?>
	<div class="g1-message g1-message-warning">
		<div class="g1-message-inner">
			<p><?php esc_html_e( 'An ad cannot be displayed here due to one of following reasons', 'bunchy' ); ?>:</p>
			<ul>
				<li><?php esc_html_e( 'ad is not assigned to this location', 'bunchy' ); ?></li>
				<li><?php esc_html_e( 'maximum number of ads on a single page has been reached', 'bunchy' ); ?></li>
			</ul>
		</div>
	</div>
<?php endif;
