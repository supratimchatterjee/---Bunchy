<?php
/**
 * The Template for displaying archive pages.
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

get_header();
?>

	<div id="primary" class="g1-primary-max">
		<div id="content" role="main">

			<header class="g1-row archive-header">
				<div class="g1-row-inner">

					<h1 class="g1-alpha g1-alpha-2nd archive-title"><?php post_type_archive_title( '' ); ?></h1>

				</div>
			</header>

			<?php
			$bunchy_archive_settings = bunchy_get_archive_default_settings();

			bunchy_set_template_part_data( $bunchy_archive_settings );

			get_template_part( 'template-parts/archive-' . $bunchy_archive_settings['template'] );

			bunchy_reset_template_part_data();
			?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer();

