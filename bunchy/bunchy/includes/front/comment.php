<?php
/**
 * Comment functions
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
 * Custom function for displaying comments
 *
 * @param object $comment Comment object.
 * @param array  $args Arguments.
 * @param int    $depth Depth.
 */
function bunchy_wp_list_comments_callback( $comment, $args, $depth ) {
	add_filter( 'get_avatar', 'bunchy_add_avatar_microdata', 99 );
	add_filter( 'get_comment_author', 'bunchy_add_comment_author_microdata' );
	add_filter( 'get_comment_author_link', 'bunchy_add_comment_author_link_microdata' );

	$avatar_size = ( 1 === $depth ) ? 40 : 30;

	switch ( $comment->comment_type ) :
		case '' :
			?>
			<li <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="li-comment-<?php comment_ID(); ?>">

			<article class="comment-body" id="comment-<?php comment_ID(); ?>" itemscope itemtype="http://schema.org/Comment">
				<footer class="comment-meta">
					<div class="comment-author" itemprop="author" itemscope itemtype="http://schema.org/Person">
						<?php echo get_avatar( $comment, $avatar_size ); ?>
						<b class="g1-epsilon fn"><?php comment_author_link(); ?></b> <span
							class="says"><?php esc_html_e( 'says:', 'bunchy' ); ?></span>
					</div><!-- .comment-author -->

					<div class="comment-metadata">
						<a itemprop="url" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<time itemprop="datePublished"
							      datetime="<?php echo esc_attr( get_comment_date( 'Y-m-d' ) . 'T' . get_comment_time( 'H:i:s' ) ); ?>">
								<?php printf( esc_html_x( '%1$s at %2$s', '1: date, 2: time', 'bunchy' ), get_comment_date(), get_comment_time() ); ?>
							</time>
						</a>
						<?php edit_comment_link( __( 'Edit', 'bunchy' ) ); ?>
					</div><!-- .comment-metadata -->

				</footer><!-- .comment-meta -->

				<?php if ( '0' === $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'bunchy' ); ?></p>
				<?php endif; ?>

				<div class="comment-content" itemprop="text">
					<?php comment_text(); ?>
				</div><!-- .comment-content -->

				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array(
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
					) ) ); ?>
				</div>
			</article><!-- .comment-body -->
			<?php
			break;
		case 'pingback'  :
		case 'trackback' :
			?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<p><?php esc_html_e( 'Pingback:', 'bunchy' ); ?><?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'bunchy' ), '<span class="edit-link">', '</span>' ); ?></p>
			<?php
			break;
	endswitch;

	remove_filter( 'get_avatar', 'bunchy_add_avatar_microdata', 99 );
	remove_filter( 'get_comment_author', 'bunchy_add_comment_author_microdata' );
	remove_filter( 'get_comment_author_link', 'bunchy_add_comment_author_link_microdata' );
}

/**
 * Add microdata related markup to avatars
 *
 * @param string $avatar Avatar markup.
 *
 * @return mixed
 */
function bunchy_add_avatar_microdata( $avatar ) {
	if ( ! empty( $avatar ) ) {
		$avatar = str_replace( '<img', '<img itemprop="image"', $avatar );
	}

	return $avatar;
}

/**
 * Add microdata related markup to comment author
 *
 * @param string $author Author markup.
 *
 * @return mixed
 */
function bunchy_add_comment_author_microdata( $author ) {
	if ( ! empty( $author ) ) {
		$author = '<span itemprop="name">' . $author . '</span>';
	}

	return $author;
}

/**
 * Add microdata related markup to comment author link
 *
 * @param string $link Markup.
 *
 * @return string
 */
function bunchy_add_comment_author_link_microdata( $link ) {
	if ( ! empty( $link ) ) {
		$link = str_replace( '<a', '<a itemprop="url"', $link );
	}

	return $link;
}

/**
 * Add placeholders to the comment form
 *
 * @param array $fields Comment for fields.
 *
 * @return mixed
 */
function bunchy_comment_form_default_fields( $fields ) {
	if ( isset( $fields['author'] ) ) {
		$fields['author'] = str_replace( 'id="author"', 'id="author" placeholder="' . esc_attr__( 'Name', 'bunchy' ) . '*"', $fields['author'] );
	}

	if ( isset( $fields['email'] ) ) {
		$fields['email'] = str_replace( 'id="email"', 'id="email" placeholder="' . esc_attr__( 'Email', 'bunchy' ) . '*"', $fields['email'] );
	}

	if ( isset( $fields['url'] ) ) {
		$fields['url'] = str_replace( 'id="url"', 'id="url" placeholder="' . esc_attr__( 'Website', 'bunchy' ) . '"', $fields['url'] );
	}

	return $fields;
}

/**
 * Add placeholder to the comment field
 *
 * @param string $field Comment field markup.
 *
 * @return mixed
 */
function bunchy_comment_form_field_comment( $field ) {
	$field = str_replace( 'id="comment"', 'id="comment" placeholder="' . esc_attr__( 'Comment', 'bunchy' ) . '*"', $field );

	return $field;
}

/**
 * Render avatar before the comment form
 */
function bunchy_comment_render_avatar_before_form() {
	if ( is_user_logged_in() ) {
		echo get_avatar( get_current_user_id(), 40 );
	} else {
		echo '<div class="g1-fake-avatar"></div>';
	}
}

/**
 * Whether or not to show the quick navigation links
 *
 * @return mixed|void
 */
function bunchy_show_quick_nav_menu() {
	$show = true;

	$latest_url   = bunchy_get_latest_page_url();
	$popular_url  = bunchy_get_popular_page_url();
	$hot_url      = bunchy_get_hot_page_url();
	$trending_url = bunchy_get_trending_page_url();

	if ( empty( $latest_url ) && empty( $popular_url ) && empty( $hot_url ) && empty( $trending_url ) ) {
		$show = false;
	}

	return apply_filters( 'bunchy_show_quick_nav_menu', $show );
}

