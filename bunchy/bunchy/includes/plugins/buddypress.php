<?php
/**
 * BuddyPress plugin functions
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
 * Set up BP and Snax
 */
function bunchy_snax_bp_setup() {
	if ( ! bunchy_can_use_plugin( 'snax/snax.php' ) ) {
		return;
	}

	// Components.
	snax_bp_activate_components( true );
}

/**
 * Move Snax tabs to the beginning of profile tabs.
 *
 * @param array  $main_nav      Navigation config.
 * @param string $id            Component id.
 *
 * @return array
 */
function bunchy_snax_bp_component_main_nav( $main_nav, $id ) {
	if ( ! bunchy_can_use_plugin( 'snax/snax.php' ) ) {
		return $main_nav;
	}

	$lists_component_id = snax_posts_bp_component_id();
	$items_component_id = snax_items_bp_component_id();
	$votes_component_id = snax_votes_bp_component_id();

	if ( $lists_component_id === $id ) {
		$main_nav['position'] = 4;
	}

	if ( $items_component_id === $id ) {
		$main_nav['position'] = 6;
	}

	if ( $votes_component_id === $id ) {
		$main_nav['position'] = 8;
	}

	return $main_nav;
}

/**
 * Adjust the markup of a directory (groups, members) search form
 *
 * @param string $html HTML markup.
 *
 * @return string
 */
function bunchy_bp_directory_search_form( $html ) {
	$html = str_replace( '<input type="submit"', '<input class="g1-button g1-button-simple" type="submit"', $html );
	return $html;
}

/**
 * Apply Bunchy styles to buttons.
 */
function bunchy_bp_member_add_button_class_filters() {
	add_filter( 'bp_get_add_friend_button', 			'bunchy_bp_get_solid_button' );
}

/**
 * Remove Bunchy styles from buttons.
 */
function bunchy_bp_member_remove_button_class_filters() {
	remove_filter( 'bp_get_add_friend_button', 			'bunchy_bp_get_solid_button' );
}

/**
 * Apply Bunchy styles to buttons.
 */
function bunchy_bp_group_add_button_class_filters() {
	add_filter( 'bp_get_group_join_button', 			'bunchy_bp_get_solid_button' );
}

/**
 * Remove Bunchy styles from buttons.
 */
function bunchy_bp_group_remove_button_class_filters() {
	remove_filter( 'bp_get_group_join_button', 			'bunchy_bp_get_solid_button' );
}

/**
 * Adjust BuddyPress button classes.
 *
 * @param array $button     Button config.
 *
 * @return array
 */
function bunchy_bp_get_solid_xs_button( $button ) {
	if ( ! isset( $button['g1'] ) ) {
		$button['link_class'] .= ' g1-button g1-button-xs g1-button-simple';

		// Add our special key for tracking purposes.
		$button['g1'] = true;
	}

	return $button;
}

/**
 * Adjust BuddyPress button classes.
 *
 * @param array $button     Button config.
 *
 * @return array
 */
function bunchy_bp_get_solid_button( $button ) {
	$button['link_class'] .= ' g1-button g1-button-m g1-button-simple';
	// Add our special key for tracking purposes.
	$button['g1'] = true;

	return $button;
}

/**
 * Render dynamic CSS for the #header-cover-image
 *
 * @param array $params Parameters.
 *
 * @return string
 */
function bunchy_cover_image_callback( $params = array() ) {
	if ( empty( $params ) ) {
		return;
	}

	return '
        #buddypress #header-cover-image {
            height: ' . absint( $params['height'] ) . 'px;
            background-image: url(' . esc_url( $params['cover_image'] ) . ');
        }
    ';
}

/**
 * Adjust cover image
 *
 * @param array $settings       Settings.
 *
 * @return array
 */
function bunchy_cover_image_css( $settings = array() ) {
	/**
	 * If you are using a child theme, use bp-child-css
	 * as the theme handle
	 */
	$settings['theme_handle'] = 'bp-parent-css';

	// Let's make it a little bit bigger.
	$settings['height'] = 320;

	$settings['callback'] = 'bunchy_cover_image_callback';

	return $settings;
}

/**
 * Add wrapper (open tag here) to items loop
 */
function bunchy_render_markup_before_list_items_loop() {
	echo '<div class="g1-indent">';
}

/**
 * Add wrapper (close tag here) to items loop
 */
function bunchy_render_markup_after_list_items_loop() {
	echo '</div>';
}

/**
 * Return current user profile url
 *
 * @param string $link          Author posts link.
 * @param int 	 $author_id		Author id.
 *
 * @return string
 */
function bunchy_bp_get_author_link( $link, $author_id ) {
	$link = bp_core_get_user_domain( $author_id );
	$link = trailingslashit( $link . bp_get_profile_slug() );

	return $link;
}


/** PROFILE **********/


/**
 * Whether or not to show the "Change Cover Image" link
 *
 * @return bool
 */
function bunchy_bp_show_cover_image_change_link() {
	$show = bp_core_can_edit_settings() && bp_displayed_user_use_cover_image_header();

	return apply_filters( 'bunchy_bp_show_cover_image_change_link', $show );
}

/**
 * Render the "Change Cover Image" link
 */
function bunchy_bp_render_cover_image_change_link() {
	$link = bp_get_members_component_link( 'profile', 'change-cover-image' );

	?>
	<a class="g1-bp-change-image" href="<?php echo esc_url( $link ); ?>"><?php esc_html_e( 'Change Cover Image', 'bunchy' ); ?></a>
	<?php
}

/**
 * Whether or not to show the "Change Profile Photo" link
 *
 * @return bool
 */
function bunchy_bp_show_profile_photo_change_link() {
	$show = bp_core_can_edit_settings() && buddypress()->avatar->show_avatars;

	return apply_filters( 'bunchy_bp_show_profile_photo_change_link', $show );
}

/**
 * Render the "Change Profile Photo" link
 */
function bunchy_bp_render_profile_photo_change_link() {
	$link = bp_get_members_component_link( 'profile', 'change-avatar' );

	?>
	<a class="g1-bp-change-avatar" href="<?php echo esc_url( $link ); ?>"><?php esc_html_e( 'Change Profile Photo', 'bunchy' ); ?></a>
	<?php
}


/** GROUP ************/


/**
 * Whether or not to show the "Change Cover Image" link
 *
 * @return bool
 */
function bunchy_bp_show_group_cover_image_change_link() {
	$show = bp_core_can_edit_settings() && bp_group_use_cover_image_header();

	return apply_filters( 'bunchy_bp_show_group_cover_image_change_link', $show );
}

/**
 * Render the "Change Cover Image" link
 */
function bunchy_bp_render_group_cover_image_change_link() {
	$group_link = bp_get_group_permalink();
	$admin_link = trailingslashit( $group_link . 'admin' );
	$link = trailingslashit( $admin_link . 'group-cover-image' );

	?>
	<a class="g1-bp-change-image" href="<?php echo esc_url( $link ); ?>" title="<?php  esc_attr_e( 'Change Cover Image', 'bunchy' ); ?>"><?php esc_html_e( 'Change Cover Image', 'bunchy' ); ?></a>
	<?php
}

/**
 * Whether or not to show the "Change Profile Photo" link
 *
 * @return bool
 */
function bunchy_bp_show_group_photo_change_link() {
	$show = bp_core_can_edit_settings() && ! bp_disable_group_avatar_uploads() && buddypress()->avatar->show_avatars;

	return apply_filters( 'bunchy_bp_show_group_photo_change_link', $show );
}

/**
 * Render the "Change Profile Photo" link
 */
function bunchy_bp_render_group_photo_change_link() {
	$group_link = bp_get_group_permalink();
	$admin_link = trailingslashit( $group_link . 'admin' );
	$link = trailingslashit( $admin_link . 'group-avatar' );

	?>
	<a class="g1-bp-change-avatar" href="<?php echo esc_url( $link ); ?>" title="<?php esc_attr_e( 'Change Group Photo', 'bunchy' ); ?>"><?php esc_html_e( 'Change Group Photo', 'bunchy' ); ?></a>
	<?php
}
