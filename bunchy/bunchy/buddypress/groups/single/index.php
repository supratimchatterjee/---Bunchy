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
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope=""
						 itemtype="<?php echo esc_attr( bunchy_get_entry_microdata_itemtype() ); ?>">

					<div id="buddypress">

						<div class="g1-row-notices">
							<?php
							/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
							do_action( 'template_notices' );
							?>
						</div>

						<?php if ( bp_has_groups() ) : ?>

							<?php while ( bp_groups() ) : bp_the_group(); ?>
							<?php
							/**
							 * If the cover image feature is enabled, use a specific header
							 */
							if ( bp_group_use_cover_image_header() ) :
								bp_get_template_part( 'groups/single/cover-image-header' );
							endif;
							?>
							<?php endwhile; ?>

						<?php endif; ?>

						<div class="g1-row g1-row-layout-page g1-row-padding-m">
							<div class="g1-row-inner">

								<div class="g1-column g1-column-1of3" id="item-header">

									<?php
									/**
									 * Fires before the display of a group's header.
									 *
									 * @since 1.2.0
									 */
									do_action( 'bp_before_group_header' );
									?>

									<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
										<div id="item-header-avatar">
											<a href="<?php bp_group_permalink(); ?>" title="<?php bp_group_name(); ?>">

												<?php bp_group_avatar(); ?>

											</a>

											<?php if ( bunchy_bp_show_group_photo_change_link() ) : ?>
												<?php bunchy_bp_render_group_photo_change_link(); ?>
											<?php endif; ?>

										</div><!-- #item-header-avatar -->
									<?php endif; ?>

									<?php the_title( '<h1 class="g1-alpha g1-alpha-2nd entry-title">', '</h1>' ); ?>

									<div id="item-header-content">

										<div id="item-buttons"><?php

											/**
											 * Fires in the group header actions section.
											 *
											 * @since 1.2.6
											 */
											do_action( 'bp_group_header_actions' ); ?></div><!-- #item-buttons -->

										<?php

										/**
										 * Fires before the display of the group's header meta.
										 *
										 * @since 1.2.0
										 */
										do_action( 'bp_before_group_header_meta' ); ?>

										<div id="item-meta">

											<?php

											/**
											 * Fires after the group header actions section.
											 *
											 * @since 1.2.0
											 */
											do_action( 'bp_group_header_meta' ); ?>

											<span class="highlight"><?php bp_group_type(); ?></span>
											<span class="activity"><?php printf( esc_html__( 'active %s', 'bunchy' ), esc_html( bp_get_group_last_active() ) ); ?></span>

											<?php bp_group_description(); ?>

										</div>
									</div><!-- #item-header-content -->

									<div id="item-actions">

										<?php if ( bp_group_is_visible() ) : ?>

											<h3 class="g1-delta g1-delta-2nd"><?php esc_html_e( 'Group Admins', 'bunchy' ); ?></h3>

											<?php bp_group_list_admins();

											/**
											 * Fires after the display of the group's administrators.
											 *
											 * @since 1.1.0
											 */
											do_action( 'bp_after_group_menu_admins' );

											if ( bp_group_has_moderators() ) :

												/**
												 * Fires before the display of the group's moderators, if there are any.
												 *
												 * @since 1.1.0
												 */
												do_action( 'bp_before_group_menu_mods' ); ?>

												<h3 class="g1-delta g1-delta-2nd"><?php esc_html_e( 'Group Mods' , 'bunchy' ); ?></h3>

												<?php bp_group_list_mods();

												/**
												 * Fires after the display of the group's moderators, if there are any.
												 *
												 * @since 1.1.0
												 */
												do_action( 'bp_after_group_menu_mods' );

											endif;

										endif; ?>

									</div><!-- #item-actions -->

									<?php
									/**
									 * Fires after the display of a group's header.
									 *
									 * @since 1.2.0
									 */
									do_action( 'bp_after_group_header' );
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

			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer();
