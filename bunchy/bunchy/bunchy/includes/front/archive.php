<?php
/**
 * Archive functions
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
 * Get the default archive settings
 *
 * @return mixed|void
 */
function bunchy_get_archive_default_settings() {
	return apply_filters( 'bunchy_archive_default_settings', array(
		'template'         => 'one-featured-list-sidebar',
		'pagination'       => 'load-more',
		'featured_entries' => array(
			'type' => 'none',
		),
		'elements'         => array(
			'featured_media' => true,
			'categories'     => true,
			'title'          => true,
			'summary'        => true,
			'author'         => true,
			'avatar'         => true,
			'date'           => true,
			'shares'         => true,
			'views'          => true,
			'comments_link'  => true,
		),
	) );
}

/**
 * Get archive settings
 *
 * @return mixed|void
 */
function bunchy_get_archive_settings() {
	return apply_filters( 'bunchy_archive_settings', array(
		'template'         => bunchy_get_theme_option( 'archive', 'template' ),
		'pagination'       => bunchy_get_theme_option( 'archive', 'pagination' ),
		'elements'         => bunchy_get_archive_elements_visibility_arr( bunchy_get_theme_option( 'archive', 'hide_elements' ) ),
		'featured_entries' => array(
			'type'       => bunchy_get_theme_option( 'archive', 'featured_entries' ),
			'time_range' => bunchy_get_theme_option( 'archive', 'featured_entries_time_range' ),
			'elements'   => bunchy_get_archive_elements_visibility_arr( bunchy_get_theme_option( 'archive', 'featured_entries_hide_elements' ) ),
		),
	) );
}

/**
 * Inject newsletter sign-up form into the loop.
 *
 * @param string $template_type Classic, grid or list.
 * @param int    $post_number The current position in the loop.
 */
function bunchy_archive_inject_newsletter_into_loop( $template_type, $post_number ) {
	$inject = bunchy_get_theme_option( 'archive', 'newsletter' ) === 'standard';

	if ( ! $inject ) {
		return;
	}

	$inject_after_post = absint( bunchy_get_theme_option( 'archive', 'newsletter_after_post' ) );

	$posts_per_page = absint( bunchy_get_theme_option( 'archive', 'posts_per_page' ) );
	$paged          = absint( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
	$offset         = ( $paged - 1 ) * $posts_per_page;

	$is_on_correct_page = ( $post_number + $offset === $inject_after_post );
	$is_inside_the_list = ( $posts_per_page + $offset > $inject_after_post );

	if ( $is_on_correct_page && $is_inside_the_list ) {
		get_template_part( 'template-parts/newsletter-inside-' . $template_type );
	}
}

/**
 * Inject an advertisement into the main archive loop.
 *
 * @param string $template_type Classic, grid or list.
 * @param int    $post_number The current position in the loop.
 */
function bunchy_archive_inject_ad_into_loop( $template_type, $post_number ) {
	$inject = bunchy_get_theme_option( 'archive', 'ad' ) === 'standard';

	if ( ! $inject ) {
		return;
	}

	$inject_after_post = absint( bunchy_get_theme_option( 'archive', 'ad_after_post' ) );

	$posts_per_page = absint( bunchy_get_theme_option( 'archive', 'posts_per_page' ) );
	$paged          = absint( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
	$offset         = ( $paged - 1 ) * $posts_per_page;

	$is_on_correct_page = ( $post_number + $offset === $inject_after_post );
	$is_inside_the_list = ( $posts_per_page + $offset > $inject_after_post );

	if ( $is_on_correct_page && $is_inside_the_list ) {
		get_template_part( 'template-parts/ad-inside-' . $template_type );
	}
}

/**
 * Get ids of featured posts on an archive page.
 *
 * @return array
 */
function bunchy_get_archive_featured_posts_ids() {
	$settings         = bunchy_get_archive_settings();
	$featured_entries = $settings['featured_entries'];

	if ( 'none' === $featured_entries['type'] ) {
		return array();
	}

	$featured_entries['posts_per_page'] = strpos( $settings['template'], 'one-featured' ) !== false ? 1 : 3;

	return bunchy_get_featured_posts_ids( $featured_entries );
}

/**
 * Exclude featured content from archive loops
 *
 * @param WP_Query $query Archive main query.
 */
function bunchy_archive_exclude_featured( $query ) {
	if ( ! $query->is_main_query() || is_feed() ) {
		return;
	}

	if ( ! is_archive() ) {
		return;
	}

	$excluded_ids = bunchy_get_archive_featured_posts_ids();

	if ( ! empty( $excluded_ids ) ) {
		$query->set( 'post__not_in', $excluded_ids );

		// When we exclude posts from main query, it can be left empty.
		// We don't want to show empty loop info because featured entries are there.
		add_filter( 'bunchy_show_archive_no_results', '__return_false' );
	}
}

/**
 * Set maximum number of entries on archive pages
 *
 * @param WP_Query $query Archive main query.
 */
function bunchy_archive_set_posts_per_page( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( ! is_archive() ) {
		return;
	}

	$posts_per_page = (int) bunchy_get_theme_option( 'archive', 'posts_per_page' );
	$offset         = $query->get( 'offset' );

	if ( - 1 === $posts_per_page || $posts_per_page > 0 ) {
		if ( $posts_per_page > 0 ) {
			$current_page   = absint( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
			$list_min_index = ( $current_page - 1 ) * $posts_per_page;
			$list_max_index = $list_min_index + $posts_per_page;

			$inject_newsletter = bunchy_get_theme_option( 'archive', 'newsletter' ) === 'standard';

			// Count "newsletter" as an item.
			if ( $inject_newsletter ) {
				$inject_after_post = absint( bunchy_get_theme_option( 'archive', 'newsletter_after_post' ) );

				$is_inside_the_list = ( $inject_after_post > $list_min_index ) && ( $inject_after_post < $list_max_index );
				$was_injected       = $inject_after_post < $list_min_index;

				if ( $is_inside_the_list ) {
					// Offset and posts_per_page work together, so if want to change posts_per_page, we need init the offset first.
					if ( empty( $offset ) ) {
						$offset = $list_min_index;
					}

					$posts_per_page --;
				} elseif ( $was_injected ) {
					if ( empty( $offset ) ) {
						$offset = $list_min_index;
					}

					$offset --;
				}
			}

			$inject_ad = bunchy_get_theme_option( 'archive', 'ad' ) === 'standard';

			// Count "ad" as an item.
			if ( $inject_ad ) {
				$inject_after_post = absint( bunchy_get_theme_option( 'archive', 'ad_after_post' ) );

				$is_inside_the_list = ( $inject_after_post > $list_min_index ) && ( $inject_after_post < $list_max_index );
				$was_injected       = $inject_after_post < $list_min_index;

				if ( $is_inside_the_list ) {
					// Offset and posts_per_page work together, so if want to change posts_per_page, we need init the offset first.
					if ( empty( $offset ) ) {
						$offset = $list_min_index;
					}

					$posts_per_page --;
				} elseif ( $was_injected ) {
					if ( empty( $offset ) ) {
						$offset = $list_min_index;
					}

					$offset --;
				}
			}
		}

		$query->set( 'posts_per_page', $posts_per_page );
		$query->set( 'offset', $offset );
	}
}

/**
 * Adjust maximum entries to show on archive pages.
 *
 * @param int      $found_posts Number of found posts.
 * @param WP_Query $query Archive main query.
 *
 * @return mixed
 */
function bunchy_archive_adjust_offset_pagination( $found_posts, $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return $found_posts;
	}

	if ( ! is_archive() ) {
		return $found_posts;
	}

	$posts_per_page = (int) bunchy_get_theme_option( 'archive', 'posts_per_page' );

	if ( $posts_per_page <= 0 ) {
		return $found_posts;
	}

	$current_page   = absint( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
	$list_min_index = ( $current_page - 1 ) * $posts_per_page;

	// Count "newsletter" as an item.
	$inject_newsletter = bunchy_get_theme_option( 'archive', 'newsletter' ) === 'standard';

	if ( $inject_newsletter ) {
		$inject_after_post = absint( bunchy_get_theme_option( 'archive', 'newsletter_after_post' ) );

		$was_injected = $inject_after_post < $list_min_index;

		if ( $was_injected ) {
			$found_posts ++;
		}
	}

	// Count "ad" as an item.
	$inject_ad = bunchy_get_theme_option( 'archive', 'ad' ) === 'standard';

	if ( $inject_ad ) {
		$inject_after_post = absint( bunchy_get_theme_option( 'archive', 'ad_after_post' ) );

		$was_injected = $inject_after_post < $list_min_index;

		if ( $was_injected ) {
			$found_posts ++;
		}
	}

	$archive_featured_posts_count = count( bunchy_get_archive_featured_posts_ids() );

	// Decrease by number of featured posts. Those posts are excluded from main query.
	$found_posts = $found_posts - $archive_featured_posts_count;

	return $found_posts;
}

/**
 * Get archive elements visibility configuration.
 *
 * @param string $elements_to_hide_str Comma-separated list of elements to hide.
 *
 * @return mixed
 */
function bunchy_get_archive_elements_visibility_arr( $elements_to_hide_str ) {
	$elements_to_hide_arr = explode( ',', $elements_to_hide_str );
	$defaults             = bunchy_get_archive_default_settings();
	$all_elements         = $defaults['elements'];

	foreach ( $all_elements as $elem_id => $is_visible ) {
		if ( in_array( $elem_id, $elements_to_hide_arr, true ) ) {
			$all_elements[ $elem_id ] = false;
		}
	}

	return $all_elements;
}

/**
 * Whether or not we are on the "Latest" page
 *
 * @return bool
 */
function bunchy_is_latest_page() {
	return is_home();
}

/**
 * Get the URL of the "Latest" page
 *
 * @return mixed|void
 */
function bunchy_get_latest_page_url() {
	$url = get_home_url();

	$enabled = bunchy_get_theme_option( 'posts', 'latest_page' );

	if ( ! $enabled ) {
		$url = '';
	}

	return apply_filters( 'bunchy_latest_page_url', $url );
}

/**
 * Get the label of the "Latest" page
 *
 * @return string|void
 */
function bunchy_get_latest_page_label() {
	$posts_page_id = absint( get_option( 'page_for_posts' ) );

	if ( $posts_page_id > 0 ) {
		$label = get_the_title( $posts_page_id );
	} else {
		$label = __( 'Latest', 'bunchy' );
	}

	return $label;
}


/**
 * Get the id of the "Hot" page.
 *
 * @return int
 */
function bunchy_get_hot_page_id() {
	$page_id = bunchy_get_theme_option( 'posts', 'hot_page' );

	if ( ! $page_id ) {
		$page_id = - 1;
	}

	return apply_filters( 'bunchy_hot_page_id', $page_id );
}

/**
 * Whether or not we are on the "Hot" page
 *
 * @return bool
 */
function bunchy_is_hot_page() {
	return is_page( bunchy_get_hot_page_id() );
}

/**
 * Get the URL of the "Hot" page.
 *
 * @return int
 */
function bunchy_get_hot_page_url() {
	return get_permalink( bunchy_get_hot_page_id() );
}

/**
 * Get the label of the "Hot" page
 *
 * @return string
 */
function bunchy_get_hot_page_label() {
	return get_the_title( bunchy_get_hot_page_id() );
}


/**
 * Get the id of the "Popular" page.
 *
 * @return int
 */
function bunchy_get_popular_page_id() {
	$page_id = bunchy_get_theme_option( 'posts', 'popular_page' );

	if ( ! $page_id ) {
		$page_id = - 1;
	}

	return apply_filters( 'bunchy_popular_page_id', $page_id );
}

/**
 * Whether or not we are on the "Popular" page
 *
 * @return bool
 */
function bunchy_is_popular_page() {
	return is_page( bunchy_get_popular_page_id() );
}

/**
 * Get the URL of the "Popular" page.
 *
 * @return int
 */
function bunchy_get_popular_page_url() {
	return get_permalink( bunchy_get_popular_page_id() );
}

/**
 * Get the label of the "Popular" page
 *
 * @return string
 */
function bunchy_get_popular_page_label() {
	return get_the_title( bunchy_get_popular_page_id() );
}


/**
 * Get the id of the "Trending" page.
 *
 * @return int
 */
function bunchy_get_trending_page_id() {
	$page_id = bunchy_get_theme_option( 'posts', 'trending_page' );

	if ( ! $page_id ) {
		$page_id = - 1;
	}

	return apply_filters( 'bunchy_trending_page_id', $page_id );
}

/**
 * Whether or not we are on the "Trending" page
 *
 * @return bool
 */
function bunchy_is_trending_page() {
	return is_page( bunchy_get_trending_page_id() );
}

/**
 * Get the URL of the "Trending" page.
 *
 * @return int
 */
function bunchy_get_trending_page_url() {
	return get_permalink( bunchy_get_trending_page_id() );
}

/**
 * Get the label of the "Trending" page
 *
 * @return string
 */
function bunchy_get_trending_page_label() {
	return get_the_title( bunchy_get_trending_page_id() );
}

/**
 * Update populat, hot, trending lists
 */
function bunchy_update_lists() {
	$update_lists = ( false === get_transient( 'bunchy_lists_up_to_date' ) );   // Transiend expired.

	if ( $update_lists ) {
		do_action( 'bunchy_update_hot_posts' );
		do_action( 'bunchy_update_popular_posts' );
		do_action( 'bunchy_update_trending_posts' );

		$expiration_time = apply_filters( 'bunchy_update_lists_interval', 60 * 60 * 24 ); // One day.

		set_transient( 'bunchy_lists_up_to_date', 'up_to_date', $expiration_time );
	}
}
