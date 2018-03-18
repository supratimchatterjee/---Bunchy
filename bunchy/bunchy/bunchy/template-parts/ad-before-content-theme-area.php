<?php
/**
 * The Template for displaying ad after post content.
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

<?php if ( bunchy_can_use_plugin( 'quick-adsense-reloaded/quick-adsense-reloaded.php' ) && ( quads_has_ad( 'bunchy_before_content_theme_area' ) ) ) : ?>
	<div class="g1-row g1-row-layout-page g1-advertisement g1-advertisement-before-content-theme-area">
		<div class="g1-row-inner">
			<div class="g1-column">

				<?php quads_ad( array( 'location' => 'bunchy_before_content_theme_area' ) ); ?>

			</div>
		</div>
		<div class="g1-row-background"></div>
	</div>
<?php endif;
