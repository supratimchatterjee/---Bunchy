<?php
/**
 * Post template tags
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
 * Get microdata (http://schema.org) itemtype.
 *
 * @return string
 */
function bunchy_get_entry_microdata_itemtype() {
	// Default value.
	$result = 'http://schema.org/CreativeWork';

	switch ( get_post_type() ) {
		case 'page' :
			$result = 'http://schema.org/WebPage';
			break;

		case 'post' :
			$result = 'http://schema.org/Article';
			break;
	}

	return apply_filters( 'bunchy_get_entry_microdata_itemtype', $result );
}

/**
 * Render entry statistics.
 *
 * @param array $args Arguments.
 */
function bunchy_render_entry_stats( $args = array() ) {
	echo bunchy_capture_entry_stats( $args );
}

/**
 * Capture entry statistics.
 *
 * @param array $args Arguments.
 *
 * @return string   Escaped HTML
 */
function bunchy_capture_entry_stats( $args = array() ) {
	$defaults = array(
		'class'         => '',
		'before'        => '<p class="%s">',
		'after'         => '</p>',
		'share_count'   => true,
		'view_count'    => true,
		'comment_count' => true,
	);

	$args = wp_parse_args( $args, $defaults );

	$final_class = array(
		'entry-meta',
		'entry-meta-stats',
	);
	$final_class = array_merge( $final_class, explode( ' ', $args['class'] ) );

	$args['before'] = sprintf( $args['before'], implode( ' ', array_map( 'sanitize_html_class', $final_class ) ) );

	$stats = array();

	if ( $args['share_count'] ) {
		$stats[] = bunchy_capture_entry_share_count();
	}

	if ( $args['view_count'] ) {
		$stats[] = bunchy_capture_entry_view_count();
	}

	if ( $args['comment_count'] ) {
		$stats[] = bunchy_capture_entry_comments_link();
	}

	// Filter empty strings.
	$stats = array_filter( $stats );

	$out_escaped = '';
	if ( count( $stats ) ) {
		$out_escaped .= $args['before'];
		$out_escaped .= implode( '', $stats );
		$out_escaped .= $args['after'];
	}

	return $out_escaped;
}


/**
 * Whether to show the total share count for the current entry.
 *
 * @return boolean
 */
function bunchy_show_entry_share_count() {
	$show        = true;
	$share_count = bunchy_get_entry_share_count();

	if ( $share_count < 0 ) {
		$show = false;
	}

	return apply_filters( 'bunchy_show_entry_share_count', $show, $share_count );
}

/**
 * Get the total share count for entry.
 *
 * @return int
 */
function bunchy_get_entry_share_count() {
	return apply_filters( 'bunchy_entry_share_count', - 1 );
}


/**
 * Render the total share count for the current entry.
 */
function bunchy_render_entry_share_count() {
	echo bunchy_capture_entry_share_count();
}

/**
 * Capture the total share count for the current entry.
 *
 * @return string   Escaped HTML
 */
function bunchy_capture_entry_share_count() {
	$out_escaped = '';

	if ( bunchy_show_entry_share_count() ) {
		$share_count           = bunchy_get_entry_share_count();
		$share_count_formatted = bunchy_format_number( $share_count );

		$out_escaped .= '<span class="entry-shares">';
		$out_escaped .= sprintf( wp_kses_post( __( '<strong>%s</strong> Shares', 'bunchy' ) ), esc_html( $share_count_formatted ) );
		$out_escaped .= '</span>';
	}

	return $out_escaped;
}


/**
 * Whether to show the total page view count for the current entry.
 *
 * @return bool
 */
function bunchy_show_entry_view_count() {
	$show       = true;
	$view_count = bunchy_get_entry_view_count();

	if ( $view_count < 0 ) {
		$show = false;
	} else {
		$views_threshold = absint( bunchy_get_theme_option( 'posts', 'views_threshold' ) );

		if ( $views_threshold && $views_threshold >= $view_count ) {
			$show = false;
		}
	}

	return apply_filters( 'bunchy_show_entry_view_count', $show, $view_count );
}

/**
 * Get the total page view count for entry.
 *
 * @return int
 */
function bunchy_get_entry_view_count() {
	return apply_filters( 'bunchy_entry_view_count', - 1 );
}


/**
 * Render the total page view count for entry.
 *
 * @param string $extra_css_class Extra CSS class.
 */
function bunchy_render_entry_view_count( $extra_css_class = '' ) {
	echo bunchy_capture_entry_view_count( $extra_css_class );
}

/**
 * Capture the total page view count for entry.
 *
 * @param string $extra_css_class Extra CSS class.
 *
 * @return string       Escaped HTML
 */
function bunchy_capture_entry_view_count( $extra_css_class = '' ) {
	$out_escaped = '';

	if ( bunchy_show_entry_view_count() ) {
		$count = bunchy_get_entry_view_count();

		$final_class = array(
			'entry-views'
		);

		if ( bunchy_is_post_trending() ) {
			$final_class[] = 'entry-views-trending';
		} elseif ( bunchy_is_post_hot() ) {
			$final_class[] = 'entry-views-hot';
		} elseif ( bunchy_is_post_popular() ) {
			$final_class[] = 'entry-views-popular';
		}

		$final_class = array_merge( $final_class, explode( ' ', $extra_css_class ) );

		if ( apply_filters( 'bunchy_shorten_view_count', true ) ) {
			$count_str = bunchy_shorten_number( (int) $count );
		} else {
			$count_str = number_format_i18n( intval( $count ) );
		}

		$out_escaped .= '<span class="' . implode( ' ', array_map( 'sanitize_html_class', $final_class ) ) . '">';
		$out_escaped .= sprintf( wp_kses_post( __( '<strong>%s</strong> Views', 'bunchy' ) ), $count_str );
		$out_escaped .= '</span>';
	}

	return $out_escaped;
}


/**
 * Whether to show the comments link for entry.
 *
 * @return bool
 */
function bunchy_show_entry_comments_link() {
	$show               = true;
	$comments_threshold = absint( bunchy_get_theme_option( 'posts', 'comments_threshold' ) );

	if ( $comments_threshold && $comments_threshold >= get_comments_number() ) {
		$show = false;
	}

	return apply_filters( 'bunchy_show_entry_comments_link', $show );
}

/**
 * Render the comments link for entry.
 */
function bunchy_render_entry_comments_link() {
	echo bunchy_capture_entry_comments_link();
}

/**
 * Capture the comments link for entry.
 *
 * @return string       Escaped HTML
 */
function bunchy_capture_entry_comments_link() {
	$out_escaped = '';

	if ( bunchy_show_entry_comments_link() ) {
		$number = (int) get_comments_number( get_the_ID() );

		if ( apply_filters( 'bunchy_hide_comments_link_below_number', false, $number ) ) {
			return '';
		}

		$final_class = array(
			'entry-comments-link',
		);

		if ( 0 === $number ) {
			$final_class[] = 'entry-comments-link-0';
		} else if ( 1 === $number ) {
			$final_class[] = 'entry-comments-link-1';
		} else {
			$final_class[] = 'entry-comments-link-x';
		}

		$out_escaped .= '<span class="' . implode( ' ', array_map( 'sanitize_html_class', $final_class ) ) . '">';

		ob_start();
		comments_popup_link(
			wp_kses_post( __( '<strong itemprop="commentCount">0</strong> <span>Comments</span>', 'bunchy' ) ),
			wp_kses_post( __( '<strong itemprop="commentCount">1</strong> <span>Comment</span>', 'bunchy' ) ),
			wp_kses_post( __( '<strong itemprop="commentCount">%</strong> <span>Comments</span>', 'bunchy' ) )
		);
		$out_escaped .= ob_get_clean();

		$out_escaped .= '</span>';
	}

	return $out_escaped;
}


/**
 * Render entry categories for the current post
 *
 * @param array $args Arguments.
 */
function bunchy_render_entry_categories( $args = array() ) {
	echo bunchy_capture_entry_categories( $args );
}

/**
 * Capture entry categories for the current post
 *
 * @param array $args Arguments.
 *
 * @return string Escaped HTML
 */
function bunchy_capture_entry_categories( $args = array() ) {
	$out_escaped = '';

	$defaults = array(
		'before'        => '<span class="entry-categories %s"><span class="entry-categories-inner"><span class="entry-categories-label">' . esc_html__( 'in', 'bunchy' ). '</span> ',
		'after'         => '</span></span>',
		'class'         => '',
		'use_microdata' => false,
	);

	$args = wp_parse_args( $args, $defaults );

	// Sanitize HTML classes.
	$args['class'] = explode( ' ', $args['class'] );
	$args['class'] = implode( ' ', array_map( 'sanitize_html_class', $args['class'] ) );

	$args['before'] = sprintf( $args['before'], $args['class'] );

	$term_list = get_the_terms( get_the_ID(), 'category' );

	if ( is_array( $term_list ) ) {
		$out_escaped .= $args['before'];

		foreach ( $term_list as $term ) {
			if ( $args['use_microdata'] ) {
				$out_escaped .= sprintf(
					'<a href="%s" class="entry-category %s"><span itemprop="articleSection">%s</span></a>',
					esc_url( get_term_link( $term->slug, 'category' ) ),
					sanitize_html_class( 'entry-category-item-' . $term->term_taxonomy_id ),
					wp_kses_post( $term->name )
				);
			} else {
				$out_escaped .= sprintf(
					'<a href="%s" class="entry-category %s">%s</a>',
					esc_url( get_term_link( $term->slug, 'category' ) ),
					sanitize_html_class( 'entry-category-item-' . $term->term_taxonomy_id ),
					wp_kses_post( $term->name )
				);
			}

			// Add separator.
			$out_escaped .= ', ';
		}

		// Remove the last separator.
		$out_escaped = trim( $out_escaped, ', ' );

		$out_escaped .= $args['after'];
	}

	return $out_escaped;
}


/**
 * Render entry tags for the current post
 *
 * @param array $args Arguments.
 */
function bunchy_render_entry_tags( $args = array() ) {
	echo bunchy_capture_entry_tags( $args );
}


/**
 * Capture entry tags for the current post
 *
 * @param array $args Arguments.
 *
 * @return string Escaped HTML
 */
function bunchy_capture_entry_tags( $args = array() ) {
	$out_escaped = '';

	$defaults = array(
		'before' => '<p class="entry-tags %s"><span class="entry-tags-inner">',
		'after'  => '</span></p>',
		'class'  => '',
	);

	$args = wp_parse_args( $args, $defaults );

	// Sanitize HTML classes.
	$args['class'] = explode( ' ', $args['class'] );
	$args['class'] = implode( ' ', array_map( 'sanitize_html_class', $args['class'] ) );

	$args['before'] = sprintf( $args['before'], $args['class'] );

	$term_list = get_the_terms( get_the_ID(), 'post_tag' );

	if ( is_array( $term_list ) ) {
		$out_escaped .= $args['before'];

		foreach ( $term_list as $term ) {
			$out_escaped .= sprintf( '<a href="%s" class="entry-tag %s">%s</a>',
				esc_url( get_term_link( $term->slug, 'post_tag' ) ),
				sanitize_html_class( 'entry-tag-' . $term->term_taxonomy_id ),
				wp_kses_post( $term->name )
			);
		}

		$out_escaped .= $args['after'];
	}

	return $out_escaped;
}


/**
 * Wrapper for the_tags function
 */
function bunchy_the_tags() {
	the_tags();
}


/**
 * Render date information for the current post.
 *
 * @param array $args Arguments.
 */
function bunchy_render_entry_date( $args = array() ) {
	$defaults = array(
		'use_microdata' => false,
	);

	$args = wp_parse_args( $args, $defaults );

	if ( $args['use_microdata'] ) {
		printf(
			'<time class="entry-date" datetime="%1$s" itemprop="datePublished">%2$s</time>',
			esc_attr( get_the_time( 'Y-m-d' ) . 'T' . get_the_time( 'H:i:s' ) ),
			esc_html( get_the_time( get_option( 'date_format' ) ) . ', ' . get_the_time( get_option( 'time_format' ) ) )
		);
	} else {
		printf(
			'<time class="entry-date" datetime="%1$s">%2$s</time>',
			esc_attr( get_the_time( 'Y-m-d' ) . 'T' . get_the_time( 'H:i:s' ) ),
			esc_html( get_the_time( get_option( 'date_format' ) ) . ', ' . get_the_time( get_option( 'time_format' ) ) )
		);
	}
}

/**
 * Check whether to show featured media
 *
 * @param bool $show Default value.
 *
 * @return mixed|null|void
 */
function bunchy_show_entry_featured_media( $show = true ) {
	$options = get_post_meta( get_the_ID(), '_bunchy_single_options', true );

	// If not set, global setting will be used.
	if ( ! empty( $options ) && ! empty( $options['featured_media'] ) ) {
		$show = 'none' !== $options['featured_media'];
	}

	return apply_filters( 'bunchy_show_entry_featured_media', $show );
}

/**
 * Render the featured media of the current post.
 *
 * @param array $args Arguments.
 */
function bunchy_render_entry_featured_media( $args = array() ) {
	echo bunchy_capture_entry_featured_media( $args );
}

/**
 * Capture the featured media of the current post.
 *
 * @param array $args Arguments.
 *
 * @return string       Escaped HTML
 */
function bunchy_capture_entry_featured_media( $args ) {
	global $post;

	$args = wp_parse_args( $args, array(
		'size'              => 'post-thumbnail',
		'class'             => '',
		'use_microdata'     => false,
		'apply_link'        => true,
		'background_image'  => false,
		'force_placeholder' => false,
	) );

	if ( post_password_required() || is_attachment() ) {
		return '';
	}

	if ( ! has_post_thumbnail() && ! $args['force_placeholder'] ) {
		return '';
	}

	$style_attr_escaped = '';

	if ( $args['background_image'] ) {
		$full_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $args['size'] );

		$style_attr_escaped = ' style="background-image: url(' . esc_url( $full_image[0] ) . ');"';
	}

	$inner_style_escaped = '';

	// Get thumbnail to display.
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $args['size'] );

	// Get image to use in microdata.
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

	if ( is_array( $thumb ) ) {
		$inner_style_escaped = ' style="padding-bottom: ' . floatval( $thumb[2] / $thumb[1] * 100 ) . '%;"';
	}

	$final_class = array(
		'entry-featured-media',
	);

	$nsfw = bunchy_is_nsfw() && ! is_category( bunchy_get_nsfw_categories() );

	if ( $nsfw ) {
		$final_class[] = 'entry-media-nsfw';
	}

	$final_class = array_merge( $final_class, explode( ' ', $args['class'] ) );

	$out_escaped = '';

	if ( $args['use_microdata'] ) {
		$out_escaped .= '<figure class="' . implode( ' ', array_map( 'sanitize_html_class', $final_class ) ) . '" ' . $style_attr_escaped . ' itemprop="image" itemscope itemtype="http://schema.org/ImageObject">';
	} else {
		$out_escaped .= '<figure class="' . implode( ' ', array_map( 'sanitize_html_class', $final_class ) ) . '" ' . $style_attr_escaped . '>';
	}

	if ( $args['apply_link'] ) {
		$out_escaped .= '<a class="g1-frame" href="' . esc_url( apply_filters( 'the_permalink', get_permalink( $post ), $post ) ) . '">';
		$out_escaped .= '<span class="g1-frame-inner"' . $inner_style_escaped . '>';

		if ( $args['use_microdata'] ) {
			$out_escaped .= get_the_post_thumbnail( null, $args['size'], array( 'itemprop' => 'contentUrl' ) );
		} else {
			$out_escaped .= get_the_post_thumbnail( null, $args['size'] );
		}

		$out_escaped .= '<span class="g1-frame-icon"></span>';

		if ( $nsfw ) {
			$out_escaped .= '<div class="g1-nsfw">';
				$out_escaped .= '<div class="g1-nsfw-inner">';
					$out_escaped .= '<i class="g1-nsfw-icon"></i>';
					$out_escaped .= '<div class="g1-nsfw-title">' . __( 'Not Safe For Work', 'bunchy' ) .  '</div>';
					$out_escaped .= '<div class="g1-nsfw-desc">' . __( 'Click to view this post', 'bunchy' ) .  '</div>';
				$out_escaped .= '</div>';
			$out_escaped .= '</div>';
		}

		$out_escaped .= '</span>';
		$out_escaped .= '</a>';
	} else {
		$out_escaped .= '<span class="g1-frame">';
		$out_escaped .= '<span class="g1-frame-inner"' . $inner_style_escaped . '>';

		if ( $args['use_microdata'] ) {
			$out_escaped .= get_the_post_thumbnail( null, $args['size'], array( 'itemprop' => 'contentUrl' ) );
		} else {
			$out_escaped .= get_the_post_thumbnail( null, $args['size'] );
		}

		$out_escaped .= '</span>';

		if ( $nsfw ) {
			$out_escaped .= '<div class="g1-nsfw">';
				$out_escaped .= '<div class="g1-nsfw-inner">';
					$out_escaped .= '<i class="g1-nsfw-icon"></i>';
					$out_escaped .= '<div class="g1-nsfw-title">' . __( 'Not Safe For Work', 'bimber' ) . '</div>';
					$out_escaped .= '<div class="g1-nsfw-desc">' . __( 'Click to view this post', 'bimber' ) . '</div>';
				$out_escaped .= '</div>';
			$out_escaped .= '</div>';
		}

		$out_escaped .= '</span>';
	}

	if ( $args['use_microdata'] ) {
		$out_escaped .= '<meta itemprop="url" content="' . esc_url( $image[0] ) .  '" />';
		$out_escaped .= '<meta itemprop="width" content="' . intval( $image[1] ) .  '" />';
		$out_escaped .= '<meta itemprop="height" content="' . intval( $image[2] ) .  '" />';
	}

	$out_escaped .= '</figure>';

	return $out_escaped;
}



/**
 * Render author information for entry.
 *
 * @param array $args Arguments.
 */
function bunchy_render_entry_author( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'avatar'        => true,
		'avatar_size'   => 30,
		'use_microdata' => false,
	) );
	?>
	<?php if ( $args['use_microdata'] ) : ?>
		<span class="entry-author" itemscope="" itemprop="author" itemtype="http://schema.org/Person">
	<?php else : ?>
		<span class="entry-author">
	<?php endif; ?>

		<span class="entry-meta-label"><?php esc_html_e( 'by', 'bunchy' ); ?></span>
			<?php
			printf(
				'<a href="%s" title="%s" rel="author">',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'Posts by %s', 'bunchy' ), get_the_author() ) )
			);
			?>

			<?php
			if ( $args['avatar'] ) :
				echo get_avatar( get_the_author_meta( 'email' ), $args['avatar_size'] );
			endif;
			?>

			<?php if ( $args['use_microdata'] ) : ?>
				<strong itemprop="name"><?php echo esc_html( get_the_author() ); ?></strong>
			<?php else : ?>
				<strong><?php echo esc_html( get_the_author() ); ?></strong>
			<?php endif; ?>
			</a>
		</span>
	<?php
}


/**
 * Render flags for entry.
 */
function bunchy_render_entry_flags() {
	$flags = array();

	if ( bunchy_is_post_trending() ) {
		$flags['trending'] = __( 'Trending', 'bunchy' );
	}

	if ( bunchy_is_post_hot() ) {
		$flags['hot'] = __( 'Hot', 'bunchy' );
	}

	if ( bunchy_is_post_popular() ) {
		$flags['popular'] = __( 'Popular', 'bunchy' );
	}

	$flags = apply_filters( 'bunchy_get_entry_flags', $flags );

	?>
	<?php if ( count( $flags ) ) : ?>
		<p class="entry-flags">
			<?php foreach ( $flags as $flag_id => $flag_label ) : ?>
				<span class="entry-flag entry-flag-<?php echo sanitize_html_class( $flag_id ); ?>"
				      title="<?php echo esc_attr( $flag_label ); ?>">
					<?php echo esc_html( $flag_label ); ?>
				</span>
			<?php endforeach; ?>
		</p>
	<?php endif;
}
