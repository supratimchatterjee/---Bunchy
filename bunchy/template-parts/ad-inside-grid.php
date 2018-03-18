<?php
/**
 * The Template for displaying ad inside collection (grid).
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
<li class="g1-collection-item">
	<?php if ( bunchy_can_use_plugin( 'quick-adsense-reloaded/quick-adsense-reloaded.php' ) ) : ?>

		<?php if ( quads_has_ad( 'bunchy_inside_grid' ) ) : ?>

			<div class="g1-advertisement g1-advertisement-inside-grid">

				<?php quads_ad( array( 'location' => 'bunchy_inside_grid' ) ); ?>

			</div>

		<?php else : ?>

			<?php get_template_part( 'template-parts/ad-not-allowed' ); ?>

		<?php endif; ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/ad-plugin-required' ); ?>

	<?php endif; ?>
</li>
