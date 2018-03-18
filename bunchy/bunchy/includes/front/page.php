<?php
/**
 * Page functions
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

/**
 * Adjust the HTML markup of pagination links
 *
 * @param array $args Arguments.
 *
 * @return array
 */
function bunchy_filter_wp_link_pages_args( $args ) {
	global $page, $numpages, $multipage, $more, $pagenow;

	$overview = bunchy_get_theme_option( 'post', 'pagination_overview' );

	$nextpagelink = __( 'Next', 'bunchy' );
	$previouspagelink = __( 'Previous', 'bunchy' );

	$before = '';
	$before .= '<nav class="g1-pagination pagelinks">';

	if ( 'none' === $overview ) {
		$before .= '<p class="g1-pagination-label g1-pagination-label-none">' . esc_html__( 'Pages:', 'bunchy' ) . '</p>';
	} elseif ( 'page_xofy' === $overview ) {
		$before .= '<p class="g1-pagination-label g1-pagination-label-xofy">' . sprintf( esc_html__( 'Page %s of %s', 'bunchy' ), intval( $page ), intval( $numpages ) ) . '</p>';
	} else {
		$before .= '<p class="g1-pagination-label g1-pagination-label-links"><strong>' . esc_html__( 'Pages:', 'bunchy' ) . '</strong></p>';
	}

	if ( 'arrow' === bunchy_get_theme_option( 'post', 'pagination_adjacent_label' ) ) {
		$before .= '<ul class="g1-pagination-just-arrows">';
	} else {
		$before .= '<ul>';
	}

	$after = '';
	$after .= '</ul>';
	$after .= '</nav>';

	if ( 'adjacent_page' === bunchy_get_theme_option( 'post', 'pagination_adjacent_label' ) ) {
		$nextpagelink       = __( 'Next page', 'bunchy' );
		$previouspagelink   = __( 'Previous page', 'bunchy' );
	}

	$args = array_merge(
		$args,
		array(
			'before'           => $before,
			'after'            => $after,
			'current_before'   => '<strong class="current">',
			'current_after'    => '</strong>',
			'link_before'      => '<span>',
			'link_after'       => '</span>',
			'next_or_number'   => 'next_and_number',
			'separator'        => '',
			'nextpagelink'     => esc_html( $nextpagelink ),
			'previouspagelink' => esc_html( $previouspagelink ),
		)
	);

	// Based on: http://www.velvetblues.com/web-development-blog/wordpress-number-next-previous-links-wp_link_pages/ .
	if ( 'next_and_number' === $args['next_or_number'] ) {
		$args['next_or_number'] = 'number';
		$prev                   = '';
		$next                   = '';
		if ( $multipage ) {
			if ( $more ) {
				$i = $page - 1;
				if ( $i && $more ) {
					$prev .= _wp_link_page( $i );
					$prev .= $args['link_before'] . $args['previouspagelink'] . $args['link_after'] . '</a>';

					if ( 'button' === bunchy_get_theme_option( 'post', 'pagination_adjacent_style' ) ) {
						$prev = '<li class="g1-pagination-item-prev">' . str_replace( '<a ', '<a class="g1-button g1-button-m g1-button-simple prev" ', $prev ) . '</li>';
					} else {
						$prev = '<li class="g1-pagination-item-prev">' . str_replace( '<a ', '<a class="g1-delta g1-delta-1st prev" ', $prev ) . '</li>';
					}
				}
				$i = $page + 1;
				if ( $i <= $numpages && $more ) {
					$next .= _wp_link_page( $i );
					$next .= $args['link_before'] . $args['nextpagelink'] . $args['link_after'] . '</a>';

					if ( 'button' === bunchy_get_theme_option( 'post', 'pagination_adjacent_style' ) ) {
						$next = '<li class="g1-pagination-item-next">' . str_replace( '<a ', '<a class="g1-button g1-button-m g1-button-simple next" ', $next ) . '</li>';
					} else {
						$next = '<li class="g1-pagination-item-next">' . str_replace( '<a ', '<a class="g1-delta g1-delta-1st next" ', $next ) . '</li>';
					}
				}
			}
		}
		$args['before'] = $args['before'] . $prev;
		$args['after']  = $next . $args['after'];
	}

	return $args;
}

/**
 * Add some markup to the output of the wp_link_pages_link function
 *
 * @param string $link Markup.
 * @param int    $i Index.
 *
 * @return string
 */
function bunchy_filter_wp_link_pages_link( $link, $i ) {
	global $page, $numpages;

	if ( $i === $page ) {
		$link = '<li class="g1-pagination-item-current">' . $link . '</li>';
	} else {
		$link = '<li class="g1-pagination-item">' . $link . '</li>';
	}

	return $link;
}


/**
 * Append the Hot entries collection to the content of the Hot page
 *
 * @param string $content Post content.
 *
 * @return string
 */
function bunchy_list_hot_entries( $content ) {
	if ( bunchy_is_hot_page() ) {
		remove_filter( 'the_content', 'bunchy_list_hot_entries', 11 );

		ob_start();
		get_template_part( 'template-parts/collection-hot' );
		$extra_content = ob_get_clean();

		add_filter( 'the_content', 'bunchy_list_hot_entries', 11 );

		$content .= $extra_content;
	}

	return $content;
}

/**
 * Append the Popular entries collection to the content of the Popular page
 *
 * @param string $content Post content.
 *
 * @return string
 */
function bunchy_list_popular_entries( $content ) {
	if ( bunchy_is_popular_page() ) {
		remove_filter( 'the_content', 'bunchy_list_popular_entries', 11 );

		ob_start();
		get_template_part( 'template-parts/collection-popular' );
		$extra_content = ob_get_clean();

		add_filter( 'the_content', 'bunchy_list_popular_entries', 11 );

		$content .= $extra_content;
	}

	return $content;
}

/**
 * Append the TrendingHot entries collection to the content of the Trending page
 *
 * @param string $content Post content.
 *
 * @return string
 */
function bunchy_list_trending_entries( $content ) {
	if ( bunchy_is_trending_page() ) {
		remove_filter( 'the_content', 'bunchy_list_trending_entries', 11 );

		ob_start();
		get_template_part( 'template-parts/collection-trending' );
		$extra_content = ob_get_clean();

		add_filter( 'the_content', 'bunchy_list_trending_entries', 11 );

		$content .= $extra_content;
	}

	return $content;
}
