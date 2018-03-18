<?php
/**
 * Post functions
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
 * Alters single post template based on theme options
 *
 * @param  string $template Template.
 *
 * @return string
 */
function bunchy_post_alter_single_template( $template ) {
	$object = get_queried_object();

	if ( 'post' !== $object->post_type ) {
		return $template;
	}

	$templates = array();

	$s        = bunchy_get_theme_option( 'post', 'template' );
	$filename = sprintf( 'g1_template_post_%s', $s );

	// Keep in mind the WordPress template hierarchy
	// Read more about it here https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post .
	array_unshift( $templates,
		"{$filename}-{$object->post_type}-{$object->post_name}.php",
		"{$filename}-{$object->post_type}.php",
		"{$filename}.php"
	);

	$templates = array_unique( $templates );

	if ( count( $templates ) ) {
		$new_template = locate_template( $templates );

		if ( ! empty( $new_template ) ) {
			return $new_template;
		}
	}

	return $template;
}

/**
 * Adjust post classes.
 *
 * @param array $classes Post classes.
 *
 * @return array
 */
function bunchy_post_class( $classes ) {
	// Add custom classes.
	if ( bunchy_is_post_trending() ) {
		$classes[] = 'wpp-post-trending';
	}

	if ( bunchy_is_post_popular() ) {
		$classes[] = 'wpp-post-popular';
	}

	if ( bunchy_is_post_hot() ) {
		$classes[] = 'wpp-post-hot';
	}

	// Remove classes.
	return array_diff( $classes, array(
		// We'll be using schema.org microdata instead of microformats.
		'hentry'
	) );
}

/**
 * Get default settings for a post
 *
 * @return mixed|void
 */
function bunchy_get_post_default_settings() {
	return apply_filters( 'bunchy_post_default_settings', array(
		'template' => 'classic',
		'elements' => array(
			'featured_media'  => true,
			'categories'      => true,
			'author'          => true,
			'avatar'          => true,
			'date'            => true,
			'comments_link'   => true,
			'shares_top'      => true,
			'tags'            => true,
			'shares_bottom'   => true,
			'newsletter'      => true,
			'navigation'      => true,
			'author_info'     => true,
			'related_entries' => true,
			'more_from'       => true,
			'dont_miss'       => true,
			'comments'        => true,
			'views'           => true,
		),
	) );
}

/**
 * Get post settings
 *
 * @return mixed|void
 */
function bunchy_get_post_settings() {
	return apply_filters( 'bunchy_post_settings', array(
		'template' => bunchy_get_theme_option( 'post', 'template' ),
		'elements' => bunchy_get_post_elements_visibility_arr( bunchy_get_theme_option( 'post', 'hide_elements' ) ),
	) );
}

/**
 * Get the post elements visibility configuration
 *
 * @param string $elements_to_hide_str Comma-separated list of elements to hide.
 *
 * @return mixed
 */
function bunchy_get_post_elements_visibility_arr( $elements_to_hide_str ) {
	$elements_to_hide_arr = explode( ',', $elements_to_hide_str );
	$defaults             = bunchy_get_post_default_settings();
	$all_elements         = $defaults['elements'];

	foreach ( $all_elements as $elem_id => $is_visible ) {
		if ( in_array( $elem_id, $elements_to_hide_arr, true ) ) {
			$all_elements[ $elem_id ] = false;
		}
	}

	return $all_elements;
}

/**
 * Get ids of related posts
 *
 * @param int $post_id Post id.
 * @param int $limit Maximum number of ids to return.
 * @param int $min_entries Minimum number of ids to return.
 *
 * @return array
 */
function bunchy_get_related_posts_ids( $post_id = 0, $limit = 10, $min_entries = 0 ) {
	return bunchy_get_related_entries_ids( $post_id, 'post', $limit, $min_entries );
}

/**
 * Get ids of related entries
 *
 * @param int    $post_id Post id.
 * @param string $post_type Post type.
 * @param int    $limit Limit.
 * @param int    $min_entries Minimum entries.
 *
 * @return array
 */
function bunchy_get_related_entries_ids( $post_id = 0, $post_type = 'post', $limit = 10, $min_entries = 0 ) {
	if ( ! $post_id ) {
		global $post;

		$post_id = $post ? $post->ID : 0;
	}

	$min_entries = min( $min_entries, $limit );

	$post_id = absint( $post_id );

	if ( $post_id <= 0 ) {
		return array();
	}

	$related_ids = array();

	$tags = get_the_terms( $post_id, 'post_tag' );

	if ( ! empty( $tags ) ) {
		$tag_ids = wp_list_pluck( $tags, 'term_id' );

		global $wpdb;

		$tag_ids = implode( ', ', array_map( 'intval', $tag_ids ) );

		// Custom SQL query.
		// Standard query_posts function doesn't have enough power to produce results we need.
		$bunchy_query = $wpdb->prepare(
			"
				SELECT p.ID, COUNT(t_r.object_id) AS cnt
	            FROM {$wpdb->term_relationships} AS t_r, {$wpdb->posts} AS p
	            WHERE t_r.object_id = p.ID
	                AND t_r.term_taxonomy_id IN( $tag_ids )
	                AND p.post_type= %s
	                AND p.ID != %d
	                AND p.post_status= %s
	            GROUP BY t_r.object_id
	            ORDER BY cnt DESC, p.post_date_gmt DESC
			",
			$post_type,
			$post_id,
			'publish'
		);

		if ( $limit > 0 ) {
			$bunchy_query .= $wpdb->prepare( ' LIMIT %d', $limit );
		}

		// Run the query.
		$posts = $wpdb->get_results( $bunchy_query );

		if ( ! empty( $posts ) ) {
			foreach ( $posts as $p ) {
				$related_ids[] = (int) $p->ID;
			}
		}
	}

	// Complement entries.
	if ( $min_entries > 0 && count( $related_ids ) < $min_entries ) {
		$entires_to_add = $min_entries - count( $related_ids );

		$query_args = array(
			'posts_per_page'      => $entires_to_add,
			'post_type'           => $post_type,
			'post_status'         => 'publish',
			'post__not_in'        => array_merge( $related_ids, array( $post_id ) ),
			'ignore_sticky_posts' => true,
		);

		$query = new WP_Query();
		$posts = $query->query( $query_args );

		foreach ( $posts as $post ) {
			$related_ids[] = $post->ID;
		}
	}

	return $related_ids;
}

/**
 * Get post taxonomies
 *
 * @param int  $post_id Post id.
 * @param bool $hierarchical Whether or not to return hierarchical taxonomies.
 *
 * @return mixed|void
 */
function bunchy_get_post_taxonomies( $post_id, $hierarchical = true ) {
	$post_obj         = get_post( $post_id );
	$taxonomy_objects = get_object_taxonomies( $post_obj, 'objects' );

	// Remove taxonomies.
	foreach ( $taxonomy_objects as $name => $object ) {
		// Non-public.
		if ( ! $object->query_var ) {
			unset( $taxonomy_objects[ $name ] );
		}

		// None hierarchical, if hierarchical requested.
		if ( $hierarchical && ! $object->hierarchical ) {
			unset( $taxonomy_objects[ $name ] );
		}

		// Hierarchical, if none hierarchical requested.
		if ( ! $hierarchical && $object->hierarchical ) {
			unset( $taxonomy_objects[ $name ] );
		}
	}

	return apply_filters( 'bunchy_post_taxonomies', $taxonomy_objects );
}

/**
 * Get post terms
 *
 * @param int  $post_id Post id.
 * @param bool $hierarchical_taxonomies Whether or not include hierarchical terms.
 *
 * @return array
 */
function bunchy_get_post_terms( $post_id, $hierarchical_taxonomies = true ) {
	$taxonomies = bunchy_get_post_taxonomies( $post_id, $hierarchical_taxonomies );

	$taxonomy_terms = array();

	foreach ( $taxonomies as $object ) {
		$terms = apply_filters( 'bunchy_post_terms', get_the_terms( $post_id, $object->name ) );

		if ( ! empty( $terms ) ) {
			$taxonomy_terms[ $object->name ] = $terms;
		}
	}

	return $taxonomy_terms;
}

/**
 * Get the first category assigned to post
 *
 * @param int $post_id Post id.
 *
 * @return mixed|null
 */
function bunchy_get_post_first_category( $post_id ) {
	$terms = bunchy_get_post_terms( $post_id, true );

	if ( empty( $terms ) ) {
		return null;
	}

	$first_taxonomy_terms = array_shift( $terms );
	$first_term           = array_shift( $first_taxonomy_terms );

	return $first_term;
}

/**
 * Whether a post is popular.
 *
 * @param int|WP_Post $p Optional. Post ID or WP_Post object. Default is global `$post`.
 *
 * @return bool
 */
function bunchy_is_post_popular( $p = null ) {
	$post_obj = get_post( $p );

	$meta_value = get_post_meta( $post_obj->ID, '_bunchy_popular', true );

	return apply_filters( 'bunchy_is_post_popular', ! empty( $meta_value ), $post_obj->ID );
}

/**
 * Get ids of popular posts
 *
 * @param int $limit Maximum number of ids to return.
 *
 * @return array
 */
function bunchy_get_popular_post_ids( $limit = 10 ) {
	$ids = array();

	$query_args = array(
		'meta_key'            => '_bunchy_popular',
		'orderby'             => 'meta_value_num',
		'order'               => 'ASC',
		'posts_per_page'      => $limit,
		'ignore_sticky_posts' => true,
	);

	$query = new WP_Query();
	$posts = $query->query( $query_args );

	foreach ( $posts as $post ) {
		$ids[] = $post->ID;
	}

	return apply_filters( 'bunchy_popular_post_ids', $ids, $limit );
}

/**
 * Whether the post is hot.
 *
 * @param int|WP_Post $p Optional. Post ID or WP_Post object. Default is global `$post`.
 *
 * @return bool
 */
function bunchy_is_post_hot( $p = null ) {
	$post_obj = get_post( $p );

	$meta_value = get_post_meta( $post_obj->ID, '_bunchy_hot', true );

	return apply_filters( 'bunchy_is_post_hot', ! empty( $meta_value ), $post_obj->ID );
}

/**
 * Get ids of hot posts
 *
 * @param int $limit Maximum number of ids to return.
 *
 * @return array
 */
function bunchy_get_hot_post_ids( $limit = 10 ) {
	$ids = array();

	$query_args = array(
		'meta_key'            => '_bunchy_hot',
		'orderby'             => 'meta_value_num',
		'order'               => 'ASC',
		'posts_per_page'      => $limit,
		'ignore_sticky_posts' => true,
	);

	$query = new WP_Query();
	$posts = $query->query( $query_args );

	foreach ( $posts as $post ) {
		$ids[] = $post->ID;
	}

	return apply_filters( 'bunchy_hot_post_ids', $ids, $limit );
}

/**
 * Whether the post is trending.
 *
 * @param int|WP_Post $p Optional. Post ID or WP_Post object. Default is global `$post`.
 *
 * @return bool
 */
function bunchy_is_post_trending( $p = null ) {
	$post_obj = get_post( $p );

	$meta_value = get_post_meta( $post_obj->ID, '_bunchy_trending', true );

	return apply_filters( 'bunchy_is_post_trending', ! empty( $meta_value ), $post_obj->ID );
}

/**
 * Get ids of trending posts
 *
 * @param int $limit Maximum numbef of ids to return.
 *
 * @return mixed|void
 */
function bunchy_get_trending_post_ids( $limit = 10 ) {
	$ids = array();

	$query_args = array(
		'meta_key'            => '_bunchy_trending',
		'orderby'             => 'meta_value_num',
		'order'               => 'ASC',
		'posts_per_page'      => $limit,
		'ignore_sticky_posts' => true,
	);

	$query = new WP_Query();
	$posts = $query->query( $query_args );

	foreach ( $posts as $post ) {
		$ids[] = $post->ID;
	}

	return apply_filters( 'bunchy_trending_post_ids', $ids, $limit );
}

/**
 * Get ids of featured posts
 *
 * @param array $query_args Query arguments.
 *
 * @return array
 */
function bunchy_get_featured_posts_ids( $query_args ) {
	// Static var as a simple cache
	// in one request, it's enough to calculate featured ids just once.
	static $featured_ids;

	if ( isset( $featured_ids ) ) {
		return $featured_ids;
	}

	// WP_Query args.
	$defaults = array(

		'posts_per_page'      => 10,
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
		'category__in'        => array(),
		'tag__in'             => array(),
		// Custom args.
		'type'                => 'recent',
		'time_range'          => 'all',
	);

	$query_args = wp_parse_args( $query_args, $defaults );

	if ( bunchy_show_global_featured_entries() ) {
		$global_featured_ids = bunchy_get_global_featured_posts_ids();

		if ( ! empty( $global_featured_ids ) ) {
			$query_args['post__not_in'] = $global_featured_ids;
		}
	}

	// Remove custom args form $args.
	$type       = $query_args['type'];
	$time_range = $query_args['time_range'];

	unset( $query_args['type'] );
	unset( $query_args['time_range'] );

	// Map custom args to WP_Query args.
	$query_args = bunchy_time_range_to_date_query( $time_range, $query_args );

	if ( is_category() ) {
		$query_args['category__in'][] = get_queried_object()->term_id;
	}

	if ( is_tag() ) {
		$query_args['tag__in'][] = get_queried_object()->term_id;
	}

	if ( is_tax() ) {
		$taxonomy = get_queried_object()->taxonomy;
		$term_id  = get_queried_object()->term_id;

		$query_args['tax_query'] = array(
			array(
				'taxonomy' => $taxonomy,
				'field'    => 'term_id',
				'terms'    => $term_id,
			),
		);
	}

	// Filter by author.
	if ( is_author() ) {
		$author = get_user_by( 'id', get_query_var( 'author' ) );

		// Try to get author by slug if ID not set.
		if ( false === $author ) {
			$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
		}

		if ( false !== $author ) {
			$query_args['author'] = $author->ID;
		}
	}

	switch ( $type ) {
		case 'recent':
			$query_args['orderby'] = 'date';
			break;

		case 'most_shared':
			$query_args = bunchy_get_most_shared_query_args( $query_args );
			break;

		case 'most_viewed':
			$query_args = bunchy_get_most_viewed_query_args( $query_args, 'featured_posts_ids' );
			break;
	}

	$query_args = apply_filters( 'bunchy_featured_posts_query_args', $query_args );
	$query      = new WP_Query();
	$posts      = $query->query( $query_args );

	$featured_ids = array();

	foreach ( $posts as $post ) {
		$featured_ids[] = $post->ID;
	}

	return $featured_ids;
}

/**
 * Format a number to a more compact form
 *
 * @param int $number Number.
 *
 * @return string
 */
function bunchy_format_number( $number ) {
	$number_formatted = $number;

	if ( $number > 1000000 ) {
		$number_formatted = round( $number / 1000000, 1 ) . esc_html_x( 'M', 'formatted number suffix', 'bunchy' );
	} elseif ( $number > 1000 ) {
		$number_formatted = round( $number / 1000, 1 ) . esc_html_x( 'k', 'formatted number suffix', 'bunchy' );
	}

	return $number_formatted;
}




/**
 * Add the "read more" link to the excerpt.
 *
 * @param string $excerpt Post excerpt.
 * @return string
 */
function bunchy_excerpt_more( $excerpt ) {
	if ( strlen( $excerpt ) ) {
		$excerpt .= sprintf(
			' <a class="g1-link g1-link-more" href="%1$s">%2$s</a>',
			esc_url( get_permalink() ),
			__( 'More', 'bunchy' )
		);
	}

	return $excerpt;
}

/**
 * Return query object for global featured entries
 *
 * @return WP_Query
 */
function bunchy_get_global_featured_entries_query() {
// Get built query from cache.
	$bunchy_query = get_transient( 'bunchy_featured_entries_query' );

	// Build cache if not set.
	if ( false === $bunchy_query ) {
		// Common args.
		$bunchy_query_args = array(
			'posts_per_page'      => 3,
			'ignore_sticky_posts' => true,
		);

		$bunchy_type 		= bunchy_get_theme_option( 'featured_entries', 'type' );
		$bunchy_time_range 	= bunchy_get_theme_option( 'featured_entries', 'time_range' );

		// Category.
		$bunchy_query_args['category_name'] = bunchy_get_theme_option( 'featured_entries', 'category' );

		if ( is_array( $bunchy_query_args['category_name'] ) ) {
			$bunchy_query_args['category_name'] = implode( ',', $bunchy_query_args['category_name'] );
		}

		// Tag.
		$bunchy_tags = array_filter( bunchy_get_theme_option( 'featured_entries', 'tag' ) ); // array_filter removes empty values.

		if ( ! empty( $bunchy_tags ) ) {
			$bunchy_query_args['tag_slug__in'] = $bunchy_tags;
		}

		// Time range.
		$bunchy_query_args = bunchy_time_range_to_date_query( $bunchy_time_range, $bunchy_query_args );

		// Type.
		switch ( $bunchy_type ) {
			case 'recent':
				$bunchy_query_args['orderby'] = 'post_date';
				break;

			case 'most_viewed':
				$bunchy_query_args = bunchy_get_most_viewed_query_args( $bunchy_query_args );
				break;

			case 'most_shared':
				$bunchy_query_args = bunchy_get_most_shared_query_args( $bunchy_query_args );
				break;
		}

		$bunchy_query_args = apply_filters( 'bunchy_global_featured_entries_query_args', $bunchy_query_args );

		$bunchy_query = new WP_Query( $bunchy_query_args );

		set_transient( 'bunchy_featured_entries_query', $bunchy_query );
	}

	return $bunchy_query;
}

/**
 * Return global featured posts ids
 *
 * @return array
 */
function bunchy_get_global_featured_posts_ids() {
	$ids = array();

	if ( 'none' === bunchy_get_theme_option( 'featured_entries', 'type' ) ) {
		return $ids;
	}

	$query = bunchy_get_global_featured_entries_query();

	if ( $query->have_posts() ) {
		$posts = $query->get_posts();

		foreach ( $posts as $post ) {
			$ids[] = $post->ID;
		}
	}

	return $ids;
}

/**
 * Checks whether the post is NSFW
 *
 * @return bool
 */
function bunchy_is_nsfw() {
	$bool = false;

	if ( bunchy_get_theme_option( 'nsfw', 'enabled' ) ) {
		$nsfw_categories = bunchy_get_nsfw_categories();

		if ( ! empty( $nsfw_categories ) && has_category( $nsfw_categories ) ) {
			$bool = true;
		}
	}

	return apply_filters( 'bunchy_is_nsfw', $bool );
}

/**
 * Return ids of categories for NSFW posts.
 *
 * @return array		Array of ids.
 */
function bunchy_get_nsfw_categories() {
	$ids = array();
	$slugs = explode( ',', bunchy_get_theme_option( 'nsfw', 'categories_ids' ) );

	foreach ( $slugs as $slug ) {
		$category = get_category_by_slug( $slug );

		if ( $category ) {
			$ids[] = $category->term_id;
		}
	}

	return $ids;
}
