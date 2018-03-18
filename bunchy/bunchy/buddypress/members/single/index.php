<?php
/**
 * The Template for displaying pages.
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

get_header();
?>
	<div id="primary" class="g1-primary-max">
		<div id="content" role="main">
			<?php
			while ( have_posts() ) : the_post();
			?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope=""
						 itemtype="<?php echo esc_attr( bunchy_get_entry_microdata_itemtype() ); ?>">
					<div id="buddypress">

						<div class="g1-row-notices">
							<?php
							/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
							do_action( 'template_notices' );
							?>
						</div>

						<?php
						/**
						 * If the cover image feature is enabled, use a specific header
						 */
						if ( bp_displayed_user_use_cover_image_header() ) :
							bp_get_template_part( 'members/single/cover-image-header' );
						endif;
						?>

						<div class="g1-row g1-row-layout-page csstodo-padding-xxx">
							<div class="g1-row-inner">

								<div class="g1-column g1-column-1of3" id="item-header">

									<?php
									/**
									 * Fires before the display of a member's header.
									 *
									 * @since 1.2.0
									 */
									do_action( 'bp_before_member_header' );
									?>

									<div id="item-header-avatar">
										<a href="<?php bp_displayed_user_link(); ?>">

											<?php bp_displayed_user_avatar( 'type=full' ); ?>

										</a>

										<?php if ( bunchy_bp_show_profile_photo_change_link() ) : ?>
											<?php bunchy_bp_render_profile_photo_change_link(); ?>
										<?php endif; ?>

									</div><!-- #item-header-avatar -->

									<?php the_title( '<h1 class="g1-alpha g1-alpha-2nd entry-title">', '</h1>' ); ?>

									<?php if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() ) : ?>
										<h2 class="g1-delta g1-delta-3rd entry-subtitle user-nicename">@<?php bp_displayed_user_mentionname(); ?></h2>
									<?php endif; ?>

									<div id="item-header-content">
										<div id="item-buttons"><?php

											/**
											 * Fires in the member header actions section.
											 *
											 * @since 1.2.6
											 */
											do_action( 'bp_member_header_actions' ); ?></div><!-- #item-buttons -->

										<span class="activity"><?php bp_last_activity( bp_displayed_user_id() ); ?></span>

										<?php

										/**
										 * Fires before the display of the member's header meta.
										 *
										 * @since 1.2.0
										 */
										do_action( 'bp_before_member_header_meta' ); ?>

										<div id="item-meta">

											<?php
											if ( bp_is_active( 'xprofile' ) ) {
												echo wp_kses_post( wpautop( xprofile_get_field_data( 'Textbox', bp_displayed_user_id() ) ) );
											} else {
												echo wp_kses_post( wpautop( get_the_author_meta( 'description', bp_displayed_user_id() ) ) );
											}

											/**
											 * Fires after the group header actions section.
											 *
											 * If you'd like to show specific profile fields here use:
											 * bp_member_profile_data( 'field=About Me' ); -- Pass the name of the field
											 *
											 * @since 1.2.0
											 */
											do_action( 'bp_profile_header_meta' );

											?>

										</div><!-- #item-meta -->

									</div><!-- #item-header-content -->

									<?php
										/**
										 * Fires after the display of a member's header.
										 *
										 * @since 1.2.0
										 */
										do_action( 'bp_after_member_header' );
									?>

								</div><!-- #item-header -->

								<div class="g1-column g1-column-2of3">
									<div class="entry-content">
										<?php
										the_content();
										wp_link_pages();
										?>
									</div><!-- .entry-content -->
								</div>


							</div>
							<div class="g1-row-background">
							</div>
						</div>

					</div><!-- #buddypress -->

				</article><!-- #post-## -->

			<?php
				endwhile;
			?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer();
