<?php
/**
 * The Template for displaying archive "Load More" pagination.
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

<?php if ( null !== get_next_posts_link() ) : ?>
	<div class="g1-collection-more">
		<div class="g1-collection-more-inner">
			<a href="#"
			   class="g1-button g1-button-m g1-button-solid g1-load-more"
			   data-g1-next-page-url="<?php echo esc_url( get_next_posts_page_link() ); ?>">
				<?php esc_html_e( 'Load More', 'bunchy' ) ?>
			</a>
			<i class="g1-collection-more-icon"></i>
		</div>
	</div>
<?php endif;
