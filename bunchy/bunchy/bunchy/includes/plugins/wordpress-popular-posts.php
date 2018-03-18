<?php
/**
 * Wordpress Popular Posts plugin functions
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
 * Remove WordPress Popular Posts Widget
 */
function bunchy_wpp_remove_widget() {
	unregister_widget( 'WordpressPopularPosts' );
}

/**
 * Return query args form most viewewd posts (Wordpress Popular Posts)
 *
 * @param array $query_args     Arguments.
 *
 * @return array
 */
function bunchy_wpp_get_most_viewed_query_args( $query_args ) {
	$defaults = array(
		'posts_per_page'      => 10,
		'ignore_sticky_posts' => true,
		'post_type'           => 'post',
		'freshness'           => false,
	);

	$query_args = wp_parse_args( $query_args, $defaults );

	// WPP doesn't use post meta so we can't use wp_query for filtering
	// we need to map wp_query args to wpp_query args.
	$wpp_range = 'all';

	if ( isset( $query_args['time_range'] ) ) {
		switch ( $query_args['time_range'] ) {
			case 'day':
				$wpp_range = 'daily';
				break;

			case 'week':
				$wpp_range = 'weekly';
				break;

			case 'month':
				$wpp_range = 'monthly';
				break;
		}
	}

	$wpp_args = array(
		'limit'     => $query_args['posts_per_page'],
		'range'     => $wpp_range,
		'order_by'  => 'views',
		'post_type' => $query_args['post_type'],
		'freshness' => $query_args['freshness'],
	);

	if ( ! empty( $query_args['category_name'] ) ) {
		$category_slugs = explode( ',', $query_args['category_name'] );
		$category_ids   = array();

		foreach ( $category_slugs as $category_slug ) {
			$category_obj = get_category_by_slug( $category_slug );

			if ( false !== $category_obj ) {
				$category_ids[] = $category_obj->term_id;
			}
		}

		if ( ! empty( $category_ids ) ) {
			$wpp_args['cat'] = implode( ',', $category_ids );
		}
	}

	if ( ! empty( $query_args['category__in'] ) ) {
		$wpp_args['cat'] = implode( ',', $query_args['category__in'] );
	}

	if ( ! empty( $query_args['post__not_in'] ) ) {
		$wpp_args['pid'] = implode( ',', $query_args['post__not_in'] );
	}

	// WPP query.
	$wpp_posts = bunchy_wpp_query_posts( $wpp_args );

	$post_ids = array();

	foreach ( $wpp_posts as $wpp_post ) {
		$post_ids[] = $wpp_post->id;
	}

	if ( empty( $post_ids ) ) {
		// Trick to prevent WP from displaying anything.
		$post_ids[] = - 1;
	}

	// If we have a full list of ids, we can simple override entire wp_query to fetch only these ids.
	return array(
		'post__in'            => $post_ids,
		'orderby'             => 'post__in',
		'posts_per_page'      => $query_args['posts_per_page'],
		'ignore_sticky_posts' => true,
	);
}

/**
 * Return popular posts
 *
 * @param array $instance       Arguments.
 *
 * @return array
 */
function bunchy_wpp_query_posts( $instance ) {

	global $wpdb;

	$defaults = array(
		'title'         => '',
		'limit'         => 10,
		'range'         => 'daily',
		'freshness'     => false,
		'order_by'      => 'views',
		'post_type'     => 'post,page',
		'pid'           => '',
		'author'        => '',
		'cat'           => '',
		'shorten_title' => array(
			'active' => false,
			'length' => 25,
			'words'  => false,
		),
		'post-excerpt'  => array(
			'active'      => false,
			'length'      => 55,
			'keep_format' => false,
			'words'       => false,
		),
		'thumbnail'     => array(
			'active' => false,
			'build'  => 'manual',
			'width'  => 15,
			'height' => 15,
			'crop'   => true,
		),
		'rating'        => false,
		'stats_tag'     => array(
			'comment_count' => false,
			'views'         => true,
			'author'        => false,
			'date'          => array(
				'active' => false,
				'format' => 'F j, Y',
			),
			'category'      => false,
		),
		'markup'        => array(
			'custom_html' => false,
			'wpp-start'   => '&lt;ul class="wpp-list"&gt;',
			'wpp-end'     => '&lt;/ul&gt;',
			'post-html'   => '&lt;li&gt;{thumb} {title} {stats}&lt;/li&gt;',
			'post-start'  => '&lt;li&gt;',
			'post-end'    => '&lt;/li&gt;',
			'title-start' => '&lt;h2&gt;',
			'title-end'   => '&lt;/h2&gt;',
		),
	);

	$instance = bunchy_wpp_merge_array_r( $defaults, $instance );

	$prefix  = $wpdb->prefix . 'popularposts';
	$fields  = "p.ID AS 'id', p.post_title AS 'title', p.post_date AS 'date', p.post_author AS 'uid'";
	$where   = 'WHERE 1 = 1';
	$orderby = '';
	$groupby = '';
	$limit   = 'LIMIT ' . $instance['limit'];

	$now = current_time( 'mysql' );

	// Post filters.
	// Freshness - get posts published within the selected time range only.
	if ( $instance['freshness'] ) {
		switch ( $instance['range'] ) {
			case 'daily':
				$where .= " AND p.post_date > DATE_SUB('{$now}', INTERVAL 1 DAY) ";
				break;

			case 'weekly':
				$where .= " AND p.post_date > DATE_SUB('{$now}', INTERVAL 1 WEEK) ";
				break;

			case 'monthly':
				$where .= " AND p.post_date > DATE_SUB('{$now}', INTERVAL 1 MONTH) ";
				break;

			default:
				$where .= '';
				break;
		}
	}

	// * post types - based on code seen at https://github.com/williamsba/WordPress-Popular-Posts-with-Custom-Post-Type-Support
	$types          = explode( ',', $instance['post_type'] );
	$sql_post_types = '';
	$join_cats      = true;

	// If we're getting just pages, why join the categories table?
	if ( 'page' === strtolower( $instance['post_type'] ) ) {

		$join_cats = false;
		$where .= " AND p.post_type = '{$instance['post_type']}'";

	} // we're listing other custom type(s)
	else {

		if ( count( $types ) > 1 ) {

			foreach ( $types as $post_type ) {
				$post_type = trim( $post_type ); // Required in case user places whitespace between commas.
				$sql_post_types .= "'{$post_type}',";
			}

			$sql_post_types = rtrim( $sql_post_types, ',' );
			$where .= " AND p.post_type IN({$sql_post_types})";

		} else {
			$where .= " AND p.post_type = '{$instance['post_type']}'";
		}
	}

	// Posts exclusion.
	if ( ! empty( $instance['pid'] ) ) {

		$ath = explode( ',', $instance['pid'] );

		$where .= ( count( $ath ) > 1 )
			? " AND p.ID NOT IN({$instance['pid']})"
			: " AND p.ID <> '{$instance['pid']}'";

	}

	// Categories.
	if ( ! empty( $instance['cat'] ) && $join_cats ) {

		$cat_ids = explode( ',', $instance['cat'] );
		$in      = array();
		$out     = array();

		$cat_count = count( $cat_ids );

		for ( $i = 0; $i < $cat_count; $i ++ ) {
			if ( $cat_ids[ $i ] >= 0 ) {
				$in[] = $cat_ids[ $i ];
			} else {
				$out[] = $cat_ids[ $i ];
			}
		}

		$in_cats  = implode( ',', $in );
		$out_cats = implode( ',', $out );
		$out_cats = preg_replace( '|[^0-9,]|', '', $out_cats );

		if ( '' !== $in_cats && '' === $out_cats ) { // Get posts from from given cats only.
			$where .= " AND p.ID IN (
						SELECT object_id
						FROM {$wpdb->term_relationships} AS r
							 JOIN {$wpdb->term_taxonomy} AS x ON x.term_taxonomy_id = r.term_taxonomy_id
						WHERE x.taxonomy = 'category' AND x.term_id IN({$in_cats})
						)";
		} else if ( '' === $in_cats && '' !== $out_cats ) { // Exclude posts from given cats only.
			$where .= " AND p.ID NOT IN (
						SELECT object_id
						FROM {$wpdb->term_relationships} AS r
							 JOIN {$wpdb->term_taxonomy} AS x ON x.term_taxonomy_id = r.term_taxonomy_id
						WHERE x.taxonomy = 'category' AND x.term_id IN({$out_cats})
						)";
		} else { // Mixed.
			$where .= " AND p.ID IN (
						SELECT object_id
						FROM {$wpdb->term_relationships} AS r
							 JOIN {$wpdb->term_taxonomy} AS x ON x.term_taxonomy_id = r.term_taxonomy_id
						WHERE x.taxonomy = 'category' AND x.term_id IN({$in_cats}) AND x.term_id NOT IN({$out_cats})
						) ";
		}
	}

	// Authors.
	if ( ! empty( $instance['author'] ) ) {

		$ath = explode( ',', $instance['author'] );

		$where .= ( count( $ath ) > 1 )
			? " AND p.post_author IN({$instance['author']})"
			: " AND p.post_author = '{$instance['author']}'";

	}

	// All-time range.
	if ( 'all' === $instance['range'] ) {

		$fields .= ", p.comment_count AS 'comment_count'";

		// Order by comments.
		if ( 'comments' === $instance['order_by'] ) {

			$from = "{$wpdb->posts} p";
			$where .= ' AND p.comment_count > 0 ';
			$orderby = ' ORDER BY p.comment_count DESC';

			// Get views, too.
			if ( $instance['stats_tag']['views'] ) {

				$fields .= ", IFNULL(v.pageviews, 0) AS 'pageviews'";
				$from .= " LEFT JOIN {$prefix}data v ON p.ID = v.postid";

			}
		} // Order by (avg) views.
		else {

			$from = "{$prefix}data v LEFT JOIN {$wpdb->posts} p ON v.postid = p.ID";

			// Order by views.
			if ( 'views' === $instance['order_by'] ) {

				$fields .= ", v.pageviews AS 'pageviews'";
				$orderby = 'ORDER BY pageviews DESC';

			} // Order by avg views.
			elseif ( 'avg' === $instance['order_by'] ) {

				$fields .= ", ( v.pageviews/(IF ( DATEDIFF('{$now}', MIN(v.day)) > 0, DATEDIFF('{$now}', MIN(v.day)), 1) ) ) AS 'avg_views'";
				$groupby = 'GROUP BY v.postid';
				$orderby = 'ORDER BY avg_views DESC';

			}
		}
	} else { // Custom range.

		switch ( $instance['range'] ) {
			case 'daily':
				$interval = '1 DAY';
				break;

			case 'weekly':
				$interval = '1 WEEK';
				break;

			case 'monthly':
				$interval = '1 MONTH';
				break;

			default:
				$interval = '1 DAY';
				break;
		}

		// Order by comments.
		if ( 'comments' === $instance['order_by'] ) {

			$fields .= ", COUNT(c.comment_post_ID) AS 'comment_count'";
			$from = "{$wpdb->comments} c LEFT JOIN {$wpdb->posts} p ON c.comment_post_ID = p.ID";
			$where .= " AND c.comment_date_gmt > DATE_SUB('{$now}', INTERVAL {$interval}) AND c.comment_approved = 1 ";
			$groupby = 'GROUP BY c.comment_post_ID';
			$orderby = 'ORDER BY comment_count DESC';

			if ( $instance['stats_tag']['views'] ) { // Get views, too.

				$fields .= ", IFNULL(v.pageviews, 0) AS 'pageviews'";
				$from .= " LEFT JOIN (SELECT postid, SUM(pageviews) AS pageviews FROM {$prefix}summary WHERE last_viewed > DATE_SUB('{$now}', INTERVAL {$interval}) GROUP BY postid) v ON p.ID = v.postid";

			}
		} // Ordered by views / avg.
		else {

			$from = "{$prefix}summary v LEFT JOIN {$wpdb->posts} p ON v.postid = p.ID";
			$where .= " AND v.last_viewed > DATE_SUB('{$now}', INTERVAL {$interval}) ";
			$groupby = 'GROUP BY v.postid';

			// Ordered by views.
			if ( 'views' === $instance['order_by'] ) {

				$fields .= ", SUM(v.pageviews) AS 'pageviews'";
				$orderby = 'ORDER BY pageviews DESC';

			} // Ordered by avg views.
			elseif ( 'avg' === $instance['order_by'] ) {

				$fields .= ", ( SUM(v.pageviews)/(IF ( DATEDIFF('{$now}', DATE_SUB('{$now}', INTERVAL {$interval})) > 0, DATEDIFF('{$now}', DATE_SUB('{$now}', INTERVAL {$interval})), 1) ) ) AS 'avg_views' ";
				$orderby = 'ORDER BY avg_views DESC';

			}

			// Get comments, too.
			if ( $instance['stats_tag']['comment_count'] ) {

				$fields .= ", IFNULL(c.comment_count, 0) AS 'comment_count'";
				$from .= " LEFT JOIN (SELECT comment_post_ID, COUNT(comment_post_ID) AS 'comment_count' FROM {$wpdb->comments} WHERE comment_date_gmt > DATE_SUB('{$now}', INTERVAL {$interval}) AND comment_approved = 1 GROUP BY comment_post_ID) c ON p.ID = c.comment_post_ID";

			}
		}
	}

	// List only published, non password-protected posts.
	$where .= " AND p.post_password = '' AND p.post_status = 'publish'";

	// Build query.
	$query = "SELECT {$fields} FROM {$from} {$where} {$groupby} {$orderby} {$limit};";

	$result = $wpdb->get_results( $query );

	return $result;
}

/**
 * Merger array recursive
 *
 * @param array $array1     Array 1.
 * @param array $array2     Array 2.
 *
 * @return array
 */
function bunchy_wpp_merge_array_r( array &$array1, array &$array2 ) {
	$merged = $array1;

	foreach ( $array2 as $key => &$value ) {

		if ( is_array( $value ) && isset( $merged[ $key ] ) && is_array( $merged[ $key ] ) ) {
			$merged[ $key ] = bunchy_wpp_merge_array_r( $merged[ $key ], $value );
		} else {
			$merged[ $key ] = $value;
		}
	}

	return $merged;
}

/**
 * Return view count
 *
 * @return string
 */
function bunchy_wpp_get_view_count() {
	global $post;

	return wpp_get_views( $post->ID, null, false );
}
