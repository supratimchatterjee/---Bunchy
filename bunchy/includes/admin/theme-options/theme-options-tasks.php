<?php
/**
 * Theme options "Logs" section
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


$section_id = 'g1ui-settings-section-tasks';

add_settings_section(
	$section_id,                        // ID used to identify this section and with which to register options.
	null,                               // Title to be displayed on the administration page.
	'bunchy_render_tasks_description',
	$this->get_page()                   // Page on which to add this section of options.
);

// Section fields.
add_settings_field(
	'task_popular_list',
	'Update Popular list',
	'bunchy_render_task_popular_list',
	$this->get_page(),
	$section_id
);

add_settings_field(
	'task_hot_list',
	'Update Hot list',
	'bunchy_render_task_hot_list',
	$this->get_page(),
	$section_id
);

add_settings_field(
	'task_trending_list',
	'Update Tredning list',
	'bunchy_render_task_trending_list',
	$this->get_page(),
	$section_id
);

/**
 * Render Popular list section
 */
function bunchy_render_task_popular_list() {
	?>
	<p>
		<a class="button" href="<?php echo esc_url( wp_nonce_url( admin_url( 'themes.php?page=theme-options&group=tasks&action=run-task&task=bunchy_update_popular_posts' ), 'bunchy-task' ) ); ?>"><?php esc_html_e( 'Run now', 'bunchy' ); ?></a>
	</p>
	<?php
}

/**
 * Render Hot list section
 */
function bunchy_render_task_hot_list() {
	?>
	<p>
		<a class="button" href="<?php echo esc_url( wp_nonce_url( admin_url( 'themes.php?page=theme-options&group=tasks&action=run-task&task=bunchy_update_hot_posts' ), 'bunchy-task' ) ); ?>"><?php esc_html_e( 'Run now', 'bunchy' ); ?></a>
	</p>
	<?php
}

/**
 * Render Trending list section
 */
function bunchy_render_task_trending_list() {
	?>
	<p>
		<a class="button" href="<?php echo esc_url( wp_nonce_url( admin_url( 'themes.php?page=theme-options&group=tasks&action=run-task&task=bunchy_update_trending_posts' ), 'bunchy-task' ) ); ?>"><?php esc_html_e( 'Run now', 'bunchy' ); ?></a>
	</p>
	<?php
}

/**
 * Render logs section description
 */
function bunchy_render_tasks_description() {
	?>
	<h3><?php esc_html_e( 'Tasks', 'bunchy' ); ?></h3>
	<?php
	$executed = get_transient( 'bunchy_task_executed' );

	if ( false !== $executed ) {
		delete_transient( 'bunchy_task_executed' );

		?>
		<div id="message" class="updated notice is-dismissible">
			<p><?php echo wp_kses_post( $executed ); ?></p>
		</div>
		<?php
	}
}
