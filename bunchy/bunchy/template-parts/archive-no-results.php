<?php
/**
 * The Template Part for displaying the "No results" message, when there are no posts in the loop.
 *
 * @license For the full license information, please view the Licensing folder
 * that was distributed with this source code.
 *
 * @package Bunchy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
?>

<div class="g1-row g1-row-layout-page g1-row-padding-m">
	<div class="g1-row-inner">
		<div class="g1-column">

			<?php if ( apply_filters( 'bunchy_show_archive_no_results', true ) ) : ?>
				<p class="no-results">
					<?php esc_html_e( 'Apologies, but no results were found.', 'bunchy' ); ?>
				</p>
			<?php endif; ?>

		</div>
	</div>
	<div class="g1-row-background">
	</div>
</div>
