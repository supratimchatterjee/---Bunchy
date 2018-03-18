<?php
/**
 * The template part for displaying user navigation
 *
 * @package Bunchy_Theme
 */

?>
<!-- BEGIN .g1-user-nav -->
<?php if ( has_nav_menu( 'bunchy_user_nav' ) ) : ?>
	<nav class="g1-drop g1-drop-before g1-drop-the-user">
		<?php
		$bunchy_current_user = wp_get_current_user();
		?>

		<?php if ( is_user_logged_in() ) : ?>
			<a class="g1-drop-toggle" href="<?php echo esc_url( get_author_posts_url( get_current_user_id() ) ); ?>">
				<i class="bunchy-icon bunchy-icon-person">
					<?php echo get_avatar( $bunchy_current_user->user_email, 40 ); ?>
				</i>
				<?php echo esc_html( $bunchy_current_user->display_name ); ?>

				<?php if ( bunchy_can_use_plugin( 'buddypress/bp-loader.php' ) && bp_is_active( 'notifications' ) ) : ?>
					<?php
					$bunchy_count = intval( bp_notifications_get_unread_notification_count( bp_loggedin_user_id() ) );
					?>
					<?php if ( $bunchy_count ) : ?>
						<span class="g1-drop-toggle-badge"><?php echo intval( $bunchy_count ); ?></span>
					<?php endif; ?>
				<?php endif; ?>
				<span class="g1-drop-toggle-arrow"></span>
			</a>

			<?php wp_nav_menu( array(
				'theme_location'    => 'bunchy_user_nav',
				'container'         => 'div',
				'container_class'   => 'g1-drop-content',
				'menu_class'        => 'sub-menu',
				'menu_id'           => '',
				'depth'             => 0,
			) );
			?>
		<?php else : ?>
			<a class="g1-drop-toggle snax-login-required" href="#">
				<i class="bunchy-icon bunchy-icon-person"></i>
				<span class="g1-drop-toggle-arrow"></span>
			</a>
		<?php endif; ?>
	</nav>

	<?php if ( bunchy_can_use_plugin( 'snax/snax.php' ) ) : ?>
		<?php if ( snax_show_create_button() ) : ?>
			<?php
			$snax_class = array(
				'g1-button',
				'g1-button-m',
				'g1-button-solid',
				'snax-button',
				'snax-button-create',
			);
			?>
			<a class="<?php echo implode( ' ', array_map( 'sanitize_html_class', $snax_class ) ); ?>"
			   href="<?php echo esc_url( snax_get_frontend_submission_page_url() ); ?>"><?php esc_html_e( 'Create', 'bunchy' ); ?></a>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>
<!-- END .g1-user-nav -->
