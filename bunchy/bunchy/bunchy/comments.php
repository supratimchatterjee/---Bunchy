<?php
/**
 * The Template Part for displaying Comments.
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

if ( post_password_required() ) {
	return;
}
?>

<?php if ( get_comments_number() || comments_open() ) : ?>
	<section id="comments" class="comments-area" itemscope itemtype="http://schema.org/UserComments">
		<?php
		$comments_by_type = separate_comments( $comments );

		$bunchy_comments_count = count( $comments_by_type['comment'] );

		// Pingbacks & Trackbacks ?
		$bunchy_pings_count = count( $comments_by_type['pings'] );
		?>
		<?php if ( $bunchy_comments_count ) : ?>

			<h2 class="comments-title g1-beta g1-beta-2nd">
				<?php echo esc_html( sprintf( _n( 'One Comment', '%1$s Comments', $bunchy_comments_count, 'bunchy' ), number_format_i18n( $bunchy_comments_count ) ) ); ?>
			</h2>

			<?php if ( comments_open() ) : ?>
				<a class="g1-button g1-button-m g1-button-solid" href="#respond"><?php esc_html_e( 'Leave a Reply', 'bunchy' ); ?></a>
			<?php endif; ?>

			<ol class="comment-list">
				<?php
				wp_list_comments( array(
					'type'     => 'comment',
					'callback' => 'bunchy_wp_list_comments_callback',
				) );
				?>
			</ol>
			<?php if ( get_comment_pages_count() > 1 ) : ?>
				<nav class="g1-comment-pagination">
					<p>
						<strong><?php esc_html_e( 'Pages', 'bunchy' ); ?></strong>
						<?php paginate_comments_links(); ?>
					</p>
				</nav>
			<?php endif; ?>

		<?php endif; ?>

		<?php if ( $bunchy_pings_count ) : ?>

			<h2 class="comments-title g1-beta g1-beta-2nd">
				<?php echo esc_html( sprintf( _n( 'One Ping', '%1$s Pings & Trackbacks', $bunchy_pings_count, 'bunchy' ), number_format_i18n( $bunchy_pings_count ) ) ); ?>
			</h2>

			<ol class="comment-list">
				<?php
				wp_list_comments( array(
					'type'     => 'pings',
					'page'     => 1,
					'per_page' => $bunchy_pings_count,
					'callback' => 'bunchy_wp_list_comments_callback',
				) );
				?>
			</ol>
		<?php endif; ?>

		<?php
		if ( comments_open() ) :
			comment_form( array(
				'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title g1-beta g1-beta-2nd">',
			) );
		endif;
		?>
	</section><!-- #comments -->
<?php endif;

