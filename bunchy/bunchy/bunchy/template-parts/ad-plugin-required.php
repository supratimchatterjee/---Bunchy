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
			<p><?php printf( wp_kses_post( __( 'This ad cannot be displayed. The <strong>%s</strong> plugin is not activated.', 'bunchy' ) ), esc_html( 'WP QUADS' ) ); ?></p>
			<p><?php printf( wp_kses_post( __( 'If you want to use other ads plugin, please refer to the <a href="%s" target="_blank">documentation</a>.', 'bunchy' ) ), esc_url( 'http://docs.bunchy.bringthepixel.com/#g1docs-use-other-ads-plugin' ) ); ?></p>
		</div>
	</div>
<?php endif;
