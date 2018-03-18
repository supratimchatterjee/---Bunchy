<?php
/**
 * The Template Part for displaying archive "Prev/Next" pagination.
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

global $wp_query;

$range = 3;

$posts_per_page = absint( get_query_var( 'posts_per_page' ) );
$paged          = absint( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
$max_num_pages  = absint( $wp_query->max_num_pages ) ? absint( $wp_query->max_num_pages ) : 1;
$request        = $wp_query->request;
$found_posts    = $wp_query->found_posts;

$max_num_links = 2 * $range + 1;
$start_at      = 0;
$end_at        = 0;

if ( $max_num_links >= $max_num_pages ) {
	$start_at = 1;
	$end_at   = $max_num_pages;
} else {
	// Determine first page to display.
	$start_at = $paged - $range;
	if ( $start_at < 1 ) {
		$start_at = 1;
	}

	// Determine last page to display.
	$end_at = $paged + $range;
	if ( $end_at > $max_num_pages ) {
		$end_at = $max_num_pages;
	}
}
?>

<?php if ( $max_num_pages > 1 ) : ?>
	<nav class="g1-pagination">
		<p class="g1-pagination-label"><strong><?php esc_html_e( 'Pages', 'bunchy' ); ?></strong></p>

		<ul>

			<?php
			// Previous Page Link.
			$prev_page = $paged - 1;
			?>
			<?php if ( $prev_page >= 1 ) : ?>
				<li class="g1-pagination-item-prev">
					<a class="g1-delta g1-delta-2nd prev" href="<?php echo esc_url( get_pagenum_link( $prev_page ) ); ?>"><?php esc_html_e( 'Previous', 'bunchy' ); ?></a>
				</li>
			<?php endif; ?>

			<?php for ( $i = $start_at; $i <= $end_at; $i ++ ) : ?>
				<?php if ( $i !== $paged ) : ?>
					<li>
						<a href="<?php echo esc_url( get_pagenum_link( $i ) ); ?>"><?php echo intval( $i ); ?></a>
					</li>
				<?php else : ?>
					<li class="g1-pagination-item-current">
						<strong><?php echo intval( $i ); ?></strong>
					</li>
				<?php endif; ?>
			<?php endfor; ?>

			<?php
			// Next Page Link.
			$next_page = $paged + 1;
			?>
			<?php if ( $next_page <= $max_num_pages ) : ?>
				<li class="g1-pagination-item-next">
					<a class="g1-delta g1-delta-2nd next" href="<?php echo esc_url( get_pagenum_link( $next_page ) ); ?>"><?php esc_html_e( 'Next', 'bunchy' ); ?></a>
				</li>
			<?php endif; ?>

		</ul>
	</nav>
<?php endif;
