<?php
/**
 * The Template for displaying ad before More From section.
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

<?php if ( bunchy_can_use_plugin( 'quick-adsense-reloaded/quick-adsense-reloaded.php' ) && ( quads_has_ad( 'bunchy_before_more_from' ) ) ) : ?>
	<div class="g1-advertisement g1-advertisement-before-more-from">

		<?php quads_ad( array( 'location' => 'bunchy_before_more_from' ) ); ?>

	</div>
<?php endif;
