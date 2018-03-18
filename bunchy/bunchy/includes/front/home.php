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
 * Alters home template based on theme options
 *
 * @param string $template Template name.
 *
 * @return string
 */
function bunchy_home_alter_template( $template ) {
	$home_settings = bunchy_get_home_settings();

	$new_template = $home_settings['template'];
	$new_template = sprintf( 'g1-template-home-%s.php', $new_template );

	$new_template = locate_template( $new_template );

	if ( ! empty( $new_template ) ) {
		return $new_template;
	}

	return $template;
}

/**
 * Get home page settings.
 *
 * @return array
 */
function bunchy_get_home_settings() {
	$featured_entries_category = bunchy_get_theme_option( 'home', 'featured_entries_category' );

	if ( is_array( $featured_entries_category ) ) {
		$featured_entries_category = implode( ',', $featured_entries_category );
	}

	return apply_filters( 'bunchy_home_settings', array(
		'template'         => bunchy_get_theme_option( 'home', 'template' ),
		'pagination'       => bunchy_get_theme_option( 'home', 'pagination' ),
		'elements'         => bunchy_get_archive_elements_visibility_arr( bunchy_get_theme_option( 'home', 'hide_elements' ) ),
		'featured_entries' => array(
			'type'          => bunchy_get_theme_option( 'home', 'featured_entries' ),
			'time_range'    => bunchy_get_theme_option( 'home', 'featured_entries_time_range' ),
			'elements'      => bunchy_get_archive_elements_visibility_arr( bunchy_get_theme_option( 'home', 'featured_entries_hide_elements' ) ),
			'category_name' => $featured_entries_category,
			'tag_slug__in'  => array_filter( bunchy_get_theme_option( 'home', 'featured_entries_tag' ) ),
		),
	) );
}

/**
 * Inject a newsletter sign-up form into the loop.
 *
 * @param string $template_type Classic, grid or list.
 * @param int    $post_number The current position in the loop.
 */
function bunchy_home_inject_newsletter_into_loop( $template_type, $post_number ) {
	$inject = bunchy_get_theme_option( 'home', 'newsletter' ) === 'standard';

	if ( ! $inject ) {
		return;
	}

	$inject_after_post = absint( bunchy_get_theme_option( 'home', 'newsletter_after_post' ) );

	$posts_per_page = (int) get_option( 'posts_per_page' );
	$current_page   = absint( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
	$page_offset    = ( $current_page - 1 ) * $posts_per_page;

	$post_preceding_newsletter_found           = ( $post_number + $page_offset === $inject_after_post );
	$injected_newsletter_still_on_current_page = ( $posts_per_page + $page_offset > $inject_after_post );

	if ( $post_preceding_newsletter_found && $injected_newsletter_still_on_current_page ) {
		get_template_part( 'template-parts/newsletter-inside-' . $template_type );
	}
}

/**
 * Inject an advertisement into the home loop.
 *
 * @param string $template_type Classic, grid or list.
 * @param int    $post_number The current position in the loop.
 */
function bunchy_home_inject_ad_into_loop( $template_type, $post_number ) {
	$inject = bunchy_get_theme_option( 'home', 'ad' ) === 'standard';

	if ( ! $inject ) {
		return;
	}

	$inject_after_post = absint( bunchy_get_theme_option( 'home', 'ad_after_post' ) );

	$posts_per_page = (int) get_option( 'posts_per_page' );
	$current_page   = absint( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
	$page_offset    = ( $current_page - 1 ) * $posts_per_page;

	$post_preceding_ad_found           = ( $post_number + $page_offset === $inject_after_post );
	$injected_ad_still_on_current_page = ( $posts_per_page + $page_offset > $inject_after_post );

	if ( $post_preceding_ad_found && $injected_ad_still_on_current_page ) {
		get_template_part( 'template-parts/ad-inside-' . $template_type );
	}
}

/**
 * Set maximum number of entries to show on the home page.
 *
 * @param WP_Query $query Home main query.
 */
function bunchy_home_set_posts_per_page( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( ! is_home() ) {
		return;
	}

	$posts_per_page = (int) get_option( 'posts_per_page' );
	$offset         = $query->get( 'offset' );

	if ( $posts_per_page <= 0 ) {
		return;
	}

	$current_page   = absint( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
	$list_min_index = ( $current_page - 1 ) * $posts_per_page;
	$list_max_index = $list_min_index + $posts_per_page;

	$inject_newsletter = bunchy_get_theme_option( 'home', 'newsletter' ) === 'standard';

	// Count "newsletter" as an item.
	if ( $inject_newsletter ) {
		$inject_after_post = absint( bunchy_get_theme_option( 'home', 'newsletter_after_post' ) );

		$is_inside_the_list         = ( $inject_after_post > $list_min_index ) && ( $inject_after_post < $list_max_index );
		$was_injected_on_prev_pages = $inject_after_post < $list_min_index;

		if ( $is_inside_the_list ) {
			// Offset and posts_per_page work together, so if want to change posts_per_page, we need init the offset first.
			if ( empty( $offset ) ) {
				$offset = $list_min_index;
			}

			$posts_per_page --;
		} elseif ( $was_injected_on_prev_pages ) {
			if ( empty( $offset ) ) {
				$offset = $list_min_index;
			}

			$offset --;
		}
	}

	// Count "ad" as an item.
	$inject_ad = bunchy_get_theme_option( 'home', 'ad' ) === 'standard';

	if ( $inject_ad ) {
		$inject_after_post = absint( bunchy_get_theme_option( 'home', 'ad_after_post' ) );

		$is_inside_the_list         = ( $inject_after_post > $list_min_index ) && ( $inject_after_post < $list_max_index );
		$was_injected_on_prev_pages = $inject_after_post < $list_min_index;

		// Ad must be inside the list.
		if ( $is_inside_the_list ) {
			// Offset and posts_per_page work together, so if want to change posts_per_page, we need init the offset first.
			if ( empty( $offset ) ) {
				$offset = $list_min_index;
			}

			$posts_per_page --;
		} elseif ( $was_injected_on_prev_pages ) {
			if ( empty( $offset ) ) {
				$offset = $list_min_index;
			}
			$offset --;
		}
	}

	$query->set( 'posts_per_page', $posts_per_page );
	$query->set( 'offset', $offset );
}

/**
 * Adjust the home pagination.
 *
 * @param int      $found_posts Number of found posts.
 * @param WP_Query $query Home main query.
 *
 * @return mixed
 */
function bunchy_home_adjust_offset_pagination( $found_posts, $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return $found_posts;
	}

	if ( ! is_home() ) {
		return $found_posts;
	}

	$posts_per_page = (int) get_option( 'posts_per_page' );

	if ( $posts_per_page <= 0 ) {
		return $found_posts;
	}

	$current_page   = absint( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
	$list_min_index = ( $current_page - 1 ) * $posts_per_page;

	// Count "newsletter" as an item.
	$inject_newsletter = bunchy_get_theme_option( 'home', 'newsletter' ) === 'standard';

	if ( $inject_newsletter ) {
		$inject_after_post = absint( bunchy_get_theme_option( 'home', 'newsletter_after_post' ) );

		$was_injected = $inject_after_post < $list_min_index;

		if ( $was_injected ) {
			$found_posts ++;
		}
	}

	// Count "ad" as an item.
	$inject_ad = bunchy_get_theme_option( 'home', 'ad' ) === 'standard';

	if ( $inject_ad ) {
		$inject_after_post = absint( bunchy_get_theme_option( 'home', 'ad_after_post' ) );

		$was_injected = $inject_after_post < $list_min_index;

		if ( $was_injected ) {
			$found_posts ++;
		}
	}

	$home_featured_posts_count = count( bunchy_get_home_featured_posts_ids() );

	// Decrease by number of featured posts. Those posts are excluded from main query.
	$found_posts = $found_posts - $home_featured_posts_count;

	return $found_posts;
}

/**
 * Get featured post ids.
 *
 * @return array
 */
function bunchy_get_home_featured_posts_ids() {
	$home_settings    = bunchy_get_home_settings();
	$featured_entries = $home_settings['featured_entries'];

	if ( 'none' === $featured_entries['type'] ) {
		return array();
	}

	$featured_entries['posts_per_page'] = strpos( $home_settings['template'], 'one-featured' ) !== false ? 1 : 3;

	return bunchy_get_featured_posts_ids( $featured_entries );
}

/**
 * Exclude the featured content from the home main query.
 *
 * @param WP_Query $query Home main query.
 */
function bunchy_home_exclude_featured( $query ) {
	if ( ! $query->is_main_query() || is_feed() ) {
		return;
	}

	if ( ! is_home() ) {
		return;
	}

	$excluded_ids = bunchy_get_home_featured_posts_ids();

	if ( bunchy_show_global_featured_entries() ) {
		$global_featured_ids = bunchy_get_global_featured_posts_ids();

		if ( ! empty( $global_featured_ids ) ) {
			$excluded_ids = array_merge( $excluded_ids, $global_featured_ids );

			$excluded_ids = array_unique( $excluded_ids );
		}
	}

	if ( ! empty( $excluded_ids ) ) {
		$query->set( 'post__not_in', $excluded_ids );

		// When we exclude posts from main query, it can be left empty.
		// We don't want to show empty loop info because featured entries are there.
		add_filter( 'bunchy_show_archive_no_results', '__return_false' );
	}
}

/**
 * Get the title of the home collection.
 *
 * @return string
 */
function bunchy_get_home_title() {
	$settings = bunchy_get_home_settings();

	$title = __( 'Latest stories', 'bunchy' );

	if ( 'recent' === $settings['featured_entries']['type'] ) {
		$title = __( 'More stories', 'bunchy' );
	}

	return $title;
}
